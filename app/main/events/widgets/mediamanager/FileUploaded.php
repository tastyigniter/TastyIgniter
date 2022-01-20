<?php

namespace Main\Events\Widgets\MediaManager;

use System\Classes\BaseEvent;

class FileUploaded extends BaseEvent
{
    public $path;
    public $upload;

    public function __construct($filePath, $uploadedFile)
    {
        $this->path = $filePath;
        $this->upload = $uploadedFile;

        $this->fireBackwardsCompatibleEvent('media.file.upload', [$this->path, $this->upload]);
    }
}
