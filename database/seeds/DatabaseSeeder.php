<?php

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
        $this->call(ThumbnailTypeTableSeeder::class); //To initialize the default thumbnail types
        $this->call(VideoTableSeeder::class); //Initialize some video examples
        $this->call(ThumbnailTableSeeder::class); //Initialize the thumbnails of a video
    }
}
