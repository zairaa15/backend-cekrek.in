<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frame extends Model
{
    protected $fillable = [
        'event_id',
        'name',
        'preview_image',
        'frame_data',
    ];

    protected function casts(): array
    {
        return [
            'frame_data' => 'array',
        ];
    }

    /**
     * Relasi frame dengan event.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
