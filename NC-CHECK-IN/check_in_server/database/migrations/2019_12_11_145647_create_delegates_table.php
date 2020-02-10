<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDelegatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('delegates');
        Schema::create('delegates', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('student_id')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('faculty')->nullable();
            $table->string('group')->nullable();
            $table->string('seat')->nullable();
            $table->boolean("state")->default(false);
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
        Schema::dropIfExists('delegates');
    }
}
