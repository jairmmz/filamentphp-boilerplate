<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Filament\Support\Icons\Heroicon;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombres')
                    ->required(),

                TextInput::make('email')
                    ->label('Correo electrónico')
                    ->email()
                    ->unique()
                    ->required(),

                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === Operation::Create)
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(6)
                    ->revealable()
                    ->confirmed(),

                TextInput::make('password_confirmation')
                    ->label('Confirmar contraseña')
                    ->password()
                    ->required(fn (string $context): bool => $context === Operation::Create)
                    ->minLength(6)
                    ->revealable()
                    ->dehydrated(false),

                Select::make('roles')
                    ->label('Rol')
                    ->required()
                    ->relationship('roles', 'name',
                        fn ($query) => $query->where('name', '!=', User::ROLE_SUPER_ADMIN))
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                Toggle::make('is_active')
                    ->label('Estado')
                    ->onIcon(Heroicon::CheckCircle)
                    ->offIcon(Heroicon::XMark)
                    ->onColor('success')
                    ->offColor('primary')
                    ->default(true)
                    ->inline(false)
                    ->belowContent('Si esta activo el usuario podrá acceder al panel administrador')
                    ->columnSpan(1),
            ]);
    }
}
