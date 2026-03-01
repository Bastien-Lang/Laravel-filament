<?php

namespace App\Enums;
use App\Enums\GuestStatusEnum;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum GuestStatusEnum: string implements HasIcon, HasColor, HasLabel
{
    case INVITED = 'INVITED';
    case CONFIRMED = 'CONFIRMED';
    case CANCELED = 'CANCELED';

    public function getIcon(): string
    {
        return match($this) {
            self::INVITED => 'heroicon-o-user',
            self::CONFIRMED => 'heroicon-o-check',
            self::CANCELED => 'heroicon-o-x',
        };
    }

    public function getColor(): string
    {
        return match($this) {
            self::INVITED => 'gray',
            self::CONFIRMED => 'success',
            self::CANCELED => 'danger',
        };
    }

    public function getLabel(): string
    {
        return $this->value;
    }
}