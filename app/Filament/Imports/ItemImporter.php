<?php

namespace App\Filament\Imports;

use App\Models\Item;
use App\Models\ItemCategory;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class ItemImporter extends Importer
{
    protected static ?string $model = Item::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('itemCategory')
                ->requiredMapping()
                ->relationship(resolveUsing: function($state) {
                    // First try to find existing category
                    $category = ItemCategory::where('name', $state)->first();
                    
                    // If not found, create a new one
                    if (!$category) {
                        $category = ItemCategory::create([
                            'name' => $state,
                            // Add any other default fields your category might need
                        ]);
                    }
                    
                    return $category;
                })
                ->rules(['required']),
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            // ImportColumn::make('photo_path')
            //     ->rules(['max:255']),
            ImportColumn::make('price')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('description'),
        ];
    }

    public function resolveRecord(): ?Item
    {
        // return Item::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Item();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your item import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
