<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                    ->label('Product Name')
                    ->required(),
                TextInput::make('kode_barang')
                    ->label('Product Code')
                    ->required(),
                Select::make('kategori_id')
                    ->label('Categories Product')
                    ->options(Kategori::all()->pluck('nama_kategori', 'id'))
                    ->required(),
                TextInput::make('harga')
                    ->label('Price')
                    ->numeric()
                    ->step(0.01)
                    ->required(),
                TextInput::make('stok')
                    ->label('Stock Produt')
                    ->numeric()
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('deskripsi')
                    ->label('Description')
                    ->maxLength(255)
                    ->autosize()
                    ->columnSpanFull()
                    ->helperText('Description A Product'),
                FileUpload::make('gambar')
                    ->label("Image Product")
                    ->image()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->searchable()
                    ->label('Product Name'),
                TextColumn::make('kode_barang')
                    ->searchable()
                    ->label('Product Code'),
                TextColumn::make('kategori.nama_kategori')
                    ->searchable()
                    ->label('Categories Product'),
                TextColumn::make('harga')
                    ->label('Price'),
                TextColumn::make('stok')
                    ->label('Stock Produt'),
                TextColumn::make('deskripsi')
                    ->label('Description'),
                ImageColumn::make('gambar')
                    ->label("Image Product")
                  
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->label('Move To Trash')
                ->modalHeading('Move To Trash')
                ->successNotificationTitle('Succes Deleted'),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
