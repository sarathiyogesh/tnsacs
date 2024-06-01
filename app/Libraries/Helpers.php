<?php

use App\Models\Websettings;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Cms;
use App\Models\Cmsimage;

class Helpers {

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

    public static function getcontent($key){
        $info = Cms::where('label_name', $key)->first();
        if($info){
            return html_entity_decode($info->content);
        }
        return '';
    }

    public static function getcheckboxcontent($key){
        $info = Cms::where('label_name', $key)->first();
        if($info && $info->content == 'yes'){
            return true;
        }
        return false;
    }

    public static function getsingleimage($key){
        $info = Cmsimage::where('label_name', $key)->first();
        if($info){
            return URL::asset($info->file_path);
        }
        return '';
    }

    public static function getsingleimage_id($key){
        $info = Cmsimage::where('label_name', $key)->first();
        if($info){
            return encrypt($info->id);
        }
        return '';
    }

    public static function getmultipleimage($key){
        $info = Cmsimage::where('label_name', $key)->select('id','file_path')->get();
        return $info;
    }
 
}