<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Partneroffer;
use App\Models\Purchasecoursemeta;
use App\Models\Purchasecoursefaculty;

use App\Models\Category;
use App\Models\Coursenotes;
use App\Models\Subject;
use App\Models\Course;
use App\Models\Coursetopic;
use App\Models\Coursetopicfield;
use App\Models\Courseprice;
use App\Models\Sitelog;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PartnerOfferCodeImport;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;
use Auth;

class CoursesController extends Controller
{
    function __construct(){
       $this->middleware('permission:course-add', ['only' => ['addcoursespost','addcourses','addcoursetopic','getcoursetopictemplate','addcoursesubtopic','addcoursetopicfield','courseupdatedynamicfields','editcourses','getcoursesubtopictemplate','getcoursegettopicfieldtemplate','courseupdateparentfields']]);
       $this->middleware('permission:course-view', ['only' => ['managecourses', 'viewallcourses','viewcourse','courseoverview','viewcourses']]);
       $this->middleware('permission:course-edit', ['only' => [ 'editcourses','getcoursesubtopictemplate','getcoursegettopicfieldtemplate','courseupdateparentfields']]);
        $this->middleware('permission:course-price', ['only' => ['coursepricing','createpricing','courseaddprice','courseupdateprice','courseremoveprice','coursepricetemplate','viewcourseprice']]);
    }
    

    public function addcourses(){
        try{
            $category = Category::active()->take(500)->select('id','cat_name')->get();
            $subject = Subject::active()->take(500)->select('id','name')->get();
            return view('courses.create',compact('category','subject'));
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage());
        }
    }

    public function addcoursespost(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "courseName"=>"required|unique:course,course_name|max:500",
                "description"=>"required",
                "category"=>"required",
                "subject"=>"required",
                "courseImage"=>"required"
                //"status"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $courseImage = '';
            if($req->hasFile('courseImage')) {
                $destinationPath = 'uploads/'; // upload path
                $file = $req->file('courseImage');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $imgex = ['png','jpeg','jpg','webp'];
                if(!in_array($extension,$imgex)){
                    return back()->with('error','The Course Image must be a file of type: png, jpeg, jpg')->withInput();
                }
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $courseImage = $destinationPath.$fileName;
            }

            $insert = new Course();
            $insert->course_name = $input['courseName'];
            $insert->description = $input['description'];
            $insert->image = $courseImage;
            $insert->category = $input['category'];
            $insert->subject = $input['subject'];
            $insert->status = 'inactive';
            $insert->save();

            return back()->with('success','New course created');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage().'__'.$e->getLine())->withInput();
        }
    }

    public function managecourses(Request $req) {
        $category = Category::active()->take(500)->select('id','cat_name')->get();
        $subject = Subject::active()->take(500)->select('id','name')->get();
        return view('courses.view',compact('category','subject'));
    }

    public function addcoursenotes(Request $req,$id) {
        $purchase_course = Purchasecoursemeta::where('id',$id)->Bookingstatus()->first();
        if(!$purchase_course){
            return back();
        }
        if($purchase_course->end_date < date('Y-m-d')){
            return back()->with('error','Course expired');
        }
        $course = Course::find($purchase_course->course_id);
        return view('courses.notes',compact('course','purchase_course'));
    }

    public function coursenotelist(Request $req) {
      try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "purchase_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $course_id = $input['course_id'];
            $purchase_id = $input['purchase_id'];
            $purchase_course = Purchasecoursemeta::where('id',$purchase_id)->Bookingstatus()->first();
            if(!$purchase_course){
                return back();
            }
            if($purchase_course->end_date < date('Y-m-d')){
                return back()->with('error','Course expired');
            }
            $notelist = Coursenotes::where('course_id',$course_id)->take(200)->get();
            $template = view('courses.note_template')->with('notelist',$notelist)->render();
            return response()->json(['status'=>'success',"template"=>$template]);
      }catch(\Exception $e){
        return response()->json(['status'=>'error','msg'=>$e->getMessage().'_'.$e->getLine()]);
      }
    }

    public function viewinstitutioncourse(Request $req,$id) {
        $purchase_course = Purchasecoursemeta::where('id',$id)->Bookingstatus()->first();
        if(!$purchase_course){
            return back();
        }
        if($purchase_course->end_date < date('Y-m-d')){
            return back()->with('error','Course expired');
        }
        $parent_topic = Coursetopic::where('parent_id',0)->where('status','active')->where('course_id',$purchase_course->course_id)->get();
        $course = Course::find($purchase_course->course_id);
        $course_price = Courseprice::find($purchase_course->course_price_id);
        $faculties = User::where('type', 'faculty')->where('institution', $purchase_course->institution_id)->where('status', 'active')->select('name', 'id')->get();
        $selected_faculties = Purchasecoursefaculty::where('course_id', $purchase_course->course_id)->where('meta_id', $id)->pluck('faculty_id')->toArray();
        return view('courses.view-institution-course',compact('course','parent_topic','course_price','purchase_course', 'faculties', 'selected_faculties'));
    }

    public function purchasedcourselist(Request $req){
        try{
            $search = $req->search;
            $category = $req->category;
            $subject = $req->subject;
            $institution = $req->institution;
            $status = $req->has('status')?$req->status:'';
            $records = Purchasecoursemeta::Bookingstatus()->where('purchase_type', 'institution')->orderBy('id', 'ASC');
            if($search){
                $records = $records->where('course_name', 'LIKE', '%'.$search.'%');
            }
            if($subject){
                $records = $records->where('subject', $subject);
            }
            if($category){
                $records = $records->where('category', $category);
            }

            if($institution){
                $records = $records->where('user_id', $institution);
            }
            $records = $records->paginate(10);
            $html = view('courses.purchased-course-template', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    // public function viewinstitutioncourses(Request $req) {
    //     return view('courses.institution-view');
    // }

    public function viewinstitutioncourses(Request $req) {
        $category = Category::active()->take(500)->select('id','cat_name')->get();
        $subject = Subject::active()->take(500)->select('id','name')->get();
        $institutions = User::where('status', 'active')->where('type', 'institution')->get();
        return view('courses.institution-view',compact('category','subject', 'institutions'));
    }

    public function viewallcourses(Request $req) {
        $category = Category::active()->take(500)->select('id','cat_name')->get();
        $subject = Subject::active()->take(500)->select('id','name')->get();
        return view('courses.all-courses',compact('category','subject'));
    }

    public function viewallinstitutioncourses(Request $req) {
        return view('courses.institution-all-courses');
    }

    public function viewcourse(Request $req,$id) {
        $course = Course::find($id);
        if(!$course){
            return back();
        }
        $parent_topic = Coursetopic::where('parent_id',0)->where('status','active')->where('course_id',$id)->get();
        return view('courses.view-course',compact('course','parent_topic'));
    }

    public function courseoverview(Request $req) {
        return view('courses.course-overview');
    }

    public function mycart(Request $req) {
        return view('courses.my-cart');
    }

    public function coursepricing(Request $req) {
        $category = Category::active()->take(500)->select('id','cat_name')->get();
        $subject = Subject::active()->take(500)->select('id','name')->get();
        return view('courses.course-pricing',compact('category','subject'));
    }

    public function createpricing(Request $req,$id='') {
        $courses = Course::take(5000)->get();
        return view('courses.create-pricing',compact('courses','id'));
    }

    public function viewcourses(Request $req){
        try{
            $search = $req->search;
            $category = $req->category;
            $subject = $req->subject;
            $status = $req->status;
            $records = Course::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('course_name', 'LIKE', '%'.$search.'%');
            }
            if($subject){
                $records = $records->where('subject', $subject);
            }
            if($category){
                $records = $records->where('category', $category);
            }
            if($status){
                $records = $records->where('status', $status);
            }
            $records = $records->paginate(10);
            $html = view('courses.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function editcourses($id){
        try{
            $course = Course::find($id);
            if($course){
                $category = Category::active()->take(500)->select('id','cat_name')->get();
                $subject = Subject::active()->take(500)->select('id','name')->get();
                return view('courses.edit',compact('course','category','subject'));
            }
        }catch(\Exception $e){
            return back();
        }
    }

    public function editcoursespost(Request $req){
        try{
            $input = $req->all();
            $id = $input['edit_id'];
            $rules = [
                "courseName"=>"required|unique:course,course_name,".$id."|max:500",
                "description"=>"required",
                "category"=>"required",
                "subject"=>"required",
                //"status"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $courseImage = '';
            if($req->hasFile('courseImage')) {
                $destinationPath = 'uploads/'; // upload path
                $file = $req->file('courseImage');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $imgex = ['png','jpeg','jpg','webp'];
                if(!in_array($extension,$imgex)){
                    return back()->with('error','The Course Image must be a file of type: png, jpeg, jpg')->withInput();
                }
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $courseImage = $destinationPath.$fileName;
            }

            $update = Course::find($id);
            $update->course_name = $input['courseName'];
            $update->description = $input['description'];
            $update->category = $input['category'];
            $update->subject = $input['subject'];
            $update->status = $input['status'];
            
            if($courseImage){
                $update->image = $courseImage;
            }
            $update->save();

            return back()->with('success','Course updated');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage().'__'.$e->getLine())->withInput();
        }
    }

    public function addcoursetopic(Request $req){
        try{
            $input = $req->all();
            $id = $input['course_id'];
            $parent_id = $input['parent_id'];
            $rules = [
                "course_id"=>"required",
                "topic_name"=>"required|max:500"
                //"topic_desc"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            
            $insert = new Coursetopic();
            $insert->topic_name = $input['topic_name'];
            $insert->description = $input['topic_desc'];
            $insert->course_id = $id;
            $insert->parent_id = $parent_id;
            $insert->status = 'active';
            $insert->save();
            Sitelog::savelog('course','add','success','New topic created',$insert->id);
            
            return response()->json(['status'=>'success','msg'=>'Topic created']);
        }catch(\Exception $e){
            Sitelog::savelog('course','add','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function getcoursetopictemplate(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $parent_topics = Coursetopic::where('course_id',$course->id)->where('parent_id',0)->get();
            $template = view('courses.parent_topic_template')->with('course',$course)->with('parent_topics',$parent_topics)->render();
            return response()->json(['status'=>'success','template'=>$template]);
        }catch(\Exception $e){
            Sitelog::savelog('course','parenttemplate','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcoursesubtopic(Request $req){
        try{
            $input = $req->all();
            $id = $input['course_id'];
            $parent_id = $input['parent_id'];
            $rules = [
                "course_id"=>"required",
                "topic_name"=>"required|max:500"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            
            $insert = new Coursetopic();
            $insert->topic_name = $input['topic_name'];
            $insert->description = '';
            $insert->course_id = $id;
            $insert->parent_id = $parent_id;
            $insert->status = 'active';
            $insert->save();
            Sitelog::savelog('course','add','success','New sub topic created',$insert->id);
            return response()->json(['status'=>'success','msg'=>'Sub topic created']);
        }catch(\Exception $e){
            Sitelog::savelog('course','add','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function getcoursesubtopictemplate(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "topic_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $sub_topics = Coursetopic::where('course_id',$course->id)->where('parent_id',$topic_id)->get();
            $template = view('courses.sub_topic_template')->with('course',$course)->with('sub_topics',$sub_topics)->render();
            return response()->json(['status'=>'success','template'=>$template]);
        }catch(\Exception $e){
            Sitelog::savelog('course','subtopictemplate','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcoursetopicfield(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "field_title" => "required",
                "course_id"=>"required",
                "topic_id"=>"required",
                "field_type"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $field_type = $input['field_type'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $coursetopic = Coursetopic::find($topic_id);
            if(!$coursetopic){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            
            $insert = new Coursetopicfield();
            $insert->course_id = $input['course_id'];
            $insert->course_topic_id = $input['topic_id'];
            $insert->field_type = $input['field_type'];
            $insert->field_title = $input['field_title'];
            $insert->field_value = '';
            $insert->save();

            Sitelog::savelog('course','add','success','Topic field updated',$insert->id);
            return response()->json(['status'=>'success','msg'=>'Topic field added']);
        }catch(\Exception $e){
            Sitelog::savelog('course','add','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function getcoursegettopicfieldtemplate(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "topic_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $topic_fields = Coursetopicfield::where('course_id',$course->id)->where('course_topic_id',$topic_id)->get();
            $template = view('courses.topic_field_template')->with('course',$course)->with('topic_fields',$topic_fields)->with('topic_id',$topic_id)->render();
            return response()->json(['status'=>'success','template'=>$template]);
        }catch(\Exception $e){
            Sitelog::savelog('course','subtopictemplate','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function courseupdateparentfields(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "topic_id"=>"required",
                "topic_name"=>"required"
                //"description"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $coursetopic = Coursetopic::find($topic_id);
            if(!$coursetopic){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $coursetopic->topic_name = $input['topic_name'];
            $coursetopic->description = $input['description'];
            $coursetopic->save();
            Sitelog::savelog('course','update','success','Parent topic content updated',$coursetopic->id);
            return response()->json(['status'=>'success','msg'=>'Content updated']);
        }catch(\Exception $e){
            Sitelog::savelog('course','update','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function courseupdatedynamicfields(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "topic_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 3']);
            }
            $coursetopic = Coursetopic::find($topic_id);
            if(!$coursetopic){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 2']);
            }
            if(!is_array($input['dynamic_field'])){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 1']);
            }
            foreach($input['dynamic_field'] as $field){
                $id = str_replace("fv_", "",$field['name']);
                $updatefield = Coursetopicfield::find($id);
                if($updatefield){
                    $updatefield->field_value = $field['value'];
                    $updatefield->save();
                }
            }
            Sitelog::savelog('course','update','success','Sub topic content updated',$coursetopic->id);
            return response()->json(['status'=>'success','msg'=>'Content updated']);
        }catch(\Exception $e){
            Sitelog::savelog('course','update','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function courseaddprice(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "priceLabel"=>"required|max:500",
                "courseAmount"=>"required|numeric",
                "studentAmount"=>"required|numeric",
                "fromMonth"=>"required",
                "fromYear"=>"required",
                "toMonth"=>"required",
                "toYear"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 3']);
            }
            $exist = Courseprice::where('course_id',$id)->where('price_label',$input['priceLabel'])->where('status','!=','deleted')->first();
            if($exist){
                return response()->json(['status'=>'error','msg'=>'Price Label already exist']);
            }
            $from_date = strtotime($input['fromYear'].'-'.$input['fromMonth'].'-01');
            $to_date = strtotime($input['toYear'].'-'.$input['toMonth'].'-01');
            if($from_date >= $to_date){
                return response()->json(['status'=>'error','msg'=>'From date should be less than To date']);
            }

            $insert = new Courseprice();
            $insert->course_id = $id;
            $insert->price_label = $input['priceLabel'];
            $insert->amount = $input['courseAmount'];
            $insert->student_amount = $input['studentAmount'];
            $insert->from_month = $input['fromMonth'];
            $insert->from_year = $input['fromYear'];
            $insert->to_month = $input['toMonth'];
            $insert->to_year = $input['toYear'];
            $insert->save();

            Sitelog::savelog('course','update','success','Sub topic content updated',$insert->id);
            return response()->json(['status'=>'success','msg'=>'Content updated']);
        }catch(\Exception $e){
            Sitelog::savelog('course','update','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function courseupdateprice(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "price_id"=>"required",
                "priceLabel"=>"required|max:500",
                "courseAmount"=>"required|numeric",
                "studentAmount"=>"required|numeric",
                "fromMonth"=>"required",
                "fromYear"=>"required",
                "toMonth"=>"required",
                "toYear"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $price_id = $input['price_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 3']);
            }
            $courseprice = Courseprice::where('id',$price_id)->where('course_id',$id)->first();
            if(!$courseprice){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 5']);
            }

            $exist = Courseprice::where('course_id',$id)->where('price_label',$input['priceLabel'])->where('status','!=','deleted')->where('id','!=',$price_id)->first();
            if($exist){
                return response()->json(['status'=>'error','msg'=>'Price Label already exist']);
            }

            $from_date = strtotime($input['fromYear'].'-'.$input['fromMonth'].'-01');
            $to_date = strtotime($input['toYear'].'-'.$input['toMonth'].'-01');
            if($from_date >= $to_date){
                return response()->json(['status'=>'error','msg'=>'From date should be less than To date']);
            }
            $courseprice->price_label = $input['priceLabel'];
            $courseprice->amount = $input['courseAmount'];
            $courseprice->student_amount = $input['studentAmount'];
            $courseprice->from_month = $input['fromMonth'];
            $courseprice->from_year = $input['fromYear'];
            $courseprice->to_month = $input['toMonth'];
            $courseprice->to_year = $input['toYear'];
            $courseprice->save();

            Sitelog::savelog('course','update','success','Course price updated',$courseprice->id);
            return response()->json(['status'=>'success','msg'=>'Price updated']);
        }catch(\Exception $e){
            Sitelog::savelog('course','update','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function courseremoveprice(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "price_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $price_id = $input['price_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 3']);
            }
            $courseprice = Courseprice::where('id',$price_id)->where('course_id',$id)->first();
            if(!$courseprice){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again - 5']);
            }
            $courseprice->status = 'deleted';
            $courseprice->save();

            Sitelog::savelog('course','delete','success','Course price deleted',$courseprice->id);
            return response()->json(['status'=>'success','msg'=>'Price deleted']);
        }catch(\Exception $e){
            Sitelog::savelog('course','delete','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function coursepricetemplate(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $prices = Courseprice::where('course_id',$course->id)->where('status','!=','deleted')->get();
            $template = view('courses.price_template')->with('course',$course)->with('prices',$prices)->render();
            return response()->json(['status'=>'success','template'=>$template]);
        }catch(\Exception $e){
            Sitelog::savelog('course','subtopictemplate','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function viewcourseprice(Request $req){
        try{
            $search = $req->search;
            $category = $req->category;
            $subject = $req->subject;
            $status = $req->status;

            $records = DB::table('course_price as cp');
            if($search){
                $records = $records->where('course.course_name', 'LIKE', '%'.$search.'%');
            }
            if($subject){
                $records = $records->where('course.subject', $subject);
            }
            if($category){
                $records = $records->where('course.category', $category);
            }
            if($status){
                $records = $records->where('course.status', $status);
                $records = $records->where('cp.status','!=','deleted');
            }else{
                $records = $records->where('cp.status','!=','deleted');
            }
            $records = $records->join('course', 'course.id', '=', 'cp.course_id');
            $records = $records->orderBy('cp.id', 'ASC')->select('cp.*','course.category as category','course.subject as subject','course.course_name as course_name')->paginate(10);

            $html = view('courses.course-price-template', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function viewcourselisting(Request $req){
        try{
            $search = $req->search;
            $category = $req->category;
            $subject = $req->subject;
            $status = $req->status;
            $records = Course::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('course_name', 'LIKE', '%'.$search.'%');
            }
            if($subject){
                $records = $records->where('subject', $subject);
            }
            if($category){
                $records = $records->where('category', $category);
            }
            if($status){
                $records = $records->where('status', $status);
            }
            $records = $records->paginate(12);
            $html = view('courses.all-course-template', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }


    public function viewcoursetopictemplate(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "course_id"=>"required",
                "topic_id"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
            }
            $id = $input['course_id'];
            $topic_id = $input['topic_id'];
            $course = Course::find($id);
            if(!$course){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $topic = Coursetopic::find($topic_id);
            if(!$topic){
                return response()->json(['status'=>'error','msg'=>'Error. Please try again']);
            }
            $sub_topics = Coursetopic::where('course_id',$course->id)->where('parent_id',$topic_id)->get();
            $template = view('courses.view_topic_template')->with('course',$course)->with('sub_topics',$sub_topics)->with('topic',$topic)->render();
            return response()->json(['status'=>'success','template'=>$template]);
        }catch(\Exception $e){
            Sitelog::savelog('course','subtopictemplate','error',$e->getMessage().'__'.$e->getLine(),0);
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

}
