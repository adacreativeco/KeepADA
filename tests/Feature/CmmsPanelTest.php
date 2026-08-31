<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CmmsPanelTest extends TestCase
{
    public function test_landing_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_language_switch_redirects(): void
    {
        $response = $this->get('/lang/en');
        $response->assertStatus(302);
    }

    public function test_unauthenticated_panel_access_redirects_to_login(): void
    {
        $response = $this->get('/panel/keepada-demo/dashboard');
        $response->assertRedirect('/login');
    }
}
