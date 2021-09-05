<?php

namespace Database\Seeders;

use App\Repositories\V1\GoalsRepository;
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
            ],
            [
                'id' => 'goals_2',
                'name' => 'Get toned',
            ],
            [
                'id' => 'goals_3',
                'name' => 'Gain muscle',
            ],
            [
                'id' => 'goals_4',
                'name' => 'Increase Endurance',
            ],
            [
                'id' => 'goals_5',
                'name' => 'Increase flexibility',
            ],
        ];

        $repo = new GoalsRepository;
        $repo->setApplyValidations(false);

        foreach ($items as $item) {
            $exists = $repo->query()->where('name', $item['name'])->exists();

            if (!$exists) {
                $created = $repo->create($item, ['customId' => true]);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
