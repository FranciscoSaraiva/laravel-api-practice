<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 13-07-2017
 * Time: 19:35
 */

namespace App\Console\Commands\Youtube;


use Illuminate\Console\Command;
use App\Video;
use DB;

class YoutubeCommand extends Command
{


    /**
     * @var array
     */
    protected $headers = ['Hash', 'Embed', 'Title'];

    /**
     * @var array
     */
    protected $fields = ['hash', 'video_embed', 'title'];

}