<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Bill;
use Filament\Tables;
use App\PaymentMethods;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BillResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BillResource\RelationManagers;

class BillResource extends Resource
{
    protected static ?string $model = Bill::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('table_number')
                    ->required()
                    ->readOnly()
                    ->maxLength(255),

                Forms\Components\Select::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ])
                    ->default('open'),

                // Discount section
                Fieldset::make('Discount')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('discount_type')
                            ->options([
                                'percentage' => 'Percentage',
                                'fixed' => 'Fixed Amount',
                            ])
                            ->live()
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::calculateDiscount($get, $set);
                            }),
                        Forms\Components\TextInput::make('discount_value')
                            ->numeric()
                            ->minValue(0)
                            ->live()
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                self::calculateDiscount($get, $set);
                            }),
                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->prefix('Rs ')
                            ->readOnly()
                            ->default(0),
                    ]),

                // Subtotal field (calculated from orders)
                Forms\Components\TextInput::make('subtotal')
                    ->numeric()
                    ->prefix('Rs ')
                    ->readOnly()
                    ->default(0)
                    ->afterStateHydrated(function ($state, callable $set, $record) {
                        $subtotal = $record?->orders->sum('total_amount') ?? 0;
                        $set('subtotal', number_format($subtotal, 2, '.', ''));
                        $set('total_amount', number_format($subtotal, 2, '.', ''));
                    }),

                // Total amount field (readonly)
                Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->prefix('Rs ')
                    ->readOnly()
                    ->default(0),

                // Payment section
                Fieldset::make('Payment')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->options(PaymentMethods::class)
                            ->default(PaymentMethods::CASH->value),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'unpaid' => 'Unpaid',
                                'partial' => 'Partial',
                                'paid' => 'Paid',
                            ])
                            ->default('unpaid'),
                    ]),

                Forms\Components\Textarea::make('notes'),
            ]);
    }

    public static function calculateDiscount(callable $get, callable $set): void
    {
        $subtotal = (float) str_replace(',', '', $get('subtotal') ?? 0);
        $discountType = $get('discount_type');
        $discountValue = (float) ($get('discount_value') ?? 0);

        // Calculate discount amount
        $discountAmount = 0;
        if ($discountType === 'percentage') {
            $discountAmount = $subtotal * ($discountValue / 100);
            // Ensure percentage discount doesn't exceed 100%
            if ($discountValue > 100) {
                $set('discount_value', 100);
                $discountAmount = $subtotal;
            }
        } else {
            // Fixed amount discount shouldn't exceed subtotal
            $discountAmount = min($discountValue, $subtotal);
            if ($discountValue > $subtotal) {
                $set('discount_value', $subtotal);
            }
        }

        $set('discount_amount', number_format($discountAmount, 2, '.', ''));
        $set('total_amount', number_format($subtotal - $discountAmount, 2, '.', ''));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('table_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Orders')
                    ->counts('orders'),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->numeric(decimalPlaces: 2)
                    ->prefix('Rs ')
                    ->state(function (Bill $record) {
                        return $record->orders->sum('total_amount') - $record->discount_amount;
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'closed' => 'Closed',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('close')
                    ->action(fn($record) => $record->update(['status' => 'closed']))
                    ->visible(fn($record) => $record->status === 'open')
                    ->color('danger')
                    ->icon('heroicon-o-lock-closed'),
                Action::make('Print Bill')
                    ->url(fn(Bill $record) => route('invoice.print', [
                        'order' => $record->orders->first(),
                        'bill' => $record->id,
                        'type' => 'bill'
                    ]))
                    ->color('success')
                    ->icon('heroicon-o-document-text')
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->orders()->count() > 0)
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
            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),
            'edit' => Pages\EditBill::route('/{record}/edit'),
        ];
    }
}