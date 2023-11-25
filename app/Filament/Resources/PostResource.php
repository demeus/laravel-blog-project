<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers\CommentsRelationManager;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static int|null $navigationSort = 1;

    protected static string|null $navigationGroup = 'Blog';

    protected static string|null $model = Post::class;

    protected static string|null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormComponents())
            ->columns([
                'md' => 1,
                'lg' => 3,
            ]);


    }

    public static function getFormComponents(): array
    {
        return [
            Forms\Components\Section::make('Content')
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


                    TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
                    RichEditor::make('body')
                        ->required()
                        ->fileAttachmentsDirectory('posts/images')->columnSpanFull(),

                    Forms\Components\MarkdownEditor::make('teaser')
                        ->maxLength(65535)
                        ->columnSpanFull()
                        ->helperText('An overview of the article used in the feed with the intent to entice readers to click through.'),

//                    SpatieMediaLibraryFileUpload::make('images')
//                        ->collection('images')
//                        ->conversion('medium')
//                        ->disk('media-library')
//                        ->downloadable()
//                        ->imageEditor()
//                        ->imageResizeMode('cover')
//                        ->multiple()
//                        ->visibility('public'),


                ])
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ]),
            Forms\Components\Section::make('Metadata')
                ->schema([
                    Select::make('user_id')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->required(),

                    SpatieMediaLibraryFileUpload::make('image')
                        ->collection('image')
                        ->conversion('medium')
                        ->disk('media-library')
                        ->downloadable()
                        ->imageCropAspectRatio('16:9')
                        ->imageEditor()
                        ->imageResizeMode('cover')
                        ->imageResizeTargetHeight('1080')
                        ->imageResizeTargetWidth('1920')
                        ->visibility('public'),

//                    FileUpload::make('image')->image()->directory('posts/thumbnails'),
                    Textarea::make('description')
                        ->maxLength(65535)
                        ->rows(5)
                        ->helperText('A short description used on the blog, social previews, and Google.'),

                    Toggle::make('commercial')
                        ->label('Is a commercial article')
                        ->helperText('If checked, the UI will focus on conversion.'),


                    DateTimePicker::make('published_at')
                        ->timezone('UTC')
                        ->helperText('When not set, the article is considered as a draft.'),

                    TagsInput::make('tags'),


                    Select::make('category_id')
                        ->relationship('category', 'title')
                        ->preload()
                        ->searchable(),

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn(Post $post): string|null => $post->created_at?->isoFormat('LLL')),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn(Post $post): string|null => $post->updated_at?->isoFormat('LLL')),
                        ])
                        ->hidden(fn(Post|null $post) => $post === null),
                ])
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ])
        ];
//        return $form
//            ->schema([
//                Section::make('Main Content')->schema(
//                    [
//
//                        TextInput::make('slug')->required()->minLength(1)->unique(ignoreRecord: true)->maxLength(150),
//                        RichEditor::make('body')
//                            ->required()
//                            ->fileAttachmentsDirectory('posts/images')->columnSpanFull(),
//                    ]
//                )->columns(2),
//                Section::make('Meta')->schema(
//                    [
//                        FileUpload::make('image')->image()->directory('posts/thumbnails'),
//                        DateTimePicker::make('published_at')->nullable(),
//                        Checkbox::make('featured'),
//                        Select::make('user_id')
//                            ->relationship('author', 'name')
//                            ->searchable()
//                            ->required(),
//                        Select::make('categories')
//                            ->multiple()
//                            ->relationship('categories', 'title')
//                            ->searchable(),
//                    ]
//                ),
//            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(static::getTableColumns())

            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'title'),
                Tables\Filters\Filter::make('Commercial')
                    ->query(fn (Builder $query) : Builder => $query->where('commercial', true))
                    ->toggle(),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }


    public static function getTableColumns() : array
    {
        return [

            Tables\Columns\TextColumn::make('id')
                ->numeric()
                ->label('ID')
                ->sortable()
                ->weight('bold'),

            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->description(fn (Post $post) => $post->slug),

            Tables\Columns\TextColumn::make('category.title')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('author.name')
                ->sortable()
                ->searchable(),


            Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                ->collection('image')
                ->conversion('medium')
                ->disk('media-library')
                ->defaultImageUrl('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMjMgMTIzIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGZpbGw9IiM1MDQ2RTYiIGQ9Ik0wIDBoMTIzdjEyM0gweiIvPjxwYXRoIGZpbGw9IiNGRkYiIGZpbGwtcnVsZT0ibm9uemVybyIgZD0iTTUyLjkwOTA5MDkgMzBjNi4yNzU5NjMxIDAgMTEuMzYzNjM2NCA1LjAzNjc5NjYgMTEuMzYzNjM2NCAxMS4yNXY1LjYyNWMwIDMuMTA2NjAxNyAyLjU0MzgzNjYgNS42MjUgNS42ODE4MTgyIDUuNjI1aDUuNjgxODE4MUM4MS45MTIzMjY3IDUyLjUgODcgNTcuNTM2Nzk2NiA4NyA2My43NXYyMy42MjVDODcgOTAuNDggODQuNDU0NTQ1NSA5MyA4MS4zMTgxODE4IDkzSDQyLjY4MTgxODJDMzkuNTQ1NDU0NSA5MyAzNyA5MC40OCAzNyA4Ny4zNzV2LTUxLjc1QzM3IDMyLjUyIDM5LjU0MjQyNDIgMzAgNDIuNjgxODE4MiAzMFpNNjIgNzcuMjVINTAuNjM2MzYzNmMtMS4yNTUxOTI2IDAtMi4yNzI3MjcyIDEuMDA3MzU5My0yLjI3MjcyNzIgMi4yNXMxLjAxNzUzNDYgMi4yNSAyLjI3MjcyNzIgMi4yNUg2MmMxLjI1NTE5MjYgMCAyLjI3MjcyNzMtMS4wMDczNTkzIDIuMjcyNzI3My0yLjI1UzYzLjI1NTE5MjYgNzcuMjUgNjIgNzcuMjVabTExLjM2MzYzNjQtOUg1MC42MzYzNjM2Yy0xLjI1NTE5MjYgMC0yLjI3MjcyNzIgMS4wMDczNTkzLTIuMjcyNzI3MiAyLjI1czEuMDE3NTM0NiAyLjI1IDIuMjcyNzI3MiAyLjI1aDIyLjcyNzI3MjhjMS4yNTUxOTI2IDAgMi4yNzI3MjcyLTEuMDA3MzU5MyAyLjI3MjcyNzItMi4yNXMtMS4wMTc1MzQ2LTIuMjUtMi4yNzI3MjcyLTIuMjVaIi8+PHBhdGggZmlsbD0iI0ZGRiIgZmlsbC1ydWxlPSJub256ZXJvIiBkPSJNNjUgMzFjMi40OTI3MjI3IDIuODc0MDgzOSAzLjg2MjY3MTEgNi41NTIyNzIyIDMuODU3Mzg5MSAxMC4zNTY3NDI4djUuNjU0ODkwMWMwIC42MjQyOTk5LjUwNjY3ODEgMS4xMzA5NzggMS4xMzA5NzggMS4xMzA5NzhoNS42NTQ4OTAxQzc5LjQ0NzcyNzggNDguMTM3MzI4OSA4My4xMjU5MTYxIDQ5LjUwNzI3NzMgODYgNTJjLTIuNzAxNDg2Ny0xMC4yNzQ0MTg3LTEwLjcyNTU4MTMtMTguMjk4NTEzMy0yMS0yMVoiLz48L2c+PC9zdmc+')
                ->circular()
                ->label(''),


            Tables\Columns\TextColumn::make('published_at')
                ->date('Y-m-d')
                ->sortable()
                ->searchable(),

            Tables\Columns\CheckboxColumn::make('commercial'),
            Tables\Columns\ToggleColumn::make('commercial')
                ->label('Is a commercial'),

        ];
    }

    public static function getRelations(): array
    {
        return [
            CommentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit'   => Pages\EditPost::route('/{record}/edit'),
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
