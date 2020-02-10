<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name");
            $table->integer("num_of_rows")->default(0);
            $table->integer("num_of_columns")->default(0);
            $table->string("cols_have_space_left")->default("");
            $table->boolean("active")->nullable()->default(null)->unique(); //Accept null or 1
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
        Schema::dropIfExists('rooms');
    }
}
