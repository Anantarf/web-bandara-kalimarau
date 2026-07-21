<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpidDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'is_active',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];
}
