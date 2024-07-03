<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Town;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationLabel = 'Empleados';

    protected static ?string $navigationGroup = 'Gestion de empleados';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Datos de la aplicacion')
                    ->columns(3)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombre')
                            ->helperText('Nombre del empleado')
                            ->required(),
                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->helperText('Correo electrónico del empleado para iniciar sesion en la aplicacion')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->helperText('Contraseña del empleado para iniciar sesion en la aplicacion')
                            ->password()
                            ->autocomplete(false)
                            ->hiddenOn('edit')
                            ->required(),
                    ]),

                Section::make('Datos personales')
                    ->columns(3)
                    ->schema([
                        TextInput::make('first_name')
                            ->label('Nombre')
                            ->required(),
                        TextInput::make('last_name')
                            ->label('Apellidos')
                            ->required(),
                        DatePicker::make('date_of_birth')
                            ->label('Fecha de nacimiento')
                            ->native(false)
                            ->locale('es')
                            ->displayFormat('d F Y')
                            ->minDate(now()->subYears(70))
                            ->maxDate(now()->subYears(16))
                            ->closeOnDateSelection(),
                        TextInput::make('phone')
                            ->label('Teléfono')
                            ->numeric()
                            ->required(),
                        TextInput::make('mobile')
                            ->label('Móvil')
                            ->numeric()
                            ->required(),
                        TextInput::make('dni')
                            ->label('DNI'),
                        TextInput::make('social_security_number')
                            ->label('Número de Seguridad Social'),
                    ]),

                Section::make('Dirección')
                    ->columns(3)
                    ->schema([
                        Select::make('town_id')
                            ->label('Población')
                            ->searchable()
                            ->relationship('town', 'name')
                            ->preload()
                            ->noSearchResultsMessage('No existe esa población.')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $town = Town::find($state);
                                if ($town) {
                                    $set('province_name', $town->province->name ?? null);
                                    $set('community_name', $town->province->community->name ?? null);
                                } else {
                                    $set('province_name', null);
                                    $set('community_name', null);
                                }
                            }),
                        TextInput::make('province_name')
                            ->label('Provincia')
                            ->helperText('Solo se muestra como caracter informativo para el usuario')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('community_name')
                            ->label('Comunidad Autónoma')
                            ->helperText('Solo se muestra como caracter informativo para el usuario')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('address')
                            ->label('Dirección')
                            ->required(),
                        TextInput::make('zip_code')
                            ->label('Código Postal')
                            ->required(),
                    ]),

                Section::make('Desactivar usuario sin eliminarlo')
                ->columns(3)
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('¿Activo?')
                        ->default(true)
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre')
                    ->getStateUsing(fn ($record) => $record->first_name . ' ' . $record->last_name)
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('town.name')
                    ->label('Población'),
                Tables\Columns\TextColumn::make('province_name')
                    ->label('Provincia')
                    ->getStateUsing(fn ($record) => $record->town->province->name ?? '-'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono'),
                Tables\Columns\TextColumn::make('mobile')
                    ->label('Móvil')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dni')
                    ->label('DNI')
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
