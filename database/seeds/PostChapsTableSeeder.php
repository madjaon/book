<?php

use App\Models\PostChap;
use Illuminate\Database\Seeder;

class PostChapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $post_ids = [7,41,29];
        foreach($post_ids as $value) {
        	$i=1;
	        while($i < 13) {
	            $name = $faker->sentence;
	            $slug = CommonMethod::buildSlug($name);
	            PostChap::create([
	                'name' => $name,
	                'slug' => $slug,
	                'summary' => $faker->paragraph,
	                'content' => '<p>'.$faker->paragraph.'</p>',
	                'post_id' => $value,
	                'chapter' => $i,
	                'position' => $i,
	                'start_date' => '2018-01-02 '.$faker->time,
	            ]);
	            $i++;
	        }
        }
        
    }
}
