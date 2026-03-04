<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getStats(): array
    {
        $stats = User::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as actives,
            SUM(CASE WHEN is_active = 0 THEN 1 ELSE 0 END) as inactives
        ")->first();

        return [
            'total' => (int) $stats->total,
            'actives' => (int) $stats->actives,
            'inactives' => (int) $stats->inactives,
        ];
    }
}
