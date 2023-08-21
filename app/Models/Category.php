<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 */
class Category extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'    => 'integer',
        'uuid'  => 'string',
        'title' => 'string',
    ];
    /** @var bool */
    public $timestamps = false;
}
