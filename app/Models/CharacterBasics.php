<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharacterBasics extends Model
{
    //
    use SoftDeletes;
     protected $primaryKey = 'characterBasicsId';
     protected $table = 'CharacterBasics';
     protected $fillable = [
         'characterName',
         'characterJobTitle',
     ];
     protected $garded = [
        'userId'
     ];
}
