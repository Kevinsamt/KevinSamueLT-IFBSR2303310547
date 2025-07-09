<?php

namespace App\Filament\Gudang\Resources\TambahStokBarangResource\Pages;

use App\Filament\Gudang\Resources\TambahStokBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTambahStokBarangs extends ListRecords
{
    protected static string $resource = TambahStokBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
} 