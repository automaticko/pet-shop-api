<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $uuid
 *
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 */
class Payment extends Model
{
    use HasFactory;

    public const TYPE_CREDIT_CAR       = 'credit_car';
    public const TYPE_CASH_ON_DELIVERY = 'cash_on_delivery';
    public const TYPE_BANK_TRANSFER    = 'bank_transfer';
    /**
     * @var array<string, string>
     */
    protected $casts = [
        'id'      => 'int',
        'uuid'    => 'string',
        'type'    => 'string',
        'details' => 'json',
    ];
}
