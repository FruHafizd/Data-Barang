<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransaksiResource\Pages;
use App\Filament\Resources\TransaksiResource\RelationManagers;
use App\Models\Transaksi;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Enum;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    public static function getModelLabel(): string
    {
        return __('Transaction');
    }

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            DatePicker::make('tanggal_transaksi')
                ->label('Date Transaction')
                ->required(),
            TextInput::make('total')
                ->label('Total')
                ->required(),
            Select::make('user_id')
                ->label('Name')
                ->options(User::all()->pluck('name', 'id'))
                ->required(),  
            Section::make('Status')->schema([
                Toggle::make('pending')
                    ->required()
                    ->default(true),
                Toggle::make('completed')
                    ->required(),
                Toggle::make('canceled')
                    ->required(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tanggal_transaksi')
                    ->searchable()
                    ->label('Date Transaction'),
                TextColumn::make('total')
                    ->searchable()
                    ->label('Total'),
                TextColumn::make('user.name')
                    ->searchable()
                    ->label('Name'),
                TextColumn::make('user_id')
                    ->searchable()
                    ->label('Name'),
                IconColumn::make('pending')
                    ->boolean(),
                IconColumn::make('completed')
                    ->boolean(),
                IconColumn::make('canceled')
                    ->boolean(),
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
