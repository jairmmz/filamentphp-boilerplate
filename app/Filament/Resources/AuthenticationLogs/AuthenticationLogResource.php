<?php

namespace App\Filament\Resources\AuthenticationLogs;

use App\Filament\Resources\AuthenticationLogs\Pages\ManageAuthenticationLogs;
use App\Filament\Resources\AuthenticationLogs\Schemas\AuthenticationLogInfolist;
use App\Filament\Resources\AuthenticationLogs\Tables\AuthenticationLogsTable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog;

class AuthenticationLogResource extends Resource
{
    protected static ?string $model = AuthenticationLog::class;

    protected static ?int $navigationSort = 180;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;

    protected static string|\UnitEnum|null $navigationGroup = 'Análisis';

    protected static ?string $recordTitleAttribute = 'ip_address';

    protected static ?string $modelLabel = 'sesión';

    protected static ?string $pluralModelLabel = 'sesiones';

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('ViewAny:AuthenticationLog') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->can('ViewAny:AuthenticationLog') ?? false;
    }

    public static function infolist(Schema $schema): Schema
    {
        return AuthenticationLogInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AuthenticationLogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAuthenticationLogs::route('/'),
        ];
    }
}
