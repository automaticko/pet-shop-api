<?php

namespace App\Observers;

use App\Models\File;

class FileObserver
{
    public function __construct(private readonly UuidSetter $uuidSetter)
    {
    }

    public function creating(File $file): void
    {
        $this->uuidSetter->assign($file);
    }
}
