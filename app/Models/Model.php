<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

/**
 * @mixin \Eloquent
 */
abstract class Model extends BaseModel
{
    /**
     * @var array<string>|bool
     */
    protected $guarded = [];
}
