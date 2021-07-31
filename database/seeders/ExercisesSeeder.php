<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Seeder;

class ExercisesSeeder extends Seeder
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
                'name' => 'Dumbbell Flat Bench Press',
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
                'muscles' => [
                    'muscles_6', 'muscles_7', 'muscles_8', 'muscles_9'
                ],
            ]
        ];

        foreach ($items as $item) {
            $exists = Exercise::where('name', $item['name'])->exists();

            if ($exists) {
                $muscles = $item['muscles'];
                unset($item['muscles']);

                $created = Exercise::create($item);

                $created->muscles()->attach($muscles);

                $this->command->info("{$created->name} creado!.");
            }
        }
    }
}
