<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWorkoutLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('workout_id');
            $table->uuid('plan_id');
            $table->integer('sets');
            $table->integer('repetitions');
            $table->integer('rest');
            $table->integer('time');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('workout_id')
                ->references('id')->on('workouts')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('plan_id')
                ->references('id')->on('plans')
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
        Schema::dropIfExists('workout_logs');
    }
}
