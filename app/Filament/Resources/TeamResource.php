<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeamResource\Pages;
use App\Filament\Resources\TeamResource\RelationManagers;
use App\Models\Team;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Teams';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $modelLabel = 'Team';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\Repeater::make('teamAffiliations')
                    ->relationship('teamAffiliations')
                    ->columnSpanFull()
                    ->schema([
                        Forms\Components\Select::make('product_group_cluster_id')
                            ->label('Product Group Cluster')
                            ->relationship('productGroupCluster', 'name')
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('target_dfr')
                            ->label('Target DFR')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('target_profiling')
                            ->label('Target Profiling')
                            ->numeric()
                            ->default(0),
                        Forms\Components\TextInput::make('target_master_call_list')
                            ->label('Target MCL')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(4)
                    ->defaultItems(0)
                    ->reorderable(false)
                    ->collapsible()
                    ->itemLabel(function (array $state, $record): ?string {
                        if (isset($state['product_group_cluster_id']) && $record) {
                            $cluster = \App\Models\ProductGroupCluster::find($state['product_group_cluster_id']);
                            return $cluster ? $cluster->name : null;
                        }
                        return null;
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('productGroupClusters.name')
                    ->label('Product Group Clusters')
                    ->badge()
                    ->separator(',')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('teamAffiliations')
                //     ->label('Total MCL')
                //     ->formatStateUsing(function ($record) {
                //         return $record->teamAffiliations->sum('target_master_call_list');
                //     })
                //     ->numeric()
                //     ->sortable(),
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
            'index' => Pages\ManageTeams::route('/'),
        ];
    }
}
