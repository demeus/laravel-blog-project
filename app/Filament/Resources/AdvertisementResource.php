<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Advertisement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\AdvertisementResource\Pages;

class AdvertisementResource extends Resource
{
    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Advertisement';

    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema(static::getFormComponents())
            ->columns([
                'md' => 1,
                'lg' => 3,
            ]);
    }

    public static function getFormComponents() : array
    {
        return [
            Section::make('Content')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->minLength(1)
                        ->maxLength(150),

                    Textarea::make('code')
                        ->rows(13)
                        ->required()
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ]),
            Section::make('Settings')
                ->schema([

                    TextInput::make('height')
                        ->numeric(),

                    TextInput::make('width')
                        ->numeric(),

                    Toggle::make('status')
                        ->label('Status')
                        ->helperText('Enable or disable .'),

                    DateTimePicker::make('start_date')
                        ->timezone('UTC')
                        ->helperText('When not set, the article is considered as a draft.'),

                    DateTimePicker::make('end_date')
                        ->after('start_date')
                        ->timezone('UTC'),

                ])
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ]),
        ];
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('start_date')
                    ->date('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('end_date')
                    ->date('Y-m-d H:i')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
