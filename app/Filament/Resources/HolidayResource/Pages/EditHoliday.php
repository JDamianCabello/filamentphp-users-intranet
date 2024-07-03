<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Mail\HolidayRejected;
use App\Models\User;
use Filament\Actions;
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
        }

        if ($record->status === 'rejected') {
            $user = User::find($record->user_id);
            $dataToSend = [
                'name' => $user->name,
                'day' => $record->day,
                'email' => $user->email,
            ];

            Mail::to($user->email)->send(new HolidayRejected($dataToSend));
        }

        return $record;
    }
}
