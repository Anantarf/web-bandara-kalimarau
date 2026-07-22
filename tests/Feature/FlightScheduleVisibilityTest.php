<?php

namespace Tests\Feature;

use App\Models\FlightSchedule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlightScheduleVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_active_flight_schedules_are_shown_on_the_public_page(): void
    {
        FlightSchedule::create([
            'airline' => 'Aktif Air',
            'route_from' => 'Kalimarau',
            'route_to' => 'Balikpapan',
            'type' => 'keberangkatan',
            'is_active' => true,
            'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'],
        ]);

        FlightSchedule::create([
            'airline' => 'Nonaktif Air',
            'route_from' => 'Kalimarau',
            'route_to' => 'Surabaya',
            'type' => 'keberangkatan',
            'is_active' => false,
            'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'],
        ]);

        $response = $this->get(route('flights.index'));

        $response->assertOk()
            ->assertSee('Aktif Air')
            ->assertDontSee('Nonaktif Air');
    }
}
