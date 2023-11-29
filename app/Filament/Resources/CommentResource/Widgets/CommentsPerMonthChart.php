<?php

namespace App\Filament\Resources\CommentResource\Widgets;

use App\Models\Comment;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class CommentsPerMonthChart extends ChartWidget
{
    protected static string|null $heading = 'Comments';

    protected function getData(): array
    {
        $data = Trend::model(Comment::class)
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->dateColumn('created_at')
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Comments',
                    'data'  => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels'   => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
