<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExerciseGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_group', function (Blueprint $table) {
            $table->uuid('group_id');
            $table->uuid('exercise_id');
            $table->string('order')->default('00000');

            $table->foreign('group_id')
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
        Schema::dropIfExists('exercise_group');
    }
}
