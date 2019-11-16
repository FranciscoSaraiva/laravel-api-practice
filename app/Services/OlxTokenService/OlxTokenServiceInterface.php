<?php

namespace App\Services\OlxTokenService;

interface OlxTokenServiceInterface
{

    /**
     * @return mixed
     */
    public function checkOlxToken($token);
}