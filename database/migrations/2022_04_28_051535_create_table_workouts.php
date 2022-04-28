<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWorkouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('exercise_id');
            $table->uuid('difficulty_id');
            $table->uuid('plan_id');
            $table->uuid('routine_id');
            $table->integer('sets');
            $table->integer('rest');
            $table->integer('order');
            $table->integer('min_repetitions');
            $table->integer('max_repetitions');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('difficulty_id')
                ->references('id')->on('difficulties')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('plan_id')
                ->references('id')->on('plans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('routine_id')
                ->references('id')->on('routines')
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
        Schema::dropIfExists('workouts');
    }
}
