<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserModel;  
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        
        $response->assertStatus(302)
                 ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_home(): void
    {
        // Create and authenticate a user
        $user = UserModel::factory()->create();
        
        // Use Laravel's built-in authentication
        $this->actingAs($user);

        $response = $this->get('/');
        
        $response->assertStatus(200);
    }
}