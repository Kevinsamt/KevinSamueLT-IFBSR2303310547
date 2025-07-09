<?php

namespace App\Filament\Gudang\Resources\GudangBarangResource\Pages;

use App\Filament\Gudang\Resources\GudangBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGudangBarangs extends ListRecords
{
    protected static string $resource = GudangBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
