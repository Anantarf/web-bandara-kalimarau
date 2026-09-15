<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Facility extends Model
{
    public const CATEGORIES = [
        'Aksesibilitas' => 'Sarana Bagi Kelompok Rentan',
        'Layanan Terminal' => 'Layanan Terminal',
        'Informasi & Pengaduan' => 'Informasi & Pengaduan',
        'Keluarga & Rekreasi' => 'Keluarga & Rekreasi',
        'Parkir & Akses Kendaraan' => 'Parkir & Akses Kendaraan',
        'Keselamatan & Operasional' => 'Keselamatan & Operasional',
    ];

    protected static function booted(): void
    {
        static::updating(function (Facility $facility): void {
            if ($facility->isDirty('image') && $facility->getOriginal('image')) {
                Storage::disk('public')->delete($facility->getOriginal('image'));
            }
        });

        static::deleted(function (Facility $facility): void {
            if ($facility->image) {
                Storage::disk('public')->delete($facility->image);
            }
        });
    }

    protected $fillable = [
        'category',
        'name',
        'image',
        'details',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'order' => 'integer',
        ];
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? Storage::disk('public')->url($this->image) : null,
        );
    }

    protected function categoryLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => self::CATEGORIES[$this->category] ?? $this->category,
        );
    }
}
