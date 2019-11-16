<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 17-07-2017
 * Time: 17:32
 */

namespace App\Services\YoutubeClient;

use App\Video;
use GuzzleHttp;

interface YoutubeClientInterface
{

    /**
     * @param string $hash
     * @return GuzzleHttp\Psr7\Response
     */
    public function getVideoFromYoutube(string $hash): GuzzleHttp\Psr7\Response;

    /**
     * @param string $hash
     * @return Video
     */
    public function getVideoAsModel(string $hash): Video;

}