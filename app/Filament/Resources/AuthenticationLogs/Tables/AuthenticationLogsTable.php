<?php

namespace App\Filament\Resources\AuthenticationLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AuthenticationLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("ip_address")
                    ->label("Dirección IP")
                    ->searchable()
                    ->sortable(),

                TextColumn::make("device_name")
                    ->label("Navegador/Dispositivo")
                    ->searchable()
                    ->default("Unknown Device"),

                TextColumn::make("user_agent")
                    ->label("User Agent")
                    ->searchable()
                    ->wrap(),

                TextColumn::make('device_name')
                    ->label('Dispositivo')
                    ->default('-')
                    ->searchable(),

                IconColumn::make('login_successful')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon(Heroicon::CheckCircle)
                    ->falseIcon(Heroicon::XCircle)
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                IconColumn::make('is_trusted')
                    ->label('¿Es confiable?')
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_suspicious')
                    ->label('¿Es sospechoso?')
                    ->boolean()
                    ->trueIcon(Heroicon::ExclamationTriangle)
                    ->trueColor('warning')
                    ->sortable(),

                TextColumn::make('login_at')
                    ->label('Inicio de sesión')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),

                TextColumn::make('logout_at')
                    ->label('Desconectado el')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('last_activity_at')
                    ->label('Última actividad')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('login_successful')
                    ->label('Estado de inicio de sesión')
                    ->placeholder('Todos los inicios de sesión')
                    ->trueLabel('Exitosos solo')
                    ->falseLabel('Fallidos solo'),

                TernaryFilter::make('is_trusted')
                    ->label('Dispositivo confiable')
                    ->placeholder('Todos los dispositivos')
                    ->trueLabel('Confiables solo')
                    ->falseLabel('No confiables solo'),

                TernaryFilter::make('is_suspicious')
                    ->label('Actividad sospechosa')
                    ->placeholder('Todas las actividades')
                    ->trueLabel('Sospechosas solo')
                    ->falseLabel('Normales solo'),

                Filter::make('active_sessions')
                    ->label('Sesiones activas')
                    ->query(fn (Builder $query): Builder => $query
                        ->where('login_successful', true)
                        ->whereNull('logout_at')
                    ),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
            ])
            ->defaultSort('login_at', 'desc');
    }

}
