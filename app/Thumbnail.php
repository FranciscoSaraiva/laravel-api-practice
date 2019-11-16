<?php
/**
 * Created by PhpStorm.
 * User: franciscosaraiva
 * Date: 11-07-2017
 * Time: 10:05
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Thumbnail extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'thumbnail';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $appends = ['width', 'height'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['url', 'thumbnail_type_id', 'video_id'];

    /**
     * @var array
     */
    protected $hidden = ['thumbnail_type_id', 'video_id', 'id', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ThumbnailType::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    /**
     * @return null
     */
    public function getWidthAttribute(){
        $width = null;
        if(ThumbnailType::where('id', '=', $this->thumbnail_type_id)){
            $thumbnail_type = ThumbnailType::where('id', '=', $this->thumbnail_type_id)->get(); //Gets the collection
            $values = $thumbnail_type[0]->getAttributes(); //Gets the array attributes
            $width = $values['width']; //gets and sets the correct width
        }
        return $width;
    }

    /**
     * @return null
     */
    public function getHeightAttribute(){
        $height = null;
        if(ThumbnailType::where('id', '=', $this->thumbnail_type_id)){
            $thumbnail_type = ThumbnailType::where('id', '=', $this->thumbnail_type_id)->get(); //Gets the collection
            $values = $thumbnail_type[0]->getAttributes(); //Gets the array attributes
            $height = $values['height']; //gets and sets the correct width
        }
        return $height;
    }
}