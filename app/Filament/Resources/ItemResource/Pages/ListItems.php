<?php

namespace App\Filament\Resources\ItemResource\Pages;

use App\Filament\Resources\ItemResource;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('Import Items')
                ->modalHeading('Import Items')
                ->modalDescription('Upload a CSV file to import items.')
                ->importer('App\Filament\Imports\ItemImporter'),
            Actions\CreateAction::make(),
        ];
    }
}
