<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(DifficultiesSeeder::class);
        $this->call(MusclesSeeder::class);
        $this->call(TagsSeeder::class);
        $this->call(GoalsSeeder::class);
        $this->call(EquipmentSeeder::class);
        $this->call(WorkoutsSeeder::class);
        $this->call(RoutinesSeeder::class);
        $this->call(UnitsSeeder::class);
    }
}
