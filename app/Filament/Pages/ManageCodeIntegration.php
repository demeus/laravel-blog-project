<?php

namespace App\Filament\Pages;

use App\Settings\CodeIntegration;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageCodeIntegration extends SettingsPage
{
    protected static string|null $navigationGroup = 'Settings';

    protected static string|null $navigationIcon = 'analytics';

    protected static string|null $title = 'Code Integration';

    protected static string|null $navigationLabel = 'Code Integration';

    protected static string $settings = CodeIntegration::class;

    protected static int|null $navigationSort = 12;


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Code Integration')
                    ->schema([
                        Repeater::make('Codes')
                            ->schema([
                                TextInput::make('name')->required(),
                                Textarea::make('code')->required(),
                            ])
                        ,
                    ]),
            ]);
    }
}
