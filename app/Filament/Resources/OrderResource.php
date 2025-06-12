<?php

namespace App\Filament\Resources;

use App\OrderTypes;
use Filament\Forms;
use App\Models\Bill;
use App\Models\Item;
use App\Models\User;
use Filament\Forms\Set;
use Filament\Tables;
use App\Models\Order;
use App\OrderStatuses;
use App\PaymentMethods;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\URL;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\OrderResource\Pages;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),

                Forms\Components\Select::make('order_type')
                    ->options(OrderTypes::class)
                    ->required()
                    ->default(OrderTypes::DINE_IN->value)
                    ->live(),

                // Bill selection with create option
                Forms\Components\Select::make('bill_id')
                    ->label('Link to Table')
                    ->relationship('bill', 'table_number')
                    ->options(Bill::where('status', 'open')->pluck('table_number', 'id'))
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('table_number')
                            ->required()
                            ->label('Table Number')
                    ])
                    ->createOptionUsing(function (array $data) {
                        return Bill::create([
                            'table_number' => $data['table_number'],
                            'status' => 'open'
                        ])->id;
                    })
                    ->required(fn(Get $get): bool => $get('order_type') === OrderTypes::DINE_IN->value)
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DINE_IN->value),

                // Delivery fields
                Fieldset::make('Delivery Information')
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DELIVERY->value)
                    ->schema([
                        Forms\Components\TextInput::make('delivery_contact_name')
                            ->required(),
                        Forms\Components\TextInput::make('delivery_address')
                            ->required(),
                        Forms\Components\TextInput::make('delivery_phone')
                            ->required(),
                        Forms\Components\Textarea::make('delivery_instructions'),
                        Forms\Components\Select::make('delivery_charge')
                            ->options([
                                100 => 'Inside Valley (100)',
                                150 => 'Outside Valley (150)',
                            ])
                            ->default(100)
                            ->required(),
                    ]),

                // Order items with image in dropdown
                Repeater::make('orderItems')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('item_id')
                            ->label('Item')
                            ->relationship('item', 'name')
                            ->getOptionLabelFromRecordUsing(fn(Item $item) => $item->name ?: 'Unnamed Item')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->distinct()
                            ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                            ->options(function () {
                                return Item::query()
                                    ->whereNotNull('name')
                                    ->get()
                                    ->mapWithKeys(function (Item $item) {
                                        $imageUrl = $item->image_url ?: asset('img/Food placements.png');
                                        return [
                                            $item->id => '
                                <div id="' . $item->name . '" class="flex items-center gap-2">
                                    <img src="' . e($imageUrl) . '" 
                                        alt="' . e($item->name) . '" 
                                        class="h-8 w-8 rounded-full object-cover" />
                                    <span class="whitespace-nowrap">' . e($item->name ?: 'Unnamed Item') . '</span>
                                </div>
                            '
                                        ];
                                    });
                            })
                            ->getSearchResultsUsing(function (string $search) {
                                // dd($search);
                                if (empty($search)) {
                                    return [];
                                }

                                return Item::query()
                                    ->where('name', 'like', '%' . $search . '%')
                                    ->get()
                                    ->mapWithKeys(function (Item $item) {
                                        $imageUrl = $item->image_url ?: asset('img/Food placements.png');

                                        return [
                                            $item->id => '
                                <div class="flex items-center gap-2">
                                    <img src="' . e($imageUrl) . '" 
                                        alt="' . e($item->name) . '" 
                                        class="h-8 w-8 rounded-full object-cover" />
                                    <span class="whitespace-nowrap">' . e($item->name ?: 'Unnamed Item') . '</span>
                                </div>
                            '
                                        ];
                                    });
                            })
                            ->allowHtml()
                            ->optionsLimit(50)
                            ->columnSpan(2)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($item = Item::find($state)) {
                                    $set('unit_price', $item->price);
                                    $set('total_price', $item->price * $get('quantity'));
                                }
                            })
                            ->live() // Add this to recalculate when items change
                            ->afterStateUpdated(function ($state, $set) {
                                // Calculate total amount when items change
                                $total = collect($state)->sum(fn($item) => ($item['total_price'] ?? 0));
                                $set('total_amount', number_format($total, 2, '.', ''));
                            }),

                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->default(1)
                            ->minValue(0.5)
                            ->step(0.5)
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $set('total_price', $get('unit_price') * $state);
                            }),

                        Forms\Components\TextInput::make('unit_price')
                            ->numeric()
                            ->prefix('Rs ')
                            ->readOnly()
                            ->default(0),

                        Forms\Components\TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rs ')
                            ->readOnly()
                            ->default(0),

                        Forms\Components\Textarea::make('special_instructions')
                            ->placeholder('Special instructions (no onions, extra spicy, etc.)')
                            ->columnSpanFull()
                            ->maxLength(500),
                    ])
                    ->columns(5)
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->collapsible()
                    ->cloneable()
                    ->itemLabel(fn(array $state): ?string => Item::find($state['item_id'])?->name ?? null),

                Forms\Components\Select::make('status')
                    ->options(OrderStatuses::class)
                    ->default(OrderStatuses::PENDING->value),

                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('Rs ')
                    ->readOnly()
                    ->default(0)
                    ->afterStateHydrated(function ($state, $set, $record) {
                        // Calculate total when form loads for existing records
                        if ($record && $record->exists) {
                            $total = $record->orderItems->sum('total_price');
                            $set('total_amount', number_format($total, 2, '.', ''));
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->recordClasses(fn($record) => $record ? match ($record->status) {
                'pending' => null,
                'preparing' => '!bg-yellow-600/20 hover:!bg-yellow-800/20',
                'ready' => '!bg-indigo-700/20 hover:!bg-indigo-800/20',
                'out_delivery' => '!bg-cyan-500/20 hover:!bg-cyan-600/20',
                'delivered' => '!bg-emerald-500/20 hover:!bg-emerald-600/20',
                'cancelled' => '!bg-red-500/20 hover:!bg-red-600/20',
                default => null
            } : null)
            ->striped()
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Staff'),

                Tables\Columns\TextColumn::make('orderItems')
                    ->formatStateUsing(function ($state) {
                        $items = $state instanceof \Illuminate\Database\Eloquent\Collection
                            ? $state
                            : collect([$state]);

                        return $items->map(function ($item) {
                            $quantity = $item->quantity;
                            $formattedQty = ($quantity == floor($quantity))
                                ? number_format($quantity)
                                : number_format($quantity, 1);

                            return $item->item->name . ' (x' . $formattedQty . ')';
                        })->implode(', ');
                    })
                    ->listWithLineBreaks()
                    ->badge()
                    ->limitList(2)
                    ->expandableLimitedList(),

                Tables\Columns\TextColumn::make('order_type')
                    ->badge(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->prefix('Rs ')
                    ->color('success'),

                Tables\Columns\SelectColumn::make('status')
                    ->options(OrderStatuses::class)
                    ->selectablePlaceholder(false),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('h:i A, M d'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_type')
                    ->options(OrderTypes::class),

                Tables\Filters\SelectFilter::make('status')
                    ->options(OrderStatuses::class),

                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(PaymentMethods::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markAsPaid')
                    ->icon('heroicon-o-banknotes')
                    ->visible(fn(Order $record) => $record->payment_status !== 'paid')
                    ->action(function (Order $record) {
                        $record->update(['payment_status' => 'paid']);
                    }),
                Tables\Actions\Action::make('Print KOT')
                    ->url(function (Model $record) {
                        return URL::route('invoice.print', [
                            'order' => $record,
                            'type' => 'kot',
                            'bill' => $record->bill_id
                        ]);
                    }, shouldOpenInNewTab: true)
                    ->button()
                    ->icon('heroicon-o-printer')
                    ->color('warning')
                    ->visible(fn(Model $record): bool => $record->status != 'cancelled')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}