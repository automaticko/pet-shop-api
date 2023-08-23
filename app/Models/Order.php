<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 */
class Order extends Model
{
    use HasFactory;

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'              => 'int',
        'order_status_id' => 'int',
        'payment_id'      => 'int',
        'uuid'            => 'string',
        'products'        => 'json',
        'address'         => 'json',
        'delivery_fee'    => 'int',
        'amount'          => 'int',
        'status'          => 'string',
        'shipped_at'      => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\OrderStatus, \App\Models\Order>
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Payment, \App\Models\Order>
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
