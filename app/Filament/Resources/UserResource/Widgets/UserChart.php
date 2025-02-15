<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData() : array
    {
        // Totals per month
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfMonth(),
                end: now()->endOfMonth(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'User Registered',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType() : string
    {
        return 'bar';
    }
}
