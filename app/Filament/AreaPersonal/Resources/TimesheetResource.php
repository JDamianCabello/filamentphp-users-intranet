<?php

namespace App\Filament\AreaPersonal\Resources;

use App\Filament\AreaPersonal\Resources\TimesheetResource\Pages;
use App\Filament\AreaPersonal\Resources\TimesheetResource\RelationManagers;
use App\Models\Timesheet;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TimesheetResource extends Resource
{
    protected static ?string $model = Timesheet::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';

    // Obtiene solo los registros del usuario autenticado
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id())->orderBy('id', 'desc');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('calendar_id')
                    ->label('Añadir al calendario')
                    ->searchable()
                    ->relationship('calendar', 'name')
                    ->preload()
                    ->noSearchResultsMessage('No existe ese calendario.')
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'WORK' => 'Tabajando',
                        'PAUSE' => 'En pausa',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('day_in')
                    ->required(),
                Forms\Components\DateTimePicker::make('day_out')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('calendar.name')
                    ->label('Calendario')
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                    /*Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $type): string => match ($type) {
                        'PAUSE' => 'info',
                        'WORK' => 'success',
                    }),*/
                Tables\Columns\TextColumn::make('day_in')
                    ->dateTime()
                    ->label('Hora de entrada')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('day_out')
                    ->dateTime()
                    ->label('Hora de salida')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'WORK' => 'Tabajando',
                        'PAUSE' => 'En pausa',
                    ])
                    ->label('Tipo'),
                Filter::make('onlyToday')
                    ->label('Ver solo hoy')
                    ->toggle()
                    ->default()
                    ->query(fn (Builder $query): Builder => $query->whereDate('day_in', now()->toDateString())),



            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListTimesheets::route('/'),
            'create' => Pages\CreateTimesheet::route('/create'),
            'edit' => Pages\EditTimesheet::route('/{record}/edit'),
        ];
    }
}
