<?php

namespace App\Filament\Gudang\Resources;

use App\Filament\Gudang\Resources\GudangBarangResource\Pages;
use App\Filament\Gudang\Resources\GudangBarangResource\RelationManagers;
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
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;

class GudangBarangResource extends Resource
{
    protected static ?string $model = StokGudang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    
    protected static ?string $navigationLabel = 'Gudang Barang';
    
    protected static ?string $modelLabel = 'Barang Gudang';
    
    protected static ?string $pluralModelLabel = 'Barang Gudang';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Barang')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                TextInput::make('nama_barang')
                                    ->label('Nama Barang')
                                    ->required()
                                    ->maxLength(255)
                                    ->string()
                                    ->placeholder('Masukkan nama barang'),
                                TextInput::make('kode_barang')
                                    ->label('Kode Barang')
                                    ->required()
                                    ->maxLength(50)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('Contoh: BRG-001'),
                                TextInput::make('jumlah')
                                    ->label('Jumlah Barang')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->integer()
                                    ->placeholder('0')
                                    ->helperText('Masukkan jumlah stok barang'),
                                TextInput::make('satuan')
                                    ->label('Satuan')
                                    ->required()
                                    ->maxLength(20)
                                    ->placeholder('Contoh: PCS, KG, LITER'),
                                TextInput::make('harga_satuan')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->minValue(0)
                                    ->prefix('Rp ')
                                    ->placeholder('0'),
                                TextInput::make('lokasi')
                                    ->label('Lokasi Barang')
                                    ->required()
                                    ->maxLength(255)
                                    ->string()
                                    ->placeholder('Contoh: Gudang A, Rak 1'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Select::make('jenis_barang')
                                    ->label('Jenis Barang')
                                    ->options([
                                        'elektronik' => 'Elektronik',
                                        'pakaian' => 'Pakaian',
                                        'makanan' => 'Makanan',
                                        'minuman' => 'Minuman',
                                        'peralatan' => 'Peralatan',
                                        'bahan_baku' => 'Bahan Baku',
                                        'barang_jadi' => 'Barang Jadi',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->required()
                                    ->searchable()
                                    ->placeholder('Pilih jenis barang'),
                                Select::make('kategori')
                                    ->label('Kategori')
                                    ->options([
                                        'premium' => 'Premium',
                                        'standar' => 'Standar',
                                        'ekonomis' => 'Ekonomis',
                                    ])
                                    ->default('standar')
                                    ->searchable(),
                                DatePicker::make('tanggal_masuk')
                                    ->label('Tanggal Masuk')
                                    ->default(now())
                                    ->required(),
                                DatePicker::make('tanggal_expired')
                                    ->label('Tanggal Expired')
                                    ->nullable()
                                    ->helperText('Kosongkan jika tidak ada tanggal expired'),
                            ]),
                        Toggle::make('status')
                            ->label('Status Barang')
                            ->default(true)
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Aktifkan jika barang tersedia'),
                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->nullable()
                            ->string()
                            ->columnSpanFull()
                            ->placeholder('Keterangan tambahan (opsional)'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_barang')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Kode barang berhasil disalin!'),
                    
                TextColumn::make('nama_barang')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                TextColumn::make('jumlah')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        $state > 50 => 'success',
                        $state > 10 => 'warning',
                        default => 'danger',
                    }),
                    
                TextColumn::make('satuan')
                    ->label('Satuan')
                    ->sortable(),
                    
                TextColumn::make('harga_satuan')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                    
                TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable()
                    ->limit(20),
                    
                TextColumn::make('jenis_barang')
                    ->label('Jenis')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'premium' => 'success',
                        'standar' => 'info',
                        'ekonomis' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                    
                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->sortable()
                    ->trueColor('success')
                    ->falseColor('danger'),
                    
                TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
                    
                TextColumn::make('tanggal_expired')
                    ->label('Expired')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable()
                    ->color(fn ($record) => $record->tanggal_expired && $record->tanggal_expired < now() ? 'danger' : 'success'),
            ])
            ->filters([
                SelectFilter::make('jenis_barang')
                    ->label('Jenis Barang')
                    ->options([
                        'elektronik' => 'Elektronik',
                        'pakaian' => 'Pakaian',
                        'makanan' => 'Makanan',
                        'minuman' => 'Minuman',
                        'peralatan' => 'Peralatan',
                        'bahan_baku' => 'Bahan Baku',
                        'barang_jadi' => 'Barang Jadi',
                        'lainnya' => 'Lainnya',
                    ]),
                    
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'premium' => 'Premium',
                        'standar' => 'Standar',
                        'ekonomis' => 'Ekonomis',
                    ]),
                    
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('Semua Status')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
                    
                Filter::make('stok_rendah')
                    ->label('Stok Rendah')
                    ->query(fn (Builder $query): Builder => $query->where('jumlah', '<=', 10))
                    ->toggle(),
                    
                Filter::make('expired')
                    ->label('Barang Expired')
                    ->query(fn (Builder $query): Builder => $query->where('tanggal_expired', '<', now()))
                    ->toggle(),
                    
                Filter::make('jumlah_range')
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
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListGudangBarangs::route('/'),
            'create' => Pages\CreateGudangBarang::route('/create'),
            'view' => Pages\ViewGudangBarang::route('/{record}'),
            'edit' => Pages\EditGudangBarang::route('/{record}/edit'),
        ];
    }
}
