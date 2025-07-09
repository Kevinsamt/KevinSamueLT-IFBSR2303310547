<?php

namespace App\Filament\Gudang\Resources\TransaksiStockResource\Pages;

use App\Filament\Gudang\Resources\TransaksiStockResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTransaksiStock extends EditRecord
{
    protected static string $resource = TransaksiStockResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
