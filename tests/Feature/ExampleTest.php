<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\UserModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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
        // Insert user directly using DB facade
        $userId = DB::table('users')->insertGetId([
            'username' => 'testuser',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Get user
        $user = UserModel::find($userId);
        
        // Login manually
        Auth::login($user);

        $response = $this->get('/');
        
        $response->assertStatus(200);
    }
}