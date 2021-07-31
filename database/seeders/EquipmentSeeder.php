<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
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
                'id' => 'equipment_1',
                'name' => 'Full Gym',
                'description' => '',
            ],
            [
                'id' => 'equipment_2',
                'name' => 'No equipment',
                'description' => '',
            ],
            [
                'id' => 'equipment_3',
                'name' => 'Dumbbells',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Equipment::where('name', $item['name'])->exists();

            if ($exists) {
                $created = Equipment::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
