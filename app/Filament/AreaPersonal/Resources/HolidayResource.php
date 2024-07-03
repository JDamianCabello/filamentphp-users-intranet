<?php

namespace App\Filament\AreaPersonal\Resources;

use App\Filament\AreaPersonal\Resources\HolidayResource\Pages;
use App\Filament\AreaPersonal\Resources\HolidayResource\RelationManagers;
use App\Models\Holiday;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class HolidayResource extends Resource
{
    protected static ?string $model = Holiday::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    // protected static ?string $slug = 'vacaciones';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('calendar_id')
                    ->relationship(name: 'calendar', titleAttribute: 'name')
                    ->required()
                    ->label('Calendario'),
                DatePicker::make('day')
                    ->required()
                    ->label('Día solicitado'),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    protected function getRedirectUrl() : string
    {
        return $this->getResource()::getUrl('holidays');
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('calendar.name')
                ->searchable()
                ->sortable(),
            TextColumn::make('user.name')
                ->searchable()
                ->sortable(),
            TextColumn::make('day')
                ->date()
                ->searchable()
                ->sortable(),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'gray',
                    'approved' => 'success',
                    'rejected' => 'danger',
                })
        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'pending' => 'Pendiente',
                    'approved' => 'Aprobada',
                    'rejected' => 'Rechazada',
                ])
                ->label('Estado de las solicitudes')
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
            'index' => Pages\ListHolidays::route('/'),
            'create' => Pages\CreateHoliday::route('/create'),
            'edit' => Pages\EditHoliday::route('/{record}/edit'),
        ];
    }
}
