<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StokResource\Pages;
use App\Filament\Resources\StokResource\RelationManagers;
use App\Models\Barang;
use App\Models\Stok;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StokResource extends Resource
{
    protected static ?string $model = Stok::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Select::make('barang_id')
                ->label('Products')
                ->options(Barang::all()->pluck('nama_barang', 'id'))
                ->required(),
            TextInput::make('jumlah_masuk')
                ->label('Entry amount')
                ->numeric()
                ->required(),
            TextInput::make('jumlah_keluar')
                ->label('Outgoing amount')
                ->numeric()
                ->required(),
            DatePicker::make('tanggal')
                ->label('Date')
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            TextColumn::make('barang_id')
                ->label('Products')
                ->searchable(),
            TextColumn::make('jumlah_masuk')
                ->label('Entry amount'),
            TextColumn::make('jumlah_keluar')
                ->label('Outgoing amount'),
            TextColumn::make('tanggal')
                ->label('Date'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListStoks::route('/'),
            'create' => Pages\CreateStok::route('/create'),
            'edit' => Pages\EditStok::route('/{record}/edit'),
        ];
    }
}
