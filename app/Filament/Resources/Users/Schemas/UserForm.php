<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nombres')
                            ->prefixIcon(Heroicon::Identification)
                            ->required(),

                        TextInput::make('email')
                            ->label('Correo electrónico')
                            ->prefixIcon(Heroicon::Envelope)
                            ->email()
                            ->unique()
                            ->required(),
                    ]),
                Grid::make(2)
                    ->schema([
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->prefixIcon(Heroicon::Key)
                            ->password()
                            ->required(fn (Operation $context): bool => $context === Operation::Create)
                            ->dehydrated(fn ($state) => filled($state))
                            ->minLength(6)
                            ->revealable()
                            ->confirmed(),

                        TextInput::make('password_confirmation')
                            ->label('Confirmar contraseña')
                            ->prefixIcon(Heroicon::Key)
                            ->password()
                            ->required(fn (Operation $context): bool => $context === Operation::Create)
                            ->minLength(6)
                            ->revealable()
                            ->dehydrated(false),
                    ]),
                Grid::make(2)
                    ->schema([
                        Select::make('roles')
                            ->label('Rol')
                            ->prefixIcon(Heroicon::UserGroup)
                            ->required()
                            ->relationship('roles', 'name', fn ($query) => $query->where('name', '!=', User::ROLE_SUPER_ADMIN))
                            ->searchable()
                            ->preload(),

                        Toggle::make('is_active')
                            ->label('Estado')
                            ->onIcon(Heroicon::CheckCircle)
                            ->offIcon(Heroicon::XMark)
                            ->onColor('success')
                            ->offColor('primary')
                            ->default(true)
                            ->inline(false)
                            ->belowContent('Si esta activo el usuario podrá acceder al panel administrador'),
                    ]),
            ])->columns(1);
    }
}
