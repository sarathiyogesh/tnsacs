<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use DB;
use Str;
use Auth;
use Validator;
use App\Exports\EventReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityTicketReportExport;
use App\Models\Ticketitem;
use App\Models\City;
use App\Models\Eventbooking;
use App\Models\Eventbookingmeta;
use File;
use App\Models\Utility;
use App\Models\EventCategory;
use App\Models\Language;
use Storage;
use App\Models\EventList;
use App\Models\Country;
use App\Models\CountryCity;

class EventController extends Controller
{

    function __construct(){
       
    }

    public function eventsalesreport(){
        return view('event.sales_report');
    }

    public function geteventreports(Request $req){
        try{

            $input = $req->all();
            
            $records = Eventbooking::orderBy('id', 'ASC');
            $records = $records->paginate(10);

            $results = [];
            $i = 0;
            foreach($records as $record){
                $results[$i]['order_id'] = $record->booking_id;
                $results[$i]['first_name'] = $record->first_name;
                $results[$i]['last_name'] = $record->last_name;
                $results[$i]['email'] = $record->email;
                $results[$i]['phonenumber'] = $record->phone;
                $results[$i]['total_amount'] = $record->total_amount;
                $i++;
            }
            $html = view('event.event_report_table', compact('results','records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function eventreportexcel(Request $req){
        return Excel::download(new EventReportExport, 'event_report.xlsx');
    }

    //category start
    public function categorypage(){
        try{
            return view('event.category.category');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function categoryview(Request $req){
        try{
            $search = $req->search;
            $records = EventCategory::latest();
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('name','ASC')->take(15)->get();
            $html = view('event.category.category-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcategory(Request $input) {
        $rules = [
            'name' => 'required|unique:event_categories,name',
            'status' => 'required'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        
        $insert = EventCategory::create($data);
        if($insert->save()){
            return response()->json(['status'=>'success', 'msg'=>'category is created successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function categoryedit(Request $req){
        $find = EventCategory::find($req->id);
        if($find){
            return response()->json(['status'=>'success', 'record'=>$find]);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function updatecategory(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_name' => 'required|unique:event_categories,name,'.$id,
            'edit_status' => 'required',
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        
        $find = EventCategory::find($id);
        $data['name'] = $input['edit_name'];
        $data['status'] = $input['edit_status'];

        if($find){
            $find->update($data);
            return response()->json(['status'=>'success', 'msg'=>'category is updated successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);

    }

    public function deletecategory(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = EventCategory::find($id);
        $delete->delete();
        return response()->json(['status'=>'success', 'msg'=>'category is deleted successfully']);
    }
    //category end

    //language start
    public function languagepage(){
        try{
            return view('event.language.language');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function languageview(Request $req){
        try{
            $search = $req->search;
            $records = Language::latest();
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('name','ASC')->take(15)->get();
            $html = view('event.language.language-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addlanguage(Request $input) {
        $rules = [
            'name' => 'required|unique:languages,name',
            'status' => 'required'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $insert = Language::create($data);
        if($insert->save()){
            return response()->json(['status'=>'success', 'msg'=>'language is created successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function languageedit(Request $req){
        $find = Language::find($req->id);
        if($find){
            return response()->json(['status'=>'success', 'record'=>$find]);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function updatelanguage(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_name' => 'required|unique:languages,name,'.$id,
            'edit_status' => 'required',
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }

        $find = Language::find($id);
        $data['name'] = $input['edit_name'];
        $data['status'] = $input['edit_status'];

        if($find){
            $find->update($data);
            return response()->json(['status'=>'success', 'msg'=>'language is updated successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);

    }

    public function deletelanguage(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = Language::find($id);
        $delete->delete();
        return response()->json(['status'=>'success', 'msg'=>'language is deleted successfully']);
    }
    //language end

    //event

    public function eventpage(){
        
        return view('event.view');
    }

    public function eventview(Request $req){
        try{
            $search = $req->search;
            $records = EventList::orderBy('id','DESC');
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
           
            $html = view('event.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addevent(){
        $categories = EventCategory::where('status', 'active')->get();
        $languages = Language::where('status', 'active')->get();
        $countries = Country::where('status', 'active')->get();
        $cities = CountryCity::where('status', 'active')->get();
        return View('event.create', compact('categories','languages', 'countries', 'cities'));
    }

    public function saveevent(Request $req){
        try{
            $data = $req->all();
           
            $rules = [
                'name' => 'required',
                'category' => 'required', 
                'country' => 'required' ,
                'api_code' => 'required' ,
                //'city' => 'required' ,
                'language' => 'required' ,
                'location' => 'required' ,
                'address' => 'required' ,
                'status' => 'required' ,
                'start_date' => 'required' ,
                'end_date' => 'required' ,
                'price' => 'required|numeric' ,
                'description' => 'required' ,
                'banner_image' => 'required|mimes:jpg,jpeg,png,svg' ,
                'feature_image' => 'required|mimes:jpg,jpeg,png,svg' ,
                'header_tag' => 'required',
                'meta_image' => 'mimes:jpg,jpeg,png,svg'
            ];
            $message = [ 'required' => 'this field is required.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }


            $feature_image = '';
            if($req->hasFile('feature_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('feature_image'), $filename, '', '');
                if($upload){
                    if($data['feature_image']){
                        try{
                            $file = explode('/',$data['feature_image']);
                            $file = end($file);
                            Utility::deleteUploadedEventFile($file);
                        }catch(\Exception $e){

                        }
                    }
                    $feature_image = $upload;
                }
            }
            $data['feature_image'] = $feature_image;

            $banner_image = '';
            if($req->hasFile('banner_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('banner_image'), $filename, '', '');
                if($upload){
                    if($data['banner_image']){
                        try{
                            $file = explode('/',$data['banner_image']);
                            $file = end($file);
                            Utility::deleteUploadedEventFile($file);
                        }catch(\Exception $e){

                        }
                    }
                    $banner_image = $upload;
                }
            }
            $data['banner_image'] = $banner_image;

            $meta_image = '';
            if($req->hasFile('meta_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('meta_image'), $filename, '', '');
                if($upload){
                    if($data['meta_image']){
                        try{
                            $file = explode('/',$data['meta_image']);
                            $file = end($file);
                            Utility::deleteUploadedEventFile($file);
                        }catch(\Exception $e){

                        }
                    }
                    $meta_image = $upload;
                }
            }
            $data['meta_image'] = $meta_image;

            $data['start_date'] = date('Y-m-d', strtotime($req->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($req->end_date));

            $data['slug'] = Str::slug($req->name, '-');
            $save = EventList::create($data);

        return response()->json(['status' => 'success', 'msg' => 'New event is created successfully.']);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    // 

    public function eventedit($event_id){
        $categories = EventCategory::where('status', 'active')->get();
        $languages = Language::where('status', 'active')->get();
        $countries = Country::where('status', 'active')->get();
        $cities = CountryCity::where('status', 'active')->get();
        $record = EventList::find($event_id);
        if($record){
            return view('event.edit', compact('record','categories','languages', 'countries', 'cities'));
        }

        return back()->with('error', 'Please try again.');
    }

    public function updateevent(Request $req){
        try{
            $data = $req->all();
           
            $rules = [
                'name' => 'required',
                'category' => 'required', 
                'country' => 'required' ,
                'api_code' => 'required' ,
                //'city' => 'required' ,
                'language' => 'required' ,
                'location' => 'required' ,
                'address' => 'required' ,
                'status' => 'required' ,
                'start_date' => 'required' ,
                'end_date' => 'required' ,
                'price' => 'required|numeric' ,
                'description' => 'required' ,
                'banner_image' => 'nullable|mimes:jpg,jpeg,png,svg' ,
                'feature_image' => 'nullable|mimes:jpg,jpeg,png,svg' ,
                'header_tag' => 'required',
                'meta_image' => 'mimes:jpg,jpeg,png,svg'
            ];
            $message = [ 'required' => 'this field is required.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }

            $record = EventList::find($req->event_id);
            if($record){

            if($req->hasFile('feature_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('feature_image'), $filename, '', '');
                if($upload){
                    if($data['feature_image']){
                        // try{
                        //     $file = explode('/',$data['feature_image']);
                        //     $file = end($file);
                        //     Utility::deleteUploadedEventFile($file);
                        // }catch(\Exception $e){

                        // }
                    }
                    $data['feature_image'] = $upload;
                }
            }

            if($req->hasFile('banner_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('banner_image'), $filename, '', '');
                if($upload){
                    if($data['banner_image']){
                        // try{
                        //     $file = explode('/',$data['banner_image']);
                        //     $file = end($file);
                        //     Utility::deleteUploadedEventFile($file);
                        // }catch(\Exception $e){

                        // }
                    }
                    $banner_image = $upload;
                    $data['banner_image'] = $upload;
                }
            }

            if($req->hasFile('meta_image')) {
                $filename = Str::slug($data['name']).'-'.time().'.jpg';
                $upload = Utility::uploadEventFile($req->file('meta_image'), $filename, '', '');
                if($upload){
                    if($data['meta_image']){
                        // try{
                        //     $file = explode('/',$data['meta_image']);
                        //     $file = end($file);
                        //     Utility::deleteUploadedEventFile($file);
                        // }catch(\Exception $e){

                        // }
                    }
                    $data['meta_image'] = $upload;
                }
            }

            $data['start_date'] = date('Y-m-d', strtotime($req->start_date));
            $data['end_date'] = date('Y-m-d', strtotime($req->end_date));
            $data['slug'] = Str::slug($req->name, '-');

            $update = $record->update($data);

            return response()->json(['status' => 'success', 'msg' => 'Event is updated successfully.']);
        }

        return response()->json(['status' => 'error', 'msg' => 'Please try again.']);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }


}
