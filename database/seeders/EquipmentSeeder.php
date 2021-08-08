<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Faker */
        $faker = Container::getInstance()->make(Faker::class);

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
                'name' => 'Agility Ladder',
                'description' => '',
            ],
            [
                'id' => 'equipment_4',
                'name' => 'Barbell / EZ-Bar',
                'description' => '',
            ],
            [
                'id' => 'equipment_5',
                'name' => 'Battle Rope',
                'description' => '',
            ],
            [
                'id' => 'equipment_6',
                'name' => 'Bosu ball',
                'description' => '',
            ],
            [
                'id' => 'equipment_7',
                'name' => 'Cable station',
                'description' => '',
            ],
            [
                'id' => 'equipment_8',
                'name' => 'Climbing Rope',
                'description' => '',
            ],
            [
                'id' => 'equipment_9',
                'name' => 'Dumbbells',
                'description' => '',
            ],
            [
                'id' => 'equipment_10',
                'name' => 'Foam roller',
                'description' => '',
            ],
            [
                'id' => 'equipment_11',
                'name' => 'Gymnastic Rings',
                'description' => '',
            ],
            [
                'id' => 'equipment_12',
                'name' => 'Kettlebells',
                'description' => '',
            ],
            [
                'id' => 'equipment_13',
                'name' => 'Medicine ball',
                'description' => '',
            ],
            [
                'id' => 'equipment_14',
                'name' => 'Powerbag / Sandbag',
                'description' => '',
            ],
            [
                'id' => 'equipment_15',
                'name' => 'Resistance bands',
                'description' => '',
            ],
            [
                'id' => 'equipment_16',
                'name' => 'Sled',
                'description' => '',
            ],
            [
                'id' => 'equipment_17',
                'name' => 'Suspension straps / TRX',
                'description' => '',
            ],
            [
                'id' => 'equipment_18',
                'name' => 'Swiss / Exercise ball',
                'description' => '',
            ],
            [
                'id' => 'equipment_19',
                'name' => 'Water Bottles',
                'description' => '',
            ],
        ];

        $imagesDir =  storage_path('app/public/equipments/images');

        if (!File::exists($imagesDir)) {
            File::makeDirectory($imagesDir, 493, true);
        }

        foreach ($items as $item) {
            $exists = Equipment::where('name', $item['name'])->exists();

            if (!$exists) {
                $image = $faker->image($imagesDir, 400, 400, null, true, false, $item['name']);
                $image = explode('/', $image);
                $image = $image[count($image) - 1];

                $item['image'] = $image;

                $created = Equipment::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
