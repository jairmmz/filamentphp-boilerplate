<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Activitylog\Models\Activity;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_updates_are_logged(): void
    {
        $user = User::factory()->create(['name' => 'Original Name']);

        $user->update(['name' => 'Updated Name']);

        $activity = Activity::query()
            ->where('subject_id', $user->id)
            ->where('event', 'updated')
            ->sole();

        $changes = $activity->attribute_changes;

        $this->assertNotNull($changes);
        $this->assertSame('Updated Name', $changes->get('attributes')['name']);
        $this->assertSame('Original Name', $changes->get('old')['name']);
    }

    public function test_empty_updates_are_not_logged(): void
    {
        $user = User::factory()->create(['name' => 'Original Name']);

        $user->save();

        $this->assertSame(0, Activity::query()->where('event', 'updated')->count());
    }
}
