<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Partneroffer;
use App\Models\Partnerofferplan;
use App\Models\Partneroffercode;
use App\Models\Partneroffercodemeta;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PartnerOfferCodeImport;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;

class NotesController extends Controller
{
    function __construct(){
        $this->middleware('permission:partners-view|partners-add|partners-edit', ['only' => ['managenotes', 'viewnotes']]);
        $this->middleware('permission:partners-add', ['only' => ['addnotes', 'addnotespost']]);
        $this->middleware('permission:partners-edit', ['only' => [ 'editnotes', 'editnotespost']]);

        $this->middleware('permission:partner-offer-view|partner-offer-add|partner-offer-edit', ['only' => ['managenotesoffercode', 'viewnotesoffercode']]);
        $this->middleware('permission:partner-offer-add', ['only' => ['addnotesoffercode', 'addnotesoffercodepost']]);
        $this->middleware('permission:partner-offer-edit', ['only' => [ 'editnotesoffercode', 'editnotesoffercodepost']]);
    }

    public function addnotes(){
        return view('notes.create');
    }

    public function addnotespost(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "partnerName"=>"required",
                "offerName"=>"required",
                "offerMessage"=>"required",
                "logo"=>"required",
                "offerType"=>"required",
                "firstLength"=>"required",
                "lastLength"=>"required",
                "status"=>"required",
                "plan"=>"required",
                "usedType"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $logo = '';
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

            if(count($input['plan']) == 0){
                return back()->with('error','Plan required')->withInput();
            }

            $insert = new Partneroffer();
            $insert->partner_name = $input['partnerName'];
            $insert->offer_name = $input['offerName'];
            $insert->offer_message = $input['offerMessage'];
            $insert->partner_logo = $logo;
            $insert->offer_type = $input['offerType'];
            $insert->used_type = $input['usedType'];
            $insert->first_len = $input['firstLength'];
            $insert->last_len = $input['lastLength'];
            $insert->status = $input['status'];
            $insert->save();

            foreach($input['plan'] as $plan){
                $insertplan = new Partnerofferplan();
                $insertplan->plan = $plan;
                $insertplan->partner_offer_id = $insert->id;
                $insertplan->save();
            }

            return back()->with('success','New offer created');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function managenotes(Request $req) {
        return view('notes.view');
    }

    public function viewnotes(Request $req){
        try{
            $search = $req->search;
            $records = Partneroffer::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('notes.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function editnotes($id){
        try{
            $partner = Partneroffer::find($id);
            if($partner){
                return view('notes.edit')->with('partner',$partner);
            }
        }catch(\Exception $e){
            return back();
        }
    }

    public function editnotespost(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "partnerName"=>"required",
                "offerName"=>"required",
                "offerMessage"=>"required",
                "offerType"=>"required",
                "firstLength"=>"required",
                "lastLength"=>"required",
                "status"=>"required",
                "plan"=>"required",
                "usedType"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            if(count($input['plan']) == 0){
                return back()->with('error','Plan required')->withInput();
            }
            $partner = Partneroffer::find($input['editId']);
            $logo = $partner->partner_logo;
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

            $partner->partner_name = $input['partnerName'];
            $partner->offer_name = $input['offerName'];
            $partner->offer_message = $input['offerMessage'];
            $partner->partner_logo = $logo;
            $partner->offer_type = $input['offerType'];
            $partner->used_type = $input['usedType'];
            $partner->first_len = $input['firstLength'];
            $partner->last_len = $input['lastLength'];
            $partner->status = $input['status'];
            $partner->save();

            Partnerofferplan::where('partner_offer_id', $partner->id)->delete();
            foreach($input['plan'] as $plan){
                $insertplan = new Partnerofferplan();
                $insertplan->plan = $plan;
                $insertplan->partner_offer_id = $partner->id;
                $insertplan->save();
            }
            
            return back()->with('success','Offer updated');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage().'__'.$e->getLine())->withInput();
        }
    }


}
