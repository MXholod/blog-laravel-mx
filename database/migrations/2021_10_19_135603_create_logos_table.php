<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->id();
			$table->boolean('logo_img_display')->default(0);
			$table->string('logo_img', 255);
			$table->string('logo_title', 255);
			$table->tinyText('logo_size', 255);
			$table->integer('logo_height')->default(50);
			$table->integer('logo_width')->default(115);
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
        Schema::dropIfExists('logos');
    }
}
