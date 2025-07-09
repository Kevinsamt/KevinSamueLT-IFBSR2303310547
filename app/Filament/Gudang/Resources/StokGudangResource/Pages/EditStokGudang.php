<?php

namespace App\Filament\Gudang\Resources\StokGudangResource\Pages;

use App\Filament\Gudang\Resources\StokGudangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStokGudang extends EditRecord
{
    protected static string $resource = StokGudangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
