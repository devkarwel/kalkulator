<?php

namespace App\Filament\User\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;

class EditProfile extends BaseEditProfile
{
    protected function getNameFormComponent(): Component
    {
        return TextInput::make('name')
            ->disabled()
            ->dehydrated(false);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
            ->email()
            ->disabled()
            ->dehydrated(false);
    }
}
