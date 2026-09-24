<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfoList
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nombres'),

                        TextEntry::make('email')
                            ->label('Correo electrónico'),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextEntry::make('roles.name')
                            ->label('Rol')
                            ->placeholder('-'),

                        TextEntry::make('is_active')
                            ->label('Estado')
                            ->badge()
                            ->icon(fn (bool $state) => $state ? Heroicon::CheckCircle : Heroicon::XCircle)
                            ->formatStateUsing(
                                fn (bool $state) => $state ? 'Activo' : 'Inactivo',
                            )
                            ->color(fn (bool $state) => $state ? 'success' : 'danger'),
                    ]),

                Grid::make(2)
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Creado el')
                            ->dateTime('d/m/Y H:i:s'),

                        TextEntry::make('updated_at')
                            ->label('Actualizado el')
                            ->dateTime('d/m/Y H:i:s'),
                    ]),
            ])->columns(1);
    }
}
