<?php

namespace Tests\Feature\Filament;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_panel_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_guests_can_see_the_panel_login_page(): void
    {
        $this->get('/admin/login')->assertOk();
    }

    public function test_inactive_users_cannot_access_the_panel(): void
    {
        $user = User::factory()->create(['is_active' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_active_user_without_permission_is_denied_the_users_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/users')->assertForbidden();
    }

    public function test_user_with_permission_can_access_the_users_page(): void
    {
        $user = User::factory()->create();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'ViewAny:User', 'guard_name' => 'web']);
        $user->givePermissionTo('ViewAny:User');

        $this->actingAs($user)->get('/admin/users')->assertOk()->assertSee('usuarios');
    }
}
