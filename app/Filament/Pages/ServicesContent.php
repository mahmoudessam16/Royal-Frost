<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ServicesContent extends ContentPage
{
    protected static ?string $navigationLabel = 'Services page';

    protected static ?string $title = 'Services page content';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'content/services';

    protected static function groups(): array
    {
        return ['services'];
    }
}
