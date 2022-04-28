<?php

namespace Database\Seeders;

use App\Repositories\V1\TagsRepository;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
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
                'id' => 'tags_1',
                'name' => 'Tag 1',
            ],
            [
                'id' => 'tags_2',
                'name' => 'Tag 2',
            ],
        ];

        $repo = new TagsRepository;
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
