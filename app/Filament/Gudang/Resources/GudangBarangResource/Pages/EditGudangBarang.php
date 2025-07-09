<?php

namespace App\Filament\Gudang\Resources\GudangBarangResource\Pages;

use App\Filament\Gudang\Resources\GudangBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGudangBarang extends EditRecord
{
    protected static string $resource = GudangBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
