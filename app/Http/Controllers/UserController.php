<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where('type', 'admin')->get();
        return view('users.create', compact('roles'));
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
                'email' => 'required|email|unique:users,email',
                'dob' => 'required|date',
                'role' => 'required',
                'department' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $pass = Str::random(8);
            $input['type'] = 'admin';
            $input['password'] = Hash::make($pass);
            $input['date_birth'] = date('Y-m-d', strtotime($input['dob']));
            $user = User::create($input);
            if($user){
                $user->assignRole($input['role']);
                // try{
                //     Mail::send("emails.user_welcome",['user' => $user, 'pass' => $pass], function($message) use ($input){
                //         $message->from(env('ADMIN_EMAIL') , env('ADMIN_NAME'));
                //         $message->to($input['email'], $input['name'])->subject("Registered successfully");
                //     });
                // }catch (Exception $e) {
                    
                // }

                return back()->with('success', 'New user is created successfully.');
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
        $record = User::find($id);
        $roles = Role::where('type', 'admin')->get();
        $role_assigned = [];
        if($record){
            $role_assigned = $record->roles->pluck('pivot')->pluck('role_id')->toArray();
        }
        return view('users.edit', compact('roles', 'record', 'role_assigned'));
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
                'email' => 'required|email|unique:users,email,'.$id,
                'dob' => 'required',
                'role' => 'required',
                'department' => 'required'
            ];
            $message = ['required' => 'this field is required.'];
            $validation = Validator::make($req->all(), $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $input['date_birth'] = date('Y-m-d', strtotime($input['dob']));
            $user = User::find($id);
            if($user){
                $user_update = $user->update($input);
            }
            if($user_update){
                DB::table('model_has_roles')->where('model_id',$user->id)->delete();
                $user->assignRole($input['role']);
                return back()->with('success', 'User details are updated successfully.');
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

    public function userview(Request $req){
        try{
            $search = $req->search;
            $records = User::orderBy('id', 'ASC')->where('type', 'admin');
            if($search){
                $records = $records->where(function($query) use ($search) {
                        $query->where('name', 'LIKE', '%'.$search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$search.'%');
                        $query->orWhere('designation', 'LIKE', '%'.$search.'%');
                        $query->orWhere('mobile', 'LIKE', '%'.$search.'%');
                    });
            }
            $records = $records->paginate(10);
            $html = view('users.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function onlineusers(){
        return view('users.onlineuser-view');
    }

    public function onlineuserview(Request $req){
        try{
            $search = $req->search;
            $records = User::orderBy('id', 'ASC')->where('type', 'online');
            if($search){
                $records = $records->where(function($query) use ($search) {
                        $query->where('name', 'LIKE', '%'.$search.'%');
                        $query->orWhere('email', 'LIKE', '%'.$search.'%');
                    });
            }
            $records = $records->paginate(10);
            $html = view('users.onlineuser-view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }
}
