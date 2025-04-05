<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum StatusBadgeEnum: string implements HasColor, HasLabel
{
    case FINISHED_AIRING = 'Finished Airing';
    case CURRENTLY_AIRING = 'Currently Airing';
    case NOT_YET_AIRING = 'Not yet aired';
    

    public function getColor(): ?string
    {
        return match ($this) {
            self::FINISHED_AIRING => 'success',
            self::CURRENTLY_AIRING => 'warning',
            self::NOT_YET_AIRING => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::FINISHED_AIRING => 'Finished Airing',
            self::CURRENTLY_AIRING => 'Currently Airing',
            self::NOT_YET_AIRING => 'Not yet aired',
        };
    }

    
}
