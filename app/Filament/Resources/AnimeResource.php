<?php

namespace App\Filament\Resources;

use App\Enums\StatusBadgeEnum;
use App\Filament\Resources\AnimeResource\Pages;
use App\Filament\Resources\AnimeResource\RelationManagers\GenresRelationManager;
use App\Models\Anime;
use App\Models\Genre;
use App\Models\Licensor;
use App\Models\Producer;
use App\Models\Source;
use App\Models\Studio;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class AnimeResource extends Resource
{
    protected static array $type = ['TV', 'ONA', 'Music', 'UNKNOWN', 'Special', 'Movie', 'OVA'];
    protected static array $season = ['winter', 'spring', 'summer', 'fall', 'unknown'];
    protected static array $rating = [
        'R - 17+ (violence & profanity)',
        'PG-13 - Teens 13 or older',
        'PG - Children',
        'R+ - Mild Nudity',
        'G - All Ages',
        'Rx - Hentai',
        'UNKNOWN'
    ];

    protected static ?string $model = Anime::class;

    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    protected static ?string $navigationGroup = 'Main';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Base Information')
                        ->schema(static::getBaseInformationComponents()),
                    Step::make('Product Details')
                        ->schema(static::getProductDetailsCompoenents()),
                    Step::make('Additional Information')
                        ->schema(static::getAdditionalInformationComponents()),
                    Step::make('Image Upload')
                        ->schema(static::getImageUploadComponents())
                ])
                    ->columnSpanFull()
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        wire:submit="Submit"
                    >
                        Submit
                    </x-filament::button>
                    BLADE))),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_url')->label(false),
                TextColumn::make('title')->searchable(),
                TextColumn::make('status')->badge()->color(fn($state) => $state->getColor()),
                TextColumn::make('type')
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
            ])
            ->paginated([5, 10, 25, 50, 100])
            ->modifyQueryUsing(fn(Builder $query) => $query->orderBy('created_at', 'desc'));
    }


    protected function getTableQuery(): Builder
    {
        return static::getModel()::query()->take(100);
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
            'index' => Pages\ListAnimes::route('/'),
            'create' => Pages\CreateAnime::route('/create'),
            'edit' => Pages\EditAnime::route('/{record}/edit'),
        ];
    }

    protected static function getBaseInformationComponents(): array
    {
        return [
            TextInput::make('title', 'Title')->columnSpanFull(),
            TextInput::make('english_title', 'English Title')->columnSpanFull(),
            TextInput::make('other_title', 'Other Title')->columnSpanFull(),
            Textarea::make('synopsis', 'Synopsis')->columnSpan('full')->autosize()->columnSpanFull(),
            Select::make('genre', 'Genre')->placeholder('Select Genre')
                ->options(Genre::all()->pluck('name', 'id'))
                ->relationship('genres', 'name')
                ->multiple()
                ->columnSpan('full'),
        ];
    }

    protected static function getProductDetailsCompoenents(): array
    {
        return [
            Select::make('type', 'Type')->placeholder('Select Type')->options(array_combine(self::$type, self::$type))->searchable(),
            TextInput::make('episodes')->label('Total Episodes')->integer()->gt(0),
            Select::make('studio', 'Studio')->placeholder('Select Studio')->multiple()->searchable()
                ->relationship('studios', 'name')
                ->getSearchResultsUsing(fn(string $search): array => Studio::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
                ->getOptionLabelsUsing(fn(array $values): array => Studio::whereIn('id', $values)->pluck('name', 'id')->toArray()),
            Select::make('producer', 'Producer')->placeholder('Select Producer')->multiple()->searchable()
                ->relationship('producers', 'name')
                ->getSearchResultsUsing(fn(string $search): array => Producer::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
                ->getOptionLabelsUsing(fn(array $values): array => Producer::whereIn('id', $values)->pluck('name', 'id')->toArray()),
            Select::make('licensor', 'Licensor')->placeholder('Select Licensor')->multiple()->searchable()
                ->relationship('licensors', 'name')
                ->getSearchResultsUsing(fn(string $search): array => Licensor::where('name', 'like', "%{$search}%")->limit(10)->pluck('name', 'id')->toArray())
                ->getOptionLabelsUsing(fn(array $values): array => Licensor::whereIn('id', $values)->pluck('name', 'id')->toArray()),
            DatePicker::make('aired_from', "Aired From")->format('Y-m-d')->native(false),
            DatePicker::make('aired_to', "Aired To")->format('Y-m-d')->native(false),
            Select::make('premiered_season', 'Premiered Season')->placeholder('Select Season')
                ->options(array_combine(self::$season, array_map('ucwords', self::$season))),
            TextInput::make('premiered_year', 'Premiered Year')->numeric()->minValue(1900)->maxValue(2050)
        ];
    }

    protected static function getAdditionalInformationComponents(): array
    {
        return [
            Select::make('source', 'Source')->placeholder('Select Source')->options(
                Source::all()->pluck('name', 'id')
            )->searchable(),
            TimePicker::make('duration')
                ->label('Duration per episode')
                ->seconds(true)
                ->native(false),
            Select::make('status', 'Status')->placeholder('Select Status')->options(StatusBadgeEnum::class),
            Select::make('rating', 'Rating')->placeholder('Select Rating')->options(array_combine(self::$rating, self::$rating)),
        ];
    }

    protected static function getImageUploadComponents(): array
    {
        return [
            FileUpload::make('image_url')->label('Poster')
                ->directory('anime-poster')
        ];
    }
}
