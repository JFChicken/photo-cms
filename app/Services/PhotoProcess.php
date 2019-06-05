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
    static public function processRecords($filter)
    {
        
        // This is not how i want to do this but it will work for now
        $newClass = new FileVault(new FileVaultModel());
        
        // Convert the filter varable to a column in the fV table
         switch ($filter) {
            case 'event':
                $filter = 'folder';
                break;

            case 'yearly':
                $filter = 'year';
                break;

            default:
                $filter = 'updated_at';
                break;
        }

        $data = $newClass->getViewUrls($filter);

        return $data;
        
    }

}
