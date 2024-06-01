<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class Coursecompletedstatus extends Model
{
    use HasFactory;

    protected $table = 'course_completedstatus';


    public static function getcompletedstatus($course_id,$topic_id){
        $user_id = Auth::id();
        $rec = Coursecompletedstatus::where('course_id',$course_id)->where('topic_id',$topic_id)->where('user_id',$user_id)->first();
        if($rec){
            return 'yes';
        }
        return 'no';
    }


    public static function completedpercentage($course_id){
        $user_id = Auth::id();
        $completedcount = Coursecompletedstatus::where('course_id',$course_id)->where('user_id',$user_id)->count();
        $coursecount = Coursetopic::where('course_id',$course_id)->where('parent_id',0)->where('status','active')->count();
        if($coursecount != 0 && $completedcount != 0){
           return ceil($completedcount * 100 / $coursecount);
        }
        return 0;
    }

}