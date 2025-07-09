<?php

namespace App\Filament\Gudang\Resources\StokGudangResource\Pages;

use App\Filament\Gudang\Resources\StokGudangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStokGudang extends CreateRecord
{
    protected static string $resource = StokGudangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
