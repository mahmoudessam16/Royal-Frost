<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class GlobalContent extends ContentPage
{
    protected static ?string $navigationLabel = 'Header, footer & SEO';

    protected static ?string $title = 'Header, footer and search-engine text';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 5;

    protected static ?string $slug = 'content/global';

    protected static function groups(): array
    {
        return ['meta', 'nav', 'footer'];
    }
}
