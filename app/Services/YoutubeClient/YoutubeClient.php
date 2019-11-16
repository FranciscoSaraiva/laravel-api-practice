<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 17-07-2017
 * Time: 10:22
 */

namespace App\Services\YoutubeClient;

use App\Thumbnail;
use App\ThumbnailType;
use App\Video;
use GuzzleHttp;

class YoutubeClient implements YoutubeClientInterface
{

    /**
     * @var mixed
     */
    private $apiKey;

    /**
     * @var array
     */
    protected $fields = ['hash', 'video_embed', 'title'];

    /**
     * YoutubeClient constructor.
     */
    function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY');
    }

    // json_decode($response->getBody(), true);

    /**
     * @param string $hash
     * @return GuzzleHttp\Psr7\Response
     */
    public function getVideoFromYoutube(string $hash) : GuzzleHttp\Psr7\Response
    {
        $client = new GuzzleHttp\Client();
        $response = $client->get('https://www.googleapis.com/youtube/v3/videos?id='
            . $hash . '&key=' . $this->apiKey . '&part=snippet,statistics&fields=items(id,snippet,statistics)');
        return $response;
    }

    /**
     * @param string $hash
     * @return Video
     */
    public function getVideoAsModel(string $hash): Video
    {
        $response = $this->getVideoFromYoutube($hash);
        $valuesArray = json_decode($response->getBody(), true);
        $valuesArray = $valuesArray['items'][0];

        $video = new Video();
        $valuesArray = [
            'title' => $valuesArray['snippet']['title'],
            'description' => $valuesArray['snippet']['description'],
            'hash' => $valuesArray['id'],
            'video_embed' => '//www.youtube.com/embed/' . $valuesArray['id'],
            'thumbnails' => $valuesArray['snippet']['thumbnails']
        ];

        $video->fill($valuesArray);
        $video->save();

        foreach ($valuesArray['thumbnails'] as $key => $thumb) {
            $thumbType = ThumbnailType::firstOrCreate([
                'width' => $thumb['width'],
                'height' => $thumb['height'],
                'thumbnail_type_name' => $key,
            ]);

            $thumb['thumbnail_type_id'] = $thumbType->id;
            $thumbnail = new Thumbnail();
            $thumbnail->fill($thumb);
            $thumbnail->video()->associate($video);
            $thumbnail->save();
        }


        return $video;
    }

}