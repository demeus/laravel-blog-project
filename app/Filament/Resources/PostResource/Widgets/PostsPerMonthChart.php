<?php

namespace App\Filament\Resources\PostResource\Widgets;

use App\Models\Post;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;

class PostsPerMonthChart extends ChartWidget
{
    protected static string|null $heading = 'Blog posts';

    protected static int|null $contentHeight = 300;


    protected function getData(): array
    {
        $data = Trend::model(Post::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->dateColumn('published_at')
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts',
                    'data'  => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels'   => $data->map(fn(TrendValue $value) => Carbon::parse($value->date)->format('M')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
