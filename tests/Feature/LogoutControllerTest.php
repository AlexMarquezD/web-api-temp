<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logout()
    {
        $this->withoutExceptionHandling();
        $user = User::first();
        $token = $user->tokens()->first();
        
        $response = $this->actingAs($user)
            ->post(route('logout'), [], ['Authorization' => 'Bearer ' . $token->token]);
        
        $response->assertStatus(200);
    }
}
