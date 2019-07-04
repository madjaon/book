<?php

use App\Models\PostTag;
use Illuminate\Database\Seeder;

class PostTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $i=1;
        while($i < 13) {
            $name = $faker->sentence;
            $slug = CommonMethod::buildSlug($name);
            PostTag::create([
                'name' => $name,
                'slug' => $slug,
            ]);
            $i++;
        }
    }
}
