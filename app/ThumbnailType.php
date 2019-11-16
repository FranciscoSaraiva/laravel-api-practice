<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 11-07-2017
 * Time: 11:35
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ThumbnailType extends Model
{

    /**
     * @var string
     */
    protected $table = 'thumbnail_type';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $appends = array('url');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['thumbnail_type_name', 'width', 'height'];

    /**
     * @var array
     */
    protected $hidden = ['thumbnail_type_name', 'thumbnail'];

    //Ir buscar o valor do URL da tabela thumbnail_type

    /**
     * @param $value
     * @return null
     */
    public function getUrlAttribute($value){
        $url = null;
        if($this->thumbnail){
            $url = $this->thumbnail->url;
        }
        return $url;
    }
}