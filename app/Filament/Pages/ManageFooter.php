<?php

namespace App\Filament\Pages;

use App\Settings\FooterSettings;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;


class ManageFooter extends SettingsPage
{
    protected static string|null $navigationGroup = 'Settings';

    protected static string|null $navigationIcon = 'document-footer';

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
                    Toggle::make('show_copyright')->live(),
                    TextInput::make('copyright')
                        ->label('Copyright notice')
                        ->hidden(fn (Get $get) => $get('show_copyright') === false),
                    Repeater::make('links')
                        ->schema([
                            TextInput::make('label')->required(),
                            TextInput::make('url')
                                ->url()
                                ->required(),
                        ])
                        ->columns(2),

                    Repeater::make('social_links')
                        ->schema([
                            TextInput::make('name')
                                ->label('Name')
                                ->columnSpan([
                                    'md' => 3,
                                ])
                                ->required(),
                            Select::make('icon')
                                ->label("Select icon")
                                ->placeholder("Select icon")
                                ->suffixIcon('heroicon-m-globe-alt')
                                ->suffixIconColor('primary')
                                ->options([
                                    'facebook' => 'Facebook',
                                    'instagram' => 'Instagram',
                                    'twitter' => 'Twitter',
                                    'youtube' => 'Youtube',
                                    'linkedin' => 'LinkedIn',
                                    'github' => 'GitHub',
                                ])
                                ->columnSpan([
                                    'md' => 2,
                                ]),

                            TextInput::make('url')
                                ->label('Url')
                                ->url()
                                ->required()
                                ->columnSpan([
                                    'md' => 5,
                                ]),

                        ])
                ])
            ]);

    }
}
