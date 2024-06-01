<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

class Extras extends Model
{
    use HasFactory;

    public static function fetchPrivacyPolicy(){
        $path = env('S3_EXTRAS_DIR').'policy.txt';
        if(Storage::disk('s3')->exists($path)){
            return Storage::disk('s3')->get($path);
        } else{
            return 'Start writing your policy';
        }
    }

    public static function savePrivacyPolicy($text){
        $path = env('S3_EXTRAS_DIR').'policy.txt';
        Storage::disk('s3')->put($path, $text);
        return true;
    }

    public static function fetchTerms(){
        $path = env('S3_EXTRAS_DIR').'terms.txt';
        if(Storage::disk('s3')->exists($path)){
            return Storage::disk('s3')->get($path);
        } else{
            return 'Start writing your terms';
        }
    }

    public static function saveTerms($text){
        $path = env('S3_EXTRAS_DIR').'terms.txt';
        Storage::disk('s3')->put($path, $text);
        return true;
    }

    public static function fetchAboutus(){
        $path = env('S3_EXTRAS_DIR').'aboutus.txt';
        if(Storage::disk('s3')->exists($path)){
            return Storage::disk('s3')->get($path);
        } else{
            return 'Start writing your aboutus';
        }
    }

    public static function saveAboutus($text){
        $path = env('S3_EXTRAS_DIR').'aboutus.txt';
        Storage::disk('s3')->put($path, $text);
        return true;
    }
}
