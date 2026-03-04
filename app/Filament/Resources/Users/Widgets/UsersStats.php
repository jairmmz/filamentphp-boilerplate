<?php

namespace App\Filament\Resources\Users\Widgets;

use App\Services\UserService;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersStats extends StatsOverviewWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        $stats = app(UserService::class)->getStats();

        return [
            Stat::make("Total de usuarios", $stats['total'])
                ->icon(Heroicon::Users),

            Stat::make("Usuarios activos", $stats['actives'])
                ->icon(Heroicon::CheckCircle),

            Stat::make("Usuarios inactivos", $stats['inactives'])
                ->icon(Heroicon::XCircle)
                ->color('danger'),
        ];
    }
}
