<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Number;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Nombres')
                ->requiredMapping()
                ->rules(['required', 'min:3', 'max:255']),

            ImportColumn::make('email')
                ->label('Correo electrónico')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),

            ImportColumn::make('password')
                ->label('Contraseña')
                ->requiredMapping()
                ->rules(['required', 'max:255'])
                ->castStateUsing(fn (string $state) => Hash::make($state)),

            ImportColumn::make('is_active')
                ->label('Estado')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): User
    {
        return User::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Su importación de usuario se ha completado y ' . Number::format($import->successful_rows) . ' ' . str('fila')->plural($import->successful_rows) . ' ' . str('importada')->plural($import->successful_rows);

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('fila')->plural($failedRowsCount) . ' fallo en la importación.';
        }

        return $body;
    }
}
