<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static string|null $model = Activity::class;

    protected static string|null $navigationGroup = 'Web site';

    protected static string|null $navigationIcon = 'activity';

    protected static string|null $recordTitleAttribute = 'id';

    protected static int|null $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('log_name'),

                Textarea::make('description')
                    ->columnSpanFull(),

                TextInput::make('subject_type'),

                TextInput::make('event'),

                TextInput::make('subject_id'),

                TextInput::make('causer_type'),

                TextInput::make('causer_id'),

                Textarea::make('properties')
                    ->formatStateUsing(fn(Model $record) => $record->getRawOriginal('properties'))
                    ->json()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('log_name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('subject_id')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('causer_type')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('causer_id')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
            ->defaultSort('id', 'desc');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'view'  => Pages\ViewActivity::route('/{record}'),
        ];
    }

    protected function paginateTableQuery(Builder $query): Paginator
    {
        return $query->simplePaginate($this->getTableRecordsPerPage());
    }
}
