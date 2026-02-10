<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_access_admin_panel()
    {
        $response = $this->get('/admin/products');
        $response->assertRedirect('/login'); // Sense login -> Login
    }

    public function test_regular_users_cannot_access_admin_panel()
    {
        // Creem un usuari normal
        $user = User::factory()->create(['role' => 'user']);

        // Actuem com aquest usuari
        $response = $this->actingAs($user)->get('/admin/products');

        // Esperem un error 403 (Forbidden)
        $response->assertStatus(403);
    }

    public function test_admin_users_can_access_admin_panel()
    {
        // Creem un usuari admin
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/products');

        $response->assertStatus(200); // Èxit total
    }
}