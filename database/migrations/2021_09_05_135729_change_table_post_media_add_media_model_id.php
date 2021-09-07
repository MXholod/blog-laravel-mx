<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTablePostMediaAddMediaModelId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_media', function (Blueprint $table) {
            //
			$table->unsignedBigInteger('media_model_id')->after('post_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_media', function (Blueprint $table) {
            //
			$table->dropColumn('media_model_id');
        });
    }
}
