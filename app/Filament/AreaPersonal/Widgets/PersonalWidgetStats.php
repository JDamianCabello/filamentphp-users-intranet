<?php

namespace App\Filament\AreaPersonal\Widgets;

use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Horas trabajadas', $this->getTotalWork(auth()->user())),
            Stat::make('Tiempo total en pausa', $this->getTotalPause(auth()->user())),
            Stat::make('Vacaciones pendientes de aprobación', $this->getPendingHoliday(auth()->user())),
            Stat::make('Vacaciones aprobadas', $this->getApprovedHoliday(auth()->user())),
        ];
    }

    protected function getPendingHoliday(User $user){
        return $user->holidays()->where('status', 'pending')->count();
    }

    protected function getApprovedHoliday(User $user){
        return $user->holidays()->where('status', 'approved')->count();
    }

    protected function getTotalWork(User $user){
        $timesheets = $user->timesheets()
            ->where('type','WORK')->get();

        $timeInSecons = $this->summTimeSheets($timesheets);
        return gmdate("H:i:s", $timeInSecons);

    }

    protected function getTotalPause(User $user){
        $timesheets = $user->timesheets()
            ->where('type','PAUSE')->get();

        $timeInSecons = $this->summTimeSheets($timesheets);
        return gmdate("H:i:s", $timeInSecons);
    }

    private function summTimeSheets($timesheets){
        $sumSeconds = 0;
        foreach ($timesheets as $timesheet) {
            $startTime = Carbon::parse($timesheet->day_in);
            $finishTime = Carbon::parse($timesheet->day_out);

            $totalDuration = $startTime->diffInSeconds($finishTime);
            $sumSeconds = $sumSeconds + $totalDuration;

        }
        return $sumSeconds;
    }
}
