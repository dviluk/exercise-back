<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('difficulty_id');
            $table->string('introduction');
            $table->string('description');
            $table->string('instructions');
            $table->integer('weeks');
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('plans');
        Schema::dropIfExists('plan_goal');
        Schema::dropIfExists('plan_exercise');
        Schema::dropIfExists('plan_group');
    }
}
