<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;
use DB;
use App\Models\Activity;
use Validator;
use Auth;

class CouponController extends Controller
{
   function __construct()
    {
        $this->middleware('permission:coupon-view|coupon-add|coupon-edit', ['only' => ['index', 'getcoupon']]);
        $this->middleware('permission:coupon-add', ['only' => ['create', 'store']]);
        $this->middleware('permission:coupon-edit', ['only' => ['edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('coupons.view');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activities = Activity::select('activity_id','activity_name')->get();
        return view('coupons.create', compact('activities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $req)
    {
        try{
            $input = $req->all();
            
            $rules=[
                'activity.*' => 'required_if:applied_to,single',
                'coupon_type.*' => 'required_if:applied_to,single',
                "coupon_type"=>'required_if:applied_to,all',
                "coupon_value.*"=>'required_if:applied_to,all',
                "couponname"=>"required",
                "couponcode"=>"required",
                "startdate"=>"required|date",
                "enddate"=>"required|date",
                "minimumamount" => "required|numeric",
                "status" => 'required'
            ];
            $messages = [
                'activity.*.required_if' => 'Activity field should not be empty',
                'coupon_type.*.required_if' => 'Coupon type should not be empty',
                'coupon_value.*.required_if' => 'Coupon value is required',
                'required' => 'this field is required'
            ];

            $validation=Validator::make($input,$rules, $messages);
            if($validation->fails()){
                return response()->json(['status'=>'validation','message'=>$validation->messages()]);
            }

            $items = [];
            foreach($input['activity'] as $key => $file)
            {
                $items[$key]['activity'] = $file;
                $items[$key]['coupon_type'] = $input['coupon_type'][$key];
                $items[$key]['coupon_value'] = $input['coupon_value'][$key];;
            }

            //return $input['applied_to'];
            if($input['applied_to'] == 'single'){
                $addedItems = [];
                foreach($items as $item){
                    $activity = Activity::find($item['activity']);
                    $activity_name = '';
                    if($activity){
                        $activity_name = $activity->activity_name;
                    }

                    if($item['coupon_type'] == 'amount' || $item['coupon_type'] == 'percentage'){
                        $value = $item['coupon_value'];
                        if(!$value){
                            return response()->json(['status' => 'validation', 'validation' => 'Coupon value should not be empty']);
                        }
                        if(!is_numeric($value)){
                            return response()->json(['status' => 'validation', 'validation' => 'Coupon value should be numeric']);
                        }
                    }

                    $check = Coupon::where('couponcode', $input['couponcode'])->where('activity_id', $item['activity'])->first();
                    if($check){
                        return response()->json(['status' => 'validation', 'validation' => 'Coupon code ('.$input["couponcode"].') alreay available for experience ('.$activity_name.')']);
                    }

                    if(!in_array($item['activity'], $addedItems)){
                        array_push($addedItems, $item['activity']);
                    }else{
                        return response()->json(['status' => 'validation', 'validation' => 'You selected activity ('.$activity_name.') for more than one time.']);
                    }

                }
                foreach($items as $item){
                    $insert=new Coupon();
                    $insert->couponname=$input['couponname'];
                    $insert->couponcode=$input['couponcode'];
                    $insert->coupontype=$item['coupon_type'];
                    if($input['startdate']!=''){
                        $insert->startdate=date('Y-m-d',strtotime($input['startdate']));
                    }else{
                        $insert->startdate='';
                    }
                    if($input['enddate']!=''){
                        $insert->enddate=date('Y-m-d',strtotime($input['enddate']));
                    }else{
                        $insert->enddate='';
                    }
                    $insert->minimumamount = $input['minimumamount'];
                    $insert->userid = Auth::User()->id;
                    $insert->totalcoupon=$input['totalcoupon'];
                    $insert->usespercustomer=$input['usespercustomer'];
                    $insert->status=$input['status'];
                    $insert->applied_to='single';
                    if($item['coupon_type'] == 'percentage'){
                        $insert->couponpercentage=$item['coupon_value'];
                    }else if($item['coupon_type'] == 'amount'){
                        $insert->couponamount = $item['coupon_value'];
                    }
                    $insert->activity_id=$item['activity'];
                    $insert->save();
                }
            }else if($input['applied_to'] == 'all'){
                $check = Coupon::where('couponcode', $input['couponcode'])->first();
                if($check){
                    return response()->json(['status' => 'validation', 'validation' => 'Coupon code ('.$input["couponcode"].') alreay available']);
                }
                //return 'yess';
                $insert=new Coupon();
                $insert->couponname=$input['couponname'];
                $insert->couponcode=$input['couponcode'];
                $insert->coupontype=$input['coupon_type'][0];
                if($input['startdate']!=''){
                    $insert->startdate=date('Y-m-d',strtotime($input['startdate']));
                }else{
                    $insert->startdate='';
                }
                if($input['enddate']!=''){
                    $insert->enddate=date('Y-m-d',strtotime($input['enddate']));
                }else{
                    $insert->enddate='';
                }
                $insert->minimumamount = $input['minimumamount'];
                $insert->userid = Auth::User()->id;
                $insert->totalcoupon=$input['totalcoupon'];
                $insert->usespercustomer=$input['usespercustomer'];
                $insert->status=$input['status'];
                $insert->applied_to='all';
                if($input['coupon_type'][0] == 'percentage'){
                    $insert->couponpercentage=$input['coupon_value'][0];
                }else if($input['coupon_type'][0] == 'amount'){
                    $insert->couponamount = $input['coupon_value'][0];
                }
                // $insert->activity_id='';
                $insert->save();
            }
            return response()->json(['status' => 'success', 'message' => 'New Coupon is created successfully.']);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage().'__'.$e->getLine()]);
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
    public function edit($couponcode)
    {
        $items = [];
        $record = Coupon::where('couponcode',$couponcode)->where('status', '!=', 'deleted')->first();
        if($record){
            $getItems = Coupon::where('couponcode', $couponcode)->where('status', '!=', 'deleted')->orderBy('id')->get();
            $i = 0;
            foreach($getItems as $item){
                $items[$i]['activity'] = (string)$item->activity_id;
                $items[$i]['coupon_type'] = $item->coupontype;
                $coupon_value = '';
                if($item->coupontype == 'amount'){
                    $coupon_value = $item->couponamount;
                }else if($item->coupontype == 'percentage'){
                    $coupon_value = $item->couponpercentage;
                }
                $items[$i]['coupon_value'] = $coupon_value;
                $i++;
            }
            $activities = Activity::select('activity_id','activity_name')->get();
            return view('coupons.edit', compact('items', 'record', 'activities'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        try{
            $input = $req->all();
            $couponcode = $input['id'];
            $id = $input['t_id'];
             $rules=[
                'activity.*' => 'required_if:applied_to,single',
                'coupon_type.*' => 'required_if:applied_to,single',
                "coupon_type"=>'required_if:applied_to,all',
                "coupon_value.*"=>'required_if:applied_to,all',
                "couponname"=>"required",
                "couponcode"=>"required",
                "startdate"=>"required|date",
                "enddate"=>"required|date",
                "minimumamount" => "required|numeric",
                "status" => 'required'
            ];
            $messages = [
                'activity.*.required_if' => 'Activity field should not be empty',
                'coupon_type.*.required_if' => 'Coupon type should not be empty',
                'coupon_value.*.required_if' => 'Coupon value is required',
                'required' => 'this field is required'
            ];
            $validation=Validator::make($input,$rules, $messages);
            if($validation->fails()){
                return response()->json(['status'=>'validation','message'=>$validation->messages()]);
            }
            $items = [];
            foreach($input['activity'] as $key => $file)
            {
                $items[$key]['activity'] = $file;
                $items[$key]['coupon_type'] = $input['coupon_type'][$key];
                $items[$key]['coupon_value'] = $input['coupon_value'][$key];;
            }

            if($input['applied_to'] == 'single'){
                $addedItems = [];
                foreach($items as $item){
                    
                    $activity = Activity::find($item['activity']);
                    $activity_name = '';
                    if($activity){
                        $activity_name = $activity->activity_name;
                    }
                    if($item['coupon_type'] == 'amount' || $item['coupon_type'] == 'percentage'){
                        $value = $item['coupon_value'];
                        if(!$value){
                            return response()->json(['status' => 'validation', 'validation' => 'Coupon value should not be empty']);
                        }
                        if(!is_numeric($value)){
                            return response()->json(['status' => 'validation', 'validation' => 'Coupon value should be numeric']);
                        }
                    }

                    if(!in_array($item['activity'], $addedItems)){
                        array_push($addedItems, $item['activity']);
                    }else{
                        return response()->json(['status' => 'error', 'message' => 'You selected activity ('.$activity_name.') for more than one time.']);
                    }
                }
                $einfo = Coupon::where('couponcode',$couponcode)->delete();

                foreach($items as $item){
                    $insert=new Coupon();
                    $insert->couponname=$input['couponname'];
                    $insert->couponcode=$input['couponcode'];
                    $insert->coupontype=$item['coupon_type'];
                    if($input['startdate']!=''){
                        $insert->startdate=date('Y-m-d',strtotime($input['startdate']));
                    }else{
                        $insert->startdate='';
                    }
                    if($input['enddate']!=''){
                        $insert->enddate=date('Y-m-d',strtotime($input['enddate']));
                    }else{
                        $insert->enddate='';
                    }
                    $insert->minimumamount = $input['minimumamount'];
                    $insert->userid = Auth::User()->id;
                    $insert->totalcoupon=$input['totalcoupon'];
                    $insert->usespercustomer=$input['usespercustomer'];
                    $insert->status=$input['status'];
                    if($item['coupon_type'] == 'percentage'){
                        $insert->couponpercentage=$item['coupon_value'];
                    }else if($item['coupon_type'] == 'amount'){
                        $insert->couponamount = $item['coupon_value'];
                    }
                    $insert->activity_id=$item['activity'];
                    $insert->save();
                }
            }else if($input['applied_to'] == 'all'){
                
                $insert = Coupon::find($id);
                if($insert->applied_to == 'single'){
                    Coupon::where('couponcode',$couponcode)->delete();
                }
                $check = Coupon::where('couponcode', $input['couponcode'])->where('id','!=',$id)->first();
                if($check){
                    return response()->json(['status' => 'validation', 'validation' => 'Coupon code ('.$input["couponcode"].') alreay available']);
                }
                if($insert->applied_to == 'single'){
                    $insert = new Coupon();
                }else{
                    $insert = Coupon::find($id);
                }

                $insert->couponname=$input['couponname'];
                $insert->couponcode=$input['couponcode'];
                $insert->coupontype=$input['coupon_type'][0];
                if($input['startdate']!=''){
                    $insert->startdate=date('Y-m-d',strtotime($input['startdate']));
                }else{
                    $insert->startdate='';
                }
                if($input['enddate']!=''){
                    $insert->enddate=date('Y-m-d',strtotime($input['enddate']));
                }else{
                    $insert->enddate='';
                }
                $insert->minimumamount = $input['minimumamount'];
                $insert->userid = Auth::User()->id;
                $insert->totalcoupon=$input['totalcoupon'];
                $insert->usespercustomer=$input['usespercustomer'];
                $insert->status=$input['status'];
                $insert->applied_to='all';

                if($input['coupon_type'][0] == 'percentage'){
                    $insert->couponpercentage=$input['coupon_value'][0];
                }else if($input['coupon_type'][0] == 'amount'){
                    $insert->couponamount = $input['coupon_value'][0];
                }
                // $insert->activity_id='';
                $insert->save();
                
                
            }
            $url = "/coupons/".$insert->couponcode.'/edit';
            return response()->json(['status' => 'success', 'message' => 'Coupon is updated successfully.', 'url' => $url]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $record = Coupon::find($id);
            if($record){
                $record->status = 'deleted';
                $record->save();
                return response()->json(['status' => 'success', 'message' => 'Coupon has been deleted successfully']);
            }
            return response()->json(['status' => 'error', 'message' => 'Coupon details not available.']);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }


    public function getcoupon(Request $req){
        try{
            $input = $req->all();
            $search = '';
            if(isset($input['search']) && $input['search'] != ''){
                $search = $input['search'];
            }
            $records = DB::table('coupon as cu')->where('cu.status','!=','deleted')->latest();
            if($search != ''){
                $records = $records->join('activity as ac', 'ac.activity_id', '=', 'cu.activityId')->where('ac.activity_name', 'LIKE', '%'.$search.'%')->orWhere('cu.couponname', 'LIKE', '%'.$search.'%')->orWhere('cu.couponcode', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);

            $html = view('coupons.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }
}
