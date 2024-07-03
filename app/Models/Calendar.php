<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'year', 'service_id', 'is_active'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
