<?php

namespace App\Services\OlxTokenService;

use GuzzleHttp;

class OlxTokenService implements OlxTokenServiceInterface
{


    public function __construct( )
    {
    }

    /**
     * @return mixed
     */
    public function checkOlxToken($token)
    {
        try{
            $client = new GuzzleHttp\Client();
            $response = $client->get('http://api.joinolx.com/api/docs/1?olx-token='.$token);
            if($response->getStatusCode()==200)
                return true;
        }catch(\Exception $ex){
            return false;
        }
    }
}