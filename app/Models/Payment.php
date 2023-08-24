<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 */
class Payment extends Model
{
    use HasFactory;

    public const TYPE_CREDIT_CARD      = 'credit_card';
    public const TYPE_CASH_ON_DELIVERY = 'cash_on_delivery';
    public const TYPE_BANK_TRANSFER    = 'bank_transfer';
    public const TYPES                 = [
        self::TYPE_CREDIT_CARD,
        self::TYPE_CASH_ON_DELIVERY,
        self::TYPE_BANK_TRANSFER,
    ];
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'      => 'int',
        'user_id' => 'int',
        'uuid'    => 'string',
        'type'    => 'string',
        'details' => 'json',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Payment>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Order>
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }
}
