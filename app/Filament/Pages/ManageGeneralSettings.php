<?php

namespace App\Filament\Pages;

use DateTimeZone;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;

class ManageGeneralSettings extends SettingsPage
{
    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $title = 'General Settings';

    protected static ?string $navigationLabel = 'General';

    //    protected static string|null $navigationParentItem = 'Settings';

    protected static ?int $navigationSort = 10;

    public function form(Form $form) : Form
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
                            ->options($this->getDatetimeFormatOptions('primary'))
                            ->native(false)
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

    private function getDatetimeFormatOptions() : array
    {
        $color = 'rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ';

        $formats = [
            'Y-m-d H:i:s',
            'm/d/Y h:i A',
            'd/m/Y H:i',
            'j M Y G:i',
        ];

        $options = [];

        foreach ($formats as $format) {
            $dateTime = date($format);
            $badge = sprintf(
                '<span class="%s">%s</span>',
                $color,
                e($dateTime)
            );

            // create label with date format text and the styled badge.
            $optionLabel = sprintf('%s %s', $format, $badge);
            $options[$format] = $optionLabel;
        }

        return $options;
    }
}
