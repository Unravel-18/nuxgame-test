<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'username',
        'phone'
    ];

    protected $casts = [
        'username' => 'string',
        'phone' => 'string',
    ];

    public function pageTokens(): HasMany
    {
        return $this->hasMany(PageToken::class);
    }
}
