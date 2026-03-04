<?php

namespace App\Filament\Exports;

use App\Models\User;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class UserExporter extends Exporter
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),

            ExportColumn::make('name')
                ->label('Nombre'),

            ExportColumn::make('email')
                ->label('Correo electrónico'),

            ExportColumn::make('is_active')
                ->label('Estado')
                ->formatStateUsing(
                    fn (bool $state) => $state ? 'Activo' : 'Inactivo'
                ),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Su exportación de usuario se ha completado y ' . Number::format($export->successful_rows) . ' ' . str('fila')->plural($export->successful_rows) . ' ' . str('exportada')->plural($export->successful_rows);

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' error al exportar.';
        }

        return $body;
    }
}
