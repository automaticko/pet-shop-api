<?php

namespace App\Observers;

use App\Models\File;

class FileObserver
{
    use SetsEmptyUuid;

    public function creating(File $file): void
    {
        $this->setEmptyUuidOn($file);
    }
}
