<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaConfig extends Model
{
    use HasFactory;

    public static function getvalue($label){
        $record = LaConfig::where('key', $label)->first();
        if($record){
            return $record->value;
        }
        return '';
    }

    public static function getskins(){
        return $skin_array = [
        'White Skin' => 'skin-white',
        'Blue Skin' => 'skin-blue',
        'Black Skin' => 'skin-black',
        'Purple Skin' => 'skin-purple',
        'Yellow Sking' => 'skin-yellow',
        'Red Skin' => 'skin-red',
        'Green Skin' => 'skin-green'
        ];
    }

    public static function getlayout(){
        return $layout_array = [
        'Fixed Layout' => 'fixed',
        'Boxed Layout' => 'layout-boxed',
        'Top Navigation Layout' => 'layout-top-nav',
        'Sidebar Collapse Layout' => 'sidebar-collapse',
        'Mini Sidebar Layout' => 'sidebar-mini'
        ];
    }

    public static function updatevalue($label, $value){
        $record = LaConfig::where('key', $label)->first();
        if($record){
            $record->value = $value;
            $record->save();
        }else{
            $new = new LaConfig();
            $new->key = $label;
            $new->value = $value;
            $new->save();
        }
        return true;
    }

    

   
}
