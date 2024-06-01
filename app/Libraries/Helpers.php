<?php

use App\Models\Websettings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Customfield;
use App\Models\Media;

class Helpers {

    public static function getcontent($key){
        $info = Customfield::where('field_slug', $key)->first();
        if($info){
            return html_entity_decode($info->field_value);
        }
        return '';
    }

    public static function getsingleimage($key){
        $info = Customfield::where('field_slug', $key)->first();
        if($info && $info->field_value){
            $image = Media::find($info->field_value);
            if($image){
                return asset($image->image_link);
            }
        }
        return '';
    }

    public static function portalname() {
        $portal_name = Websettings::getvalue("portalName");
        return $portal_name !="" ? $portal_name : "Sais Academy";
    }

    public static function sitetitle() {
        $site_title = Websettings::getvalue("siteTitle");
        return $site_title !="" ? $site_title : "Sais Academy";
    }

    public static function favicon() {
        $favicon = Websettings::getvalue("favicon");
        return $favicon !="" ? $favicon : "";
    }

    public static function displaymsg(){
  	    if(Session::has('success')){
  		    return '<div class="alert alert-success">'.Session::get('success').'</div>';
  	    }elseif(Session::has('error')){
  		    return '<div class="alert alert-danger">'.Session::get('error').'</div>';
  	    }
    }

    public static function strtoslug($string){
        return Str::slug($string);
    }
    public static function tamilstrtoslug($string){
        return str_replace(" ","-",$string);
        return Str::slug($string);
    }

    public static function fileupload($file, $path, $width, $height)
    {
        $image_name = md5($file->getClientOriginalName()."".date("YmdHis")).'.'.$file->getClientOriginalExtension();
        $tmp_image = Image::make($file->getRealPath())->resize($width, $height);
        $tmp_image->save(public_path("{$path}{$image_name}"));
        $file_path = $path.$image_name;
        return $file_path;
    }

    public static function web_getcontent($key){
        return Websettings::getvalue($key);
    }
 
}