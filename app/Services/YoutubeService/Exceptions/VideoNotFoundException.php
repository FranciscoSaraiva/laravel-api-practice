<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 14-07-2017
 * Time: 16:41
 */

namespace App\Services\YoutubeService\Exceptions;

use Throwable;
use Illuminate\Http\Response;

class VideoNotFoundException extends \Exception
{
    public function __construct($attributeName = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf("Video [%s] not found on youtube.", $attributeName), Response::HTTP_NOT_FOUND, $previous);
    }
}