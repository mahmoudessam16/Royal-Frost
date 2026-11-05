<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class AboutContent extends ContentPage
{
    protected static ?string $navigationLabel = 'About page';

    protected static ?string $title = 'About page content';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedInformationCircle;

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'content/about';

    protected static function groups(): array
    {
        return ['about'];
    }
}
