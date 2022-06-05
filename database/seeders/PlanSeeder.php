<?php

namespace Database\Seeders;

use App\Repositories\V1\PlansRepository;
use App\Repositories\V1\RoutinesRepository;
use App\Repositories\V1\WorkoutsRepository;
use DB;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $plan = [
                'id' => 'plans_1',
                'name' => 'Legionarios',
                'difficulty_id' => 'difficulties_1',
                'introduction' => 'lorem ipsum',
                'description' => 'lorem ipsum',
                'weeks' => 12,
                'goals' => ['goals_1', 'goals_2'],
            ];

            $repo = new PlansRepository;
            $repo->setApplyValidations(false);
            $repo->create($plan, ['customId' => true]);

            $routines = [
                [
                    'id' => 'routines_1',
                    'name' => 'Routine 1',
                    'description' => 'lorem ipsum',
                    'plan_id' => 'plans_1',
                    'day' => 1
                ],
            ];

            $routinesRepo = new RoutinesRepository;
            $routinesRepo->setApplyValidations(false);

            foreach ($routines as $routine) {
                $routinesRepo->create($routine, ['customId' => true]);
            }

            $workouts = [
                [
                    'id' => 'workouts_1',
                    'exercise_id' => 'exercises_1',
                    'difficulty_id' => 'difficulties_1',
                    'plan_id' => 'plans_1',
                    'routine_id' => 'routines_1',
                    'sets' => 3,
                    'rest' => 2,
                    'order' => 1,
                    'min_repetitions' => 10,
                    'max_repetitions' => 15,
                ]
            ];

            $workoutRepo = new WorkoutsRepository;
            $workoutRepo->setApplyValidations(false);

            foreach ($workouts as $workout) {
                $workoutRepo->create($workout, ['customId' => true]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();

            throw $th;
        }
    }
}
