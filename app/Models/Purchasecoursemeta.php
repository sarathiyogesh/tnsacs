<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Course;

class Purchasecoursemeta extends Model
{
    use HasFactory;

    protected $table = 'purchase_course_meta';

     public function scopeInstitute($query){
        if(Auth::User()->type == 'institution'){
            $institute_id = Auth::id(); 
        }else if(Auth::User()->type == 'faculty'){
            $institute_id = Auth::User()->institution;
        }else if(Auth::User()->type == 'coordinator'){
            $institute_id = Auth::User()->institution;
        }else{
            $institute_id = 0;
        }
       return $query->where('user_id',$institute_id);
    }

    public function scopeBookingstatus($query){
       return $query->where('booking_status','completed');
    }

    public static function getinstitutecourselist(){
       try{
            $purchase_course_id = Purchasecoursemeta::Institute()->Bookingstatus()->pluck('course_id')->toArray();
            $courses = Course::whereIn('id',$purchase_course_id)->take(500)->get();
            return $courses;
       }catch(\Exception $e){
            return [];
       }
    }

}
