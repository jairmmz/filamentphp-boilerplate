<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_root_admin_cannot_be_updated(): void
    {
        $root = User::factory()->create(['id' => 1]);
        $editor = $this->userWith('Update:User');

        $this->assertFalse(app(UserPolicy::class)->update($editor, $root));
    }

    public function test_root_admin_cannot_be_deleted(): void
    {
        $root = User::factory()->create(['id' => 1]);
        $editor = $this->userWith('Delete:User');

        $this->assertFalse(app(UserPolicy::class)->delete($editor, $root));
    }

    public function test_user_with_permission_can_update_other_users(): void
    {
        $target = User::factory()->create();
        $editor = $this->userWith('Update:User');

        $this->assertTrue(app(UserPolicy::class)->update($editor, $target));
    }

    public function test_user_without_permission_cannot_view_users(): void
    {
        $reporter = User::factory()->create();

        $this->assertFalse(Gate::forUser($reporter)->allows('viewAny', User::class));
    }

    public function test_user_with_permission_can_view_users(): void
    {
        $viewer = $this->userWith('ViewAny:User');

        $this->assertTrue(Gate::forUser($viewer)->allows('viewAny', User::class));
    }

    private function userWith(string $permission): User
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $user = User::factory()->create();
        Permission::create(['name' => $permission, 'guard_name' => 'web']);
        $user->givePermissionTo($permission);

        return $user;
    }
}
