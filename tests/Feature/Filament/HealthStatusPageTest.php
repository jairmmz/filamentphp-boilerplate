<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class HealthStatusPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_without_permission_is_denied_the_health_status_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin/health-status')->assertForbidden();
    }

    public function test_user_with_permission_can_see_the_health_status_page(): void
    {
        $user = User::factory()->create();
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name' => 'View:HealthStatus', 'guard_name' => 'web']);
        $user->givePermissionTo('View:HealthStatus');

        $this->actingAs($user)->get('/admin/health-status')
            ->assertOk()
            ->assertSee('Estado de salud')
            ->assertSee('Caché')
            ->assertSee('La caché responde correctamente.')
            ->assertDontSee('expected to be');
    }
}
