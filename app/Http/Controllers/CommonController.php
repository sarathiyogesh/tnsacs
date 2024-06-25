<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Session;
use Mail;
use Validator;
use App\Models\User;
use App\Models\Modules;
use App\Models\Modulechapter;
use App\Models\Modulehistory;
use App\Models\Modulechapterhistory;

use App\Models\LaConfig;
use App\Models\Phonecode;
use App\Models\UserProfile;
use App\Models\Subscriber;
use App\Models\Contact;
use App\Models\Corporate;
use App\Models\Department;
use Spatie\Permission\Models\Role;
use App\Models\City;
use App\Models\Bulkqrcode;
use App\Models\Activity;
use App\Models\Ticketitem;
use App\Models\Ticketitemapioptions;
use App\Imports\BulkQrCodeImport;
use Hash;
use App\Exports\SubscriberExport;
use App\Exports\CorporateUsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Purchasecoursemeta;

class CommonController extends Controller
{    
    // function __construct(){
    //     $this->middleware('permission:bulkQR-view|bulkQR-add|bulkQR-edit', ['only' => ['bulkqrcodes', 'bulkqrcodesview']]);
    //     $this->middleware('permission:bulkQR-add', ['only' => ['addqrcodes', 'savebulkqrcodes']]);
    //     $this->middleware('permission:bulkQR-edit', ['only' => [ 'editqrcodes', 'updatebulkqrcodes']]);

    //     $this->middleware('permission:discount-organization-view|discount-organization-add|discount-organization-edit', ['only' => ['organization', 'organizationview']]);
    //     $this->middleware('permission:discount-organization-add', ['only' => ['saveorganization']]);
    //     $this->middleware('permission:discount-organization-edit', ['only' => [ 'editorganization', 'deleteorganization', 'restoreorganization']]);

    //     $this->middleware('permission:corporate-users-view', ['only' => ['corporateusers', 'corporateusersview']]);

    //     $this->middleware('permission:pro-users-view', ['only' => ['prousers', 'prousersview']]);

    //     $this->middleware('permission:pro-users-transactions-view', ['only' => ['protransactionhistory', 'protransactionhistoryview']]);

    //     $this->middleware('permission:contact-us-view', ['only' => ['contactmessages', 'contactmessagesview']]);

    //     $this->middleware('permission:subscribers-view', ['only' => ['subscribers', 'subscribersview']]);

    //     $this->middleware('permission:socialusers-view', ['only' => ['socialusers', 'socialusersview']]);
    // }

    public function testing(){
        return \Hash::make('qwertyuiop');
        Mail::raw('Hello, this is a test mail!', function ($message) {
            $message->to('sarathinnce@gmail.com')->subject('Test Mail');
        });
        return 'succcess';
    }

    public function samplepdf(){
        return $pdf = PDF::loadView('frontend.certificate_pdf',array('data'=>''))->setPaper('a4', 'landscape')->stream('sample.pdf');
    }
    
    public function dashboard(){
        return view('dashboard');
    }



    public function getdashboardinfo(){
        $data = [];
        $data['total_user'] = User::where('status','active')->where('type','online')->count();
        $data['total_module'] = Modules::where('status','active')->count();


        $chapter = Modulechapterhistory::select(DB::raw('COUNT(module_chapter_user_history.chapter_id) as chapter_count'),'chapter_id')
        ->groupBy('chapter_id')
        ->orderBy('chapter_count')
        ->take(5)
        ->get();
        
        $chapter_template = '';
        foreach($chapter as $chap){
            $name = Modulechapter::getname($chap->chapter_id);
            $visitor_count = Modulechapterhistory::where('chapter_id',$chap->chapter_id)->count();
            $completed_count = Modulechapterhistory::where('completed_status','yes')->where('chapter_id',$chap->chapter_id)->count();
            $chapter_template = $chapter_template.' <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <div class="dot-icon me-3"></div>
                              <span>'.$name.'</span>
                            </div>
                          </td>
                          <td align="center">'.$visitor_count.'</td>
                          <td align="center">'.$completed_count.'</td>
                        </tr>';
        }
        $data['chapter_perform_data'] = $chapter_template;

        $modules = Modules::where('status','active')->take(5)->get();
        $module_completion_template = '';
        foreach($modules as $mo){
            $total_module_c = Modulehistory::where('module_id',$mo->id)->where('completed_status','yes')->count();
            if($total_module_c != 0 && $data['total_module'] != 0){
                $percentage = ($total_module_c / $data['total_user']) * 100;
            }else{
                $percentage = 0;
            }
            $name = Modules::getmodulename($mo->id);
            $percentage = $percentage;
            $module_completion_template = $module_completion_template.' <div class="d-flex align-items-start mb-4">
                          <div class="dot-icon-two me-3"></div>
                          <div class="dot-icon-two-info">
                            <h3>'.$name.'</h3>
                            <h2>'.$percentage.'%</h2>
                          </div>
                        </div>';
        }
        $total_module_completed = Modulehistory::where('completed_status','yes')->groupBy('user_id','module_id')->count();
        if($data['total_user'] != 0 && $total_module_completed != 0){
            $data['overall_completion_percentage'] = ($total_module_completed / $data['total_user']) * 100;
        }else{
            $data['overall_completion_percentage'] = 0;
        }
        $data['module_completion'] = $module_completion_template;

        return response()->json(['status'=>'success','data'=>$data]);
    }

    public function custom_number_format($n, $precision = 2) {
        if ($n < 1000000) {
            // Anything less than a million
            $n_format = floatval(number_format($n, 2, '.', ''));
        } else if ($n < 1000000000) {
            // Anything less than a billion
            $n_format = floatval(number_format($n / 1000000, $precision, '.', '')) . 'M';
        } else {
            // At least a billion
            $n_format = floatval(number_format($n / 1000000000, $precision, '.', '')) . 'B';
        }
        return $n_format;
    }

    public function samplepage(){
        return view('sample');
    }

    public function login(){
        //return Hash::make('password');
        return view('login');
    }

    public function savelogin(Request $req){
        try{
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];
            $validation = Validator::make($req->all(), $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            if(Auth::attempt(['email' => $req->email, 'password' => $req->password, 'type' => 'admin', 'status' => 'active'])){

                return redirect(route('dashboard'));
            }
            return back()->with('error', 'Please check your credentials.');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function loginwithotp(Request $req){
        try{
            $rules = [
                'email' => 'required|email',
                'password' => 'required'
            ];
            $validation = Validator::make($req->all(), $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            if(Auth::attempt(['email' => $req->email, 'password' => $req->password, 'type' => 'admin', 'status' => 'active','email_otp'=>$req->otp])){
                return redirect('index');
            }
            return back()->with('error', 'Enter the valid otp')->with('loggedIn','yes')->withInput();
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect(route('logout'));
    }

    public function myprofile(){
        $phonecodes = Phonecode::where('status', 'active')->get();
        $record = Auth::user();
        $departments = Department::get();
        $roles = Role::where('type', 'admin')->get();
        $role_assigned = $record->roles->pluck('pivot')->pluck('role_id')->toArray();
        return view('myprofile', compact('phonecodes', 'record', 'departments', 'roles', 'role_assigned'));
    }

    public function savemyprofile(Request $req){
        try{
            $id = Auth::id();
            $input = $req->all();
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'mobile' => 'required',
                'date_birth' => 'required|date'
            ];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }

            $user = User::find($id);
            $input['date_birth'] = date('Y-m-d', strtotime($input['date_birth']));
            if($user){
                $update = $user->update($input);
            }
            return back()->with('success', 'Updated successfully.');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function configuration(){
        return view('configuration');
    }

    public function saveconfiguration(Request $req){
        $input = $req->input();
        array_shift($input);
        foreach ($input as $key => $value) {
            if ($key == "default_email") {
                $rules[$key] = 'required|email';
            } else {
                $rules[$key] = 'required';
            }
        }
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        foreach(['sidebar_search', 'show_messages', 'show_notifications', 'show_tasks', 'show_rightsidebar'] as $key) {
            if(!isset($input[$key])) {
                $input[$key] = 0;
            } else {
                $input[$key] = 1;
            }
        }
        foreach ($input as $key => $value) {
            LaConfig::updatevalue($key, $value);
        }
        return back()->withInput()->with('success', 'Updated successfully.');
    }

    public function changepassword(){
        return view('changepassword');
    }

    public function savechangepassword(Request $req){
        $input = $req->input();
        $rules = array('current_password' => 'required', 'new_password' => 'required|min:6|max:15', 'confirm_password' => 'required|min:6|max:15|same:new_password');
        $validation = Validator::make($input, $rules);
        if ($validation->fails()) {
            return back()->withErrors($validation)->withInput();
        } 
            $currentpassword = $input['current_password'];
            $currentpassword1 = Auth::user()->password;
            if (Hash::check($currentpassword, $currentpassword1)) {
                $update = User::find(Auth::user()->id);
                $newpassword = Hash::make($input['new_password']);
                $update->password = $newpassword;
                if ($update->save()) {
                    return back()->with('success', 'Password is changed successfully');
                }
            } else {
                return back()->with('error', 'Please check your Current Password');
            }
    }

    public function subscribers(){
        return view('subscribers');
    }

    public function subscribersview(Request $req){
        try{
            $search = $req->search;
            $records = Subscriber::latest();
            if($search){
                $records = $records->where('email', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('subscribers-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function contactmessages(){
        return view('contact-messages');
    }

    public function contactmessagesview(Request $req){
        try{
            $search = $req->search;
            $records = Contact::latest();
            if($search){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('name', 'LIKE', '%'.$search.'%')
                              ->orWhere('email', 'LIKE', '%'.$search.'%')
                              ->orWhere('message', 'LIKE', '%'.$search.'%');
                              });
            }
            $records = $records->paginate(10);
            $html = view('contact-messages-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function socialusers(){
        return view('common.social-users');
    }

    public function socialusersview(Request $req){
        try{
            $search = $req->search;
            $records = User::where('provider','!=','')->latest();
            if($search){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('name', 'LIKE', '%'.$search.'%')
                              ->orWhere('email', 'LIKE', '%'.$search.'%');
                              });
            }
            $records = $records->paginate(10);
            $html = view('common.social-users-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function subscriberexcel(){
        return Excel::download(new SubscriberExport, 'subscribers_report.xlsx');
    }

    public function organization(){
        $cities = City::orderBy('name', 'ASC')->get();
        return view('corporate.organization', compact('cities'));
    }

    public function organizationview(Request $req){
        try{
            $search = $req->search;
            
            $records = Corporate::withTrashed();
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->latest()->get();
            $ciphering_value = "AES-128-CTR";   
            $encryption_iv_value = '11121';
            $options = 0;  
            foreach($records as $rec){
                $encryption = $this->encrypt_decrypt('encrypt',$rec->id);
                $rec->activation_link = $encryption;
                $rec->location = City::getname($rec->location);
            }
            $html = view('corporate.organization-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'xxxxxxxxxxxxxxxxxxxxxxxx';
        $secret_iv = 'xxxxxxxxxxxxxxxxxxxxxxxxx';
        // hash
        $key = hash('sha256', $secret_key);    
        // iv - encrypt method AES-256-CBC expects 16 bytes 
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public function saveorganization(Request $req) {
        $input = $req->all();
        if($input['orgId']){
            $id = $input['orgId'];
            $rules = [
                'name' => 'required|unique:corporates,name,'.$id,
                'email' => 'required|unique:corporates,email,'.$id,
                'domain' => 'required|unique:corporates,domain,'.$id,
                'location' => 'required',
                'expiry' => 'required',
                'phone' => 'nullable'
            ];
        }else{
            $rules = [
                'name' => 'required|unique:corporates',
                'email' => 'required|unique:corporates',
                'domain' => 'required|unique:corporates',
                'location' => 'required',
                'expiry' => 'required',
                'phone' => 'nullable'
            ];
        }
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $input['expiry'] = date('Y-m-d', strtotime($input['expiry']));
        if($input['orgId']){
            $message = 'Corporate details has been updated successfully';
            $id = $input['orgId'];
            unset($input['orgId']);
            $create = Corporate::find($id)->update($input);
        }else{
            $message = 'New corporate details has been created successfully';
            unset($input['orgId']);
            $create = Corporate::create($input);
        }
        return response()->json(['status'=>'success', 'message' => $message]);
    }

    public function editorganization(Request $req){
        $id = $req->id;
        $record = Corporate::find($id);
        return response()->json(['status' => 'success', 'data' => $record]);
    }

    public function deleteorganization(Request $req) {
        try {
            $id = $req->id;
            Corporate::find($id)->delete();
            $org = Corporate::withTrashed()->find($id);
            return response()->json(['status' => 'success', 'data' => $org]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to delete organization']);
        }
        
    }

    public function restoreorganization(Request $input) {
        $data = $input->all();
        try {
            $org = Corporate::withTrashed()->find($data['id']);
            $org->deleted_at = null;
            $org->status = 1;
            $org->save();
            return response()->json(['status' => 'success', 'data' => $org]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to restore organization']);
        }
    }

    public function corporateusers(){
        return view('corporate.corporate-users');
    }

    public function corporateusersview(Request $req){
        try{
            $search = $req->search;
            $records = DB::table('users as u');
            if($search){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('u.name', 'LIKE', '%'.$search.'%')
                              ->orWhere('u.email', 'LIKE', '%'.$search.'%');
                              });
            }
            $records = $records->leftJoin('corporates as c', 'u.ca_org_id', '=', 'c.id')
                ->where('u.ca_status', 1)
                ->whereDate('u.ca_expiry', '>=', Date('Y-m-d'))
                ->select('u.name', 'u.ca_email', 'u.ca_expiry', 'u.ca_status', 'c.name as org_name', 'c.domain', 'c.status as org_status', 'c.expiry as org_expiry', 'u.email')->orderBy('u.id','DESC')
                ->paginate(10);

            $html = view('corporate.corporate-users-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function corporateusersexcel(){
        return Excel::download(new CorporateUsersExport, 'corporateusers_report.xlsx');
    }

    public function prousers(){
        return view('corporate.pro-users');
    }

    public function prousersview(Request $req){
        try{
            $search = $req->search;
            $records = DB::table('users as u');
            if($search){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('u.name', 'LIKE', '%'.$search.'%')
                              ->orWhere('u.email', 'LIKE', '%'.$search.'%');
                              });
            }
            $records = $records->where('u.pro_status', 'yes')
                ->select('u.name', 'u.email','u.pro_email', 'u.pro_mobile', 'u.pro_plan_enddate', 'u.pro_plan_startdate', 'u.pro_plan_desc', 'u.pro_plan')->orderBy('u.id','DESC')
                ->paginate(10);

            $html = view('corporate.pro-users-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function protransactionhistory(){
        return view('corporate.pro-transactions');
    }

    public function protransactionhistoryview(Request $req){
        try{
            $search = $req->search;
            $records = DB::table('pro_transaction as pt')->leftJoin('users as u', 'u.id', '=', 'pt.user_id');
            if($search){
                $records = $records->where(function ($query) use ($search) {
                              $query->where('u.name', 'LIKE', '%'.$search.'%')
                              ->orWhere('u.email', 'LIKE', '%'.$search.'%');
                              });
            }
            $records = $records->where('pt.status', 'completed')
                ->select('pt.user_id', 'pt.transaction_id','pt.res_amount','pt.unique_id', 'u.pro_plan_enddate', 'u.name', 'u.email', 'u.pro_plan_desc')->orderBy('pt.id','DESC')
                ->paginate(10);
            $html = view('corporate.pro-transactions-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function bulkqrcodes(){
        return view('common.bulk-qr-codes');
    }

    public function bulkqrcodesview(Request $req){
        try{
            $search = $req->search;
            $records = Bulkqrcode::where('status', 'active');
            if($search){
                $records = $records->where('option_id', 'LIKE', '%'.$search.'%');
            }
            $records = $records->select('option_id','activity_id')->groupBy('option_id', 'activity_id', 'id')->orderBy('id','DESC')
                ->paginate(25);
            $html = view('common.bulk-qr-codes-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

     public function optionqrcodes($optionId){
        $record = Bulkqrcode::where('option_id', $optionId)->where('status', 'active')->first();
        $activity_name = '';
        if($record){
            $activity_name = Activity::getactivityname($record->activity_id);
        }
        return view('common.bulk-qr-code-option', compact('optionId', 'activity_name'));
    }

    public function optionqrcodesview(Request $req){
        try{
            $search = $req->search;
            $status = $req->status;
            $optionId = $req->optionId;
            
            $records = Bulkqrcode::where('option_id', $optionId)->where('status', 'active');
            if($status == 'expired'){
                $records = $records->where('qr_status', 'pending')->where('expiry_date', '<', date('Y-m-d'));
            }else if($status == 'pending'){
                $records = $records->where('qr_status', 'pending')->where('expiry_date', '>=', date('Y-m-d'));
            }else if($status == 'used'){
                $records = $records->where('qr_status', 'used');
            }
            if($search){
                $records = $records->where('qr_code', 'LIKE', '%'.$search.'%');
            }
            $records = $records->latest()->paginate(20);
            $html = view('common.bulk-qr-code-option-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addqrcodes(){
        $activities = Activity::select('activity_id','activity_name')->orderBy('activity_name', 'ASC')->get();
        return view('common.bulk-qr-code-add', compact('activities'));
    }

    public function savebulkqrcodes(Request $request)
    {
        try{
            $input = $request->all();
            $rules = ['qr_code' => 'required|unique:bulk_qr_codes,qr_code', 'activity_id' => 'required', 'item_id' => 'required', 'option_id' => 'required', 'status' => 'required', 'expiry_date' => 'required|date'];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $expiry_date = date('Y-m-d', strtotime($input['expiry_date']));
            $insert = new Bulkqrcode();
            $insert->qr_code = $input['qr_code'];
            $insert->activity_id = $input['activity_id'];
            $insert->item_id = $input['item_id'];
            $insert->option_id = $input['option_id'];
            $insert->status = $input['status'];
            $insert->qr_status = 'pending';
            $insert->expiry_date = $expiry_date;
            $insert->save();
            return back()->with('success', 'QR Code added successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage()."_".$e->getLine());
        }
    }

    public function getactivityitems(Request $request){
        $id = $request->id;
        $records = Ticketitem::where('activityId', $id)->orderBy('id')->get();
        $html = '';
        foreach($records as $record){
            if($record->id && $record->item_name){
                $html .= '<option value="'.$record->id.'">'.$record->item_name.'</option>';
            }
        }
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function getitemoptions(Request $request){
        $id = $request->id;
        $records = Ticketitemapioptions::where('ticket_item_id', $id)->orderBy('id')->get();
        $html = '';
        foreach($records as $record){
            if($record->api_tourOptionId){
                $html .= '<option value="'.$record->api_tourOptionId.'">'.$record->api_tourOptionId.'</option>';
            }
        }
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function editqrcodes($id)
    {
        $activities = Activity::select('activity_id','activity_name')->get();
        $record = Bulkqrcode::find($id);
        $items = Ticketitem::where('activityId', $record->activity_id)->orderBy('id')->get();
        $options = Ticketitemapioptions::where('ticket_item_id', $record->item_id)->orderBy('id')->get();
        
        return view('common.bulk-qr-code-edit', compact('activities', 'record', 'items', 'options'));
    }

    public function updatebulkqrcodes(Request $request, $id)
    {
        try{
            $input = $request->all();
            $rules = ['qr_code' => 'required|unique:bulk_qr_codes,qr_code,'.$id, 'activity_id' => 'required', 'item_id' => 'required', 'option_id' => 'required', 'status' => 'required', 'expiry_date' => 'required|date'];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return $validation->messages();
                return back()->withErrors($validation)->withInput();
            }
            $expiry_date = date('Y-m-d', strtotime($input['expiry_date']));
            $insert = Bulkqrcode::find($id);
            $insert->qr_code = $input['qr_code'];
            $insert->activity_id = $input['activity_id'];
            $insert->item_id = $input['item_id'];
            $insert->option_id = $input['option_id'];
            $insert->status = $input['status'];
            $insert->expiry_date = $expiry_date;
            $insert->save();
            return back()->with('success', 'QR Code updated successfully');
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage()."_".$e->getLine());
        }
    }

    public function importqrcodes()
    {
        $activities = Activity::select('activity_id','activity_name')->get();
        return view('common.bulk-qr-code-import', compact('activities'));
    }

    public function saveimportqrcodes(Request $req){
        try{
            $input = $req->all();
            $rules = ['qrcode_file' => 'required|mimes:xlsx', 'activity_id' => 'required', 'item_id' => 'required', 'option_id' => 'required', 'status' => 'required', 'expiry_date' => 'required|date'];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $expiry_date = date('Y-m-d', strtotime($input['expiry_date']));
            if ($req->hasFile('qrcode_file')) {
                $file = $req->file('qrcode_file');
                $destinationPath = 'uploads/qrcodes/';
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                if($extension == 'xls' || $extension == 'xlsx'){
                    //check if name exist
                    $tmp_name = $filename;
                    if ($pos = strrpos($filename, '.')) {
                        $name = substr($filename, 0, $pos);
                        $ext = substr($filename, $pos);
                    } else {
                        $name = $filename;
                    }
                    $uniq_no = 0;
                    $file_exists = public_path($destinationPath . $filename);
                    while (file_exists($file_exists)) {
                        $tmp_name = $name .'_'. $uniq_no . $ext;
                        $uniq_no++;
                        $file_exists = public_path($destinationPath . $tmp_name);
                    }
                    $upload_success = $file->move($destinationPath, $tmp_name);
                    $img_url = $destinationPath . $tmp_name;
                    $fileUrl = asset($img_url);
                    $path = public_path()."/".$img_url;
                    $import = new BulkQrCodeImport($input, $expiry_date);
                    $result = Excel::import($import, $path);
                    return back()->with($import->count.' success','QR code details imported successfully');
                }else{
                    return back()->with('error','Upload valid file');
                }
            }else{
                return back()->with('error','Upload file');
            }
        }catch(\Exception $e){
            return back()->with('error',$e->getMessage().'__'.$e->getLine());
        }
    }


}
