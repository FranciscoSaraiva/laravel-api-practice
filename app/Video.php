<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 10-07-2017
 * Time: 11:01
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Video extends Model
{
    use Notifiable;

    protected $table = 'video';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'hash', 'video_embed',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function thumbnail(){
        return $this->hasMany(Thumbnail::class, 'video_id');
    }
}