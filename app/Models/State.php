<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'state_list';
    protected $fillable = ['state'];

    public static function getname($id){
        $result = State::where('id', $id)->first();
        if($result){
            return $result->state;
        }
        return "";
    }
}
