<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\ExportBulkAction;
use App\Filament\Resources\UserResource\Pages;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;
use Filament\Infolists\Components\Section as InfolistSection;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $slug = 'settings/users';

    protected static ?string $title = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(
                    'User Information'
                )->schema([
                            TextInput::make('name')
                                ->required(),
                            TextInput::make('email')
                                ->required(),
                            TextInput::make('password')
                                ->required(),
                        ]),
            ]);
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('username')
                    ->searchable(),
                Tables\Columns\TextColumn::make('roles.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\Layout\Split::make([
                //     Tables\Columns\ImageColumn::make('avatar_url')
                //         ->searchable()
                //         ->circular()
                //         ->grow(false)
                //         ->getStateUsing(fn($record) => $record->avatar_url
                //             ? $record->avatar_url
                //             : "https://ui-avatars.com/api/?name=" . urlencode($record->name)),
                //     Tables\Columns\TextColumn::make('name')
                //         ->searchable()
                //         ->weight(FontWeight::Bold),
                //     Tables\Columns\Layout\Stack::make([
                //         Tables\Columns\TextColumn::make('roles.name')
                //             ->searchable()
                //             ->icon('heroicon-o-shield-check')
                //             ->grow(false),
                //         Tables\Columns\TextColumn::make('email')
                //             ->icon('heroicon-m-envelope')
                //             ->searchable()
                //             ->grow(false),
                //     ])->alignStart()->visibleFrom('lg')->space(1)
                // ]),
            ])
            ->filters([
                //
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                // Tables\Actions\ViewAction::make()
                //     ->label(''),
                // impersonate action
                Impersonate::make()
                    ->label('')
                    ->icon('heroicon-o-key'),
                Tables\Actions\EditAction::make()
                    ->label(''),
                Action::make('Set Role')
                    ->icon('heroicon-m-adjustments-vertical')
                    ->label('')
                    ->form([
                        Select::make('role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->getOptionLabelFromRecordUsing(fn($record) => $record->name),
                    ]),
                // Impersonate::make(),
                Tables\Actions\DeleteAction::make()
                    ->label(''),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(UserExporter::class),
                ImportAction::make()
                    ->importer(UserImporter::class)
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                    ->exporter(UserExporter::class)
            ])
            ->recordUrl(null)
            ->recordAction(null)
            ->striped()
            ->deferLoading();
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make('User Information')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                ]),
            ]);
    }

    // disable globally search
    public static function canGloballySearch(): bool
    {
        return false;
    }
}
