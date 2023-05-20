<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEmpty;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->roles();
        $this->permissions();
        $this->role_permission();
        $user = User::factory()->create();
        $this->user_role();
        Sanctum::actingAs(
            $user
        );
    }

    /**
     * A basic feature test user get.
     *
     * @return void
     */
    public function test_user_get(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->get(route('user.index'));
        assertEquals(count(json_decode($response->content())), 1);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test user create.
     *
     * @return void
     */
    public function test_user_create(): void
    {

        $response = $this->post(route('user.store'), $this->data());

        assertNotEmpty($response->original['access_token']);
        $response->assertStatus(201);
    }

    /**
     * A basic feature test user update.
     *
     * @return void
     */
    public function test_user_update(): void
    {
        $response = $this->put(route('user.update', 1), $this->data_update());

        assertEquals('juan', json_decode($response->content())->name);
        $response->assertStatus(200);
    }

    /**
     * A basic feature test user show.
     *
     * @return void
     */
    public function test_user_show(): void
    {
        $response = $this->get(route('user.show', 1));

        $response->assertStatus(200);
    }

    /**
     * A basic feature test user delete.
     *
     * @return void
     */
    public function test_user_delete(): void
    {
        $response = $this->delete(route('user.delete', 1));

        $response->assertStatus(204);
    }

    public function data()
    {
        return [
            'name' => 'juanito',
            'password' => 'password',
            'email' => 'juanito@gmail.com',
        ];
    }

    public function data_update()
    {
        return [
            'name' => 'juan'
        ];
    }

    public function roles()
    {
        Role::create(['name' => 'admin']);
    }

    public function permissions()
    {
        Permission::create(['name' => 'user-delete']);
        Permission::create(['name' => 'user-update']);
        Permission::create(['name' => 'user-show']);
        Permission::create(['name' => 'user-index']);
    }

    public function role_permission()
    {
        $role = Role::first();
        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
    }

    public function user_role()
    {
        $user = User::first();
        $user->assignRole('admin');
    }
}
