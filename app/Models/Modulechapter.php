<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulechapter extends Model
{
    protected $table = 'module_chapter';

    public static function getname($id){
        $record = Modulechapter::find($id);
        if($record){
            return $record->title;
        }
        return '';
    }
    
}
