<?php

namespace App\Filament\Resources;

use App\Enums\VisibilityStatusEnum;
use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

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
                        ColorPicker::make('text_color')
                            ->nullable(),


                        Toggle::make('status')
                            ->label(__('categories.fields.is_visible'))
                            ->default(VisibilityStatusEnum::ACTIVE->value)
                            ->afterStateHydrated(function (Toggle $component, string $state) {
                                $component->state($state == VisibilityStatusEnum::ACTIVE->value);
                            })
                            ->dehydrateStateUsing(
                                fn(
                                    string $state
                                ): string => $state ? VisibilityStatusEnum::ACTIVE->value : VisibilityStatusEnum::DISABLED->value
                            ),

                        Toggle::make('show_in_navigation')
                            ->label('Show in navigation')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order'),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('posts_count')
                    ->counts('posts')
                    ->sortable(),

                ToggleColumn::make('show_in_navigation')
                    ->label('Show in navigation'),

                ToggleColumn::make('status')
                    ->label(__('categories.fields.is_visible')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->striped()
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->slideOver(),
            ])
            ->striped()
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->recordClasses(fn(Category $record) => $record->deleted_at === 'draft' ? 'opacity-30' : null)
            ->paginated(false)
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
//            'edit'   => Pages\EditCategory::route('/{record}/edit'),
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
