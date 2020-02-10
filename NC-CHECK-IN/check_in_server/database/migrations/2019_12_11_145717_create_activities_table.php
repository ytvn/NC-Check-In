<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('activities');
        Schema::create('activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('delegate_id');
            $table->string('status');
            $table->timestamps();    
            $table->foreign('delegate_id')->references('id')->on('delegates')
                ->onDelete("cascade")
                ->onUpdate("cascade");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
