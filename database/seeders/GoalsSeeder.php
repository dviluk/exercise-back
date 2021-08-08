<?php

namespace Database\Seeders;

use App\Models\Goal;
use Illuminate\Database\Seeder;

class GoalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 'goals_1',
                'name' => 'Lose fat',
                'description' => '',
            ],
            [
                'id' => 'goals_2',
                'name' => 'Get toned',
                'description' => '',
            ],
            [
                'id' => 'goals_3',
                'name' => 'Gain muscle',
                'description' => '',
            ],
            [
                'id' => 'goals_4',
                'name' => 'Increase Endurance',
                'description' => '',
            ],
            [
                'id' => 'goals_5',
                'name' => 'Increase flexibility',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Goal::where('name', $item['name'])->exists();

            if (!$exists) {
                $created = Goal::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
