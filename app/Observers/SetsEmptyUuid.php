<?php

namespace App\Observers;

use App\Models\Model;
use Illuminate\Support\Str;

trait SetsEmptyUuid
{
    private function setEmptyUuidOn(Model $model): void
    {
        $uuid = $model->getAttribute('uuid') ?? Str::uuid();

        $model->setAttribute('uuid', $uuid);
    }
}
