<?php

namespace App\Filament\Gudang\TransaksiStockResource\Pages;

use App\Filament\Gudang\TransaksiStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTransaksiStock extends ViewRecord
{
    protected static string $resource = TransaksiStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
} 