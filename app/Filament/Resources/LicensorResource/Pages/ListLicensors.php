<?php

namespace App\Filament\Resources\LicensorResource\Pages;

use App\Filament\Resources\LicensorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLicensors extends ListRecords
{
    protected static string $resource = LicensorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
