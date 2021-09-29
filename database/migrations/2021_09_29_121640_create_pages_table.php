<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
			$table->string('title');
			$table->string('slug')->unique();
			$table->text('content');
			$table->string('thumbnail')->nullable();
			$table->boolean('display')->default(0);
			$table->tinyInteger('display_place')->default(0);//0 header, 1 footer
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
        Schema::dropIfExists('pages');
    }
}
