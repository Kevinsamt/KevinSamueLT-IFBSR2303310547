<?php

namespace App\Filament\Gudang\Resources\TambahStokBarangResource\Pages;

use App\Filament\Gudang\Resources\TambahStokBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTambahStokBarang extends ViewRecord
{
    protected static string $resource = TambahStokBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
} 