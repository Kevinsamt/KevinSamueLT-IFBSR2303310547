<?php

namespace App\Filament\Admin\Resources;


use App\Filament\Admin\Resources\ProdukResource\Pages;
use App\Filament\Admin\Resources\ProdukResource\RelationManagers;
use App\Models\Produk;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Forms\Components\Grid;

class ProdukResource extends Resource
{
    protected static ?string $model = Produk::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    
    protected static ?string $navigationLabel = 'Manajemen Produk';
    
    protected static ?string $modelLabel = 'Produk';
    
    protected static ?string $pluralModelLabel = 'Produk';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar')
                    ->description('Informasi utama produk')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('nama')
                                    ->label('Nama Produk')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Masukkan nama produk')
                                    ->columnSpan(2),
                                Select::make('kategori')
                                    ->label('Kategori Produk')
                                    ->options([
                                        'elektronik' => 'Elektronik',
                                        'pakaian' => 'Pakaian',
                                        'makanan' => 'Makanan',
                                        'minuman' => 'Minuman',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->required()
                                    ->default('elektronik')
                                    ->searchable(),
                                Select::make('status')
                                    ->label('Status Produk')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Nonaktif' => 'Nonaktif',
                                        'Habis' => 'Habis',
                                    ])
                                    ->required()
                                    ->default('Aktif'),
                            ]),
                        RichEditor::make('deskripsi')
                            ->label('Deskripsi Produk')
                            ->required()
                            ->default('-')
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'bulletList',
                                'orderedList',
                            ]),
                    ]),
                
                Section::make('Harga & Stok')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('harga')
                                    ->label('Harga Produk')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->prefix('Rp ')
                                    ->placeholder('Masukkan harga produk'),
                                TextInput::make('stok')
                                    ->label('Stok')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->placeholder('Masukkan jumlah stok'),
                                TextInput::make('berat')
                                    ->label('Berat (gram)')
                                    ->numeric()
                                    ->default(0)
                                    ->suffix('g')
                                    ->placeholder('Masukkan berat produk'),
                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->placeholder('Masukkan kode SKU')
                                    ->helperText('Kode unik produk'),
                            ]),
                    ]),
                
                Section::make('Media & Pengaturan')
                    ->schema([
                        FileUpload::make('gambar')
                            ->label('Gambar Produk')
                            ->image()
                            ->multiple()
                            ->maxFiles(5)
                            ->directory('produk')
                            ->columnSpanFull(),
                        Toggle::make('featured')
                            ->label('Produk Unggulan')
                            ->default(false)
                            ->helperText('Tampilkan di halaman utama'),
                        Toggle::make('promo')
                            ->label('Produk Promo')
                            ->default(false)
                            ->helperText('Tandai sebagai produk promo'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->circular(),
                TextColumn::make('nama')
                    ->label('Nama Produk')
                    ->sortable()
                    ->searchable()
                    ->weight('bold'),
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable()
                    ->searchable(),
                IconColumn::make('featured')
                    ->label('Unggulan')
                    ->boolean()
                    ->sortable(),
                IconColumn::make('promo')
                    ->label('Promo')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Nonaktif' => 'danger',
                        'Habis' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('kategori')
                    ->options([
                        'elektronik' => 'Elektronik',
                        'pakaian' => 'Pakaian',
                        'makanan' => 'Makanan',
                        'minuman' => 'Minuman',
                        'lainnya' => 'Lainnya',
                    ]),
                SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Nonaktif' => 'Nonaktif',
                        'Habis' => 'Habis',
                    ]),
                Filter::make('stok')
                    ->form([
                        TextInput::make('stok_min')
                            ->label('Stok Minimum')
                            ->numeric(),
                        TextInput::make('stok_max')
                            ->label('Stok Maksimum')
                            ->numeric(),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when(
                                $data['stok_min'],
                                fn($query) => $query->where('stok', '>=', $data['stok_min'])
                            )
                            ->when(
                                $data['stok_max'],
                                fn($query) => $query->where('stok', '<=', $data['stok_max'])
                            );
                    }),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make()
                    ->button()
                    ->color('primary'),
                Tables\Actions\DeleteAction::make()
                    ->button()
                    ->color('danger'),
                Action::make('duplicate')
                    ->label('Duplikat')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function ($record) {
                        $newRecord = $record->replicate();
                        $newRecord->nama = $record->nama . ' (Copy)';
                        $newRecord->save();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-check-circle')
                        ->form([
                            Select::make('status')
                                ->options([
                                    'Aktif' => 'Aktif',
                                    'Nonaktif' => 'Nonaktif',
                                    'Habis' => 'Habis',
                                ])
                                ->required(),
                        ])
                        ->action(function ($records, array $data) {
                            $records->each(function ($record) use ($data) {
                                $record->update(['status' => $data['status']]);
                            });
                        }),
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
            'index' => Pages\ListProduks::route('/'),
            'create' => Pages\CreateProduk::route('/create'),
            'edit' => Pages\EditProduk::route('/{record}/edit'),
        ];
    }
}
