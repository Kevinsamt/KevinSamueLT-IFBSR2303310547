<?php

namespace App\Filament\Gudang\Resources\TransaksiStockResource\Pages;

use App\Filament\Gudang\Resources\TransaksiStockResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransaksiStocks extends ListRecords
{
    protected static string $resource = TransaksiStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
