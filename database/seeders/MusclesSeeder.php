<?php

namespace Database\Seeders;

use App\Models\Muscle;
use Illuminate\Database\Seeder;

class MusclesSeeder extends Seeder
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
                'id' => 'muscles_1',
                'name' => 'Abs',
                'description' => '',
            ],
            [
                'id' => 'muscles_2',
                'name' => 'Biceps',
                'description' => '',
            ],
            [
                'id' => 'muscles_3',
                'name' => 'Calves',
                'description' => '',
            ],
            [
                'id' => 'muscles_4',
                'name' => 'Chest',
                'description' => '',
            ],
            [
                'id' => 'muscles_5',
                'name' => 'Forearms',
                'description' => '',
            ],
            [
                'id' => 'muscles_6',
                'name' => 'Glutes & Hip Flexors',
                'description' => '',
            ],
            [
                'id' => 'muscles_7',
                'name' => 'Hamstrings',
                'description' => '',
            ],
            [
                'id' => 'muscles_8',
                'name' => 'Lower Back',
                'description' => '',
            ],
            [
                'id' => 'muscles_9',
                'name' => 'Middle Back / Lats',
                'description' => '',
            ],
            [
                'id' => 'muscles_10',
                'name' => 'Neck & Upper Traps',
                'description' => '',
            ],
            [
                'id' => 'muscles_11',
                'name' => 'Obliques',
                'description' => '',
            ],
            [
                'id' => 'muscles_12',
                'name' => 'Quadriceps',
                'description' => '',
            ],
            [
                'id' => 'muscles_13',
                'name' => 'Shoulders',
                'description' => '',
            ],
            [
                'id' => 'muscles_14',
                'name' => 'Triceps',
                'description' => '',
            ],
            [
                'id' => 'muscles_15',
                'name' => 'Upper Back & Lower Traps',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Muscle::where('name', $item['name'])->exists();

            if (!$exists) {
                $created = Muscle::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
