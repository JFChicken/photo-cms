<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFileVaultDisplay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FileVaultDisplay', function (Blueprint $table) {
            $table->bigIncrements('fileVaultDisplayId');
            
            $table->string('sourceFile');
            $table->string('fileName');
            $table->string('fileExtestion');
            
            $table->boolean('thumbnailCreated');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('FileVaultDisplay');
    }
}
