<?php

namespace Database\Seeders;

use App\Repositories\V1\ExercisesRepository;
use Faker\Generator as Faker;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Mmo\Faker\PicsumProvider;

class ExercisesSeeder extends Seeder
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
                'id' => 'exercises_1',
                'name' => 'Dumbbell Flat Bench Press',
                'tag_id' => 'tags_1',
                'description' => '
                Lie on a flat bench holding a dumbbell in each hand with an overhand grip.
                Start by holding the dumbbells slightly wider than shoulder width apart above your shoulders. Your palms should be facing forward.
                Slowly bend your elbows until they are at a 90 degree angle and your upper arms are parallel to the ground.
                Push the weights up by straightening your arms.
                As you push the weights up, move your arms in an arc to bring the dumbbells together, until they meet over the center of your chest. Hold for a count of one.
                Lower the dumbbells by slowly bending your elbows back to 90 degrees.
                Continue lowering your arms until they are a little lower than parallel to the floor. (Your elbows should be pointing slightly towards the floor and you should feel a stretch in your chest muscles and shoulders.)
                Repeat
            ',
                'difficulty_id' => 'difficulties_1',
                'equipment' => [
                    'equipment_6', 'equipment_7', 'equipment_8', 'equipment_9'
                ],
                'muscles' => [
                    [
                        'id' => 'muscles_6',
                        'primary' => true,
                    ],
                    [
                        'id' => 'muscles_7',
                        'primary' => false,
                    ],
                    [
                        'id' => 'muscles_8',
                        'primary' => false,
                    ],
                    [
                        'id' => 'muscles_9',
                        'primary' => false,
                    ],
                ],
            ]
        ];

        $repo = new ExercisesRepository;
        $repo->setApplyValidations(false);

        $tempDir =  storage_path('app/temp');
        $imagesDir =  storage_path('app/public/exercises/images');
        $illustrationsDir =  storage_path('app/public/exercises/illustrations');

        if (!File::exists($tempDir)) {
            File::makeDirectory($tempDir, 493, true);
        }

        if (!File::exists($imagesDir)) {
            File::makeDirectory($imagesDir, 493, true);
        }

        if (!File::exists($illustrationsDir)) {
            File::makeDirectory($illustrationsDir, 493, true);
        }

        foreach ($items as $item) {
            $exists = $repo->query()->where('name', $item['name'])->exists();

            if (!$exists) {
                $image = $faker->picsum($tempDir, 400, 400, null, true, false, $item['name']);
                $image = explode('/', $image);
                $image = last($image);

                $item['image'] = new UploadedFile($tempDir . '/' . $image, $image);

                $illustration = $faker->picsum($tempDir, 400, 400, null, true, false, $item['name']);
                $illustration = explode('/', $illustration);
                $illustration = last($illustration);

                $item['illustration'] = new UploadedFile($tempDir . '/' . $illustration, $illustration);

                $created = $repo->create($item, ['customId' => true]);

                $this->command->info("{$created->name} creado!.");
            }
        }
    }
}
