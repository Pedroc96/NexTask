<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserM;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

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
        // Create user with ONLY the columns that exist in your table
        $user = UserM::create([
            'username' => 'testuser',
            'password' => Hash::make('password')
        ]);

        $this->actingAs($user);

        $response = $this->get('/');
        
        $response->assertStatus(200);
    }
}