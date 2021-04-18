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
                'name' => 'Fat loss',
                'description' => '',
            ],
            [
                'id' => 'goals_2',
                'name' => 'Get toned',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Goal::where('name', $item['name'])->exists();

            if (!$exists) {
                Goal::create($item);
            }
        }
    }
}
