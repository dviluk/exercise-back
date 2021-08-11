<?php

namespace Database\Seeders;

use App\Repositories\V1\DifficultiesRepository;
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
            ],
            [
                'id' => 'difficulties_2',
                'name' => 'Intermediate',
            ],
            [
                'id' => 'difficulties_3',
                'name' => 'Difficult',
            ],
        ];

        $repo = new DifficultiesRepository;
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
