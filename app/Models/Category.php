<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property string $uuid
 * @property string $slug
 * @property string $title
 *
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'    => 'integer',
        'uuid'  => 'string',
        'slug'  => 'string',
        'title' => 'string',
    ];
    /** @var bool */
    public $timestamps = false;

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

    /**
     * @return HasMany<\App\Models\Product>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_uuid', 'uuid');
    }
}
