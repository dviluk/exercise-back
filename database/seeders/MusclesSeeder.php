<?php

namespace Database\Seeders;

use App\Repositories\V1\MusclesRepository;
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
            ],
            [
                'id' => 'muscles_2',
                'name' => 'Biceps',
            ],
            [
                'id' => 'muscles_3',
                'name' => 'Calves',
            ],
            [
                'id' => 'muscles_4',
                'name' => 'Chest',
            ],
            [
                'id' => 'muscles_5',
                'name' => 'Forearms',
            ],
            [
                'id' => 'muscles_6',
                'name' => 'Glutes & Hip Flexors',
            ],
            [
                'id' => 'muscles_7',
                'name' => 'Hamstrings',
            ],
            [
                'id' => 'muscles_8',
                'name' => 'Lower Back',
            ],
            [
                'id' => 'muscles_9',
                'name' => 'Middle Back / Lats',
            ],
            [
                'id' => 'muscles_10',
                'name' => 'Neck & Upper Traps',
            ],
            [
                'id' => 'muscles_11',
                'name' => 'Obliques',
            ],
            [
                'id' => 'muscles_12',
                'name' => 'Quadriceps',
            ],
            [
                'id' => 'muscles_13',
                'name' => 'Shoulders',
            ],
            [
                'id' => 'muscles_14',
                'name' => 'Triceps',
            ],
            [
                'id' => 'muscles_15',
                'name' => 'Upper Back & Lower Traps',
            ],
        ];

        $repo = new MusclesRepository;
        $repo->setIgnoreValidations(true);

        foreach ($items as $item) {
            $exists = $repo->query()->where('name', $item['name'])->exists();

            if (!$exists) {
                $created = $repo->create($item, ['customId' => true]);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
