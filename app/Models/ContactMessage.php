<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'need', 'name', 'company', 'email', 'phone', 'subject', 'message',
        'locale', 'ip', 'emailed', 'read_at',
    ];

    protected function casts(): array
    {
        return ['emailed' => 'boolean', 'read_at' => 'datetime'];
    }
}
