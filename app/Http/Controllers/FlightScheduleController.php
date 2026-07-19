<?php

namespace App\Http\Controllers;

use App\Models\FlightSchedule;

class FlightScheduleController extends Controller
{
    public function index()
    {
        $departures = FlightSchedule::query()
            ->active()
            ->where('type', 'keberangkatan')
            ->orderBy('sort_order')
            ->orderBy('departure_time')
            ->get();

        $arrivals = FlightSchedule::query()
            ->active()
            ->where('type', 'kedatangan')
            ->orderBy('sort_order')
            ->orderBy('arrival_time')
            ->get();

        $logos = [
            'Batik Air' => asset('images/airlines/batik-air.svg'),
            'Super Air Jet' => asset('images/airlines/super-air-jet.svg'),
            'AirAsia' => asset('images/airlines/airasia.svg'),
            'Sriwijaya Air' => asset('images/airlines/sriwijaya-air.png'),
            'Citilink' => asset('images/airlines/citilink.svg'),
            'Wings Air' => asset('images/airlines/wings-air.svg'),
            'Smart Aviation' => asset('images/airlines/smart-aviation.png'),
        ];

        return view('flights.index', compact('departures', 'arrivals', 'logos'));
    }
}
