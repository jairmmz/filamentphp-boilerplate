<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Services\PdfService;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Mpdf\Mpdf;

use function Illuminate\Support\now;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombres')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('email')
                    ->label('Correo electrónico')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->color('warning')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('is_active')
                    ->label("Estado")
                    ->badge()
                    ->icon(fn(bool $state) => $state ? Heroicon::CheckCircle : Heroicon::XCircle)
                    ->formatStateUsing(
                        fn(bool $state) => $state ? "Activo" : "Inactivo",
                    )
                    ->color(fn(bool $state) => $state ? "success" : "danger")
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->label('Rol')
                    ->relationship('roles', 'name')
                    ->searchable()
                    ->preload(),

                SelectFilter::make("is_active")
                    ->label("Estado")
                    ->options([
                        1 => "Activo",
                        0 => "Inactivo",
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ImportAction::make('importUsersExcel')
                    ->importer(UserImporter::class)
                    ->icon(Heroicon::ArrowUpTray)
                    ->label('Importar CSV')
                    ->color('warning'),

                ExportAction::make('exportUsersExcel')
                    ->exporter(UserExporter::class)
                    ->icon(Heroicon::ArrowDownTray)
                    ->label('Exportar Excel')
                    ->color('success'),

                Action::make('exportUsersPdf')
                    ->label('Exportar PDF')
                    ->color('danger')
                    ->icon(Heroicon::ArrowDownCircle)
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar exportación')
                    ->modalDescription('Se generará un archivo PDF con los registros filtrados actualmente. ¿Desea continuar?')
                    ->modalSubmitActionLabel('Sí, exportar')
                    ->modalCancelActionLabel('Cancelar')
                    ->action(function (Table $table, PdfService $service) {
                        $users = $table->getLivewire()->getFilteredSortedTableQuery()->get();

                        return $service->generate(
                            'exports.pdf.users',
                            compact('users'),
                            'reporte_usuarios',
                            ['title' => 'Reporte de usuarios']
                        );
                    }),
            ]);
    }
}
