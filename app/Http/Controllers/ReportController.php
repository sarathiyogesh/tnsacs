<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\Purchasecoursemeta;
use App\Models\Course;
use DB;
use App\Exports\InstitutionCourseExport;
use App\Exports\StudentCourseExport;
use App\Exports\PaymentExport;
use App\Exports\CourseExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    function __construct(){
        $this->middleware('permission:booking-report-view', ['only' => ['bookingreports']]);
        $this->middleware('permission:price-report-view', ['only' => ['pricereports']]);
        $this->middleware('permission:salesbyCustomer-report-view', ['only' => ['salesbycustomers']]);
        $this->middleware('permission:APIprice-report-view', ['only' => ['apibuyingprice']]);
    }

    public function institutioncourse(Request $request){
        $categories = Category::Active()->orderBy('cat_name', 'ASC')->select('cat_name', 'id')->get();
        $institutions = User::where('type', 'institution')->where('status', 'active')->orderBy('name', 'ASC')->select('name', 'id')->get();
        return view('reports.institution-course', compact('categories', 'institutions'));
    }

    public function institutioncourseget (Request $req){
        $input = $req->all();
        $records = Purchasecoursemeta::where('booking_status', 'completed')->where('purchase_type', 'institution');
        if($req->subscription_id){
            $records = $records->where('unique_id', $req->subscription_id);
        }

        if($req->date_from){
            $records = $records->where('purchase_date', '>=', date('Y-m-d', strtotime($req->date_from)));
        }

        if($req->date_to){
            $records = $records->where('purchase_date', '<=', date('Y-m-d', strtotime($req->date_to)));
        }

        if($req->category){
            $records = $records->where('category', $req->category);
        }

        if($req->institution){
            $records = $records->where('institution_id', $req->institution);
        }

        $records = $records->latest()->paginate(20);
        $html = view('reports.institution-course-table', compact('records'))->render();
        return response()->json(['status' => 'success', 'data' => $html]);
    }

    public function institutioncourseexcel (){
        return Excel::download(new InstitutionCourseExport, 'Institution Course.xlsx');
    }



    //Payment Report
    public function payment(Request $request){
        $students = User::where('type', 'student')->where('status', 'active')->orderBy('name', 'ASC')->select('name', 'id')->get();
        $institutions = User::where('type', 'institution')->where('status', 'active')->orderBy('name', 'ASC')->select('name', 'id')->get();
        return view('reports.payment', compact('institutions', 'students'));
    }

    public function paymentget (Request $req){
        $input = $req->all();
        $records = DB::table('purchase_course_meta as pcm')->where('pcm.booking_status', 'completed')->join('purchase_course as pc', 'pcm.purchase_course_id', '=', 'pc.id');
        if($req->subscription_id){
            $records = $records->where('pcm.unique_id', $req->subscription_id);
        }

        if($req->date_from){
            $records = $records->where('pcm.purchase_date', '>=', date('Y-m-d', strtotime($req->date_from)));
        }

        if($req->date_to){
            $records = $records->where('pcm.purchase_date', '<=', date('Y-m-d', strtotime($req->date_to)));
        }

        if($req->transaction_id){
            $records = $records->where('pc.pg_tracking_id', $req->transaction_id);
        }

        if($req->institution){
            $records = $records->where('pcm.institution_id', $req->institution);
        }

        if($req->student){
            $records = $records->where('pcm.user_id', $req->student);
        }

        $records = $records->latest()->select('pcm.unique_id', 'pcm.user_id', 'pcm.institution_id', 'pcm.start_date', 'pcm.end_date', 'pc.pg_tracking_id', 'pcm.purchase_date', 'pcm.total_amount', 'pcm.created_at', 'pcm.course_id')->paginate(20);
        $html = view('reports.payment-table', compact('records'))->render();
        return response()->json(['status' => 'success', 'data' => $html]);
    }

    public function paymentexcel (){
        return Excel::download(new PaymentExport, 'Payments.xlsx');
    }



    //Student Course Report
    public function studentcourse(Request $request){
        $categories = Category::Active()->orderBy('cat_name', 'ASC')->select('cat_name', 'id')->get();
        $students = User::where('type', 'student')->where('status', 'active')->orderBy('name', 'ASC')->select('name', 'id')->get();
        $institutions = User::where('type', 'institution')->where('status', 'active')->orderBy('name', 'ASC')->select('name', 'id')->get();
        return view('reports.student-course', compact('categories', 'institutions', 'students'));
    }

    public function studentcourseget (Request $req){
        $input = $req->all();
        $records = Purchasecoursemeta::where('booking_status', 'completed')->where('purchase_type', 'student');
        if($req->subscription_id){
            $records = $records->where('unique_id', $req->subscription_id);
        }

        if($req->date_from){
            $records = $records->where('purchase_date', '>=', date('Y-m-d', strtotime($req->date_from)));
        }

        if($req->date_to){
            $records = $records->where('purchase_date', '<=', date('Y-m-d', strtotime($req->date_to)));
        }

        if($req->category){
            $records = $records->where('category', $req->category);
        }

        if($req->institution){
            $records = $records->where('institution_id', $req->institution);
        }

        if($req->student){
            $records = $records->where('user_id', $req->student);
        }

        $records = $records->latest()->paginate(20);
        $html = view('reports.student-course-table', compact('records'))->render();
        return response()->json(['status' => 'success', 'data' => $html]);
    }

    public function studentcourseexcel (){
        return Excel::download(new StudentCourseExport, 'Student Course.xlsx');
    }



    //Course Report
    public function course(Request $request){
        $courses = Course::where('status', 'active')->orderBy('id', 'ASC')->select('course_name', 'id')->get();
        return view('reports.course', compact('courses'));
    }

    public function courseget (Request $req){
        $input = $req->all();
        $records = Purchasecoursemeta::where('booking_status', 'completed');
        if($req->course){
            $records = $records->where('course_id', $req->course);
        }

        if($req->date_from){
            $records = $records->where('purchase_date', '>=', date('Y-m-d', strtotime($req->date_from)));
        }

        if($req->date_to){
            $records = $records->where('purchase_date', '<=', date('Y-m-d', strtotime($req->date_to)));
        }

        $records = $records->latest()->paginate(20);
        $html = view('reports.course-table', compact('records'))->render();
        return response()->json(['status' => 'success', 'data' => $html]);
    }

    public function courseexcel (){
        return Excel::download(new CourseExport, 'Course.xlsx');
    }

}
