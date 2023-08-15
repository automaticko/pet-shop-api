<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Database\Factories\FileFactory factory($count = null, $state = [])
 */
class File extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'   => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'path' => 'string',
        'size' => 'string',
        'type' => 'string',
    ];

    /**
     * @return HasMany<\App\Models\User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'avatar_id', 'id');
    }
}
