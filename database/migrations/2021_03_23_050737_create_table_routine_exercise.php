<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRoutineExercise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routine_exercise', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->uuid('routine_id');
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('order');
            $table->unsignedTinyInteger('repetitions');
            $table->unsignedTinyInteger('quantity');
            $table->uuid('quantity_unit_id');
            $table->unsignedTinyInteger('rest_time_between_repetitions');
            $table->unsignedTinyInteger('rest_time_after_exercise');

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('routine_id')
                ->references('id')->on('routines')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('quantity_unit_id')
                ->references('id')->on('units')
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
        Schema::dropIfExists('exercise_routine');
    }
}
