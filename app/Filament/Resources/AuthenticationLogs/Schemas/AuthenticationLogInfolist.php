<?php

namespace App\Filament\Resources\AuthenticationLogs\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuthenticationLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información de Acceso')
                    ->icon('heroicon-o-shield-check')
                    ->columns(4)
                    ->schema([
                        TextEntry::make('ip_address')
                            ->label('Dirección IP')
                            ->icon('heroicon-o-globe-alt')
                            ->copyable()
                            ->copyMessage('IP copiada')
                            ->default('-'),

                        TextEntry::make('login_at')
                            ->label('Inicio de sesión')
                            ->icon('heroicon-o-arrow-right-end-on-rectangle')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('logout_at')
                            ->label('Desconectado el')
                            ->icon('heroicon-o-arrow-left-end-on-rectangle')
                            ->dateTime('d/m/Y H:i:s')
                            ->placeholder('-'),

                        TextEntry::make('last_activity_at')
                            ->label('Última actividad')
                            ->icon('heroicon-o-clock')
                            ->dateTime('d/m/Y H:i:s'),
                    ])
                    ->columnSpanFull(),

                Section::make('Dispositivo y Ubicación')
                    ->icon('heroicon-o-device-phone-mobile')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('device_name')
                            ->label('Navegador / Dispositivo')
                            ->icon('heroicon-o-computer-desktop')
                            ->default('Desconocido'),

                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->icon('heroicon-o-code-bracket')
                            ->columnSpanFull()
                            ->copyable()
                            ->copyMessage('User Agent copiado')
                            ->default('-'),
                    ])
                    ->columnSpanFull(),

                Section::make('Estado')
                    ->icon('heroicon-o-check-badge')
                    ->columns(3)
                    ->schema([
                        IconEntry::make('login_successful')
                            ->label('Estado')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        IconEntry::make('is_trusted')
                            ->label('¿Es confiable?')
                            ->boolean()
                            ->trueIcon('heroicon-o-shield-check')
                            ->falseIcon('heroicon-o-shield-exclamation')
                            ->trueColor('success')
                            ->falseColor('warning'),

                        IconEntry::make('is_suspicious')
                            ->label('¿Es sospechoso?')
                            ->boolean()
                            ->trueIcon('heroicon-o-exclamation-triangle')
                            ->falseIcon('heroicon-o-check-circle')
                            ->trueColor('danger')
                            ->falseColor('success'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
