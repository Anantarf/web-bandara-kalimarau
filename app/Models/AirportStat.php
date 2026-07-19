<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'period_name',
        'period_date',
        'passenger_count',
        'flight_count',
        'cargo_count',
        'is_active',
    ];

    protected $casts = [
        'period_date' => 'date',
        'passenger_count' => 'integer',
        'flight_count' => 'integer',
        'cargo_count' => 'integer',
        'is_active' => 'boolean',
    ];
}
