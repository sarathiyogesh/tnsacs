<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'city';

    public function roles()
    {
        return $this->hasMany('App\Activity');
    }

    public static function getname($id){
        $record = City::find($id);
        if($record){
            return $record->name;
        }
        return '';
    }
}
