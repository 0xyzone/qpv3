<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Item;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ItemResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ItemResource\RelationManagers;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $activeNavigationIcon = 'heroicon-m-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('item_category_id')
                            ->relationship('itemCategory', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('Select a category')
                            ->helperText('Choose the appropriate category for this item'),

                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Buff. Momos, Veg. Thukpa, Chicken Curry')
                            ->helperText('Max 255 characters')
                            ->columnSpan(1),
                    ]),

                Forms\Components\Section::make('Pricing & Details')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100000)
                            ->step(0.01)
                            ->prefix('रु')
                            ->inputMode('decimal')
                            ->placeholder('0.00')
                            ->default(0.00),

                        Forms\Components\FileUpload::make('photo_path')
                            ->label('Product Image')
                            ->image()
                            ->directory('items')
                            ->disk('public')
                            // ->required()
                            ->imageEditor()
                            ->imageCropAspectRatio('4:3')
                            ->imageResizeMode('cover')
                            ->imagePreviewHeight(250)
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Max file size: 2MB. Allowed types: JPG, PNG, WEBP')
                            ->columnSpan(2),
                    ]),

                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->rows(5)
                            ->maxLength(1000)
                            ->placeholder('Enter detailed product description...')
                            ->helperText('Max 1000 characters')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('photo_path')
                    ->label('Image')
                    ->circular()
                    ->size(60)
                    ->defaultImageUrl(asset('img/Food placements.png')),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn(Item $record) => Str::limit($record->description, 40))
                    ->wrap(),

                Tables\Columns\TextColumn::make('itemCategory.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('price')
                    // ->money('रु')
                    ->prefix('रु ')
                    ->formatStateUsing(fn($state) => number_format($state, 0))
                    ->sortable()
                    ->alignEnd()
                    ->color('success')
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M d, Y h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('itemCategory', 'name')
                    ->searchable()
                    ->preload(),

                // Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
