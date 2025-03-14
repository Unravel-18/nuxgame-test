<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LuckyAttempt extends Model
{
    protected $fillable = [
        'is_winner',
        'rand_number',
        'winner_sum'
    ];

    protected $casts = [
        'is_winner' => 'boolean',
        'winner_sum' => 'float',
        'rand_number' => 'integer',
    ];

    public function pageToken(): BelongsTo
    {
        return $this->belongsTo(PageToken::class);
    }
}
