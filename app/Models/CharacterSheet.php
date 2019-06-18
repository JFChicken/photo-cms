<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharacterSheet extends Model
{
    //
    use SoftDeletes;
     protected $primaryKey = 'characterSheetId';
     protected $table = 'CharacterSheet';
     protected $fillable = [
         'userId',
         'characterId',
         'characterJson',
     ];
     
}
