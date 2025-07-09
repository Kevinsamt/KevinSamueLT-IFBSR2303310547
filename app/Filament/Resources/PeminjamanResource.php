<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Filament\Resources\PeminjamanResource\RelationManagers;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('buku_id')
                    ->relationship('buku', 'judul')
                    ->required()
                    ->label('Buku'),
                Forms\Components\TextInput::make('peminjam')
                    ->required()
                    ->label('Peminjam'),
                Forms\Components\DatePicker::make('tanggal_pinjam')
                    ->required()
                    ->label('Tanggal Pinjam'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('buku.judul')
                    ->label('Buku')
                    ->sortable(),
                Tables\Columns\TextColumn::make('peminjam')
                    ->label('Peminjam')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tanggal_pinjam')
                    ->label('Tanggal Pinjam')
                    ->date(),
                Tables\Columns\TextColumn::make('tanggal_kembali')
                    ->label('Tanggal Kembali')
                    ->date()
                    ->placeholder('-'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('kembalikan')
                    ->label('Kembalikan')
                    ->icon('heroicon-o-arrow-uturn-left')
                    ->visible(fn($record) => is_null($record->tanggal_kembali))
                    ->action(function ($record) {
                        $record->tanggal_kembali = now();
                        $record->save();
                    })
                    ->requiresConfirmation()
                    ->color('success'),
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
            'index' => Pages\ListPeminjamans::route('/'),
            'create' => Pages\CreatePeminjaman::route('/create'),
            'edit' => Pages\EditPeminjaman::route('/{record}/edit'),
        ];
    }
}
