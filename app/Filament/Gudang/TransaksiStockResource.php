<?php

namespace App\Filament\Gudang;

use App\Models\TransaksiStock;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiStockResource extends Resource
{
    protected static ?string $model = TransaksiStock::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'Gudang';

    protected static ?string $navigationLabel = 'Transaksi Stock';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->required()
                    ->label('Tanggal'),
                Forms\Components\Select::make('stock_id')
                    ->relationship('stock', 'nama')
                    ->required()
                    ->label('Stock'),
                Forms\Components\TextInput::make('keterangan')
                    ->required()
                    ->label('Keterangan'),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric()
                    ->label('Jumlah'),
                Forms\Components\Select::make('jenis')
                    ->options([
                        'Debit' => 'Debit',
                        'Kredit' => 'Kredit',
                    ])
                    ->required()
                    ->label('Jenis'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->sortable()
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('stock.nama')
                    ->sortable()
                    ->label('Stock'),
                Tables\Columns\TextColumn::make('keterangan')
                    ->searchable()
                    ->label('Keterangan'),
                Tables\Columns\TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable()
                    ->label('Jumlah'),
                Tables\Columns\TextColumn::make('jenis')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Debit' => 'success',
                        'Kredit' => 'danger',
                    })
                    ->label('Jenis'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Dibuat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'view' => Pages\ViewTransaksiStock::route('/{record}'),
            'edit' => Pages\EditTransaksiStock::route('/{record}/edit'),
        ];
    }
} 