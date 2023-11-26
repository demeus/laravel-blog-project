<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;

class SettingsResource extends Resource
{
    protected static string|null $model = Settings::class;

    protected static string|null $navigationIcon = 'heroicon-o-cog';

    protected static int|null $navigationSort = 4;

    protected static string|null $navigationGroup = 'Settings';


    public static function form(Form $form): Form
    {
        $settings = Settings::all()->groupBy('category');

        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs($settings
                        ->map(function ($settingsGroup, $category) {
                            return Tabs\Tab::make($category)
                                ->schema($settingsGroup
                                    ->map(function ($setting) {
                                        return TextInput::make($setting->key)
                                            ->label($setting->key)
                                            ->default($setting->value);
                                    })
                                    ->toArray()
                                );
                        })
                        ->toArray()
                    ),
            ])->columns(1);
    }




    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
//            'edit' => Pages\EditSettings::route('/'),

        ];
    }
}
