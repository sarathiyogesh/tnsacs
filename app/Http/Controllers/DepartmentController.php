<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use DB;
use Mail;
use Str;


class DepartmentController extends Controller
{

    function __construct(){
        $this->middleware('permission:department-view|department-add|department-edit', ['only' => ['index']]);
        $this->middleware('permission:department-add', ['only' => ['create','store']]);
        $this->middleware('permission:department-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departments.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        try{
           $input = $req->all();
            $rules = [
                'name' => 'required',
                'code' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $department = Department::create($input);
            return back()->with('success', 'New department is created successfully.');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Department::find($id);
        return view('departments.edit', compact('record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        try{
            $input = $req->all();
            $rules = [
                'name' => 'required',
                'code' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $department = Department::find($id);
            if($department){
                $department_update = $department->update($input);
            }
            return back()->with('success', 'User details are updated successfully.');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function departmentview(Request $req){
        try{
            $search = $req->search;
            $records = Department::orderBy('id', 'ASC');
            if($search){
                $records = $records->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%');
                    $query->orWhere('code', 'LIKE', '%'.$search.'%');
                });
            }
            $records = $records->paginate(10);
            $html = view('departments.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }
}
