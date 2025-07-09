<?php

namespace App\Filament\Gudang\Resources\GudangBarangResource\Pages;

use App\Filament\Gudang\Resources\GudangBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGudangBarang extends ViewRecord
{
    protected static string $resource = GudangBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
} 