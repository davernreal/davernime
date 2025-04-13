<?php

namespace App\Filament\Resources\StreamingPlatformResource\Pages;

use App\Filament\Resources\StreamingPlatformResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStreamingPlatforms extends ListRecords
{
    protected static string $resource = StreamingPlatformResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
