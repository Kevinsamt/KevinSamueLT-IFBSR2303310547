<?php

namespace App\Filament\Gudang\Resources;

use App\Filament\Gudang\Resources\TambahStokBarangResource\Pages;
use App\Models\StokGudang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class TambahStokBarangResource extends Resource
{
    protected static ?string $model = StokGudang::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    
    protected static ?string $navigationLabel = 'Stock';
    
    protected static ?string $modelLabel = 'Stock';
    
    protected static ?string $pluralModelLabel = 'Stock';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        TextInput::make('nama_barang')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(255)
                            ->string()
                            ->placeholder('Masukkan nama barang'),
                        TextInput::make('jumlah')
                            ->label('Jumlah Barang')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->integer()
                            ->placeholder('0')
                            ->helperText('Masukkan jumlah stok barang'),
                        TextInput::make('lokasi')
                            ->label('Lokasi Barang')
                            ->required()
                            ->maxLength(255)
                            ->string()
                            ->placeholder('Contoh: Gudang A'),
                        Select::make('jenis_barang')
                            ->label('Jenis Barang')
                            ->options([
                                'elektronik' => 'Elektronik',
                                'pakaian' => 'Pakaian',
                                'makanan' => 'Makanan',
                                'minuman' => 'Minuman',
                                'lainnya' => 'Lainnya',
                            ])
                            ->required()
                            ->string()
                            ->placeholder('Pilih jenis barang'),
                    ]),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->nullable()
                    ->string()
                    ->columnSpanFull()
                    ->placeholder('Keterangan tambahan (opsional)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
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
            'index' => Pages\ListTambahStokBarangs::route('/'),
            'create' => Pages\CreateTambahStokBarang::route('/create'),
            'view' => Pages\ViewTambahStokBarang::route('/{record}'),
            'edit' => Pages\EditTambahStokBarang::route('/{record}/edit'),
        ];
    }
} 