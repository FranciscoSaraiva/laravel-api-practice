<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 10-07-2017
 * Time: 19:06
 */

namespace App\Http\Requests\API\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVideoPut extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'hash'     =>  'required',
        ];
    }

}