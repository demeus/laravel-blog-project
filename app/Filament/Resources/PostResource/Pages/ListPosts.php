<?php

namespace App\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\ListRecords;
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
                ->icon('heroicon-o-document-check')
                ->query(fn (Builder $query) => $query->published()),
            'Draft' => Tab::make()
                ->icon('heroicon-o-pencil-square')
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
