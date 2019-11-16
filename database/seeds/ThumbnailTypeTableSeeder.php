<?php

use Illuminate\Database\Seeder;
use App\ThumbnailType;

class ThumbnailTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\ThumbnailType::create(['thumbnail_type_name' => 'default',      'width'=>120,   'height'=>90]);
        App\ThumbnailType::create(['thumbnail_type_name' => 'medium',       'width'=>320,   'height'=>180]);
        App\ThumbnailType::create(['thumbnail_type_name' => 'large',        'width'=>480,   'height'=>360]);
        /*
        DB::table('thumbnail_type')->insert(['thumbnail_type_name' => 'small',    'width'=>120,   'height'=>90]);
        DB::table('thumbnail_type')->insert(['thumbnail_type_name' => 'medium',   'width'=>320,   'height'=>180]);
        DB::table('thumbnail_type')->insert(['thumbnail_type_name' => 'large',    'width'=>480,   'height'=>360]);
        */
    }
}
