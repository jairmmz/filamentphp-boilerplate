<?php

namespace App\Filament\Widgets;

use App\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StatsOverview extends StatsOverviewWidget
{
    use HasWidgetShield;

    protected static bool $isLazy = true;

    protected ?string $heading = 'Estadísticas generales';

    protected ?string $description = 'Estadísticas generales del sistema.';

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalUsers = User::query()->count();
        $totalRoles = Role::query()->count();
        $totalPermissions = Permission::query()->count();

        return [
            Stat::make('Total de usuarios', $totalUsers)
                ->description('Total de usuarios registrados')
                ->icon(Heroicon::User),

            Stat::make('Total de roles', $totalRoles)
                ->description('Total de roles registrados')
                ->icon(Heroicon::Clipboard),

            Stat::make('Total de permisos', $totalPermissions)
                ->description('Total de permisos registrados')
                ->icon(Heroicon::Key),
        ];
    }
}
