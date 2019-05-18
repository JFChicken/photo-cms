<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileVault extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FileVault', function (Blueprint $table) {
            $table->bigIncrements('fileVaultId');
            $table->string('fileName');
            $table->string('folder');
            $table->string('year');
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
        Schema::dropIfExists('FileVault');
    }
}