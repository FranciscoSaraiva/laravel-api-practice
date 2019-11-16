<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 14-07-2017
 * Time: 16:03
 */

namespace App\Http\Response\API\v1;


class ResponseVideo extends ResponseAPI
{
    /**
     * @param $videos
     * @return $this
     */
    public function setVideos($videos)
    {
        $this->data['videos'] = $videos;

        return $this;
    }

    /**
     * @param int $total
     * @return $this
     */
    public function setTotal(int $total)
    {
        $this->meta['total'] = $total;

        return $this;
    }
}