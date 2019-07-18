<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRawFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FileVaultRawFile', function (Blueprint $table) {
            $table->bigIncrements('fileVaultRawFileId');
            $table->string('sourceFile');
            $table->string('fileName');
            $table->string('fileExtestion');

            $table->bigInteger('fileVaultDisplayId')->nullable();
            
            $table->string('gpsLatitude');
            $table->string('gpsLongitude');
            $table->string('dateTimeTaken');
            
            $table->integer('orientation');

            
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
        Schema::dropIfExists('FileVaultRawFile');
    }
}
