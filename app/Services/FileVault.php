<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;
use Illuminate\Support\Facades\Storage;

class FileVault
{

    protected $rootDir = 'public/photos';

    protected $fileVaultModel;

    public function __construct(FileVaultModel $fileVault)
    {
        $this->fileVaultModel = $fileVault;
    }

    private function getPhotos()
    {
        $rootDir = $this->rootDir;
        $files = Storage::allFiles($rootDir);
        return $files;
    }

    private function updateDatabase(array $files)
    {
        $response = false;
        foreach ($files as $file) {
            // Check if the year is valid if it is then we are good to go.
            if (checkdate(1, 1, $file['year'])) {
                $fileVaultObj = FileVaultModel::firstOrNew(
                    [
                        'fileName' => $file['fileName'],
                        'folder' => $file['folder'],
                        'year' => $file['year'],
                    ],
                    [
                        'thumbnailCreated' => false
                    ]
                );

                if (is_null($fileVaultObj->thumbnailCreated)) {
                    $fileVaultObj->thumbnailCreated = false;
                }
                $fileVaultObj->save();
                $response = true;
                
            }
        }
        
        return $response;
    }
    private function processFiles(array $files)
    {
        $rootDir = $this->rootDir;

        $processedFiles = [];

        foreach ($files as $file) {
            // Take the string and remove the root
            $file = str_replace($rootDir . '/', '', $file);


            if (strpos($file, '.jpg') !== false) {
                // Split the remander to get the 3 need values, year, event and file name

                $split = explode('/', $file);

                $year = (int)$split[0];
                $event = $split[1];
                $fileName = preg_replace('/.[^.]*$/', '', $split[2]);
                $processedFiles[] = [
                    'year' => $year,
                    'folder' => $event,
                    'fileName' => $fileName,
                ];
            }
        }
        return $processedFiles;
    }

    public function readPhotoDir()
    {

        $files = $this->getPhotos();
        return $this->processFiles($files);
        
    }

    public function updatePhotoRecords($files){
        
         return $this->updateDatabase($files);
    }
}
