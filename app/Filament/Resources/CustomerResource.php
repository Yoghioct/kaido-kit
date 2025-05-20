<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $slug = 'master-data/customers/list';
    protected static ?string $navigationGroup = 'Master Data';


    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('code')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),
            Forms\Components\TextInput::make('prefix_title')
                ->label('Prefix Title')
                ->maxLength(255),
            Forms\Components\TextInput::make('full_name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('suffix_title')
                ->label('Suffix Title')
                ->maxLength(255),
            Forms\Components\Select::make('specialist_id')
                ->relationship('specialist', 'name')
                ->searchable()
                ->preload(),
            Forms\Components\Select::make('title_id')
                ->relationship('title', 'name')
                ->searchable()
                ->preload(),
            Forms\Components\Toggle::make('is_kpdm')
                ->label('Is KPDM')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix_title')
                    ->label('Prefix Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('suffix_title')
                    ->label('Suffix Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('specialist.name')
                    ->label('Specialist'),
                Tables\Columns\TextColumn::make('title.name')
                    ->label('Title'),
                Tables\Columns\IconColumn::make('is_kpdm')
                    ->label('KPDM')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('specialist_id')
                    ->relationship('specialist', 'name')
                    ->label('Specialist'),
                Tables\Filters\SelectFilter::make('title_id')
                    ->relationship('title', 'name')
                    ->label('Title'),
                Tables\Filters\TernaryFilter::make('is_kpdm')
                    ->label('KPDM'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->modalHeading('Edit Customer'),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->recordUrl(null)
            ->recordAction(null)
            ->striped()
            ->deferLoading();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCustomers::route('/'),
        ];
    }
}
