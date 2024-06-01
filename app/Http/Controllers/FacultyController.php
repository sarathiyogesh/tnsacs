<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;

class FacultyController extends Controller
{
    function __construct(){
        $this->middleware('permission:faculties-report', ['only' => ['managefaculty', 'viewfaculty']]);
    }
    
    public function managefaculty(Request $req) {
        $institutions = User::where('type', 'institution')->where('status', 'active')->orderBy('name')->get();
        return view('faculty.view', compact('institutions'));
    }

    public function viewfaculty(Request $req){
        try{
            $search = $req->search;
            $institution = $req->institution;
            $records = User::orderBy('id', 'ASC')->where('type', 'faculty');
            if($search){
                $records = $records->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%');
                    $query->orWhere('email', 'LIKE', '%'.$search.'%');
                    $query->orWhere('mobile', 'LIKE', '%'.$search.'%');
                });

            }
            if($institution){
                $records = $records->where('institution', $institution);
            }
            $records = $records->paginate(10);
            $html = view('faculty.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }


}
