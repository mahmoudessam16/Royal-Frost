<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ContactContent extends ContentPage
{
    protected static ?string $navigationLabel = 'Contact page';

    protected static ?string $title = 'Contact page content';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedEnvelope;

    protected static ?int $navigationSort = 4;

    protected static ?string $slug = 'content/contact';

    protected static function groups(): array
    {
        return ['contact'];
    }
}
