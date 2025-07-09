<?php

namespace App\Filament\Gudang\Resources\StokGudangResource\Pages;

use App\Filament\Gudang\Resources\StokGudangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStokGudang extends ViewRecord
{
    protected static string $resource = StokGudangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
} 