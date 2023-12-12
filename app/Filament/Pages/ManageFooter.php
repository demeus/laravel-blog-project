<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;


class ManageFooter extends SettingsPage
{
    protected static string|null $navigationGroup = 'Settings';

    protected static string|null $navigationIcon = 'icon-document-footer';

    protected static string $settings = FooterSettings::class;

    protected static string|null $title = 'Footer Settings';

    protected static string|null $navigationLabel = 'Footer';

//    protected static string|null $navigationParentItem = 'General';


    protected static int|null $navigationSort = 11;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')
                ->schema([
                    TextInput::make('copyright')
                        ->label('Copyright notice')
                        ->required(),
                    Repeater::make('links')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')
                                ->url()
                                ->required(),
                        ])
                        ->columns(2),
                ])
            ]);

    }
}
