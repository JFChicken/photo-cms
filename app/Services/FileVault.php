<?php

namespace App\Services;

use App\Models\FileVault as FileVaultModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

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
        $newFiles = 0;
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
                        // We set this Null to use as a counter for processed files
                        'thumbnailCreated' => null
                    ]
                );
                
                if (is_null($fileVaultObj->thumbnailCreated)) {
                    $newFiles++;
                    $fileVaultObj->thumbnailCreated = false;
                }

                $fileVaultObj->save();
            }
        }
        
        return $newFiles;
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

    /**
     *  This will take a record and return an array with the image url and the preposed thumbnail url
     */
    private function  createFileUrls($record){

        $url = $this->storagePath();
        $thumbnailUrl = $this->thumbnailPath();
        
        // Create the thumbnail drive before sending this since the python script will not handle it.
        $this->createThumbnailDir($thumbnailUrl.$record->year.'/'.$record->folder);
        
        return [
            'id'=>$record->fileVaultId,
            'image'=>$url.$record->year.'/'.$record->folder.'/'.$record->fileName.'.jpg',
            'thumbnail'=>$thumbnailUrl.$record->year.'/'.$record->folder.'/'.$record->fileName.'.jpg'
        ];
    }

    private function processDbRecords($records){
        
        $files=[];
        foreach ($records as $record){
            $files[$record->fileVaultId] = $this->createFileUrls($record);
        }
        
        return $files;
    } 

    private function storagePath(){
        return storage_path() .'/app/public/photos/';
    }

    private function thumbnailPath(){
        return storage_path() .'/app/public/thumbnails/';
    }

    private function createThumbnailDir($path){
        if(!File::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true);
        }
    }

    public function readPhotoDir()
    {

        $files = $this->getPhotos();
        return $this->processFiles($files);
        
    }

    public function updatePhotoRecords($files){
        
         return $this->updateDatabase($files);
    }

    public function updatePhotoThumbnail($recordId){
        return $this->fileVaultModel::find($recordId)->update(['thumbnailCreated' => true]);
    }

    public function getPhotoRecords(){
        // Right now we are just going to get the unprocessed photos that have no thumbnails
        $files = $this->fileVaultModel::where(['thumbnailCreated'=>false])->get();

        return $this->processDbRecords($files);
    }
}
