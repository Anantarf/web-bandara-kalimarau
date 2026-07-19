<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_navigation_exposes_mobile_menu_state(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('aria-controls="mobile-navigation"', false)
            ->assertSee(':aria-expanded="mobileOpen.toString()"', false);
    }
}
