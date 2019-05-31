<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;
use App\Services\FileVault;

class PhotoProcess
{

    protected $rootDir = 'public/photos';

    protected $fileVaultModel;

    public function __construct(FileVaultModel $fileVault)
    {
        $this->fileVaultModel = $fileVault;
    }

    /**
     *  Pulls photo files for the view
     */
    static public function processRecords()
    {
        // This is not how i want to do this but it will work for now
        $newClass = new FileVault(new FileVaultModel());
        
        $data = $newClass->getViewUrls();

        return $data;
        
    }

}
