<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\CharacterBasics;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CharacterBasicsModelTest extends TestCase
{
    // use DatabaseMigrations;
    //use DatabaseTransactions;

    public function testCreateNewRecord()
    {
        $newCharacter = new CharacterBasics(
            [
                'userId' => 1,
                'characterName' => 'fakerName',
                'characterJobTitle' => 'MASTER KEEPER',
            ]
        );

        $this->assertTrue($newCharacter->save(), 'Canont create new record');
        // What do we do for clean up?
    }

    public function testUpdateRecord()
    {


        // $this->assertTrue(false);
    }

    public function testDeleteRecord()
    {
        // $this->assertTrue(false);
    }


    public function testRestoreRecord()
    {
        // $this->assertTrue(false);
    }
}
