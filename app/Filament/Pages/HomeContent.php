<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class HomeContent extends ContentPage
{
    protected static ?string $navigationLabel = 'Home page';

    protected static ?string $title = 'Home page content';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?int $navigationSort = 1;

    protected static ?string $slug = 'content/home';

    protected static function groups(): array
    {
        return ['home'];
    }
}
