<?php

namespace App\Services;

use App\Models\CharacterBasics;
use App\Models\CharacterSheet;

class CharacterProcess
{

    protected $characterBasics;
    protected $characterSheet;

    public function __construct(CharacterBasics $characterBasics,CharacterSheet $characterSheet)
    {
        $this->characterBasics = $characterBasics;
        $this->characterSheet = $characterSheet;
    }

    static public function storeCharacter($character,$userId){
        
        $sheet =  new CharacterSheet();

        $characterSheet = $sheet::create([
            'userId'=>$userId,
            'characterId'=>$userId,
            'characterJson'=>$character,
        ]);
            return $characterSheet->save();
        
    }

}
