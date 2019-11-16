<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 14-07-2017
 * Time: 15:59
 */

namespace App\Http\Response\API\v1;

use Illuminate\Http\Response;

class ResponseAPI extends Response
{
    protected $data;
    protected $meta;
    protected $message;

    /**
     * @return array
     */
    protected function builder(): array
    {
        $this->meta['status_code'] = $this->statusCode;
        return [
            'meta' => $this->meta,
            'data' => $this->data
        ];
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
     public function makeToJson()
    {
        return response()->json($this->builder());
    }

    /**
     * @param \Exception $exp
     * @return \Illuminate\Http\JsonResponse
     */
     public function makeException(\Exception $exp)
    {
        $this->data = [];
        $this->meta['error'] = $exp->getMessage();
        $this->statusCode = $exp->getCode();
        return response()->json($this->builder());
    }

    /**
     * @param string $message
     * @return $this
     */
    public function message(string $message)
    {
        $this->meta['message'] = $message;

        return $this;
    }
}