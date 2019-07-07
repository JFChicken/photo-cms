<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSourceFileColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('FileVault', function (Blueprint $table) {
            $table->string('sourceFile')->default("null")->after('thumbnailCreated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('FileVault', function (Blueprint $table) {
            //
            $table->dropColumn('sourceFile');
        });
    }
}
