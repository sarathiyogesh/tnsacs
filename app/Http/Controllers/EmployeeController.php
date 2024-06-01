<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;


class EmployeeController extends Controller
{

   function __construct(){
        $this->middleware('permission:employee-view|employee-add|employee-edit', ['only' => ['index']]);
        $this->middleware('permission:employee-add', ['only' => ['create','store']]);
        $this->middleware('permission:employee-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('employees.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::get();
        $roles = Role::get();
        return view('employees.create', compact('departments', 'roles'));
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
                'designation' => 'required',
                'mobile' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:employees,email',
                'dob' => 'required',
                'role' => 'required',
                'dept' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $pass = Str::random(8);
            $input['password'] = Hash::make($pass);
            $input['date_birth'] = date('Y-m-d', strtotime($input['dob']));
            $employee = Employee::create($input);
            if($employee){
                $input['context_id'] = $employee->id;
                $user = User::create($input);
            }
            if($user){
                $user->assignRole($input['role']);
                try{
                    Mail::send("emails.employee_welcome",['user' => $employee, 'pass' => $pass], function($message) use ($input){
                        $message->from("sangeethapbce@gmail.com" , env('APP_NAME'));
                        $message->to($input['email'], $input['name'])->subject("Registered successfully");
                    });
                }catch (Exception $e) {
                    
                }

                return back()->with('success', 'New Employee is created successfully.');
            }

            return back()->with('error', 'Please try again.');
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
        $record = Employee::find($id);
        $departments = Department::get();
        $roles = Role::get();
        $user = User::where('context_id', $id)->first();
        $role_assigned = [];
        if($user){
            $role_assigned = $user->roles->pluck('pivot')->pluck('role_id')->toArray();
        }
        return view('employees.edit', compact('departments', 'roles', 'record', 'role_assigned'));
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
                'designation' => 'required',
                'mobile' => 'required',
                'gender' => 'required',
                'email' => 'required|email|unique:employees,email,'.$id,
                'dob' => 'required',
                'role' => 'required',
                'dept' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $input['date_birth'] = date('Y-m-d', strtotime($input['dob']));
            $employee = Employee::find($id);
            if($employee){
                $employee_update = $employee->update($input);
            }
            if($employee_update){
                $user = User::where('context_id', $id)->first();
                $user->update($input);
                DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                $user->assignRole($input['role']);
                return back()->with('success', 'Employee details are updated successfully.');
            }

            return back()->with('error', 'Please try again.');
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

    public function employeeview(Request $req){
        try{
            $search = $req->search;
            $records = Employee::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('employees.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }
}
