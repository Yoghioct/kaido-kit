<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutletResource\Pages;
use App\Filament\Resources\OutletResource\RelationManagers;
use App\Models\Outlet;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Cheesegrits\FilamentGoogleMaps\Fields\Map;

class OutletResource extends Resource
{
    protected static ?string $model = Outlet::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('outlet_group_id')
                    ->relationship('outletGroup', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('address')
                    ->maxLength(255)
                    ->columnSpanFull(),
                Map::make('location')
                    ->autocomplete(
                        fieldName: 'address',
                        // countries: ['ID'],
                    )
                    ->columnSpanFull()
                    ->debug()
                    ->reactive()
                    // ->geolocateOnLoad(true, false)
                    ->defaultZoom(15)
                    ->reverseGeocode([
                        'state' => '%A1',
                        'city' => '%A2',
                        'district' => '%A3',
                        'subdistrict' => '%A4',
                        'zip' => '%z',
                    ]) // reverse geocode marker location to form fields, see notes below
                    // ->autocompleteReverse(true)
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('lat', $state['lat']);
                        $set('long', $state['lng']);
                    }),

                Forms\Components\TextInput::make('state')
                    ->readOnly(),
                Forms\Components\TextInput::make('city')
                    ->readOnly(),
                Forms\Components\TextInput::make('district')
                    ->readOnly(),
                Forms\Components\TextInput::make('subdistrict')
                    ->readOnly(),
                Forms\Components\TextInput::make('zip')
                    ->readOnly(),

                Forms\Components\TextInput::make('lat')
                    ->readOnly()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('location', [
                            'lat' => floatVal($state),
                            'long' => floatVal($get('long')),
                        ]);
                    })
                    ->lazy()
                    ->maxLength(255),
                Forms\Components\TextInput::make('long')
                    ->readOnly()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $set('location', [
                            'lat' => floatval($get('lat')),
                            'long' => floatVal($state),
                        ]);
                    })
                    ->lazy()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('outletGroup.name')
                    ->label('Outlet Group')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lat')
                    ->searchable(),
                Tables\Columns\TextColumn::make('long')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label(''),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
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
            'index' => Pages\ManageOutlets::route('/'),
        ];
    }
}
