<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableExerciseEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercise_equipment', function (Blueprint $table) {
            $table->uuid('exercise_id');
            $table->uuid('equipment_id');

            $table->foreign('exercise_id')
                ->references('id')->on('exercises')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreign('equipment_id')
                ->references('id')->on('equipment')
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
    }
}
