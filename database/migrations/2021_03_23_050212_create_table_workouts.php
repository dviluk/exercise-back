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
            $table->uuid('workout_id')->nullable();
            $table->uuid('difficulty_id');
            $table->string('cover');
            $table->string('illustration');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            // No se puede crear referencias en la misma tabla
            // $table->foreign('workout_id')
            //     ->references('id')->on('workouts')
            //     ->cascadeOnUpdate()
            //     ->cascadeOnDelete();
            $table->foreign('difficulty_id')
                ->references('id')->on('difficulties')
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
