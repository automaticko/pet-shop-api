<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\FileFactory factory($count = null, $state = [])
 */
class File extends Model
{
    use HasFactory;

    /** @var array<string, string> $casts */
    protected $casts = [
        'id'   => 'integer',
        'uuid' => 'string',
        'name' => 'string',
        'path' => 'string',
        'size' => 'string',
        'type' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'avatar_uuid', 'uuid');
    }
}
