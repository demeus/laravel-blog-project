<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use App\Filament\Resources\PostResource;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PostResource\Widgets\PostsPerMonthChart;
use Illuminate\Database\Eloquent\Builder;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions() : array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs() : array
    {
        return [
            'Published' => Tab::make()
                ->query(fn (Builder $query) => $query->published()),
            'Draft' => \Filament\Resources\Components\Tab::make()
                ->query(fn (Builder $query) => $query->unpublished()),
        ];
    }

//    protected function getFooterWidgets() : array
//    {
//        return [
//            PostsPerMonthChart::class,
//        ];
//    }
}
