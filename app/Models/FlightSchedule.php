<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    protected $fillable = [
        'airline',
        'flight_number',
        'route_from',
        'route_to',
        'departure_time',
        'arrival_time',
        'days',
        'type',
        'is_active',
        'notes',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'days' => 'array',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'departure_time' => 'datetime:H:i',
            'arrival_time' => 'datetime:H:i',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
