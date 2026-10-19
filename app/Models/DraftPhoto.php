<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DraftPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'draft_id',
        'photo_url',
        'position',
        'config',
    ];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'config' => 'array',
        ];
    }

    public function draft(): BelongsTo
    {
        return $this->belongsTo(Draft::class);
    }
}
