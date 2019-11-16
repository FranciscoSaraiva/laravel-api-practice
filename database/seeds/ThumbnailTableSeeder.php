<?php

use Illuminate\Database\Seeder;

class ThumbnailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $urlIdentifier1 = str_random(8);
        for($i=0; $i < 3; $i++){
            App\Thumbnail::create([
                'url'                   => 'https://i.ytimg.com/vi/'.$urlIdentifier1.'/'.$this->getThumbnailFilename(($i+1)),
                'thumbnail_type_id'     => ($i+1),
                'video_id'              => 1
            ]);
        }

        $urlIdentifier2 = str_random(8);
        for($i=0; $i < 3; $i++){
            App\Thumbnail::create([
                'url'                   => 'https://i.ytimg.com/vi/'.$urlIdentifier2.'/'.$this->getThumbnailFilename(($i+1)),
                'thumbnail_type_id'     => ($i+1),
                'video_id'              => 2
            ]);
        }

        $urlIdentifier3 = str_random(8);
        for($i=0; $i < 3; $i++){
            App\Thumbnail::create([
                'url'                   => 'https://i.ytimg.com/vi/'.$urlIdentifier3.'/'.$this->getThumbnailFilename(($i+1)),
                'thumbnail_type_id'     => ($i+1),
                'video_id'              => 3
            ]);
        }
    }


    public function getThumbnailFilename($thumbnail_type){
        switch($thumbnail_type){
            case 1: return 'default.jpg'; break;
            case 2: return 'mdefault.jpg'; break;
            case 3: return 'hqdefault.jpg'; break;
        }
    }

}
