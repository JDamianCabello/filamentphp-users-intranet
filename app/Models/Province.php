<?php

namespace App\Models;

use Flogti\SpanishCities\Models\Province as Model;

class Province extends Model
{
    public function community()
    {
        return $this->belongsTo(Community::class);
    }
}
