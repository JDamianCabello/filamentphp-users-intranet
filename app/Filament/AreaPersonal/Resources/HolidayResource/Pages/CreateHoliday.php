<?php

namespace App\Filament\AreaPersonal\Resources\HolidayResource\Pages;

use App\Filament\AreaPersonal\Resources\HolidayResource;
use App\Mail\HolidayPending;
use App\Models\Calendar;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        $adminUser = User::find(1);


        $dataToSend = [
            'user' => Auth::user(),
            'days' => $data['day'],
            'employee_name' => Auth::user()->name,
            'employee_email' => Auth::user()->email,
            'calendar_data' => Calendar::find($data['calendar_id']),
        ];

        Mail::to($adminUser->email)->send(new HolidayPending($dataToSend));

        $formattedDate = Carbon::parse($data['day'])->format('Y-m-d');
        $recipient = auth()->user();
        Notification::make()
            ->title('Solicitud de vacaciones enviada')
            ->body("El día {$formattedDate} está pendiente de aprobación.")
            ->sendToDatabase($recipient);
        return $data;
    }

}
