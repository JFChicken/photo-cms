<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\FileVault;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FileVaultModelTest extends TestCase
{
    // use DatabaseMigrations;
    //use DatabaseTransactions;
    /**
     * A very basic create record in the file vault
     *
     * @return void
     */
    public function testCreateNewRecord()
    {


        $fileVaultObj = FileVault::create(
            [
                'fileName' => 'Test.jpg',
                'folder' => 'TestFolder',
                'year' => '2019',
                'thumbnailCreated' => rand(0, 1)
            ]);
            $this->assertTrue($fileVaultObj->save());
    }
}
