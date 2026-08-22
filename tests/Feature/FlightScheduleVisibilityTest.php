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

    public function test_flight_schedule_routes_are_normalized_when_type_changes(): void
    {
        $schedule = FlightSchedule::create([
            'airline' => 'Test Air',
            'route_from' => 'Balikpapan',
            'route_to' => 'Surabaya',
            'type' => 'keberangkatan',
            'departure_time' => '09:30',
            'arrival_time' => '10:30',
            'is_active' => true,
            'days' => ['senin'],
        ]);

        $this->assertSame(FlightSchedule::KALIMARAU_ROUTE, $schedule->refresh()->route_from);
        $this->assertNull($schedule->arrival_time);

        $schedule->update([
            'type' => 'kedatangan',
            'route_from' => 'Balikpapan',
            'route_to' => 'Surabaya',
            'departure_time' => '09:30',
            'arrival_time' => '10:30',
        ]);

        $schedule->refresh();

        $this->assertSame('Balikpapan', $schedule->route_from);
        $this->assertSame(FlightSchedule::KALIMARAU_ROUTE, $schedule->route_to);
        $this->assertNull($schedule->departure_time);
        $this->assertNotNull($schedule->arrival_time);
    }
}
