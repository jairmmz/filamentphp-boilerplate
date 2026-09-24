<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class HealthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Health::checks([
            CacheCheck::new()->label('Caché'),
            DatabaseCheck::new()->label('Base de datos'),
            DatabaseSizeCheck::new()->label('Tamaño de la base de datos'),
            DebugModeCheck::new()->label('Modo depuración'),
            OptimizedAppCheck::new()->label('Aplicación optimizada'),
            QueueCheck::new()->label('Cola'),
            UsedDiskSpaceCheck::new()
                ->label('Espacio en disco')
                ->warnWhenUsedSpaceIsAbovePercentage(70)
                ->failWhenUsedSpaceIsAbovePercentage(90),
        ]);
    }
}
