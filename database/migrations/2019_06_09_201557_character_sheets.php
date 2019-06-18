<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CharacterSheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('CharacterSheet', function (Blueprint $table) {
            $table->bigIncrements('characterSheetId');
            $table->json('characterJson');
            $table->bigInteger('characterId');
            $table->bigInteger('userId');

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
        Schema::dropIfExists('CharacterSheet');
    }
}
