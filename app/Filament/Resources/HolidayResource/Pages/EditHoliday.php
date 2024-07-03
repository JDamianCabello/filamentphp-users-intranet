<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Mail\HolidayRejected;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record = parent::handleRecordUpdate($record, $data);

        if ($record->status === 'approved') {
            $user = User::find($record->user_id);
            $dataToSend = [
                'name' => $user->name,
                'day' => $record->day,
                'email' => $user->email,
            ];

            Mail::to($record->user->email)->send(new HolidayApproved($dataToSend));

            $formattedDate = Carbon::parse($data['day'])->format('Y-m-d');
            Notification::make()
                ->title('Solicitud de vacaciones APROBADA')
                ->body("El día {$formattedDate} está aprobado.")
                ->success()
                ->sendToDatabase($user);
        }

        if ($record->status === 'rejected') {
            $user = User::find($record->user_id);
            $dataToSend = [
                'name' => $user->name,
                'day' => $record->day,
                'email' => $user->email,
            ];

            Mail::to($user->email)->send(new HolidayRejected($dataToSend));

            $formattedDate = Carbon::parse($data['day'])->format('Y-m-d');
            Notification::make()
                ->title('Solicitud de vacaciones RECHAZADA')
                ->body("El día {$formattedDate} está rechazado.")
                ->danger()
                ->sendToDatabase($user);
        }

        return $record;
    }
}
