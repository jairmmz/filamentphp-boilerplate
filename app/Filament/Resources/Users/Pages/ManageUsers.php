<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Imports\UserImporter;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Users\Widgets\UsersStats;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Icons\Heroicon;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            UsersStats::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make('importUsersExcel')
                ->importer(UserImporter::class)
                ->icon(Heroicon::ArrowUpTray)
                ->label('Importar CSV'),

            CreateAction::make()
                ->icon(Heroicon::Plus),
        ];
    }
}
