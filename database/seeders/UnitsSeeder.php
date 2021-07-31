<?php

namespace Database\Seeders;

use App\Models\Unit;
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
                'name' => 'Seconds',
                'description' => '-',
            ],
            [
                'name' => 'time',
                'description' => '-',
            ],
        ];

        foreach ($items as $item) {
            $exists = Unit::where('name', $item['name'])->exists();
            if (!$exists) {
                $created = Unit::create($item);
                $this->command->info("{$created->name} creado.");
            }
        }
    }
}
