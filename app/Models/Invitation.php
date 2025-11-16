<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'invitee_name',
        'slug',
        'is_opened',
    ];

    protected $casts = [
        'is_opened' => 'boolean',
    ];

    // Relasi
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function rsvps(): HasMany {
        return $this->hasMany(Rsvp::class);
    }
    public function wishes(): HasMany {
        return $this->hasMany(Wish::class);
    }

    // Buat slug otomatis dari invitee_name jika belum di-set
    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->slug)) {
                // slug dasar dari nama
                $base = Str::slug($model->invitee_name);
                $slug = $base;
                $i = 2;

                // pastikan unik
                while (static::where('slug', $slug)->exists()) {
                    $slug = $base.'-'.$i;
                    $i++;
                }
                $model->slug = $slug;
            }
        });
    }

    // URL share: andre-yohani.undanganly.com/{slug}
    // Simpan domain di .env: INVITE_BASE_DOMAIN=andre-yohani.undanganly.com
    public function getShareUrlAttribute(): string
    {
        $base = config('app.invite_base_domain', env('INVITE_BASE_DOMAIN', 'andre-yohani.undanganly.com'));
        return rtrim($base, '/').'/'.$this->slug;
    }

    // Tandai undangan sudah dibuka (tanpa hitung)
    public function markOpened(): void
    {
        if (!$this->is_opened) {
            $this->is_opened = true;
            $this->save();
        }
    }
}
