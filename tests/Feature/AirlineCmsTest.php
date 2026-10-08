<?php

namespace Tests\Feature;

use App\Models\Airline;
use App\Models\FlightSchedule;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AirlineCmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_super_admin_can_access_airline_resource_pages(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['super_admin']);

        $airline = Airline::query()->create([
            'name' => 'Garuda Indonesia',
            'slug' => 'garuda-indonesia',
            'routes' => 'Jakarta (CGK)',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($admin)->get('/admin/airlines')->assertOk();
        $this->actingAs($admin)->get('/admin/airlines/create')->assertOk();
        $this->actingAs($admin)->get("/admin/airlines/{$airline->id}/edit")->assertOk();

        $batikAir = Airline::where('slug', 'batik-air')->first();
        $this->actingAs($admin)->get("/admin/airlines/{$batikAir->id}/edit")->assertOk();
    }

    public function test_operator_admin_can_access_airlines(): void
    {
        $admin = User::factory()->create(['is_active' => true]);
        $admin->syncRoles(['admin']);

        $this->actingAs($admin)->get('/admin/airlines')->assertOk();
    }

    public function test_airline_slug_is_automatically_generated_and_normalized(): void
    {
        $airline = Airline::query()->create([
            'name' => 'Pelita Air Service!!',
            'is_active' => true,
        ]);

        $this->assertSame('pelita-air-service', $airline->slug);
    }

    public function test_airline_logo_url_resolves_static_and_storage_paths(): void
    {
        $staticAirline = Airline::query()->create([
            'name' => 'Static Test Air',
            'slug' => 'static-test-air',
            'logo' => 'images/airlines/test.png',
            'is_active' => true,
        ]);
        $this->assertSame(asset('images/airlines/test.png'), $staticAirline->logo_url);

        Storage::fake('public');
        $uploaded = UploadedFile::fake()->image('custom-logo.png');
        $storedPath = $uploaded->store('airlines', 'public');

        $uploadedAirline = Airline::query()->create([
            'name' => 'Custom Air',
            'slug' => 'custom-air',
            'logo' => $storedPath,
            'is_active' => true,
        ]);

        $this->assertSame(Storage::disk('public')->url($storedPath), $uploadedAirline->logo_url);
    }

    public function test_homepage_and_flight_schedule_render_dynamic_airline_logos(): void
    {
        Storage::fake('public');
        $uploaded = UploadedFile::fake()->image('nusantara-air.png');
        $storedPath = $uploaded->store('airlines', 'public');

        Airline::query()->create([
            'name' => 'Nusantara Air',
            'slug' => 'nusantara-air',
            'routes' => 'Balikpapan (BPN)',
            'logo' => $storedPath,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        FlightSchedule::query()->create([
            'airline' => 'Nusantara Air',
            'route_from' => 'Balikpapan',
            'route_to' => FlightSchedule::KALIMARAU_ROUTE,
            'flight_number' => 'NA 101',
            'arrival_time' => '11:00',
            'type' => 'kedatangan',
            'is_active' => true,
            'days' => ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'],
        ]);

        // Homepage test
        $homeResponse = $this->get(route('home'));
        $homeResponse->assertOk()
            ->assertSee('Nusantara Air')
            ->assertSee(Storage::disk('public')->url($storedPath));

        // Flights page test
        $flightsResponse = $this->get(route('flights.index'));
        $flightsResponse->assertOk()
            ->assertSee('Nusantara Air')
            ->assertSee(Storage::disk('public')->url($storedPath));
    }
}
