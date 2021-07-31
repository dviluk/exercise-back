<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExerciseMuscle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_muscle', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->uuid('muscle_id');
            $table->boolean('primary');

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('muscle_id')
                ->references('id')->on('muscles')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercise_mucle');
    }
}
