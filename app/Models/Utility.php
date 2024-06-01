<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;
use File;
use App\Models\SimpleImage;


class Utility extends Model
{
    use HasFactory;

    public static function getHost(){
        return 'http://'.$_SERVER['HTTP_HOST'].'/';
    }

    public static function uploadMovieFile($string, $filename, $w, $h) {
        $imgUrl = '';

        $path = env('UPLOAD_MOVIE_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_MOVIE_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedMovieFile($file){
        $path = env('S3_UPLOAD_MOVIE_DIR').$file;
        Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadActivityFile($string, $filename, $w, $h) {
        $imgUrl = '';

        $path = env('UPLOAD_ACTIVITY_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_ACTIVITY_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedActivityFile($file){
        $path = env('S3_UPLOAD_ACTIVITY_DIR').$file;
        Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadStayCationFile($string, $filename, $w, $h) {
        $imgUrl = '';

        $path = env('UPLOAD_STAYCATION_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_STAYCATION_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedStayCationFile($file){
        $path = env('S3_UPLOAD_STAYCATION_DIR').$file;
        Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadEventFile($string, $filename, $w, $h) {
        $imgUrl = '';
       // $path = env('UPLOAD_EVENT_DIR').$filename;
        $move_path = 'uploads/event/';
        $path = '/uploads/event/'.$filename;
        \Log::info($move_path);
        // save image and thumbnail on server
        //$save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));
        try{
            $save = $string->move($move_path, $filename);
            \Log::info($save);
        }catch(\Exception $e){
            \Log::info($e->getMessage());
        }

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_EVENT_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedEventFile($file){
        $path = env('S3_UPLOAD_EVENT_DIR').$file;
        Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadNightlifeFile($string, $filename, $w, $h) {
        $imgUrl = '';

        $path = env('UPLOAD_NIGHTLIFE_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_NIGHTLIFE_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedNightlifeFile($file){
        $path = env('S3_UPLOAD_NIGHTLIFE_DIR').$file;
        $delete = Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadDjFile($string, $filename, $w, $h) {
        $imgUrl = '';

        $path = env('UPLOAD_DJ_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 80);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_DJ_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedDjFile($file){
        $path = env('S3_UPLOAD_DJ_DIR').$file;
        $delete = Storage::disk('s3')->delete($path);
        return true;
    }

    public static function uploadPostFile($string, $filename, $w=Null, $h=Null) {
        $imgUrl = '';

        $path = env('UPLOAD_POST_DIR').$filename;

        // save image and thumbnail on server
        $save = File::put(public_path().$path, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $string)));

        // compress image
        Utility::compress(public_path().$path, public_path().$path, 90);
        if($w){
            Utility::resizeW(public_path().$path, $w);
        }
        if($h){
            Utility::resizeH(public_path().$path, $h);
        }

        // upload image to s3
        $s3path = env('S3_UPLOAD_POST_DIR').$filename;
        Storage::disk('s3')->put($s3path, file_get_contents(public_path().$path));

        // Get the uploaded image path
        $imgUrl = Storage::disk('s3')->url($s3path);

        // delete the files on server we no longer need them
        File::delete(public_path().$path);

        return $save ? $imgUrl  : false;
    }

    public static function deleteUploadedPostFile($file){
        $path = env('S3_UPLOAD_POST_DIR').$file;
        $delete = Storage::disk('s3')->delete($path);
        return true;
    }

    public static function compress($source, $destination, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);

        imagejpeg($image, $destination, $quality);

        return $destination;
    }

    public static function resizeW($path, $width){
        $image = new SimpleImage();
        $image->load($path);
        $image->resizeToWidth($width);
        $image->saveImg($path);
    }
    public static function resizeH($path, $height){
        $image = new SimpleImage();
        $image->load($path);
        $image->resizeToHeight($height);
        $image->saveImg($path);
    }
}
