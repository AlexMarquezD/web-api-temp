<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_logout()
    {
        $this->withoutExceptionHandling();

        $response = $this->post(route('logout'));
        $response->assertStatus(200);
    }
}
