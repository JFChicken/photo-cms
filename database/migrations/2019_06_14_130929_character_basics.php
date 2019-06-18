<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharacterBasics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('CharacterBasics', function (Blueprint $table) {
            $table->bigIncrements('characterBasicsId');
            $table->bigInteger('userId');
            // Content
            $table->string('characterName', 254);
            $table->string('characterJobTitle', 254);

            //TIME KEEPING
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('CharacterBasics');
    }
}
