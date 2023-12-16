<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use App\Settings\CodeIntegration;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class ManageCodeIntegration extends SettingsPage
{
    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'analytics';

    protected static ?string $title = 'Code Integration';

    protected static ?string $navigationLabel = 'Code Integration';

    protected static string $settings = CodeIntegration::class;

    protected static ?int $navigationSort = 12;

    public function form(Form $form) : Form
    {
        return $form
            ->schema([
                Section::make('Code Integration')
                    ->schema([
                        Repeater::make('Codes')
                            ->schema([
                                TextInput::make('name')->required(),
                                Textarea::make('code')->required(),
                            ]),
                    ]),
            ]);
    }
}
