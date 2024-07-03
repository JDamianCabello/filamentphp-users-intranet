<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'town_id', 'is_active', 'responsible_user_id', 'calendar_id'];

    public function town()
    {
        return $this->belongsTo(Town::class);
    }

    public function responsibleUser()
    {
        return $this->belongsTo(User::class, 'responsible_user_id');
    }

    public function calendar()
    {
        return $this->belongsTo(Calendar::class);
    }
}
