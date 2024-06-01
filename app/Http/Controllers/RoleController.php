<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;

class RoleController extends Controller
{
    function __construct(){
        $this->middleware('permission:role-view', ['only' => ['index']]);
        $this->middleware('permission:role-add', ['only' => ['create','store']]);
        $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.view');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::where('type', 'admin')->get();
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        try{
            $input = $req->all();
            $rules = [
                'name' => 'required|unique:roles,name',
                'permission' => 'required|array|min:1',
            ];
            $message = [ 'permission.required' => 'Please select minimum one permission.',
                'required' => 'this field is required.'];
            $validation = Validator::make($input, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }
            $role = Role::create(['name' => $input['name'], 'type' => 'admin', 'institution' => NULL]);
            $role->syncPermissions($input['permission']);
            return response()->json(['status' => 'success', 'msg' => 'New Role is created successfully.']);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Role::find($id);
        $permissions = Permission::where('type', 'admin')->get();
        $pivot = $record->permissions->pluck('pivot');
        $permitted = $pivot->pluck('permission_id')->toArray();
        return view('role.edit', compact('record', 'permissions', 'permitted'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        try{
            $input = $req->all();
            $rules = [
                'name' => 'required|unique:roles,name,'.$id,
                'permission' => 'required|array|min:1',
            ];
            $message = ['permission.required' => 'Please select minimum one permission.',
                        'required' => 'this field is required.' ];
            $validation = Validator::make($input, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }
            $role = Role::find($id);
            $role->name = $input['name'];
            $role->save();
            $role->syncPermissions($input['permission']);
            return response()->json(['status' => 'success', 'msg' => 'Updated successfully.']);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function roleview(Request $req){
        try{
            $search = $req->search;
            $records = Role::where('type', 'admin')->latest();
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(5);
            $html = view('role.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }

    }
}
