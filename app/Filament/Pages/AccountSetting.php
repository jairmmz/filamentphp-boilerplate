<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Jeffgreco13\FilamentBreezy\Pages\MyProfilePage;

class AccountSetting extends MyProfilePage
{
    use HasPageShield;

    // public static function canAccess(): bool
    // {
    //     return auth()->user()->can('View:MyProfilePage');
    // }
}
