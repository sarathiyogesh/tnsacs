<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;

class InstitutionController extends Controller
{
    function __construct(){
        $this->middleware('permission:institution-view|institution-add|institution-edit', ['only' => ['manageinstitution', 'viewinstitution']]);
        $this->middleware('permission:institution-add', ['only' => ['addinstitution', 'addinstitutionpost']]);
        $this->middleware('permission:institution-edit', ['only' => [ 'editinstitution', 'editinstitutionpost']]);
    }

    public function addinstitution(){
        $states = State::orderBy('state', 'ASC')->get();
        return view('institution.create', compact('states'));
    }

    public function addinstitutionpost(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "name"=>"required",
                "code"=>"required|max:10",
                'password' => 'required|min:6|max:15',
                'confirm_password' => 'required|min:6|max:15|same:password',
                "email"=>"required|email|unique:users,email",
                "mobile"=>"required|integer|digits:10",
                "mobile2"=>"nullable|integer|digits:10",
                "logo" => 'required|mimes:png,gig,jpg,jpeg,webp',
                "contact_person_name"=>"required",
                "contact_person_mobile"=>"required",
                "status"=>"required",
                "address"=>"required",
                "state"=>"required",
                "city" => 'required',
                "pincode" => 'required'
            ];

            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $logo = NULL;
            if($req->hasFile('logo')) {
                $destinationPath = 'uploads/cms/'; // upload path
                $file = $req->file('logo');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $imgex = ['png','jpeg','jpg','webp'];
                if(!in_array($extension,$imgex)){
                    return back()->with('error','The logo must be a file of type: png, jpeg, jpg')->withInput();
                }
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $logo = $destinationPath.$fileName;
            }

            $input['logo'] = $logo;
            $input['type'] = 'institution';
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
            try{

                

                Mail::send("emails.institution_welcome",['user' => $user], function($message) use ($user){
                    $message->from(env('ADMIN_EMAIL'), env('ADMIN_NAME')) ;
                    $message->to($user->email, $user->name)->subject("Institution Account Created");
                });
            }catch(\Exception $e){
                //return back()->with('error', $e->getMessage());
            }

            return back()->with('success','New institution has been created');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function manageinstitution(Request $req) {
        return view('institution.view');
    }

    public function viewinstitution(Request $req){
        try{
            $search = $req->search;
            $records = User::orderBy('id', 'ASC')->where('type', 'institution');
            if($search){
                $records = $records->where(function($query) use ($search) {
                    $query->where('name', 'LIKE', '%'.$search.'%');
                    $query->orWhere('email', 'LIKE', '%'.$search.'%');
                    $query->orWhere('mobile', 'LIKE', '%'.$search.'%');
                });
            }
            $records = $records->paginate(10);
            $html = view('institution.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function editinstitution($id){
        try{
            $record = User::find($id);
            if($record){
                $states = State::orderBy('state', 'ASC')->get();
                return view('institution.edit', compact('states'))->with('record',$record);
            }
        }catch(\Exception $e){
            return back();
        }
    }

    public function editinstitutionpost(Request $req){
        try{
            $input = $req->all();
            $id = $input['editId'];
            $rules = [
                "name"=>"required",
                "code"=>"required|max:10",
                "email"=>"required|email|unique:users,email,".$id,
                "mobile"=>"required|integer|digits:10",
                "mobile2"=>"nullable|integer|digits:10",
                "logo" => 'nullable|mimes:png,gig,jpg,jpeg,webp',
                "contact_person_name"=>"required",
                "contact_person_mobile"=>"required|integer|digits:10",
                "status"=>"required",
                "address"=>"required",
                "state"=>"required",
                "city" => 'required',
                "pincode" => 'required'
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $user = User::find($input['editId']);
            $logo = $user->logo;
            if($req->hasFile('logo')) {
                $destinationPath = 'uploads/cms/'; // upload path
                $file = $req->file('logo');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $imgex = ['png','jpeg','jpg'];
                if(!in_array($extension,$imgex)){
                    return back()->with('error','The logo must be a file of type: png, jpeg, jpg')->withInput();
                }
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $logo = $destinationPath.$fileName;
            }

            $input['logo'] = $logo;
            $user_update = $user->update($input);
            
            return back()->with('success','Offer updated');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage().'__'.$e->getLine())->withInput();
        }
    }


}
