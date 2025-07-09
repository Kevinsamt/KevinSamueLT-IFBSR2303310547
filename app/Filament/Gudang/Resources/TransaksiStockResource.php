<?php

namespace App\Filament\Gudang\Resources;

use App\Filament\Gudang\Resources\TransaksiStockResource\Pages;
use App\Filament\Gudang\Resources\TransaksiStockResource\RelationManagers;
use App\Models\TransaksiStock;
use App\Models\Produk;
use App\Models\StokGudang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\Jenistransaksi;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Carbon\Carbon;

class TransaksiStockResource extends Resource
{
    protected static ?string $model = TransaksiStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
           ->schema([
                DatePicker::make('tanggal')
                    ->label('Tanggal')
                    ->default(Carbon::today())
                    ->format('Y-m-d')
                    ->required(),
                Select::make('barang_id')
                    ->label('Barang')
                    ->options(Produk::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('gudang_id')
                    ->label('Gudang')
                    ->options(StokGudang::all()->pluck('nama_barang', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->required(),
                Select::make('jenis')
                    ->label('Jenis Transaksi')
                    ->options([
                        'debit' => 'Debit',
                        'kredit' => 'Kredit'
                    ])
                    ->required(),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransaksiStocks::route('/'),
            'create' => Pages\CreateTransaksiStock::route('/create'),
            'edit' => Pages\EditTransaksiStock::route('/{record}/edit'),
        ];
    }
}
