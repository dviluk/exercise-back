<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableWorkoutEquipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workout_equipment', function (Blueprint $table) {
            $table->uuid('workout_id');
            $table->uuid('equipment_id');

            $table->foreign('workout_id')
                ->references('id')->on('workouts')
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
        Schema::dropIfExists('workout_equipment');
    }
}
