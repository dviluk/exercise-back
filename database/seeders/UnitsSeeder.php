<?php

namespace Database\Seeders;

use App\Repositories\V1\UnitsRepository;
use Illuminate\Database\Seeder;

class UnitsSeeder extends Seeder
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
                'symbol' => 's',
                'name' => 'seconds',
                'display_name' => 's',
            ],
            [
                'symbol' => 'm',
                'name' => 'minutes',
                'display_name' => 'm',
            ],
        ];

        $repo = new UnitsRepository;
        $repo->setIgnoreValidations(true);

        foreach ($items as $item) {
            $exists = $repo->query()->where('name', $item['name'])->exists();
            if (!$exists) {
                $created = $repo->create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
