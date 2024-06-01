<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';

    public static function gethourandmin($minutes){
        try{
            $hours = floor($minutes / 60);
            $min = $minutes - ($hours * 60);
            return $hours."hr ".$min."mins";
        }catch(\Exception $e){
            return '';
        }
    }
    
}
