<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePlanGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plan_group', function (Blueprint $table) {
            $table->uuid('plan_id');
            $table->uuid('group_id');

            $table->foreign('plan_id')
                ->references('id')->on('plans')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('group_id')
                ->references('id')->on('exercise_groups')
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
        Schema::dropIfExists('plan_group');
    }
}
