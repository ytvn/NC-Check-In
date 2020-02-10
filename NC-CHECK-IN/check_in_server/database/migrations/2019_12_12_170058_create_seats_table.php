<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('seats');
        Schema::create('seats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("delegate_id")->nullable();
            $table->unsignedBigInteger("room_id");
            $table->string("seat");
            $table->boolean("state")->default(false);
            $table->timestamps();

            $table->unique(['room_id', 'delegate_id']);
            $table->unique(['room_id', 'seat']);
            
            $table->foreign("delegate_id")->references('id')->on('delegates')
                ->onUpdate("cascade")->onDelete("cascade");

            $table->foreign("room_id")->references('id')->on('rooms')
                ->onDelete("cascade")->onDelete("cascade");  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seats');
    }
}
