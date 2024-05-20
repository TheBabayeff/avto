<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentType: string implements HasColor, HasIcon, HasLabel
{
    case Card = 'card';

    case Cash = 'cash';

    public function getLabel(): string
    {
        return match ($this) {
            self::Card => 'card',
            self::Cash => 'cash',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Card => 'info',
            self::Cash => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Card => 'heroicon-m-sparkles',
            self::Cash => 'heroicon-m-arrow-path',
        };
    }

}
