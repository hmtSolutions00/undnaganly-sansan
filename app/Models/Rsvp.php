<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rsvp extends Model
{
    protected $fillable = [
        'invitation_id',
        'name',
        'status',
        'total_attendees',
    ];

    protected $casts = [
        'total_attendees' => 'integer',
    ];

    public function invitation(): BelongsTo {
        return $this->belongsTo(Invitation::class);
    }
}
