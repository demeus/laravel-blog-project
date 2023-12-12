<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use DateTimeZone;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageGeneralSettings extends SettingsPage
{
    protected static string|null $navigationGroup = 'Settings';

    protected static string|null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static string|null $title = 'General Settings';

    protected static string|null $navigationLabel = 'General';

//    protected static string|null $navigationParentItem = 'Settings';


    protected static int|null $navigationSort = 10;


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('General Settings')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Site Name')
                            ->required(),

                        TextInput::make('site_description')
                            ->label('Site Description')
                            ->required(),

                        TagsInput::make('site_keywords')
                            ->label('Meta Keywords')
                            ->required(),

                        Select::make('time_zone')
                            ->options(array_combine($timezones = DateTimeZone::listIdentifiers(), $timezones))
                            ->label('Time Zone')
                            ->required(),
                        Select::make('datetime_format')
                            ->label('Datetime Format')
                            ->options([
                                'Y-m-d H:i:s' => 'Y-m-d H:i:s <span class="text-gray-500">(' . date('Y-m-d H:i:s') . ')</span>',
                                'm/d/Y h:i A' => 'm/d/Y h:i A <span class="text-gray-500">(' . date('m/d/Y h:i A') . ')</span>',
                                'd/m/Y H:i'   => 'd/m/Y H:i <span class="text-gray-500">(' . date('d/m/Y H:i') . ')</span>',
                                'j M Y G:i'   => 'j M Y G:i <span class="text-gray-500">(' . date('j M Y G:i') . ')</span>',
                            ])
                            ->required()
                            ->allowHtml(),

                        Toggle::make('display_cookie_notification_bar')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-o-x-mark'),

                        Toggle::make('site_active')
                            ->onIcon('heroicon-o-check')
                            ->offIcon('heroicon-o-x-mark'),

                    ]),
            ]);
    }
}
