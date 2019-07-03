<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchCr2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batchCr', function (Blueprint $table) {
            $table->bigIncrements('batchCrId');
            $table->string('SourceFile');
            $table->string('FileName');
            $table->integer('Orientation');
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
        Schema::dropIfExists('batchCr');
    }
}
