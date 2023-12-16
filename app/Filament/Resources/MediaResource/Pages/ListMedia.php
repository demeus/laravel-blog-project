<?php

namespace App\Filament\Resources\MediaResource\Pages;

use Filament\Actions;
use App\Filament\Resources\MediaResource;
use Filament\Resources\Pages\ListRecords;

class ListMedia extends ListRecords
{
    protected static string $resource = MediaResource::class;

    //    protected function getHeaderActions(): array
    //    {
    //        return [
    //            Actions\CreateAction::make(),
    //        ];
    //    }
}
