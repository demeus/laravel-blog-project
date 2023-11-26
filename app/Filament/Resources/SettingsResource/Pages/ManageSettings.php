<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ManageRecords;

class ManageSettings extends CreateRecord
{
    protected static string $resource = SettingsResource::class;


//    protected function getHeaderActions(): array
//    {
//        return [
//            Actions\CreateAction::make(),
//        ];
//    }
}
