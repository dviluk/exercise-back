<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlanExercise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_exercise', function (Blueprint $table) {
            $table->uuid('plan_id');
            $table->uuid('exercise_id');
            $table->string('order')->default('00000');

            $table->foreign('plan_id')
                ->references('id')->on('plans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
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
        Schema::dropIfExists('plan_exercise');
    }
}
