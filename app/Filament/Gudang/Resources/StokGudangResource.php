<?php

namespace App\Filament\Gudang\Resources;

use App\Filament\Gudang\Resources\StokGudangResource\Pages;
use App\Filament\Gudang\Resources\StokGudangResource\RelationManagers;
use App\Models\StokGudang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;

class StokGudangResource extends Resource
{
    protected static ?string $model = StokGudang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationLabel = 'Stok Gudang';
    
    protected static ?string $modelLabel = 'Stok Gudang';
    
    protected static ?string $pluralModelLabel = 'Stok Gudang';

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
                        Toggle::make('status')
                            ->label('Status Barang')
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Aktifkan jika barang tersedia'),
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
                    
                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->sortable()
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->options([
                        'elektronik' => 'Elektronik',
                        'pakaian' => 'Pakaian',
                        'makanan' => 'Makanan',
                        'minuman' => 'Minuman',
                        'lainnya' => 'Lainnya',
                    ]),
                    
                Filter::make('status')
                    ->label('Status')
                    ->query(fn (Builder $query): Builder => $query->where('status', true))
                    ->toggle(),
                    
                Filter::make('jumlah')
                    ->form([
                        TextInput::make('jumlah_min')
                            ->label('Jumlah Minimum')
                            ->numeric(),
                        TextInput::make('jumlah_max')
                            ->label('Jumlah Maksimum')
                            ->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['jumlah_min'],
                                fn (Builder $query, $data): Builder => $query->where('jumlah', '>=', $data['jumlah_min']),
                            )
                            ->when(
                                $data['jumlah_max'],
                                fn (Builder $query, $data): Builder => $query->where('jumlah', '<=', $data['jumlah_max']),
                            );
                    })
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
            'index' => Pages\ListStokGudangs::route('/'),
            'create' => Pages\CreateStokGudang::route('/create'),
            'view' => Pages\ViewStokGudang::route('/{record}'),
            'edit' => Pages\EditStokGudang::route('/{record}/edit'),
        ];
    }
}
