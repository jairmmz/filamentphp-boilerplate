<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Result;
use Spatie\Health\Facades\Health;

class HealthStatus extends Page
{
    use HasPageShield;

    protected string $view = 'filament.pages.health-status';

    protected static string|\UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?int $navigationSort = 150;

    protected function getViewData(): array
    {
        return [
            'checkResults' => $this->runChecks(),
        ];
    }

    /** @return Collection<int, array{check: Check, result: Result}> */
    private function runChecks(): Collection
    {
        return Health::registeredChecks()
            ->map(fn (Check $check) => ['check' => $check, 'result' => $check->run()]);
    }
}
