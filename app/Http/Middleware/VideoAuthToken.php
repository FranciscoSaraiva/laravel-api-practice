<?php

namespace App\Http\Middleware;

use App\Http\Response\API\v1\ResponseAPI;
use App\Services\OlxTokenService\OlxTokenService;
use Closure;

class VideoAuthToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $olxTokenService = new OlxTokenService();

        if($olxTokenService->checkOlxToken($request->token))
            return $next($request);

        $response = new ResponseAPI();
        $response->message('This access token is not valid.');
        $response->setStatusCode('401');

        return $response->makeToJson();
    }
}
