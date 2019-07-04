<?php

use App\Models\Post;
use App\Models\PostTypeRelation;
use App\Models\PostTagRelation;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
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
        while($i < 120) {
            $name = $faker->sentence;
            $slug = CommonMethod::buildSlug($name);
            Post::create([
                'name' => $name,
                'slug' => $slug,
                'summary' => $faker->paragraph,
                'content' => '<p>'.$faker->paragraph.'</p>',
                'type_main_id' => $faker->numberBetween(1,40),
                'seri' => $faker->numberBetween(1,12),
                'start_date' => '2018-01-02 '.$faker->time,
            ]);
            PostTypeRelation::insert([
                ['post_id' => $i, 'posttype_id' => $faker->numberBetween(1,20)],
                ['post_id' => $i, 'posttype_id' => $faker->numberBetween(21,40)],
            ]);
            PostTagRelation::insert([
                ['post_id' => $i, 'posttag_id' => $faker->numberBetween(1,6)],
                ['post_id' => $i, 'posttag_id' => $faker->numberBetween(7,12)],
            ]);
            $i++;
        }
    }
}
