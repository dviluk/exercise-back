<?php

namespace Database\Seeders;

use App\Models\Tag;
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
                'description' => '',
            ],
            [
                'id' => 'tags_2',
                'name' => 'Tag 2',
                'description' => '',
            ],
        ];

        foreach ($items as $item) {
            $exists = Tag::where('name', $item['name'])->exists();

            if (!$exists) {
                Tag::create($item);
            }
        }
    }
}
