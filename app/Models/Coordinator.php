<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coordinator extends Model
{
    use HasFactory;

    protected $table = 'coordinators';
    protected $fillable = ['institution', 'course', 'name','email', 'phone', 'photo', 'address', 'state', 'city', 'pincode', 'status', 'created_by'];

    public static function getname($id){
        $result = Coordinator::find($id);
        if($result){
            return $result->name;
        }
        return "";
    }

}
