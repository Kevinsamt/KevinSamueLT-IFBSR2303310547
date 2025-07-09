<?php

namespace App\Filament\Gudang\Resources\TambahStokBarangResource\Pages;

use App\Filament\Gudang\Resources\TambahStokBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTambahStokBarang extends EditRecord
{
    protected static string $resource = TambahStokBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
} 