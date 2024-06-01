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

class PartnerController extends Controller
{
    function __construct(){
        $this->middleware('permission:partners-view|partners-add|partners-edit', ['only' => ['managepartner', 'viewpartner']]);
        $this->middleware('permission:partners-add', ['only' => ['addpartner', 'addpartnerpost']]);
        $this->middleware('permission:partners-edit', ['only' => [ 'editpartner', 'editpartnerpost']]);

        $this->middleware('permission:partner-offer-view|partner-offer-add|partner-offer-edit', ['only' => ['managepartneroffercode', 'viewpartneroffercode']]);
        $this->middleware('permission:partner-offer-add', ['only' => ['addpartneroffercode', 'addpartneroffercodepost']]);
        $this->middleware('permission:partner-offer-edit', ['only' => [ 'editpartneroffercode', 'editpartneroffercodepost']]);
    }

    public function addpartner(){
        return view('partners.create');
    }

    public function addpartnerpost(Request $req){
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

    public function managepartner(Request $req) {
        return view('partners.view');
    }

    public function viewpartner(Request $req){
        try{
            $search = $req->search;
            $records = Partneroffer::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('partners.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function editpartner($id){
        try{
            $partner = Partneroffer::find($id);
            if($partner){
                return view('partners.edit')->with('partner',$partner);
            }
        }catch(\Exception $e){
            return back();
        }
    }

    public function editpartnerpost(Request $req){
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


    public function addpartneroffercode(){
        $partners = Partneroffer::take(50)->get();
        return view('partners.offercode-create')->with(['partners'=>$partners]);
    }

    public function addpartneroffercodepost(Request $req){
        try{
            $input = $req->all();
            $rules = [
                "partner"=>"required",
                "offerCode"=>"required",
                "status"=>"required"
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $offerrec = Partneroffercode::where('offer_code',$input['offerCode'])->first();
            if($offerrec){
                return back()->with('error','Offer code already exist')->withInput();
            }
            if(!isset($input['cardType'])){
                $input['cardType'] = '';
            }
            if($req->has('isBulkCode') && $req->get('isBulkCode') == 'yes'){
                for($i=0; $i<$input['bulkCount']; $i++){
                    $offerCode = $this->generate_random_string(6);
                    $offerrec = Partneroffercode::where('offer_code',$offerCode)->first();
                    if(!$offerrec){
                        $insert = new Partneroffercode();
                        $insert->partner_id = $input['partner'];
                        $insert->offer_code = $offerCode;
                        $insert->bank_card_type = $input['cardType'];
                        $insert->status = $input['status'];
                        $insert->save();
                    }
                }
            }else{
                $insert = new Partneroffercode();
                $insert->partner_id = $input['partner'];
                $insert->offer_code = $input['offerCode'];
                $insert->bank_card_type = $input['cardType'];
                $insert->status = $input['status'];
                $insert->save();
            }
            return back()->with('success','New offer code created');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage().'__'.$e->getLine())->withInput();
        }
    }

    public function editpartneroffercode($id){
        try{
            $offerrec = Partneroffercode::find($id);
            if(!$offerrec){
                return back();
            }
            if($offerrec->status == 2){
                return back();
            }
            $partners = Partneroffer::take(50)->get();
            return view('partners.offercode-edit')->with(['partners'=>$partners,'offerrec'=>$offerrec]);
        }catch(\Exception $e){
            return back();
        }
    }

    public function managepartneroffercode(Request $req) {
        $partners = Partneroffer::take(50)->get();
        return view('partners.offercode-view')->with(['partners'=>$partners]);
    }

    public function viewpartneroffercode(Request $req){
        try{
            $records = Partneroffercode::where('id', '!=', '');

            // if($search){
            //     $records = $records->where('name', 'LIKE', '%'.$search.'%');
            // }

            if($req->has('partner') && $req->partner != ''){
                $records = $records->where('partner_id', $req->partner);
            }
            if($req->has('status') && $req->status != ''){
                $records = $records->where('status', $req->status);
            }
            $records = $records->paginate(10);
            $html = view('partners.viewoffercode-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function updatepartneroffercodepost(Request $req){
        try{
            $input = $req->all();
            $editId = $input['editId'];
            $rules = ["partner"=>"required","offerCode"=>"required","status"=>"required",];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $record = Partneroffercode::find($editId);
            if(!$record){
                return back();
            }
            if($record->status == 2){
                return back()->with('error','Offer code already used')->withInput();
            }
            $offerrec = Partneroffercode::where('offer_code',$input['offerCode'])->where('id','!=',$record->id)->first();
            if($offerrec){
                return back()->with('error','Offer code already exist')->withInput();
            }
            $record->partner_id = $input['partner'];
            $record->offer_code = $input['offerCode'];
            $record->status = $input['status'];
            $record->save();
            return back()->with('success','Offer code updated');
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage().'__'.$e->getLine())->withInput();
        }
    }

    public function importpartneroffercode(){
        $partners = Partneroffer::take(50)->get();
        return view('partners.offercode-import')->with(['partners'=>$partners]);
    }

    public function importpartneroffercodepost(Request $request){
        try{
            $input = $request->all();
            $rules = [
                //'offercode_file' => 'required|mimes:xlsx', 
                'partner' => 'required', 
                'status' => 'required'
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            if(!isset($input['cardType'])){
                $input['cardType'] = '';
            }
            if($request->hasFile('offercode_file')){
                $path = $request->file('offercode_file')->getRealPath();
                $data = Excel::toArray(new PartnerOfferCodeImport(), $path);
                array_shift($data[0]);
                if(!empty($data)){
                    set_time_limit(0);
                    foreach ($data[0] as $value) {
                        $offercode = isset($value[0])?$value[0]:'';
                        $cardtype = isset($value[1])?$value[1]:'';
                        if($offercode != ''){
                            $check = Partneroffercode::where('offer_code', $offercode)->first();
                            if(!$check){
                                $insertoffer = new Partneroffercode();
                                $insertoffer->offer_code = $offercode;
                                $insertoffer->bank_card_type = $cardtype;
                                $insertoffer->partner_id = $input['partner'];
                               // $insertoffer->bank_card_type = $input['cardType'];
                                $insertoffer->status = $input['status'];
                                $insertoffer->save();
                            }
                        }

                    }
                }
            }
            return back()->with('success', 'Offer Code imported successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage()."_".$e->getLine());
        }
        
    }

}
