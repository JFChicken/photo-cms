<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThumbnailImageTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testFileVaultCommand()
    {
        $this->artisan('thumbnail:processImages')->assertExitCode(0);
        //  $this->assertTrue(true);
    }
}
