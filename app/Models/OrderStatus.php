<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\OrderStatusFactory factory($count = null, $state = [])
 */
class OrderStatus extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'    => 'int',
        'uuid'  => 'string',
        'title' => 'string',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'order_status_id', 'id');
    }
}
