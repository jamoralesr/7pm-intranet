<?php

namespace App\Filament\Pages\Tenancy;
 
use App\Models\Space;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;
 
class RegisterSpace extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register space';
    }
 
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('slug'),
                TextInput::make('description'),
            ]);
    }
 
    protected function handleRegistration(array $data): Space
    {
        $space = Space::create($data);
 
        $space->members()->attach(auth()->user());
 
        return $space;
    }
}