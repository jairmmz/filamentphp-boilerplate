<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Checks\Result;
use Spatie\Health\Enums\Status;
use Spatie\Health\Facades\Health;

class HealthStatus extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.health-status';

    protected static ?string $navigationLabel = 'Estado de salud';

    protected static ?string $title = 'Estado de salud';

    protected ?string $heading = 'Estado de salud';

    protected static string|\UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 150;

    protected function getViewData(): array
    {
        return [
            'checkResults' => $this->runChecks(),
        ];
    }

    /** @return Collection<int, array{check: Check, result: Result, message: string}> */
    private function runChecks(): Collection
    {
        return Health::registeredChecks()
            ->map(fn (Check $check) => [
                'check' => $check,
                'result' => $result = $check->run(),
                'message' => $this->translateResult($check, $result),
            ]);
    }

    private function translateResult(Check $check, Result $result): string
    {
        $meta = $result->meta;

        return match (true) {
            $check instanceof CacheCheck => $result->status === Status::ok()
                ? 'La caché responde correctamente.'
                : 'No se pudo escribir ni leer un valor en la caché.',

            $check instanceof DatabaseCheck => $result->status === Status::ok()
                ? 'Conexión a la base de datos establecida.'
                : sprintf('No se pudo conectar a la base de datos (%s).', $meta['connection_name'] ?? ''),

            $check instanceof DatabaseSizeCheck => $result->status === Status::ok()
                ? 'El tamaño de la base de datos está dentro del límite permitido.'
                : 'La base de datos supera el tamaño máximo permitido.',

            $check instanceof DebugModeCheck => $result->status === Status::ok()
                ? 'El modo de depuración está desactivado.'
                : sprintf(
                    'Se esperaba que el modo de depuración estuviera en `%s`, pero está en `%s`.',
                    $this->toSpanish((bool) ($meta['expected'] ?? false)),
                    $this->toSpanish((bool) ($meta['actual'] ?? false)),
                ),

            $check instanceof OptimizedAppCheck => $result->status === Status::ok()
                ? 'Configuración, rutas y eventos están en caché.'
                : 'Hay configuración, rutas o eventos sin cachear. Ejecuta `php artisan optimize` en producción.',

            $check instanceof QueueCheck => $result->status === Status::ok()
                ? 'Los trabajos de la cola se están procesando.'
                : 'Los trabajos de la cola están fallando o no se han procesado.',

            $check instanceof UsedDiskSpaceCheck => $result->status === Status::ok()
                ? 'El espacio en disco es suficiente.'
                : sprintf('El espacio en disco está casi lleno (%s%% usado).', $meta['disk_space_used_percentage'] ?? '?'),

            default => $result->getNotificationMessage(),
        };
    }

    private function toSpanish(bool $value): string
    {
        return $value ? 'activado' : 'desactivado';
    }
}
