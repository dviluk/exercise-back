<?php

namespace Database\Seeders;

use App\Repositories\V1\EquipmentRepository;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Mmo\Faker\PicsumProvider;

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
        $faker->addProvider(new PicsumProvider($faker));

        $items = [
            [
                'id' => 'equipment_1',
                'name' => 'Full Gym',
            ],
            [
                'id' => 'equipment_2',
                'name' => 'No equipment',
            ],
            [
                'id' => 'equipment_3',
                'name' => 'Agility Ladder',
            ],
            [
                'id' => 'equipment_4',
                'name' => 'Barbell / EZ-Bar',
            ],
            [
                'id' => 'equipment_5',
                'name' => 'Battle Rope',
            ],
            [
                'id' => 'equipment_6',
                'name' => 'Bosu ball',
            ],
            [
                'id' => 'equipment_7',
                'name' => 'Cable station',
            ],
            [
                'id' => 'equipment_8',
                'name' => 'Climbing Rope',
            ],
            [
                'id' => 'equipment_9',
                'name' => 'Dumbbells',
            ],
            [
                'id' => 'equipment_10',
                'name' => 'Foam roller',
            ],
            [
                'id' => 'equipment_11',
                'name' => 'Gymnastic Rings',
            ],
            [
                'id' => 'equipment_12',
                'name' => 'Kettlebells',
            ],
            [
                'id' => 'equipment_13',
                'name' => 'Medicine ball',
            ],
            [
                'id' => 'equipment_14',
                'name' => 'Powerbag / Sandbag',
            ],
            [
                'id' => 'equipment_15',
                'name' => 'Resistance bands',
            ],
            [
                'id' => 'equipment_16',
                'name' => 'Sled',
            ],
            [
                'id' => 'equipment_17',
                'name' => 'Suspension straps / TRX',
            ],
            [
                'id' => 'equipment_18',
                'name' => 'Swiss / Exercise ball',
            ],
            [
                'id' => 'equipment_19',
                'name' => 'Water Bottles',
            ],
        ];

        $repo = new EquipmentRepository;
        $repo->setApplyValidations(false);

        $imagesDir =  storage_path('app/public/equipments/images');

        if (!File::exists($imagesDir)) {
            File::makeDirectory($imagesDir, 493, true);
        }

        $tempDir =  storage_path('app/temp');

        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 493, true);
        }

        foreach ($items as $item) {
            $exists = $repo->query()->where('name', $item['name'])->exists();

            if (!$exists) {
                $image = $faker->picsum($tempDir, 400, 400, null, true, false, $item['name']);
                $image = explode('/', $image);
                $image = last($image);

                $item['image'] = new UploadedFile($tempDir . '/' . $image, $image);

                $created = $repo->create($item, ['customId' => true]);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
