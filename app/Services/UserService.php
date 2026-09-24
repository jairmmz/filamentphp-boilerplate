<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Get statistics about the users.
     *
     * @return array{total: int, actives: int, inactives: int}
     */
    public function getStats(): array
    {
        $stats = DB::table('users')->selectRaw('
            COUNT(*) as total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as actives,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactives
        ')->first();

        return [
            'total' => (int) ($stats->total ?? 0),
            'actives' => (int) ($stats->actives ?? 0),
            'inactives' => (int) ($stats->inactives ?? 0),
        ];
    }
}
