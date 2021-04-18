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
                'name' => 'Lower Back',
                'description' => '',
            ],
            [
                'id' => 'muscles_2',
                'name' => 'Upper Back',
                'description' => '',
            ],
            [
                'id' => 'muscles_3',
                'name' => 'Lower Traps',
                'description' => '',
            ],
            [
                'id' => 'muscles_4',
                'name' => 'Biceps',
                'description' => '',
            ],
            [
                'id' => 'muscles_5',
                'name' => 'Forearms',
                'description' => '',
            ],
            [
                'id' => 'muscles_6',
                'name' => 'Shoulders',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Muscle::where('name', $item['name'])->exists();

            if (!$exists) {
                Muscle::create($item);
            }
        }
    }
}
