<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ConnectRelationshipsSeeder::class);
        $this->call(ThemesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ConfigsTableSeeder::class);
        $this->call(PostTypesTableSeeder::class);
        $this->call(PostTagsTableSeeder::class);
        $this->call(PostSeriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(PostChapsTableSeeder::class);

        Model::reguard();
    }
}
