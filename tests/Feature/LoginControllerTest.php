<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
        Session::start();
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        $user = User::first();
        $response = $this->post(route('login'), ['email' => $user->email, 'password' => 'password']);
        $response->assertStatus(200);
    }
}
