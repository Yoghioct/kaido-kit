<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductPricelistResource\Pages;
use App\Filament\Resources\ProductPricelistResource\RelationManagers;
use App\Models\ProductPricelist;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput\Mask;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;
use Pelmered\FilamentMoneyField\Tables\Columns\MoneyColumn;

class ProductPricelistResource extends Resource
{
    protected static ?string $model = ProductPricelist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name'),
                // MoneyInput::make('price')
                //     ->symbolPlacement('hidden')
                //     ->decimals(0)
                //     ->minValue(0),
                // Forms\Components\TextInput::make('price')
                //     ->required()
                //     ->prefix('Rp')
                //     ->numeric()
                //     ->inputMode('decimal')
                //     ->formatStateUsing(fn ($state) => $state ? number_format($state, 0, ',', '.') : '')
                //     ->dehydrateStateUsing(fn ($state) => str_replace(['.', ',', 'Rp', ' '], ['', '.', '', ''], $state))
                //     ->stripCharacters(['.', ' ', 'Rp']),

                Forms\Components\TextInput::make('price')
                    ->prefix('Rp.')
                    ->minValue(0)
                //     ->inputMode('decimal')
                //     ->mask(RawJs::make('$money($input, ",")'))
                    ->numeric()
                    ->default(0)
                    ->dehydrateStateUsing(fn ($state) => ltrim($state, '0') === '' ? 0 : ltrim($state, '0')),
                Forms\Components\DatePicker::make('effective_at')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereIn('id', function ($sub) {
                    $sub->selectRaw('MAX(id)')
                        ->from('product_pricelists')
                        ->whereNull('deleted_at')
                        ->groupBy('product_id');
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    // ->money('IDR')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                // MoneyColumn::make('price')
                //     ->decimals(0),
                Tables\Columns\TextColumn::make('effective_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductPricelists::route('/'),
        ];
    }
}
