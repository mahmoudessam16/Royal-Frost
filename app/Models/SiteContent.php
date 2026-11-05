<?php

namespace App\Models;

use App\Support\Content;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    protected $fillable = ['locale', 'group', 'data'];

    protected function casts(): array
    {
        return ['data' => 'array'];
    }

    protected static function booted(): void
    {
        static::saved(fn () => Content::flush());
        static::deleted(fn () => Content::flush());
    }
}
