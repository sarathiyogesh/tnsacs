<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'course';
    //protected $fillable = ['course_name','description','status'];

    public static function getname($id){
        $result = Course::find($id);
        if($result){
            return $result->course_name;
        }
        return "";
    }

    public function scopeActive($query){
        return $query->where('status', 'active');
    }

}
