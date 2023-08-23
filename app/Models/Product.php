<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 */
class Product extends Model
{
    use HasFactory;

    /** @var array<string, string> */
    protected $casts = [
        'id'            => 'string',
        'category_uuid' => 'string',
        'title'         => 'string',
        'price'         => 'int',
        'description'   => 'string',
        'metadata'      => 'json',
        'created_at'    => 'timestamp',
        'updated_at'    => 'timestamp',
        'deleted_at'    => 'timestamp',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Category, \App\Models\Product>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_uuid', 'uuid');
    }
}
