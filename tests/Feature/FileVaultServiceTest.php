<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\FileVault;
use App\Models\FileVault as FileVaultModel;

class FileVaultServiceTest extends TestCase
{

    private $fileVault;

    public function setUp(): void
    {
        parent::setUp();
        $this->fileVault = new FileVault(
            app(FileVaultModel::class)
        );
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetFiles()
    {

        $this->assertIsArray($this->fileVault->readPhotoDir());
    }

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdatingDatabase()
    {
        
        $files = $this->fileVault->readPhotoDir();
        // WE need to set up one file for this test to work correctly
        $this->assertTrue(count($files)>=1,'Count is off');
        // Files Processed should be a minimum of one new one
        $this->assertTrue($this->fileVault->updatePhotoRecords($files),'No Files Were Updated(added)');
    }

    public function testGetPhotoRecords()
    {
        
        $files = $this->fileVault->getPhotoRecords();
        
        $this->assertIsArray($files);
    }
}
