<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FlightSchedule extends Model
{
    public const KALIMARAU_ROUTE = 'Bandara Kalimarau - Berau';

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

    protected static function booted(): void
    {
        static::saving(function (FlightSchedule $flightSchedule): void {
            if ($flightSchedule->type === 'keberangkatan') {
                $flightSchedule->route_from = self::KALIMARAU_ROUTE;
                $flightSchedule->arrival_time = null;
            }

            if ($flightSchedule->type === 'kedatangan') {
                $flightSchedule->route_to = self::KALIMARAU_ROUTE;
                $flightSchedule->departure_time = null;
            }
        });
    }

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
