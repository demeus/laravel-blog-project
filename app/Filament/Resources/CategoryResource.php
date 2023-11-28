<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Category;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Enums\VisibilityStatusEnum;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static string|null $model = Category::class;

    protected static string|null $navigationGroup = 'Blog';

    protected static string|null $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        TextInput::make('title')
                            ->live()
                            ->required()->minLength(1)->maxLength(150)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ('edit' === $operation) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->minLength(1)
                            ->unique(ignoreRecord: true)
                            ->maxLength(150),
                        TextInput::make('text_color')
                            ->nullable(),
                        TextInput::make('bg_color')
                            ->nullable(),
                        Toggle::make('status')
                            ->label(__('categories.fields.is_visible'))
                            ->default(VisibilityStatusEnum::ACTIVE->value)
                            ->helperText(__('categories.fields.is_visible_help_text'))
                            ->afterStateHydrated(function (Toggle $component, string $state) {
                                $component->state($state == VisibilityStatusEnum::ACTIVE->value);
                            })
                            ->dehydrateStateUsing(fn(string $state): string => $state ? VisibilityStatusEnum::ACTIVE->value : VisibilityStatusEnum::INACTIVE->value),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->sortable(),
                TextColumn::make('text_color')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('bg_color')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver(),
            ])
            ->striped()
            ->deferLoading();
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
//            'create' => Pages\CreateCategory::route('/create'),
//            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
