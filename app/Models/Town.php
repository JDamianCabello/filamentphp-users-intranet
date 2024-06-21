<?php

namespace App\Models;

use Flogti\SpanishCities\Models\Town as Model;

class Town extends Model
{
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
