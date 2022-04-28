<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExercises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('difficulty_id');
            $table->uuid('tag_id');
            // Es la imagen que se mostrara
            $table->string('illustration');
            $table->string('image');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('difficulty_id')
                ->references('id')->on('difficulties')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('tag_id')
                ->references('id')->on('tags')
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
        Schema::dropIfExists('exercise_equipment');
        Schema::dropIfExists('exercise_muscle');
        Schema::dropIfExists('exercises');
    }
}
