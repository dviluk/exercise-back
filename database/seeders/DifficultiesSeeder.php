<?php

namespace Database\Seeders;

use App\Models\Difficulty;
use Illuminate\Database\Seeder;

class DifficultiesSeeder extends Seeder
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
                'id' => 'difficulties_1',
                'name' => 'Easy',
                'description' => '',
            ],
            [
                'id' => 'difficulties_2',
                'name' => 'Intermediate',
                'description' => '',
            ],
            [
                'id' => 'difficulties_3',
                'name' => 'Difficult',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Difficulty::where('name', $item['name'])->exists();
            if (!$exists) {
                $created = Difficulty::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
