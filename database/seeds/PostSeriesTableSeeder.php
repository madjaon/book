<?php

use App\Models\PostSeri;
use Illuminate\Database\Seeder;

class PostSeriesTableSeeder extends Seeder
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
            PostSeri::create([
                'name' => $name,
                'slug' => $slug,
            ]);
            $i++;
        }
    }
}
