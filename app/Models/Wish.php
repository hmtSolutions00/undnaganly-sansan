<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wish extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'message',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    public function invitation(): BelongsTo {
        return $this->belongsTo(Invitation::class);
    }
}
