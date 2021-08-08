<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExerciseRelated extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_related', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->uuid('exercise_related_id');

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('exercise_related_id')
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
        Schema::dropIfExists('table_exercise_related');
    }
}
