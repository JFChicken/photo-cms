<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;


class PhotoProcess
{

    protected $rootDir = 'public/photos';

    protected $fileVaultModel;

    public function __construct(FileVaultModel $fileVault)
    {
        $this->fileVaultModel = $fileVault;
    }

    public function processRecords()
    {

        $files = $this->getPhotos();
        return $this->processFiles($files);
        
    }

}
