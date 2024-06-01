<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Photo;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'gallery';
    public $timestamps = false;
    protected $primaryKey = 'gallery_id';
    protected $fillable = ['name'];

    public static function updateSortIds($gallery_id, $photo_id){
        $gallery = Gallery::find($gallery_id);
        $ids = $gallery->sorted_ids;
        if(!$ids){
            $ids = [];
            array_push($ids, $photo_id);
        } else{
            $ids = json_decode($ids);
            array_push($ids, $photo_id);
        }
        $gallery->sorted_ids = json_encode($ids);
        $gallery->save();

        return true;
    }

    public static function getPhotos($ids){
        $photos = [];
        if(!is_array($ids)){
            $ids = [];
        }
        foreach($ids as $id){
            $photo = Photo::find($id);
            array_push($photos, $photo); 
        }
        return $photos;
    }
}
