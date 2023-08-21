<?php

namespace App\Observers;

use App\Models\Model;
use Illuminate\Support\Str;

class UuidSetter
{
    public function assignUuid(Model $model): void
    {
        $uuid = $model->getAttribute('uuid') ?? Str::uuid();

        $model->setAttribute('uuid', $uuid);
    }
}
