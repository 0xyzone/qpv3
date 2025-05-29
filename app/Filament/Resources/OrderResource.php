<?php

namespace App\Filament\Resources;

use App\OrderTypes;
use Filament\Forms;
use App\Models\Item;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use App\OrderStatuses;
use App\PaymentMethods;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Number;
use Filament\Resources\Resource;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\Model;
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
                    ->selectablePlaceholder(false)
                    ->options(OrderTypes::class)
                    ->required()
                    ->default(OrderTypes::DINE_IN->value)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        if ($state === OrderTypes::DELIVERY->value) {
                            $set('payment_method', PaymentMethods::COD->value);
                        }
                    }),

                Forms\Components\TextInput::make('delivery_address')
                    ->required(fn(Get $get) => $get('order_type') === OrderTypes::DELIVERY->value)
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DELIVERY->value),

                Forms\Components\TextInput::make('delivery_phone')
                    ->required(fn(Get $get) => $get('order_type') === OrderTypes::DELIVERY->value)
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DELIVERY->value),

                Forms\Components\TextArea::make('delivery_instructions')
                    ->required(fn(Get $get) => $get('order_type') === OrderTypes::DELIVERY->value)
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DELIVERY->value),

                // Order Items Repeater
                Repeater::make('orderItems')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('item_id')
                            ->label('Item')
                            ->relationship('item', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(onBlur: true)
                            ->selectablePlaceholder(false)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($item = Item::find($state)) {
                                    $set('unit_price', $item->price);
                                    $quantity = (float) ($get('quantity') ?: 0.5);
                                    $set('total_price', $item->price * $quantity);
                                }
                            })
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->minValue(0.5)
                            ->step(0.5)
                            ->live(onBlur: true)
                            ->default(1)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $unitPrice = (float) ($get('unit_price') ?: 0);
                                $set('total_price', $unitPrice * $state);
                            })
                            ->inputMode('decimal')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('unit_price')
                            ->prefix('Rs ')
                            ->readOnly()
                            ->numeric()
                            ->minValue(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $quantity = (float) ($get('quantity') ?: 0.5);
                                $set('total_price', $state * $quantity);
                            })
                            ->dehydrated()
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('total_price')
                            ->prefix('Rs ')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated()
                            ->columnSpan(2),

                        Forms\Components\Textarea::make('special_instructions')
                            ->rows(1)
                            ->placeholder('Special instructions')
                            ->columnSpan(10),
                    ])
                    ->columns(10)
                    ->columnSpanFull()
                    ->live()
                    ->afterStateUpdated(function (callable $get, callable $set) {
                        self::updateTotals($get, $set);
                    }),

                // Discount Section
                Fieldset::make('Discount')
                    ->schema([
                        Forms\Components\Select::make('discount_type')
                            ->options([
                                'percentage' => 'Percentage (%)',
                                'fixed_amount' => 'Fixed Amount',
                            ])
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::updateTotals($get, $set);
                            }),

                        Forms\Components\TextInput::make('discount_value')
                            ->numeric()
                            ->prefix(fn(Get $get) => $get('discount_type') === 'percentage' ? '%' : 'Rs ')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::updateTotals($get, $set);
                            })
                            ->hidden(fn(Get $get): bool => $get('discount_type') === null),
                    ])
                    ->columns(2)
                    ->columnSpan(1),

                // Delivery Section
                Fieldset::make('Delivery')
                    ->hidden(fn(Get $get): bool => $get('order_type') !== OrderTypes::DELIVERY->value)
                    ->schema([
                        Forms\Components\TextInput::make('delivery_charge')
                            ->prefix('Rs ')
                            ->numeric()
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::updateTotals($get, $set);
                            }),
                    ])
                    ->columnSpan(1),

                // Payment & Status
                Fieldset::make('Payment & Status')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->options(PaymentMethods::class)
                            ->required()
                            ->default(PaymentMethods::CASH->value),

                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'partial' => 'Partial Payment',
                                'paid' => 'Paid',
                            ])
                            ->required()
                            ->default('unpaid'),

                        Forms\Components\Select::make('status')
                            ->options(OrderStatuses::class)
                            ->required()
                            ->default(OrderStatuses::PENDING->value),

                        Forms\Components\DateTimePicker::make('completed_at'),
                    ])
                    ->columns(2),

                // Order Notes
                Forms\Components\Textarea::make('notes')
                    ->placeholder('Order notes')
                    ->columnSpanFull(),

                // Totals Summary
                Section::make('Total Summary')
                    ->extraAttributes(['class' => 'fixed w-max', 'style' => 'bottom: 20px; left: 20px;'])
                    ->schema([
                        Placeholder::make('subtotal_placeholder')
                            ->label('Sub Total')
                            ->inlineLabel()
                            ->content(fn(Get $get) => 'Rs ' . number_format($get('subtotal'), 2)),

                        Placeholder::make('discount_placeholder')
                            ->label('Discount')
                            ->inlineLabel()
                            ->content(fn(Get $get) => 'Rs ' . number_format($get('discount_amount'), 2))
                            ->hidden(fn(Get $get): bool => $get('discount_amount') <= 0),

                        Placeholder::make('delivery_placeholder')
                            ->label('Delivery')
                            ->inlineLabel()
                            ->content(fn(Get $get) => 'Rs ' . number_format($get('delivery_charge'), 2))
                            ->hidden(fn(Get $get): bool => $get('delivery_charge') <= 0)
                            ->extraAttributes([
                                'class' => 'w-max'
                            ]),

                        Placeholder::make('total_placeholder')
                            ->label('Total')
                            ->inlineLabel()
                            ->content(fn(Get $get) => 'Rs ' . number_format($get('total_amount'), 2)),

                        // Hidden fields for calculations
                        Forms\Components\Hidden::make('subtotal'),
                        Forms\Components\Hidden::make('discount_amount'),
                        Forms\Components\Hidden::make('total_amount'),
                    ]),
            ])
            ->columns(2);
    }

    public static function updateTotals(callable $get, callable $set): void
    {
        // Calculate subtotal from order items
        $orderItems = $get('orderItems');
        $selectedProducts = collect($get('orderItems'))->filter(fn($item) => !empty($item['item_id']) && !empty($item['quantity']));
        $prices = Item::find($selectedProducts->pluck('item_id'))->pluck('price', 'id');
        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['item_id']] * $product['quantity']);
        }, 0);

        // if (is_array($orderItems)) {
        //     foreach ($orderItems as $item) {
        //         $subtotal += (float) ($item['total_price'] ?? 0);
        //     }
        // }

        // Calculate discount
        $discountType = $get('discount_type');
        $discountValue = (float) ($get('discount_value') ?? 0);
        $discountAmount = 0;

        if ($discountType === 'percentage') {
            $discountAmount = $subtotal * ($discountValue / 100);
        } elseif ($discountType === 'fixed_amount') {
            $discountAmount = $discountValue;
        }

        // Get delivery charge
        $deliveryCharge = (float) ($get('delivery_charge') ?? 0);

        // Calculate total
        $total = $subtotal - $discountAmount + $deliveryCharge;

        // Update hidden fields
        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('discount_amount', number_format($discountAmount, 2, '.', ''));
        $set('total_amount', number_format($total, 2, '.', ''));
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
                        // Handle both collection and single model cases
                        $items = $state instanceof \Illuminate\Database\Eloquent\Collection
                            ? $state
                            : collect([$state]);

                        // Return as array for listWithLineBreaks
                        return $items->map(function ($item) {
                            $quantity = $item->quantity;
                            $formattedQty = ($quantity == floor($quantity))
                                ? number_format($quantity)
                                : number_format($quantity, 1);

                            return $item->item->name . ' (x' . $formattedQty . ')';
                        }
                        )->implode(', ');
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