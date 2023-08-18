<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'                => 'integer',
        'avatar_id'         => 'integer',
        'uuid'              => 'string',
        'first_name'        => 'string',
        'last_name'         => 'string',
        'is_admin'          => 'boolean',
        'email'             => 'string',
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'address'           => 'string',
        'phone_number'      => 'string',
        'is_marketing'      => 'boolean',
        'last_login_at'     => 'datetime',
    ];

    /**
     * @return BelongsTo<\App\Models\File, \App\Models\User>
     */
    public function avatar(): BelongsTo
    {
        return $this->belongsTo(File::class, 'avatar_id');
    }

    public function getAuthIdentifierName(): string
    {
        return 'uuid';
    }
}
