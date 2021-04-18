<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWorkoutMuscle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_muscle', function (Blueprint $table) {
            $table->uuid('workout_id');
            $table->uuid('muscle_id');
            $table->boolean('primary');

            $table->foreign('workout_id')
                ->references('id')->on('workouts')
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
        Schema::dropIfExists('workout_mucle');
    }
}
