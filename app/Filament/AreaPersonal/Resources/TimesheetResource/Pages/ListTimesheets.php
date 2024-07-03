<?php

namespace App\Filament\AreaPersonal\Resources\TimesheetResource\Pages;

use App\Filament\AreaPersonal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {

        $lastTimesheet = auth()->user()->timesheets()->latest()->first();

        return [
            Action::make('inWork')
                ->label('Entrar a trabajar')
                ->requiresConfirmation()
                ->modalHeading('Confimar entrada')
                ->modalDescription('¿Estás seguro de que quieres comenzar a trabajar?, en caso de error no podrás modificarlo.')
                ->modalSubmitActionLabel('Confirmar')
                ->modalCancelActionLabel('Ir atras')
                ->modalIcon('heroicon-o-clock')
                ->color('success')
                ->visible(!$lastTimesheet || $lastTimesheet->day_out !== null)
                ->action(function () {
                    $timesheet = new Timesheet([
                        'type' => 'WORK',
                        'user_id' => auth()->id(),
                        'day_in' => Carbon::now(),
                        'day_out' => null,
                        'calendar_id' => 1
                    ]);
                    $timesheet->save();

                    Notification::make()
                        ->title('Has comenzado a trabajar, ¡buen día!')
                        ->success()
                        ->color('success')
                        ->send();
                }),
                Action::make('stopWork')
                ->label('Salir de trabajar')
                ->requiresConfirmation()
                ->modalHeading('Confimar salida')
                ->modalDescription('¿Estás seguro de que quieres confirmar la salida?, el tiempo no cuenta como pausa y en caso de error no podrás modificarlo.')
                ->modalSubmitActionLabel('Confirmar')
                ->modalCancelActionLabel('Ir atras')
                ->modalIcon('heroicon-o-clock')
                ->visible($lastTimesheet && $lastTimesheet->day_out === null)
                ->action(function () use ($lastTimesheet){
                    $lastTimesheet->update([
                        'day_out' => Carbon::now()
                    ]);
                    $lastTimesheet->save();

                    Notification::make()
                        ->title('Has terminado tu jornada laboral, ¡hasta mañana!')
                        ->success()
                        ->color('success')
                        ->send();
                }),
                Action::make('inPause')
                ->label('Comenzar pausa')
                ->requiresConfirmation()
                ->modalHeading('Confimar pausa')
                ->modalDescription('¿Estás seguro de que quieres comenzar una pausa?, en caso de error no podrás modificarlo.')
                ->modalSubmitActionLabel('Confirmar')
                ->modalCancelActionLabel('Ir atras')
                ->modalIcon('heroicon-o-pause')
                ->color('info')
                ->visible($lastTimesheet && $lastTimesheet->type !== 'PAUSE' && $lastTimesheet->day_out === null)
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->update([
                        'day_out' => Carbon::now()
                    ]);
                    $lastTimesheet->save();
                    $timesheet = new Timesheet([
                        'type' => 'PAUSE',
                        'user_id' => auth()->id(),
                        'day_in' => Carbon::now(),
                        'day_out' => null,
                        'calendar_id' => 1
                    ]);
                    $timesheet->save();

                    Notification::make()
                        ->title('Has comenzado una pausa, ¡disfrútala!')
                        ->success()
                        ->color('info')
                        ->send();
                }),
                Action::make('stopPause')
                ->label('Continuar trabajando')
                ->requiresConfirmation()
                ->modalHeading('Confimar FIN de pausa')
                ->modalDescription('¿Estás seguro de que quieres volver al trabajo?, en caso de error no podrás modificarlo.')
                ->modalSubmitActionLabel('Confirmar')
                ->modalCancelActionLabel('Ir atras')
                ->modalIcon('heroicon-o-play')
                ->color('success')
                ->visible($lastTimesheet && $lastTimesheet->type === 'PAUSE' && $lastTimesheet->day_out === null)
                ->action(function () use ($lastTimesheet) {
                    $lastTimesheet->update([
                        'day_out' => Carbon::now()
                    ]);
                    $lastTimesheet->save();
                    $timesheet = new Timesheet([
                        'type' => 'WORK',
                        'user_id' => auth()->id(),
                        'day_in' => Carbon::now(),
                        'day_out' => null,
                        'calendar_id' => 1
                    ]);
                    $timesheet->save();

                    Notification::make()
                        ->title('Has vuelto al trabajo, ¡buen día!')
                        ->success()
                        ->color('info')
                        ->send();
                }),
            Actions\CreateAction::make()
            ->label('Registrar tiempo'),
        ];
    }
}
