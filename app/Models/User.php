<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Flogti\SpanishCities\Traits\HasTown;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasTown;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    public function calendars()
    {
        return $this->belongsToMany(Calendar::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function holidays()
    {
        return $this->hasMany(Holiday::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
