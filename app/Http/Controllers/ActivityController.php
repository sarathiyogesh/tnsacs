<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use DB;
use Str;
use Auth;
use Validator;
use App\Exports\ActivityReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ActivityTicketReportExport;
use App\Models\Ticketitem;
use App\Models\Ticket;
use App\Models\City;
use App\Models\Raynatourlist;
use App\Models\Raynatouroption;
use App\Models\Rayna;
use App\Models\Ticketitemapioptions;
use App\Models\Apiticketavailability;
use App\Models\Bookingreportmeta;
use App\Models\Priohub;
use App\Models\ActivityCategoryMap;
use App\Models\ActivityTagMap;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Coupon;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Country;
use App\Models\Tickettimeslot;
use App\Models\Ticketsection;
use File;
use App\Models\Utility;
use Storage;

class ActivityController extends Controller
{

    function __construct(){
        $this->middleware('permission:activity-report-view', ['only' => ['activityreports']]);
        $this->middleware('permission:activity-ticket-view', ['only' => ['activitytickets']]);
        $this->middleware('permission:activities-view|activities-add|activities-edit', ['only' => ['manageactivities', 'viewactivities']]);
        $this->middleware('permission:activities-add', ['only' => ['storeactivity']]);
        $this->middleware('permission:activities-edit', ['only' => [ 'deleteactivity', 'updatefeature', 'editactivity', 'galleryactivity', 'savegallery', 'deletegallery', 'updateactivity']]);
        $this->middleware('permission:rayna-api-report-view', ['only' => ['raynaapireport']]);
        $this->middleware('permission:ticket-report-view', ['only' => ['ticketreports']]);
    }


    public function activityreports(){
        return view('activities.activity_report_view');
    }

    public function activitytickets(){
        $activities = Activity::select('activity_name','activity_id')->get();
        return view('activities.activityticket_report_view', compact('activities'));
    }

    public function getactivityreports(Request $req){
        try{

            $input = $req->all();
            $activity_type = '';
            $status = '';
            $search_filter = '';
            
            if(isset($input['search_filter']) && $input['search_filter'] != ''){
                $search_filter = $input['search_filter'];
            }

            if(isset($input['activity_type']) && $input['activity_type'] != ''){
                $activity_type = $input['activity_type'];
            }

            if(isset($input['status']) && $input['status'] != ''){
                $status = $input['status'];
            }

            $records = Activity::orderBy('activity_id', 'ASC');

            if($activity_type != ''){
                $records = $records->where('ticket_source', $activity_type);
            }

            if($search_filter != ''){
                $records = $records->where('activity_name', 'LIKE', '%'.$search_filter.'%');
            }

            if($status != ''){
                $records = $records->where('activity_status', $status);
            }
            $records = $records->paginate(10);

            $results = [];
            $i = 0;
            foreach($records as $record){
                $status = ucfirst($record->activity_status);
                if($record->activity_status == 'hide'){
                    $status = 'Hidden';
                }
                $via = 'Manual';
                if($record->ticket_source == 'a'){
                    $via = "Rayna API";
                }else if($record->ticket_source == 'ph'){
                    $via = 'PrioHub API';
                }

                $getdates = DB::table('activity_ticket')->where('activityId',$record->activity_id)->where('status','active')->first();
                $last_date = '--';
                if($getdates){
                    $dates = explode (",", $getdates->ticket_date);
                    if(is_array($dates) && count($dates) != 0){
                        $last_date = $dates[count($dates)-1];
                    }
                }

                $results[$i]['name'] = $record->activity_name;
                $results[$i]['status'] = $status;
                $results[$i]['via'] = $via;
                $results[$i]['date'] = $last_date;
                $results[$i]['regular_price'] = $record->regular_price;
                $results[$i]['discount_price'] = $record->discount_price;
                $results[$i]['corporate_discount_price'] = $record->corporate_discount_price;
                $results[$i]['start_day'] = $record->starting_days;
                $i++;
            }

            $html = view('activities.activity_report_table', compact('results', 'records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function activityreportexcel(Request $req){
        return Excel::download(new ActivityReportExport, 'activity_report.xlsx');
    }

    //Activity Ticket

    public function getactivityticketreports(Request $req){
        try{
            $input = $req->all();
            $activity = '';
            $search_filter = '';

            if(isset($input['search_filter']) && $input['search_filter'] != ''){
                $search_filter = $input['search_filter'];
            }

            if(isset($input['activity']) && $input['activity'] != ''){
                $activity = $input['activity'];
            }
            
            //$records = Ticketitem::orderBy('activityId', 'ASC');
            $records = DB::table('activity_ticket_item as ti')->orderBy('ti.activityId', 'ASC');

            if($activity != ''){
                $records = $records->where('ti.activityId', $activity);
            }

            if($search_filter != ''){
                $records = $records->join('activity as ac', 'ac.activity_id', '=', 'ti.activityId')->where('ac.activity_name', 'LIKE', '%'.$search_filter.'%')->orWhere('ti.item_name', 'LIKE', '%'.$search_filter.'%');
            }

            $records = $records->paginate(10);

            $results = [];
            $i = 0;

            foreach($records as $record){
                $price_type = 'All age';
                if($record->price_type == 'adultandchild'){
                    $price_type = 'Adult and Child';
                }else if($record->price_type == 'adult' || $record->price_type == 'child'){
                    $price_type = ucfirst($record->price_type);
                }

                $minmax = '--/--';
                if($record->minimum_ticket && $record->maximum_ticket){
                    $minmax = $record->minimum_ticket.'/'.$record->maximum_ticket;
                }else if($record->minimum_ticket && !$record->maximum_ticket){
                    $minmax = $record->minimum_ticket.'/--';
                }else if(!$record->minimum_ticket && $record->maximum_ticket){
                    $minmax = '--/'.$record->maximum_ticket;
                }

                $getdates = DB::table('activity_ticket')->where('activityId',$record->activityId)->where('status','active')->first();
                $last_date = '--';
                if($getdates){
                    $dates = explode (",", $getdates->ticket_date);
                    if(is_array($dates) && count($dates) != 0){
                        $last_date = $dates[count($dates)-1];
                    }
                }

                $results[$i]['activity_name'] = Activity::getactivityname($record->activityId);
                $results[$i]['ticket_name'] = $record->item_name;
                $results[$i]['description'] = $record->item_desc;
                $results[$i]['price_type'] = $price_type;
                $results[$i]['adult_price'] = $record->adult_price;
                $results[$i]['child_price'] = $record->child_price;
                $results[$i]['allage_price'] = $record->allage_price;
                $results[$i]['adult1_price'] = $record->adult_price1;
                $results[$i]['child1_price'] = $record->child_price1;
                $results[$i]['allage1_price'] = $record->allage_price1;
                $results[$i]['minmax'] = $minmax;
                $results[$i]['last_date'] = $last_date;

                $i++;
            }
            $html = view('activities.activityticket_report_table', compact('results', 'records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function activityticketreportexcel(Request $req){
        return Excel::download(new ActivityTicketReportExport, 'activity_ticket_report.xlsx');
    }

    public function manageactivities(){
        return view('activities.view');
    }

    public function viewactivities(Request $req){
        try{
            $search = $req->search;
            $records = Activity::orderBy('activity_name');
            if($search){
                $records = $records->where('activity_name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->select('activity_id','activity_name','activity_city','featured')->get();
            foreach($records as $record){
                $getdates = DB::table('activity_ticket')->where('activityId',$record->activity_id)->where('status','active')->first();
                $city = City::find($record->activity_city);
                $city_name = '';
                if($city){
                    $city_name = $city->name;
                }
                $record->last_date = '--';
                $record->past_date = 'no';
                $record->activity_city_name = $city_name;
                if($getdates){
                    $dates = explode (",", $getdates->ticket_date);
                    if(is_array($dates) && count($dates) != 0){
                        $record->last_date = $dates[count($dates)-1];
                        if (strtotime($dates[count($dates)-1]) <= strtotime(date('Y-m-d'))) {
                             $record->past_date = 'yes';
                        }else{
                             $record->past_date = 'no';
                        }
                    }
                }
            }

            $html = view('activities.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function updatefeature(Request $req){
        $activityid = $req->activityid;
        $city = $req->city;

        $record = Activity::find($activityid);
        if($record){
            $value = 1;
            if($record->featured == 1){
                $value = 0;
                $check = Activity::where('featured',1)->where('activity_city',$city)->count();
                if($check == 10){
                    return response()->json(['status' => 'limit', 'msg' => 'Featured activity limit exceeded for: '.City::getname($city)]);
                }
            }
            $record->featured = $value;
            $record->save();

            $feature = 'Unfeature this';
            if($value == 0){
                $feature = 'Feature this';
            }

            return response()->json(['status' => 'success', 'msg' => 'Updated successfully', 'value' => $feature]);
        }
        return response()->json(['status' => 'error', 'msg' => 'Activity details not found.']);
    }

    public function storeactivity(Request $req){
        $rules = [
            'activity_name' => 'required|unique:activity|max:255'
        ];
        $input = $req->all();
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $input['activity_name_slug'] = Str::slug($input['activity_name'], '-');
        $input['created_by'] = Auth::id();
        $input['activity_status'] = 1;
        $create = Activity::create($input);
        return response()->json(['status'=>'success', 'msg'=>'New activity has been created successfully.']);
    }

    public function editactivity($activity_id){
        $categoryMap = ActivityCategoryMap::where('activity_id', $activity_id)->pluck('category_id')->toArray();
        $categoryList = Category::where('activity',1)->select('category_id as id','category_name as name')->get();

        $tagMapIds = ActivityTagMap::where('activity_id', $activity_id)->pluck('tag_id');
        $tagMap = Tag::whereIn('tag_id',$tagMapIds)->pluck('tag_name as name')->toArray();
        $tagList = Tag::select('tag_name as name', 'tag_id as id')->get();

        $info = Activity::find($activity_id);
        $info['categories'] = $categoryMap;
        $info['tags'] = $tagMap;
        $cities = City::get();
        $activity_tags = config('laraadmin.activity_tags');
        $coupons = Coupon::where('status','!=','deleted')->get();
        $countries = Country::where('status', 'active')->orderBy('country_name')->get();
        return View('activities.edit', compact('countries'))->with(['activityInfo'=>$info,'cities'=>$cities,'categories'=>$categoryList,'tags'=>$tagList,'activity_tags' =>[], 'coupons'=>$coupons]);
    }

    public function updateactivity(Request $req){
        $rules = [
            'activity_name' => 'required|unique:activity,activity_name,'.$req->activity_id.',activity_id|max:255',
            'regular_price' => 'required'
        ];

        $validation = Validator::make($req->all(), $rules);
        if($validation->fails()){
            return $validation->messages();
        }

        $data = $req->all();

        $data['activity_name_slug'] = Str::slug($req['activity_name'], '-');

        // Banner image validation
        if(isset($data['activity_banner_string']) && $data['activity_banner_string']){
            $filename = str_slug($data['activity_name']).'-'.time().'.jpg';
            $upload = Utility::uploadActivityFile($data['activity_banner_string'], $filename, 1920, '');
            if($upload){
                // new image is uploaded remove the old one
                if($data['horizontal_banner']){
                    $file = explode('/',$data['horizontal_banner']);
                    $file = end($file);
                    Utility::deleteUploadedActivityFile($file);
                }
                // set new uploaded file URL
                $data['horizontal_banner'] = $upload;
            }
        }

        // Poster image validation
        if(isset($data['activity_poster_string']) && $data['activity_poster_string']){
            $filename = str_slug($data['activity_name']).'-vertical-'.time().'.jpg';
            $upload = Utility::uploadActivityFile($data['activity_poster_string'], $filename, '', 472);
            if($upload){
                if($data['vertical_banner']){
                    $file = explode('/',$data['vertical_banner']);
                    $file = end($file);
                    Utility::deleteUploadedActivityFile($file);
                }
                // set new uploaded file URL
                $data['vertical_banner'] = $upload;
            }
        }

        // Featured image validation
        if(isset($data['activity_featured_string']) && $data['activity_featured_string']){
            $filename = str_slug($data['activity_name']).'-featured-image-'.time().'.jpg';
            $upload = Utility::uploadActivityFile($data['activity_featured_string'], $filename, '', 472);
            if($upload){
                if($data['featured_image']){
                    $file = explode('/',$data['featured_image']);
                    $file = end($file);
                    Utility::deleteUploadedActivityFile($file);
                }
                // set new uploaded file URL
                $data['featured_image'] = $upload;
            }
        }

        // Meta image validation
        if(isset($data['meta_image_string']) && $data['meta_image_string']){
            $filename = str_slug($data['activity_name']).'-meta-image-'.time().'.webp';
            $upload = Utility::uploadActivityFile($data['meta_image_string'], $filename, '', 472);
            if($upload){
                if($data['meta_image']){
                    $file = explode('/',$data['meta_image']);
                    $file = end($file);
                    Utility::deleteUploadedActivityFile($file);
                }
                // set new uploaded file URL
                $data['meta_image'] = $upload;
            }
        } 

        DB::transaction(function() use($data){

            $activity_id = $data['activity_id'];

            ActivityCategoryMap::where('activity_id', $activity_id)->delete();
            ActivityTagMap::where('activity_id', $activity_id)->delete();

            $update = Activity::find($activity_id)->update($data);
            if(isset($data['categories'])){
                foreach($data['categories'] as $cat){
                    ActivityCategoryMap::create(['category_id'=>$cat,'activity_id'=>$activity_id]);
                }
            }

            if(isset($data['tags'])){
                foreach($data['tags'] as $tag){
                    $check = Tag::where('tag_name',$tag)->first();
                    if($check){
                        $tagid = $check->tag_id;
                    } else{
                        // $create = Tag::create(['tag_name'=>$tag,'tag_name_slug'=>str_slug($tag, '-')]);
                        // $tagid = $create->tag_id;
                    }
                    //ActivityTagMap::create(['tag_id'=>$tagid,'activity_id'=>$activity_id]);
                }
            }

            

        });

        

        return back()->with('success', 'Activity details has been updated successfully');
    }

    public function deleteactivity(Request $req){
        $activityid = $req->activityid;
        $delete = Activity::find($activityid)->delete();
        return response()->json(['status' => 'success', 'msg' => 'Activity has been deleted successfully.']);
    }

    public function galleryactivity($activity_id){
        $gallery = [];
        $photos = [];
        $activity = Activity::find($activity_id);
        if($activity->gallery_id){
            $gallery = Gallery::find($activity->gallery_id);
            $gallery = json_decode($gallery->sorted_ids);
        }

        if(!is_array($gallery)){
            $gallery = [];
        }

        foreach ($gallery as $photo_id) {
            $photo = Photo::find($photo_id);
            array_push($photos, $photo);
        }

        return View('activities.gallery', compact('activity', 'photos'));
    }

    public function savegallery(Request $input){
        $rules = [
            "photo_name" => 'required',
            "newImage" => 'required|mimes:jpg,jpeg,png,svg,gif',

        ];
        $message = [ 'required' => 'this field is required.'];
        $validation = Validator::make($input->all(), $rules, $message);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $activity_id = $input['activity_id'];
        $find = Activity::find($activity_id);
        $gallery_id = $find->gallery_id;
        if(!$gallery_id){
            $gallery = Gallery::create(['name'=>'Activity_gallery']);
            $gallery_id = $gallery->gallery_id;
            $find->gallery_id = $gallery_id;
            $find->save();
        }

        $folderpath = env('GALLERY_DIR', "/uploads/gallery");

        $filename = 'activity_'.$activity_id.'_img_'.time().'.jpg';
        $thumbmailfilename = 'activity_'.$activity_id.'_img_thumbnail_'.time().'.jpg';

        $filepath = $folderpath.'/'.$filename;
        $thumbnailfilepath = $folderpath.'/'.$thumbmailfilename;

        $upload = File::put(public_path().$filepath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $input['newImage'])));
        $uploadThumb = File::put(public_path().$thumbnailfilepath, base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $input['newImage'])));

        // Utility::compress(public_path().$filepath, public_path().$filepath, 80);
        // Utility::resizeW(public_path().$thumbnailfilepath, 200);

        // //upload image to s3       

        // $s3path = env('S3_GALLERY_DIR').$filename;
        // $s3thumbpath = env('S3_GALLERY_DIR').$thumbmailfilename;

        // Storage::disk('s3')->put($s3path, file_get_contents(public_path().$filepath));
        // Storage::disk('s3')->put($s3thumbpath, file_get_contents(public_path().$thumbnailfilepath));

        // $imgpath = Storage::disk('s3')->url($s3path);
        // $tmbpath = Storage::disk('s3')->url($s3thumbpath);

        // File::delete(public_path().$filepath);
        // File::delete(public_path().$thumbnailfilepath);
        $imgpath = $filepath;
        $tmbpath = $uploadThumb;

        if($upload && $uploadThumb){
            $imgpath = $imgpath;
            $tmbpath = $tmbpath;
            $data = ['name'=>$input['name'],'description'=>$input['description'],'gallery_id'=>$gallery_id,'photo_url'=>$imgpath,'thumbnail_url'=>$tmbpath];
            $save = Photo::create($data);
            $updateSortIds = Gallery::updateSortIds($gallery_id, $save->photo_id);
             return response()->json(['status'=>'success','img'=>$imgpath,'thumb'=>$tmbpath]); 
        } else{
            return response()->json(['status'=>'error', 'msg' => 'Please try again.']);
        }
    }

    public function  deletegallery(Request $req){
        $input = $req->input();
        $photoid = $input['photoid'];
        //$galleryid = $input['galleryid'];
        $photogal = Photo::find($photoid);
        $images = Gallery::find($photogal->gallery_id);
        $galleryid = $images->gallery_id;
        $photos = [];
        if($images){
            $photos = json_decode($images->sorted_ids);
        }
        $newPhotos = [];
        foreach($photos as $photo){
            if($photo != $photoid){
                array_push($newPhotos, $photo);
            }
        }
        Gallery::where('gallery_id', $galleryid)->update(['sorted_ids'=>json_encode($newPhotos)]);
        $photodetails = Photo::find($photoid);
        // if($photodetails){
        //     $photourl = $photodetails->photo_url;
        //     $thumburl = $photodetails->thumbnail_url;
        //     $s3path = env('S3_GALLERY_DIR').$photourl;
        //     $s3thumbpath = env('S3_GALLERY_DIR').$thumburl;

        //     Storage::disk('s3')->delete($s3path);
        //     Storage::disk('s3')->delete($s3thumbpath);
        // }
        Photo::find($photoid)->delete();
        $photos = [];
        foreach ($newPhotos as $photo) {
            $photo = Photo::find($photo);
            array_push($photos, $photo);
        }
        return response()->json(['status'=>'success', 'message'=>'Photo is deleted successfully.']);
    }

    public function raynaapireport(Request $request){
        $total = Raynatourlist::count();
        $records = DB::table('rayna_tour_option as tp')->leftJoin('rayna_tour_list_data as tl', 'tl.tour_id', '=', 'tp.tour_id');
        if($request->has('tour_id') && $request->tour_id){
            $records = $records->where('tp.tour_id', $request->tour_id);
        }
        if($request->has('tour_name') && $request->tour_name){
            $records = $records->where('tl.tour_name', 'LIKE', '%'.$request->tour_name.'%');
        }
        $records = $records->select('tp.tour_id', 'tp.option_id', 'tp.contract_id', 'tp.transfer_id', 'tl.tour_name', 'tp.transfer_name')->paginate(10);
        return View('reports.rayna-api-report', compact('total', 'records'));
    }

    public function raynatourlist(){
        try{
            $country_id = 13063;
            $cities = [13160, 13236, 13668, 13765, 14644, 14777];
            $list_date = date('m/d/Y');
            Raynatourlist::where('id', '!=', NULL)->delete();
            $total = 0;
            foreach($cities as $city){
                $slots = new Rayna();
                $payload = [
                    "countryId"=> $country_id,
                    "cityId"=> $city,
                    "travelDate" => $list_date
                ];
                $slots = $slots->fetchTourList($payload);
                $slots = json_decode($slots);

                if(isset($slots->statuscode) && $slots->statuscode == 200 && isset($slots->result) ){
                    $total += $slots->count;
                    $results = $slots->result;
                    if(count($results) > 0){
                        foreach($results as $result){
                            $input = [];
                            $input['tour_id'] = $result->tourId;
                            $input['contract_id'] = $result->contractId;
                            $input['list_date'] = date('Y-m-d', strtotime($list_date));
                            Raynatourlist::insert($input);
                        }
                    }
                }else{
                    return response()->json(['status' => 'error', 'message' => "Rayna tour list api failed - ".$city]);
                }
            }
            return response()->json(['status' => 'success', 'message' => "Rayna tour list imported successfully", "total" => $total]);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()." - ".$e->getLine()]);
        }
    }

    public function raynatouroption(Request $request){
        try{
            $take = $request->take;
            $skip = $request->skip;
            $total = $request->total;
            $list_date = date('m/d/Y');
            $list_date_format = date('Y-m-d');
            if($skip == 0){
                Raynatouroption::where('id', '!=', '')->delete();
                $tours = Raynatourlist::orderBy('tour_id', 'ASC')->where('list_date', $list_date_format)->get();
                if(count($tours) == 0){
                    return response()->json(['status' => 'error', 'message' => 'Please first fetch tour list']);
                }
            }
            
            $tours = Raynatourlist::orderBy('tour_id', 'ASC')->take($take)->skip($skip)->get();
            foreach($tours as $tour){
                $slots = new Rayna();
                $payload = [
                    "tourId"=> $tour->tour_id,
                    "contractId"=> $tour->contract_id,
                    "travelDate" => $list_date,
                    "noOfAdult" => 1,
                    "noOfChild" => 0,
                    "noOfInfant" => 0
                ];
                $slots = $slots->fetchTour($payload);
                $slots = json_decode($slots);
                if(isset($slots->statuscode) && $slots->statuscode == 200 && isset($slots->result) ){
                    $results = $slots->result;
                    if(count($results) > 0){
                        foreach($results as $result){
                            $input = [];
                            $input['tour_id'] = $result->tourId;
                            $input['option_id'] = $result->tourOptionId;
                            $input['transfer_id'] = $result->transferId;
                            $input['transfer_name'] = $result->transferName;
                            $input['contract_id'] = $tour->contract_id;
                            $input['list_date'] = $list_date;
                            $input['adult_price'] = $result->adultPrice;
                            $input['child_price'] = $result->childPrice;
                            $insert = Raynatouroption::insert($input);
                        }
                    }
                }else{
                    return response()->json(['status' => 'error', 'message' => 'Rayna tour option  api failed - '.$tour->tour_id." - ".$tour->contract_id]);
                }
            }
            return response()->json(['status' => 'success', 'message' => 'Rayna tour option imported successfully']);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'message' => $e->getMessage()." - ".$e->getLine()]);
        }
    }

    public function getapiavailabilitytickets(Request $request, $total_days){
        $take = $request->take;
        $skip = $request->skip;
        $activities = Activity::where('activity_status', 'active')->where('ticket_source', 'ph')->take($take)->skip($skip)->orderBy('activity_id')->get();
        foreach($activities as $activity){
            $api_options = Ticketitemapioptions::where('activityId', $activity->activity_id)->orderBy('id', 'ASC')->get();
            foreach($api_options as $option){
                $i = 0;
                for($i; $i<$total_days;$i++){
                    $available_count = 0;
                    $date = date('Y-m-d', strtotime('+'.($i+1).' day', time()));
                    //$date = '2023-05-07';
                    $check_option_id = $option->api_tourOptionId;
                    if($activity->ticket_source == 'ph'){
                        $check_option_id = $option->api_tour_id;
                    }

                    $datecheck = Apiticketavailability::where('option_id', $check_option_id)->where('api_from', $activity->ticket_source)->where('ticket_date', $date)->first();
                    if(!$datecheck){
                        if($activity->ticket_source == 'a' && $activity->api_timeslot == 1 && $option->api_tourOptionId){
                            $option_id = $option->api_tourOptionId;
                            $transfer_id = $option->api_transferId;
                            $api_tour_id = $option->api_tour_id;
                            $api_contract_id = $option->api_contract_id;
                            $slots = new Rayna();
                            $payload = [
                                    "tourId" => $api_tour_id,
                                    "tourOptionId" => $option_id,
                                    "travelDate" => $date,
                                    "transferId" => $transfer_id,
                                    "contractId" => $api_contract_id
                            ];
                            $slots = $slots->fetchTimeSlots($payload);
                            $slots = json_decode($slots);
                            $available_count = 0;
                            if (isset($slots->count) && $slots->count > 0){
                                foreach($slots->result as $slot){
                                    $available_count += $slot->available;
                                }
                            }
                        }else if($activity->ticket_source == 'ph' && $activity->api_timeslot == 1 && $option->api_tour_id){
                            $api_tour_id = $option->api_tour_id;
                            $availability = new Priohub();
                            $availability = $availability->fetchAvailability($api_tour_id, $date);
                            //return $availability;
                            $availability = json_decode($availability);
                            
                            if(isset($availability->data->items)){
                                $items = $availability->data->items;
                                foreach($items as $item){
                                    if(isset($item->availability_spots) && isset($item->availability_spots->availability_spots_open)){
                                        $available_count += $item->availability_spots->availability_spots_open;
                                    }
                                }
                            }
                            //return $available_count;
                        }

                        if($available_count == 0 && $activity->api_timeslot == 1 && ($activity->ticket_source == 'a' || $activity->ticket_source == 'ph')){
                            $check = Apiticketavailability::where('option_id', $check_option_id)->where('api_from', $activity->ticket_source)->where('ticket_date', $date)->first();
                            if(!$check){
                                $new = new Apiticketavailability();
                                $new->activity_id = $activity->activity_id;
                                $new->option_id = $check_option_id;
                                $new->api_from = $activity->ticket_source;
                                $new->ticket_date = $date;
                                $new->save();
                            }
                        }
                    }
                }
            }
        }
        return response()->json(['status' => 'success']);
    }

    public function getdashboardinfo(){
        //sales count summary
            $todayDate = date('Y-m-d');
            $currentMontFirst = date('Y-m-01');
            $psmonth = date('Y-m-01',strtotime("-6 month"));
            $ptmonth = date('Y-m-01',strtotime("-12 month"));

            $today_count = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $today_count = $today_count->whereBetween('bookingDate',array($todayDate,$todayDate));
            $today_count = $today_count->count();

            $thismonth_count = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $thismonth_count = $thismonth_count->whereBetween('bookingDate',array($currentMontFirst,$todayDate));
            $thismonth_count = $thismonth_count->count();

            $lastsix_count = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $lastsix_count = $lastsix_count->whereBetween('bookingDate',array($psmonth,$todayDate));
            $lastsix_count = $lastsix_count->count();

            $last12month_count = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $last12month_count = $last12month_count->whereBetween('bookingDate',array($ptmonth,$todayDate));
            $last12month_count = $last12month_count->count();
        //sales count summary

        //sales amount summary
            $today_trans = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $today_trans = $today_trans->whereBetween('bookingDate',array($todayDate,$todayDate));
            $today_trans = $today_trans->sum('totalPrice') ?? 0;

            $thismonth_trans = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $thismonth_trans = $thismonth_trans->whereBetween('bookingDate',array($currentMontFirst,$todayDate));
            $thismonth_trans = $thismonth_trans->sum('totalPrice') ?? 0;

            $lastsix_trans = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $lastsix_trans = $lastsix_trans->whereBetween('bookingDate',array($psmonth,$todayDate));
            $lastsix_trans = $lastsix_trans->sum('totalPrice') ?? 0;

            $last12month_trans = DB::table('bookingreports')->where('bookingStatus','confirmed');
            $last12month_trans = $last12month_trans->whereBetween('bookingDate',array($ptmonth,$todayDate));
            $last12month_trans = $last12month_trans->sum('totalPrice') ?? 0;
        //sales amount summary
        //User summary
            $coruser_count = DB::table('users as u')
                ->leftJoin('corporates as c', 'u.ca_org_id', '=', 'c.id')
                ->where('u.ca_status', 1)
                ->whereDate('u.ca_expiry', '>=', Date('Y-m-d'))
                ->select('u.name', 'u.ca_email', 'u.ca_expiry', 'u.ca_status', 'c.name as org_name', 'c.domain', 'c.status as org_status', 'c.expiry as org_expiry')
                ->count();
            $prouser_count = DB::table('users as u')
                ->where('u.pro_status', 'yes')
                ->whereDate('u.pro_plan_enddate', '>=', Date('Y-m-d'))
                ->select('u.name', 'u.pro_email', 'u.pro_mobile', 'u.pro_plan_enddate', 'u.pro_plan_startdate', 'u.pro_plan_desc')
                ->count();
            $reg_count = DB::table('users as u')->count();
        //User summary

        //chart
            $pre6month = [];
            $pre6monthname = [];
            $pre6monthtranscount = [];
            $pre6monthbookcount = [];
            $pre6monthregcount = [];
            for ($i = 0; $i <= 6; $i++) {
              $start = date('Y-m-01', strtotime(-$i . 'month'));
              $end = date('Y-m-31', strtotime(-$i . 'month'));
              $pre6month[$i]['start'] = $start;
              $pre6month[$i]['end'] = $end;
              $pre6monthname[$i] = date('M y', strtotime(-$i . 'month'));
            }
            $i = 0;
            $pre6month = array_reverse($pre6month);
            $pre6monthname = array_reverse($pre6monthname);
            foreach($pre6month as $mon){
                $count = DB::table('bookingreports')->where('bookingStatus','confirmed');
                $count = $count->whereBetween('bookingDate',array($mon['start'],$mon['end']));
                $count = $count->sum('totalPrice') ?? 0;
                $pre6monthtranscount[$i] = $count;

                $bookcount = DB::table('bookingreports')->where('bookingStatus','confirmed');
                $bookcount = $bookcount->whereBetween('bookingDate',array($mon['start'],$mon['end']));
                $bookcount = $bookcount->count();
                $pre6monthbookcount[$i] = $bookcount;

                $treg_count = DB::table('users as u')
                ->whereBetween('u.created_at',array($mon['start'],$mon['end']))
                ->count();
                $pre6monthregcount[$i] = $treg_count;
                $i++;
            }
        //chart

      $topsalesitemlabel = [];
      $topsalesitemdata = [];
       try{
        //  $topsalesitem = DB::table('bookingreportmeta')
        // ->selectRaw('COALESCE(sum(item_id),0) total','activityName')
        // ->orderBy('total','desc')
        // ->take(10)
        // ->get();
        $topsalesitem = Bookingreportmeta::select(DB::raw('COUNT(activity_id) as cnt'),'activityName')->groupBy('activity_id','activityName')->orderBy('cnt', 'DESC')->take(5)->get();
        $i = 0;
        foreach($topsalesitem as $item){
            $topsalesitemlabel[$i] = $item->activityName;
            $topsalesitemdata[$i] = $item->cnt;
            $i++;
        }
       }catch(\Exception $e){
            //return $e->getMessage();
       }

        $data = [];

        $data['today_count'] = $today_count;
        $data['thismonth_count'] = $thismonth_count;
        $data['lastsix_count'] = $lastsix_count;
        $data['last12month_count'] = $last12month_count;

        $data['today_trans'] = 'AED '.$this->custom_number_format($today_trans,2);
        $data['thismonth_trans'] = 'AED '.$this->custom_number_format($thismonth_trans,2);
        $data['lastsix_trans'] = 'AED '.$this->custom_number_format($lastsix_trans,2);
        $data['last12month_trans'] = 'AED '.$this->custom_number_format($last12month_trans,2);

        $data['coruser_count'] = $coruser_count;
        $data['prouser_count'] = $prouser_count;
        $data['reg_count'] = $reg_count;

        $data['sales_count_label'] = $pre6monthname;
        $data['sales_count_data'] = $pre6monthtranscount;
        $data['sales_tktcount_data'] = $pre6monthbookcount;
        $data['sales_regcount_data'] = $pre6monthregcount;

        $data['topsalesitemlabel'] = $topsalesitemlabel;
        $data['topsalesitemdata'] = $topsalesitemdata;

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

    public function ticketreports(Request $req){
        $input = $req->all();
        if(isset($input['booking_from']) && $input['booking_from']){
            $input['booking_from'] = date('Y-m-d', strtotime($input['booking_from']));
        }
        if(isset($input['booking_to']) && $input['booking_to']){
            $input['booking_to'] = date('Y-m-d', strtotime($input['booking_to']));
        }
        $records = DB::table('bookingreports')->where('bookingStatus','confirmed');
        //return [$records];
        if(isset($input['booking_from']) && isset($input['booking_to']) && $input['booking_from'] != '' && $input['booking_to'] != ''){
            $records = $records->whereBetween('bookingDate',array($input['booking_from'],$input['booking_to']));
        }

        if(isset($input['booking_id']) && $input['booking_id'] != ''){
            $records = $records->where('bookingId',$input['booking_id']);
        }
        if(isset($input['email']) && $input['email'] != ''){
            $records = $records->where('email',$input['email']);
        }
        if(isset($input['phonenumber']) && $input['phonenumber'] != ''){
            $records = $records->where('phonenumber',$input['phonenumber']);
        }

        if(isset($input['reference_no']) && $input['reference_no'] != ''){
            $records = $records->where('reference_no',$input['reference_no']);
        }

        if(isset($input['user_type']) && $input['user_type'] != ''){
            $records = $records->where('ca_status',$input['user_type']);
        }

        if(isset($input['ticket_from']) && $input['ticket_from'] != ''){
            $records = $records->where('ticket_from',$input['ticket_from']);
        }

        if(isset($input['complete_status']) && $input['complete_status'] == '1'){
            $records = $records->where('completeStatus','completed');
        }

        if(isset($input['complete_status']) && $input['complete_status'] == '2'){
            $records = $records->where('completeStatus',NULL);
        }

        $records = $records->latest()->paginate(10);
        return view('reports.ticket-report',compact('records','input'));
    }

    public function ticketdetails(Request $req,$bookingId){
      $input = $req->all();
      $records = DB::table('bookingreports')->where('bookingId',$bookingId)->where('bookingStatus','confirmed')->first();
      if ($records) {
        return view('reports.ticket-view', compact('records'));
      }
      return redirect('/report/ticket-reports');
    }

    public function updateticketstatus(Request $input){
        $input = $input->all();
        $id = $input['id'];
        $ch = $input['ch'];
        if($ch == 'yes'){
            $sta = 'completed';
        }else{
            $sta = NULL;
        }
        $info = DB::table('bookingreports')->where('id',$id)->update(['completeStatus'=>$sta]);
        return response()->json(['status'=>'success']);
    }

    public function completebooking(Request $req){
        $id = $req->id;
        $current_option_id = '';
        if($req->has('option_id')){
            $current_option_id = $req->option_id;
        }
        $booking = Bookingreports::find($id);
        if($booking->action_status == 'running' && $current_option_id == ''){
           return response()->json(['status' => 'error', 'msg' => 'Confirm booking already in progress.']); 
        }
        $booking->action_status = 'running';
        $booking->save();
        if($booking){
            $prefix = 'Mr';
            if($booking->gender != 'male'){
                $prefix = 'Mrs';
            }
            $firstname = $booking->fullname;
            $lastname = '';
            $email = $booking->email;
            $phone = '+'.$booking->country_code.$booking->phonenumber;
            //Update Rayna Price Details
            $random = random_int(100000, 999999);
            $metas = Bookingreportmeta::where('bookingreportId',$booking->id)->get();
            foreach($metas as $meta){
                $activity = Activity::find($meta->activity_id);
                $adultCount = $meta->adultCount + $meta->allageCount;
                $childCount = $meta->childCount;

                $adultPrice = $meta->adultPrice;
                $childPrice = $meta->childPrice;
                $allagePrice = $meta->allagePrice;
                $totalPrice = $meta->totalPrice;
                if($adultPrice == 0 && $allagePrice > 0){
                    $adultPrice = $allagePrice;
                }
                $optionss = Bookingreportsapioptions::where('bookingreportId', $booking->id)->where('metaId', $meta->id)->orderBy('id', 'ASC');
                if($current_option_id){
                    $optionss = $optionss->where('id', $current_option_id);
                }
                $optionss = $optionss->get();
                if($meta->ticket_source == 'a'){
                    foreach($optionss as $options){
                        $tour_id = '';
                        $contract_id = '';
                        $option_id = '';
                        $transfer_id = '';
                        if($options){
                            $tour_id = $options->tour_id;
                            $contract_id = $options->contract_id;
                            $option_id = $options->option_id;
                            $transfer_id = $options->transfer_id;
                        }

                        $api_prices = new Rayna();
                        $payload = [
                            "tourId"=> $tour_id,
                            "contractId"=> $contract_id,
                            "travelDate"=> $meta->date,
                            "noOfAdult"=> $adultCount,
                            "noOfChild"=> $childCount,
                            "noOfInfant"=> 0,
                            "tourOptionId" => $option_id,
                            "transferId" => $transfer_id
                        ];
                        $response = $api_prices->fetchTour($payload);
                        
                        try{
                            //update booking log
                            DB::table('booking_log')->insert([
                                'bookingId' => $booking->bookingId,
                                'optionId' => $options->option_id,
                                'api_type' => 'Activity Price',
                                'api_request' => json_encode($payload),
                                'api_response' => $response,
                                'created_at' => date('Y-m-d H:i:s'),
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                        }catch(\Exception $e){
                            Log::info('************************************');
                            Log::info('tourprices-error:'.$booking->bookingId.'-'.$options->option_id);
                            Log::info($e->getMessage()." - ".$e->getLine());
                            Log::info('************************************');
                        }

                        $api_prices = json_decode($response);

                        if(isset($api_prices->statuscode) && $api_prices->statuscode == 200 && isset($api_prices->result) && $api_prices->result != null && isset($api_prices->result[0])){
                            $result = $api_prices->result[0];
                            $adultPrice = $result->adultPrice;
                            $childPrice = $result->childPrice;
                            $allagePrice = $result->adultPrice;

                            $totalPrice = 0;
                            if($meta->adultCount != 0){
                                $totalPrice = $totalPrice + ($adultPrice * $meta->adultCount);
                            }
                            if($meta->childCount != 0){
                                $totalPrice = $totalPrice + ($childPrice * $meta->childCount);
                            }
                            if($meta->allageCount != 0){
                                $totalPrice = $totalPrice + ($adultPrice * $meta->allageCount);
                            }
                            $update = Bookingreportsapioptions::find($options->id);
                            $update->rayna_adult_price = $adultPrice;
                            $update->rayna_child_price = $childPrice;
                            $update->rayna_allage_price = $allagePrice;
                            $update->rayna_total_price = $totalPrice;
                            $update->save();
                        }
                    }
                }else if($meta->ticket_source == 'ph'){
                    foreach($optionss as $options){
                        $product_detail = new Priohub();
                        $response = $product_detail->fetchTour($options->tour_id);
                        $response =  json_decode($response);
                        if(isset($response->data->product)){
                            $product = $response->data->product;
                            //Adult and Child Type id
                            if(isset($product->product_type_seasons[0]->product_type_season_details)){
                                $details = $product->product_type_seasons[0]->product_type_season_details;
                                foreach($details as $detail){
                                    $sales_price = 0;
                                    if(isset($detail->product_type_pricing->product_type_sales_price)){
                                        $sales_price = $detail->product_type_pricing->product_type_sales_price;
                                    }
                                    if($detail->product_type == 'ADULT'){
                                        $adultPrice = $sales_price;
                                    }else if($detail->product_type == 'CHILD'){
                                        $childPrice = $sales_price;
                                    }else if($detail->product_type == 'PERSON'){
                                        $allagePrice = $sales_price;
                                    }
                                }
                            }
                        }

                        $totalPrice = 0;
                        if($meta->adultCount != 0){
                            $totalPrice = $totalPrice + ($adultPrice * $meta->adultCount);
                        }
                        if($meta->childCount != 0){
                            $totalPrice = $totalPrice + ($childPrice * $meta->childCount);
                        }
                        if($meta->allageCount != 0){
                            $totalPrice = $totalPrice + ($adultPrice * $meta->allageCount);
                        }

                        $update = Bookingreportsapioptions::find($options->id);
                        $update->rayna_adult_price = $adultPrice;
                        $update->rayna_child_price = $childPrice;
                        $update->rayna_allage_price = $allagePrice;
                        $update->rayna_total_price = $totalPrice;
                        $update->save();
                    }
                }
            }

            $total_tickets = Bookingreportsapioptions::where('bookingId', $booking->bookingId);
            if($current_option_id){
                $total_tickets = $total_tickets->where('id', $current_option_id);
            }
            $total_tickets = $total_tickets->count();
            $confirmed_from_qrcode = 0;
            $confirmed_from_api = 0;

            $metas = Bookingreportmeta::where('bookingreportId',$booking->id)->get();
            
            $check_config = DB::table('la_configs')->where('key', 'bulk_qr_code')->where('value', 'enable')->first();

            foreach($metas as $meta){
                $options = Bookingreportsapioptions::where('bookingId', $booking->bookingId)->where('metaId', $meta->id);
                if($current_option_id){
                    $options = $options->where('id', $current_option_id);
                }
                $options = $options->get();
                foreach($options as $option){
                    //Check QR Code Available
                    $qrcode_available = 'no';
                    if($check_config && $option->option_id){
                        $qrcode_count = Bulkqrcode::where('option_id', $option->option_id)->where('qr_code', '!=', NULL)->where('status', 'active')->where('expiry_date', '>=', date('Y-m-d'))->where('qr_status', 'pending')->orderBy('id')->count();
                        if($qrcode_count >= $option->total_pax){
                            $qrcode_available = 'yes';
                        }
                    }
                    if($qrcode_available == 'yes'){
                        //Confirm Ticket using Bulk QR Code
                        $activity = Activity::find($meta->activity_id);
                        $adultCount = $meta->adultCount + $meta->allageCount;
                        $childCount = $meta->childCount;

                        $adultPrice = $meta->adultPrice;
                        $childPrice = $meta->childPrice;
                        $allagePrice = $meta->allagePrice;
                        $totalPrice = $meta->totalPrice;
                        if($adultPrice == 0 && $allagePrice > 0){
                            $adultPrice = $allagePrice;
                        }

                        $ticketitem = ticketitem::find($option->item_id);
                        $ticketItemName = NULL;
                        if($ticketitem){
                            $ticketItemName = $ticketitem->item_name;
                        }
                        $check = DB::table('bookingreports_api_details')->where('bookingId', $booking->bookingId)->where('api_option_id', $option->id)->delete();

                        $updateoption = Bookingreportsapioptions::find($option->id);
                        $updateoption->api_booking_id = $random;
                        $updateoption->service_unique_id = $random;
                        $updateoption->save();
                        //Adult Ticket
                        $k = 1;
                        while($k <= $meta->adultCount){
                            $barcode_record = Bulkqrcode::where('option_id', $option->option_id)->where('qr_code', '!=', NULL)->where('status', 'active')->where('expiry_date', '>=', date('Y-m-d'))->where('qr_status', 'pending')->orderBy('id')->first();
                            if($barcode_record){
                                DB::table('bookingreports_api_details')->insert([
                                    'api_option_id' => $option->id,
                                    'bookingreportId' => $booking->id,
                                    'bookingId' => $booking->bookingId,
                                    'barCode' => $barcode_record->qr_code,
                                    'noOfAdult' => 1,
                                    'noOfchild' => 0,
                                    'optionName' => $ticketItemName,
                                    'type' => 'adult'
                                ]);
                                Bulkqrcode::where('id', $barcode_record->id)->update(['qr_status' => 'used']);
                                if($barcode_record->expiry_date){
                                    Bookingreportsapioptions::where('id', $option->id)->update(['api_validity' => $barcode_record->expiry_date]);
                                }
                            }
                            $k++;
                        }

                        //Child Ticket
                        $k = 1;
                        while($k <= $meta->childCount){
                            $barcode_record = Bulkqrcode::where('expiry_date', '>=', date('Y-m-d'))->where('option_id', $option->option_id)->where('qr_code', '!=', NULL)->where('status', 'active')->where('qr_status', 'pending')->orderBy('id')->first();
                            if($barcode_record){
                                DB::table('bookingreports_api_details')->insert([
                                    'api_option_id' => $option->id,
                                    'bookingreportId' => $booking->id,
                                    'bookingId' => $booking->bookingId,
                                    'barCode' => $barcode_record->qr_code,
                                    'noOfAdult' => 1,
                                    'noOfchild' => 0,
                                    'optionName' => $ticketItemName,
                                    'type' => 'child'
                                ]);
                                Bulkqrcode::where('id', $barcode_record->id)->update(['qr_status' => 'used']);
                                if($barcode_record->expiry_date){
                                    Bookingreportsapioptions::where('id', $option->id)->update(['api_validity' => $barcode_record->expiry_date]);
                                }
                            }
                            $k++;
                        }

                        //Allage Ticket
                        $k = 1;
                        while($k <= $meta->allageCount){
                            $barcode_record = Bulkqrcode::where('expiry_date', '>=', date('Y-m-d'))->where('option_id', $option->option_id)->where('qr_code', '!=', NULL)->where('status', 'active')->where('qr_status', 'pending')->orderBy('id')->first();
                            if($barcode_record){
                                DB::table('bookingreports_api_details')->insert([
                                    'api_option_id' => $option->id,
                                    'bookingreportId' => $booking->id,
                                    'bookingId' => $booking->bookingId,
                                    'barCode' => $barcode_record->qr_code,
                                    'noOfAdult' => 1,
                                    'noOfchild' => 0,
                                    'optionName' => $ticketItemName,
                                    'type' => 'adult'
                                ]);
                                Bulkqrcode::where('id', $barcode_record->id)->update(['qr_status' => 'used']);
                                if($barcode_record->expiry_date){
                                    Bookingreportsapioptions::where('id', $option->id)->update(['api_validity' => $barcode_record->expiry_date]);
                                }
                            }
                            $k++;
                        }
                        
                        $bookingreportsmeta = Bookingreportmeta::where('id',$meta->id)->update([
                            'ticketStatus'=>'confirmed'
                        ]);

                        $update = Bookingreportsapioptions::where('id',$option->id)->update([
                            'api_optionName' => $ticketItemName,
                            'api_printType' => 'QR Code',
                        ]);

                        $confirmed_from_qrcode++;

                        $reference_no = random_int(1000000, 9999999);
                        Bookingreportsapioptions::where('id',$option->id)->update([
                            'reservation_no' => $reference_no,
                            'ticket_confirmed_from' => 'qrcode',
                            'ticket_status' => 'confirmed'
                        ]);
                        $update = Bookingreports::find($booking->id);
                        $update->reference_no = $reference_no;
                        $update->save();

                        $update = Bookingreportmeta::find($meta->id);
                        $update->reference_no = $reference_no;
                        $update->ticket_confirmed_from = 'qrcode';
                        $update->save();
                    }else{
                        //Confirm Ticket from API
                        $activity = Activity::find($meta->activity_id);
                        $adultCount = $meta->adultCount + $meta->allageCount;
                        $childCount = $meta->childCount;

                        $adultPrice = $meta->adultPrice;
                        $childPrice = $meta->childPrice;
                        $allagePrice = $meta->allagePrice;
                        $totalPrice = $meta->totalPrice;
                        if($adultPrice == 0 && $allagePrice > 0){
                            $adultPrice = $allagePrice;
                        }
                        
                        $prefix = 'Mr';
                        if($booking->gender != 'male'){
                            $prefix = 'Mrs';
                        }

                        $firstname = $booking->fullname;
                        $lastname = '';
                        $email = $booking->email;
                        $phone = '+'.$booking->country_code.$booking->phonenumber;
                        
                        $tourDetails = [];
                        if($meta->ticket_source == 'a'){
                            //Confirm ticket from rayna api
                            $random = random_int(100000, 999999);
                            $update = Bookingreportsapioptions::where('id', $option->id)->update(['service_unique_id' => $random]);
                            $tourDetails[0]["serviceUniqueId"] = $random;
                            $tourDetails[0]["tourId"] = $option->tour_id;
                            $tourDetails[0]["optionId"] = $option->option_id;
                            $tourDetails[0]["adult"] = $adultCount;
                            $tourDetails[0]["child"] = $childCount;
                            $tourDetails[0]["infant"] = 0;
                            $tourDetails[0]["tourDate"] = $meta->date;
                            $tourDetails[0]["timeSlotId"] = $meta->timeslot_id;
                            $tourDetails[0]["startTime"] = $meta->timeString;
                            $tourDetails[0]["transferId"] = $option->transfer_id;
                            $tourDetails[0]["adultRate"] = $option->rayna_adult_price;
                            $tourDetails[0]["childRate"] =  $option->rayna_child_price;
                            $tourDetails[0]["serviceTotal"] = $option->rayna_total_price;
                            $tourDetails[0]["pickup"] = "No Transfer Selected";

                            $slots = new Rayna();
                            $payload = [
                                "uniqueNo"=> $booking->bookingId.$option->id,
                                "tourDetails"=> $tourDetails,
                                "passengers"=> [
                                    0 => [
                                        "cartId"=> 0,
                                        "guestUserId"=> 0,
                                        "serviceType"=> "Tour",
                                        "prefix"=> $prefix,
                                        "firstName"=> $firstname,
                                        "lastName"=> $lastname,
                                        "email"=> "reservations@bookingbash.com",
                                        "mobile"=> "00971505601104",
                                        "nationality"=> "",
                                        "leadPassenger"=> 1
                                    ]
                                ]
                            ];

                            $response = $slots->fetchTicketBooking($payload);

                            try{
                                //update booking log
                                DB::table('booking_log')->insert([
                                    'bookingId' => $booking->bookingId,
                                    'optionId' => $option->option_id,
                                    'api_type' => 'Confirm Ticket',
                                    'api_request' => json_encode($payload),
                                    'api_response' => $response,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }catch(\Exception $e){
                                Log::info('************************************');
                                Log::info('ticketbooking-error:'.$booking->bookingId);
                                Log::info($e->getMessage()." - ".$e->getLine());
                                Log::info('************************************');
                            }
                            $slots = json_decode($response);

                            if(isset($slots->statuscode) && $slots->statuscode == 200 && isset($slots->result) && $slots->result != null){
                                if(isset($slots->result->details[0])){
                                    $details = $slots->result->details;
                                    foreach($details as $detail){
                                        $api_booking_id = $detail->bookingId;
                                        $service_unique_id = $detail->serviceUniqueId;
                                        $update = Bookingreportsapioptions::where('bookingId', $booking->bookingId)->where('metaId', $meta->id)->where('service_unique_id', $service_unique_id)->update(['api_booking_id' => $api_booking_id]);
                                    }
                                    $reference_no = $slots->result->referenceNo;
                                    $update = Bookingreportmeta::find($meta->id);
                                    $update->reference_no = $reference_no;
                                    $update->save();

                                    $update = Bookingreports::find($booking->id);
                                    $update->reference_no = $reference_no;
                                    $update->save();

                                    Bookingreportsapioptions::where('id', $option->id)->update(['reservation_no' => $reference_no, 'ticket_status' => 'confirmed']);

                                    $confirmed_from_api = $confirmed_from_api++;
                                }else{
                                    return response()->json(['status' => 'error', 'msg' => 'Rayna Api return empty response']);
                                }
                            }elseif(isset($slots->error) && isset($slots->error->description)){
                                return response()->json(['status' => 'error', 'msg' => $slots->error->description]);
                            }else{
                                return response()->json(['status' => 'error', 'msg' => 'Ticket confirmation in api failed.']);
                            }

                        }else if($meta->ticket_source == 'ph'){
                            //Confirm Ticket from Priohub
                            $distributor_id = '47000';
                            $name = explode(' ', $booking->fullname);
                            $first_name = $name[0];
                            $last_name = $name[1];


                            
                            $payload = [
                                'data' => [
                                    'order' => [
                                        'order_distributor_id' => $distributor_id,
                                        'order_external_reference' => Str::random(10),
                                        'order_language' => 'en',
                                        "order_contacts" => [
                                               0 => [
                                                    "contact_email" => 'reservations@bookingbash.com',
                                                    "contact_name_first" => $first_name,
                                                    "contact_name_last" => $last_name,
                                                    "contact_mobile" => '+971505601104'
                                                ]
                                            ],
                                        'order_bookings' => [
                                            0 => [
                                                'booking_option_type' => 'CONFIRM_RESERVATION',
                                                'reservation_reference' => $option->reservation_no
                                            ]
                                        ]
                                    ]
                                ]
                            ];

                            
                            $confirm = new Priohub();
                            $confirm = $confirm->confirmOrder($payload);
                            try{
                                //update booking log
                                DB::table('booking_log')->insert([
                                    'bookingId' => $booking->bookingId,
                                    'optionId' => $option->option_id,
                                    'api_type' => 'Confirm Ticket',
                                    'api_request' => json_encode($payload),
                                    'api_response' => $confirm,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }catch(\Exception $e){
                                Log::info('************************************');
                                Log::info('ticketbooking-error:'.$booking->bookingId);
                                Log::info($e->getMessage()." - ".$e->getLine());
                                Log::info('************************************');
                            }

                            $confirm =  json_decode($confirm);
                            if(isset($confirm->error_description)){
                                return response()->json(['status' => 'error', 'msg' => $confirm->error_description]);
                            }

                            $reference_no = $option->reservation_no;
                            Bookingreportsapioptions::where('id', $option->id)->update(['reservation_no' => $reference_no, 'ticket_status' => 'confirmed']);
                            $update = Bookingreportmeta::find($meta->id);
                            $update->reference_no = $reference_no;
                            $update->save();

                            $update = Bookingreports::find($booking->id);
                            $update->reference_no = $reference_no;
                            $update->save();

                            $confirmed_from_api++;
                        }
                    }
                } //option close
            }//Meta close

            if($current_option_id){
                $check = Bookingreportsapioptions::where('id', $current_option_id)->where('ticket_status', 'confirmed')->first();
                if($check){
                    return response()->json(['status' => 'success', 'msg' => 'Ticket confirmed']);
                }else{
                    return response()->json(['status' => 'success', 'msg' => 'Ticket not confirmed']);
                }
            }

            $metas = Bookingreportmeta::where('bookingreportId',$booking->id)->count();
            $completed_records = Bookingreportmeta::where('bookingreportId', $booking->id)->where('reference_no', '!=', NULL)->count();
            if($metas == $completed_records){

                try{
                    DB::table('auto_booking')->where('booking_id',$booking->id)->delete();
                }catch(\Exception $ss){
                }

                return response()->json(['status' => 'success', 'msg' => 'Tickets confirmed successfully. Total Tickets = '.$total_tickets.'. confirmed from qrcode = '.$confirmed_from_qrcode.'. confirmed from api = '.$confirmed_from_api]);
            }else{
                return response()->json(['status' => 'error', 'msg' => 'Tickets not confirmed.']);
            }
        }
        return response()->json(['status' => 'error', 'msg' => 'Booking details not available.']);
    }

    public function resetbooking(Request $req){
        $id = $req->id;
        $booking = Bookingreports::find($id);
        if($booking->ticketStatus == 'confirmed'){
           return response()->json(['status' => 'error', 'msg' => 'Ticket already confirmed']); 
        }
        $booking->action_status = '';
        $booking->save();
        return response()->json(['status' => 'success', 'msg' => 'Reset done']); 
    }

    public function autoprocesssetting(Request $req){
        $c = $req->c;
        if(Auth::User()->email != 'admin@bookingbash.com'){
             return response()->json(['status' => 'error', 'msg' => 'Failed']); 
        }
        DB::table('cms')->where('field_key','activity_auto_ticket')->update(['field_value'=>$c]);
        return response()->json(['status' => 'success', 'msg' => 'Settings updated']); 
    }

    public function apisendtickettopax(Request $req){
        try{
            $id = $req->id;
            $email = $req->email;
            $booking = Bookingreports::find($id);
            $tickets = [];
            if($booking && $email){
                $metas = Bookingreportmeta::where('bookingreportId',$booking->id)->get();
                foreach($metas as $meta){
                    $bookedOption = [];
                    $options = Bookingreportsapioptions::where('bookingreportId', $booking->id)->where('metaId', $meta->id)->orderBy('id', 'ASC')->get();
                    if($meta->ticket_source == 'a'){
                        foreach($options as $option){
                            if($option->ticket_confirmed_from == 'api'){
                                $slots = new Rayna();
                                $payload = [
                                    "uniqNO"=> $booking->bookingId.$option->id,
                                    "referenceNo" => $option->reservation_no,
                                    "bookedOption"=> [
                                        0 => [
                                            'serviceUniqueId' => $option->service_unique_id,
                                            'bookingID' => $option->api_booking_id
                                        ]
                                    ]
                                ];
                                $response = $slots->getTicketBooking($payload);

                                try{
                                    //update booking log
                                    DB::table('booking_log')->insert([
                                        'bookingId' => $booking->bookingId,
                                        'optionId' => $option->option_id,
                                        'api_type' => 'Ticket Details',
                                        'api_request' => json_encode($payload),
                                        'api_response' => $response,
                                        'created_at' => date('Y-m-d H:i:s'),
                                        'updated_at' => date('Y-m-d H:i:s')
                                    ]);
                                }catch(\Exception $e){
                                    Log::info('************************************');
                                    Log::info('getticket-error:'.$booking->bookingId);
                                    Log::info($e->getMessage()." - ".$e->getLine());
                                    Log::info('************************************');
                                }

                                $slots = json_decode($response);

                                if(isset($slots->statuscode) && $slots->statuscode == 200 && isset($slots->result) && $slots->result != null){
                                    $ticket_url = $slots->result->ticketURL;

                                    $rayna_optionName = $slots->result->optionName;
                                    $rayna_pnrNumber = $slots->result->pnrNumber;
                                    $rayna_printType = $slots->result->printType;
                                    $rayna_slot = $slots->result->slot;
                                    $rayna_validity = $slots->result->validity;
                                    $rayna_validityExtraDetails = $slots->result->validityExtraDetails;

                                    $rayna_ticket_details = $slots->result->ticketDetails;
                                    $check = DB::table('bookingreports_api_details')->where('bookingId', $booking->bookingId)->where('api_option_id', $option->id)->delete();
                                    foreach($rayna_ticket_details as $detail){
                                        $barCode = $detail->barCode;
                                        $guides = $detail->guides;
                                        $noOfAdult = $detail->noOfAdult;
                                        $noOfchild = $detail->noOfchild;
                                        $noOfinfant = $detail->noOfinfant;
                                        $optionName = $detail->optionName;
                                        $type = $detail->type;

                                        DB::table('bookingreports_api_details')->insert([
                                            'api_option_id' => $option->id,
                                            'bookingreportId' => $booking->id,
                                            'bookingId' => $booking->bookingId,
                                            'barCode' => $barCode,
                                            'guides' => $guides,
                                            'noOfAdult' => $noOfAdult,
                                            'noOfchild' => $noOfchild,
                                            'noOfinfant' => $noOfinfant,
                                            'optionName' => $optionName,
                                            'type' => $type
                                        ]);
                                    }

                                    $bookingreportsmeta = Bookingreportmeta::where('id',$meta->id)->update([
                                        'ticketStatus'=>'confirmed'
                                    ]);

                                    $update = Bookingreportsapioptions::where('id',$option->id)->update([
                                        'ticket_url' => $ticket_url,
                                        'api_optionName' => $rayna_optionName,
                                        'api_pnrNumber' => $rayna_pnrNumber,
                                        'api_printType' => $rayna_printType,
                                        'api_slot' => $rayna_slot,
                                        'api_validity' => $rayna_validity,
                                        'api_validity_extra_details' => $rayna_validityExtraDetails
                                    ]);
                                    
                                }elseif(isset($slots->error) && isset($slots->error->description)){
                                    return response()->json(['status' => 'error', 'msg' => $slots->error->description]);
                                }else{
                                    return response()->json(['status' => 'error', 'msg' => 'Ticket not sent. Api request failed.']);
                                }
                            }
                        }
                    }else if($meta->ticket_source == 'ph'){
                        foreach($options as $option){
                            //Priohub Ticket URL
                            $result = new Priohub();
                            $result = $result->getVoucher($option->reservation_no);
                            try{
                                //update booking log
                                DB::table('booking_log')->insert([
                                    'bookingId' => $booking->bookingId,
                                    'optionId' => $option->option_id,
                                    'api_type' => 'Ticket URL',
                                    'api_request' => $option->reservation_no,
                                    'api_response' => $result,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }catch(\Exception $e){
                                Log::info('************************************');
                                Log::info('getticket-error:'.$booking->bookingId);
                                Log::info($e->getMessage()." - ".$e->getLine());
                                Log::info('************************************');
                            }
                            $result = json_decode($result);
                            if(isset($result->error_description)){
                                return response()->json(['status' => 'error', 'msg' => $result->error_description]);
                            }
                            $ticket_url = '';
                            if(isset($result->url)){
                                $ticket_url = $result->url;
                            }
                            $update = Bookingreportsapioptions::where('id',$option->id)->update([
                                'ticket_url' => $ticket_url
                            ]);
                            $bookingreportsmeta = Bookingreportmeta::where('id',$meta->id)->update([
                                'ticketStatus'=>'confirmed'
                            ]);


                            //Priohub Order Details
                            $result = new Priohub();
                            $result = $result->getOrderDetails($option->reservation_no);
                            try{
                                //update booking log
                                DB::table('booking_log')->insert([
                                    'bookingId' => $booking->bookingId,
                                    'optionId' => $option->option_id,
                                    'api_type' => 'Ticket Details',
                                    'api_request' => $option->reservation_no,
                                    'api_response' => $result,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }catch(\Exception $e){
                                Log::info('************************************');
                                Log::info('getticket-error:'.$booking->bookingId);
                                Log::info($e->getMessage()." - ".$e->getLine());
                                Log::info('************************************');
                            }
                            $result = json_decode($result);
                            $check = DB::table('bookingreports_api_details')->where('bookingId', $booking->bookingId)->where('api_option_id', $option->id)->delete();
                            if(isset($result->data->order->order_status) && $result->data->order->order_status == 'ORDER_CONFIRMED'){
                                $order_bookings = $result->data->order->order_bookings;
                                foreach($order_bookings as $order_booking){
                                    $time_txt = '';
                                    //calculate from time
                                    if(isset($order_booking->product_availability_from_date_time) && $order_booking->product_availability_from_date_time){
                                        $from_time = explode('T', $order_booking->product_availability_from_date_time);
                                        if(count($from_time) == 2){
                                            $from_time = explode('+', $from_time[1]);
                                            if(count($from_time) == 2){
                                                $from_time = explode(':', $from_time[0]);
                                                if(count($from_time) == 3){
                                                    $time_txt = $from_time[0].":".$from_time[1];
                                                }
                                            }
                                        }
                                    }

                                    //calculate to time
                                    if(isset($order_booking->product_availability_to_date_time) && $order_booking->product_availability_to_date_time){
                                        $to_time = explode('T', $order_booking->product_availability_to_date_time);
                                        if(count($to_time) == 2){
                                            $to_time = explode('+', $to_time[1]);
                                            if(count($to_time) == 2){
                                                $to_time = explode(':', $to_time[0]);
                                                if(count($to_time) == 3){
                                                    $time_txt .= ' to '.$to_time[0].":".$to_time[1];
                                                }
                                            }
                                        }
                                    }

                                    if($time_txt){
                                        $bookingreportsmeta = Bookingreportmeta::where('id',$meta->id)->update([
                                            'timeString'=>$time_txt
                                        ]);
                                    }

                                    if(isset($order_booking->product_type_details)){
                                        $ticketTypes = $order_booking->product_type_details;
                                        foreach($ticketTypes as $type){
                                            $productType = strtolower($type->product_type);
                                            $adult_count = 0;
                                            $child_count = 0;
                                            if($productType == 'adult'){
                                                $adult_count = $type->product_type_pax;
                                            }else if($productType == 'child'){
                                                $child_count = $type->product_type_pax;
                                            }
                                            DB::table('bookingreports_api_details')->insert([
                                                'api_option_id' => $option->id,
                                                'bookingreportId' => $booking->id,
                                                'bookingId' => $booking->bookingId,
                                                'barCode' => $type->product_type_code,
                                                'noOfAdult' => $adult_count,
                                                'noOfchild' => $child_count,
                                                'noOfinfant' => 0,
                                                'optionName' => $meta->itemName,
                                                'ticket_url' => $ticket_url,
                                                'type' => strtolower($type->product_type)
                                            ]);
                                        }
                                    }
                                }
                                
                            }else{
                                $error_description = '';
                                if(isset($result->error_description)){
                                    $error_description = $result->error_description;
                                }
                                return response()->json(['status' => 'error', 'msg' => 'Priohub order details not returning expected response.', 'api_error' => $error_description]);
                            }
                        }
                    }

                    // Generate PDFticket
                    $activity = Activity::find($meta->activity_id);
                    $options = Bookingreportsapioptions::where('bookingreportId', $booking->id)->where('metaId', $meta->id)->orderBy('id', 'ASC')->get();
                    foreach($options as $option){
                        $api_details = DB::table('bookingreports_api_details')->where('api_option_id', $option->id)->where('bookingreportId', $booking->id)->get();
                        $html = view('admin/activities/ticket_pdf')->with(['booking' => $booking, 'meta' => $meta, 'activity' => $activity, 'api_details' => $api_details, 'option' => $option])->render();
                        $file_name = $booking->bookingId.$option->id;
                        File::put(public_path().'/uploads/'.$file_name.'.html',$html);
                        $pdf = PDF::loadFile(public_path().'/uploads/'.$file_name.'.html')->save(public_path().'/uploads/'.$file_name.'.pdf');
                        array_push($tickets, public_path().'/uploads/'.$file_name.'.pdf');
                    }

                    //send mail
                    Mail::send('emails.sendticket', ['tb'=>$booking], function($message) use ($tickets, $email){
                        $message->from('reservations@bookingbash.com', 'Bookingbash');
                        // foreach($tickets as $tic){
                        //     $message->attach($tic);
                        // }
                      $message->to($email, 'Bookingbash')->subject("Your booking is confirmed. Keep this handy.");
                    });
                    //send mail

                }
                                    
                return response()->json(['status' => 'success']);
            }
            return response()->json(['status' => 'error', 'msg' => 'Booking details not available.']);
        }catch(\Exception $e){
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'_'.$e->getLine()]);
        }
    }

    public function setfromtodate(Request $req){
        $input = $req->all();
        $from = $input['from'];
        $to = $input['to'];
        $rules=['from'=>'required|date','to'=>'required|date'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status'=>'validation', 'validation'=>$validation->messages()]);
        }
        if(strtotime($from) >= strtotime($to)){
            return response()->json(['status'=>'validation', 'validation'=>['from'=>['FROM date must be grater than TO date']]]);
        }
        $exceptday = [];
        $onlyday = [];
        if(isset($input['exceptday'])){
            $exceptday = $input['exceptday'];
        }
        if(isset($input['onlyday'])){
            $onlyday = $input['onlyday'];
        }
        $array = []; $onlyday = [];
        $startTime = strtotime($from); 
        $endTime = strtotime($to);
        for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
            $cdate = date( 'Y-m-d', $i );
            array_push($array, $cdate);
            //exceptday
            if(count($exceptday) != 0 && in_array(date('l',strtotime($cdate)), $exceptday)){
                array_pop($array);
            }
            //onlyday
            if(count($onlyday) != 0 && in_array(date('l',strtotime($cdate)), $onlyday)){
                array_push($onlyday, $cdate);
            }
        }
        if(count($onlyday) == 0){
            $explode = implode(', ',$array);
        }else{
            $explode = implode(', ',$onlyday);
        }
        return response()->json(['status'=>'success','dateRange'=>$explode]);
    }

    public function viewoptionids(Request $req){
        $input = $req->all();
        $bookingInfo = Bookingreports::find($input['id']);
        $bookingreportsmeta = Bookingreportmeta::where('bookingreportId',$bookingInfo->id)->get();
        $html = '<table class="table table-hover table-striped">
                        <tbody>
                            <tr>
                                <th>Item Name</th>
                                <th>Option ID</th>
                                <th>Action</th>
                            </tr>';
        foreach($bookingreportsmeta as $meta){
            $options = Bookingreportsapioptions::where('metaId',$meta->id)->get();
            foreach($options as $option){
                $html = $html.'<tr>
                                <td>'.$meta->itemName.'</td>
                                <td><input type="text" name="" id="option_'.$option->id.'" value="'.$option->option_id.'"></td>
                                <td><a href="javascript:;" class="btn btn-success updateOptionId" data-id="'.$option->id.'">Update</a></td>
                            </tr>';
            }
        }
        $html = $html.'</tbody></table>';
        return response()->json(['status'=>'success','template'=>$html]);
    }

    public function updateactivityoptionid(Request $req){
        $input = $req->all();
        $options = Bookingreportsapioptions::find($input['id']);
        $options->option_id = $input['option_id'];
        $options->save();
        return response()->json(['status'=>'success','msg'=>'Updated']);
    }

    public function activityticket($activity_id){
        $activity = Activity::find($activity_id);
        if($activity){
            $list = Ticket::where('activityId',$activity_id)->where('status', '!=', 'deleted')->get();
            return view('activities.ticket', compact('list'))->with(['activity'=>$activity]);
        }
        return redirect("/");
    }

    public function activityticketdelete(Request $req){
        $input = $req->all();
        $list = Ticket::where('id',$input['id'])->update(['status' => 'deleted']);
        return response()->json(['status'=>'success']);
    }

    public function addactivityticket($activity_id){
        $activity = Activity::find($activity_id);
        if($activity){
            $time = [];
            $seconds = 60;
            while($seconds <= 86400) {
              $time[$seconds] = gmdate("H:i", $seconds);
              $seconds += 60;
            }
            return view('activities.ticket-add', compact('activity', 'time'));
        }
        return redirect("/");
    }

    public function saveticketdates(Request $input){
        $input = $input->all();
        $timeslots = $input['timeslots'];

        //date validation start
            $tdate = explode(', ', $input['dates']);
            $rules=['dates'=>'required|date'];
            $in = [];
            foreach($tdate as $td){
                $in['dates'] = $td;
                $validation = Validator::make($in, $rules);
                if($validation->fails()){
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages(),'secno'=>'']);
                }
            }
        //date validation end

        $dateval = Ticket::where('activityId',$input['activity_id'])->get();
        foreach($dateval as $v){
            $array1 = explode(', ', $v->ticket_date);
            $array2 = $tdate;
            $result = array_intersect($array1, $array2);
            if(count($result) != 0){
                return response()->json(['status'=>'validation', 'validation'=>['date exist'=>['ticket date already exist for this activity']],'secno'=>'']);
            }
        }

        //time validation start
            $timeslot_array = [];
            if($timeslots){
                $timeslot_array = json_decode($timeslots);
            } 
            $rules=['from_time'=>'required|numeric','to_time'=>'required|numeric'];
            $in = [];
            foreach($timeslot_array as $slot){
                $in['from_time'] = $slot->from_time;
                $in['to_time'] = $slot->to_time;
                $validation = Validator::make($in, $rules);
                if($validation->fails()){
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages(),'secno'=>'']);
                }
            }
        //time validation end

        //Save Activity Ticket Dates
        $insert = new Ticket();
        $insert->activityId = $input['activity_id'];
        $insert->ticket_date = $input['dates'];
        $insert->userId = Auth::user()->id;
        if($input['status'] == 'active'){
            $insert->status = 'active';
        }else{
            $insert->status = 'inactive';
        }
        $insert->save();


        //Save activity ticket timeslots
        foreach($timeslot_array as $slot){
            $inserttimeslot = new Tickettimeslot();
            $inserttimeslot->ticketId = $insert->id;
            $inserttimeslot->activityId = $insert->activityId;
            $inserttimeslot->userId = Auth::user()->id;
            $inserttimeslot->from_slot = $slot->from_time;
            $inserttimeslot->to_slot = $slot->to_time;
            $inserttimeslot->save();
        }
        //timeslot
        return response()->json(['status'=>'success']);
    }


    public function editticketdates($activity_id, $ticket_id){
        $ticketInfo = Ticket::where('activityId',$activity_id)->where('id',$ticket_id)->first();
        if($ticketInfo){
            $time = [];
            $seconds = 60;
            while($seconds <= 86400) {
              $time[$seconds] = gmdate("H:i", $seconds);
              $seconds += 60;
            }
            $selected_dates = [];
            if($ticketInfo->ticket_date){
                $selected_dates = explode(', ', $ticketInfo->ticket_date);
            }
            $activity = Activity::find($activity_id);
            $timeslots = Tickettimeslot::where('ticketId', $ticket_id)->where('activityId', $activity_id)->orderBy('id')->get();
            return View('activities.ticket-date-edit', compact('activity', 'ticketInfo', 'time', 'selected_dates', 'timeslots'));
        }
    }


    public function updateticketdates(Request $input){
        $input = $input->all();
        $timeslots = $input['timeslots'];

        $tinfo = Ticket::find($input['ticket_id']);
        if(!$tinfo){
            return response()->json(['status' => 'error']);
        }
        $ticket_source = Activity::find($input['activity_id'])->first()->ticket_source;
        //date validation start
            $tdate = explode(', ', $input['dates']);
            $rules=['dates'=>'required|date'];
            foreach($tdate as $td){
                $in['dates'] = $td;
                $validation = Validator::make($in, $rules);
                if($validation->fails()){
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages(),'secno'=>'']);
                }
            }
        //date validation end

        $dateval = Ticket::where('activityId',$tinfo->activityId)->where('id','!=',$tinfo->id)->get();
        foreach($dateval as $v){
            $array1 = explode(', ', $v->ticket_date);
            $array2 = $tdate;
            $result = array_intersect($array1, $array2);
            if(count($result) != 0){
                return response()->json(['status'=>'validation', 'validation'=>['date exist'=>['ticket date already exist for this activity']],'secno'=>'']);
            }
        }
        
        //time validation start
            $timeslot_array = [];
            if($timeslots){
                $timeslot_array = json_decode($timeslots);
            } 
            $rules=['from_time'=>'required|numeric','to_time'=>'required|numeric'];
            $in = [];
            foreach($timeslot_array as $slot){
                $in['from_time'] = $slot->from_time;
                $in['to_time'] = $slot->to_time;
                $validation = Validator::make($in, $rules);
                if($validation->fails()){
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages(),'secno'=>'']);
                }
            }
        //time validation end

        $insert = Ticket::find($input['ticket_id']);
        $insert->ticket_date = $input['dates'];
        $insert->userId = Auth::user()->id;
        $insert->status = strtolower($input['status']);
        $insert->save();
        //ticket

        $remove = Tickettimeslot::where('activityId',$insert->activityId)->where('ticketId',$input['ticket_id'])->delete();
        foreach($timeslot_array as $slot){
            $inserttimeslot = new Tickettimeslot();
            $inserttimeslot->ticketId = $insert->id;
            $inserttimeslot->activityId = $insert->activityId;
            $inserttimeslot->userId = Auth::user()->id;
            $inserttimeslot->from_slot = $slot->from_time;
            $inserttimeslot->to_slot = $slot->to_time;
            $inserttimeslot->save();
        }
        return response()->json(['status'=>'success']);
    }

    public function editticketitems($activity_id, $ticket_id){
        $ticketInfo = Ticket::where('activityId',$activity_id)->where('id',$ticket_id)->first();
        if($ticketInfo){
            $activity = Activity::find($activity_id);
            return View('activities.ticket-items-edit', compact('activity', 'ticketInfo'));
        }
    }

    public function savesection(Request $req){
        $input = $req->all();

        $rules=['name'=>'required'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status'=>'validation', 'validation'=>$validation->messages()]);
        }

        if($input['section_id']){
            $insertsec = Ticketsection::find($input['section_id']);
        }else{
            $insertsec = new Ticketsection();
            $insertsec->userId = Auth::user()->id;
        }
        $insertsec->ticketId = $input['ticket_id'];
        $insertsec->activityId = $input['activity_id'];
        $insertsec->section_name = $input['name'];
        $insertsec->save();
        return response()->json(['status' => 'success']);
    }

    public function getsections(Request $req){
        $input = $req->all();
        $sections = Ticketsection::where('ticketId', $req->ticket_id)->where('activityId', $req->activity_id)->orderBy('id')->get();
        $html = view('activities/ticket-items-table')->with(['sections' => $sections])->render();
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function saveitemdetails(Request $req){
        $input = $req->all();

        $rules=[
            'item_description'=>'required',
            'item_name'=>'required',
            'price_type'=>'required',
            'allage_price'=>'nullable|required_if:price_type,allage|numeric',
            'adult_price'=>'nullable|required_if:price_type,adult|numeric',
            'adult_price'=>'nullable|required_if:price_type,adultandchild|numeric',
            'child_price'=>'nullable|required_if:price_type,child|numeric',
            'child_price'=>'nullable|required_if:price_type,adultandchild|numeric'
        ];

        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status'=>'validation', 'validation'=>$validation->messages()]);
        }

        $minimum_ticket = NULL;
        $sorting = NULL;
        $maximum_ticket = NULL;
        if($input['minimum_ticket']){
            $minimum_ticket = $input['minimum_ticket'];
        }

        if($input['maximum_ticket']){
            $maximum_ticket = $input['maximum_ticket'];
        }

        if($input['sorting_position']){
            $sorting = $input['sorting_position'];
        }

        if($input['item_id']){
            $insertitem = Ticketitem::find($input['item_id']);
        }else{
            $insertitem = new Ticketitem();
            $insertitem->userId = Auth::user()->id;
        }
        
        $insertitem->ticketId = $input['ticket_id'];
        $insertitem->sectionId = $input['section_id'];
        $insertitem->activityId = $input['activity_id'];
        $insertitem->sorting = $sorting;
        $insertitem->maximum_ticket = $maximum_ticket;
        $insertitem->minimum_ticket = $minimum_ticket;
        $insertitem->item_name = $input['item_name'];
        $insertitem->item_desc = $input['item_description'];
        $insertitem->price_type = $input['price_type'];
        if($input['price_type'] == 'adult' || $input['price_type'] == 'adultandchild'){
            $insertitem->adult_price = $input['adult_price'];
            $insertitem->adult_price1 = $input['adult_price1'];
        }
        if($input['price_type'] == 'child' || $input['price_type'] == 'adultandchild'){
            $insertitem->child_price = $input['child_price'];
            $insertitem->child_price1 = $input['child_price1'];
        }
        if($input['price_type'] == 'allage'){
            $insertitem->allage_price = $input['allage_price'];
            $insertitem->allage_price1 = $input['allage_price1'];
        }
        $insertitem->save();


        //Save Tour Option IDS
        Ticketitemapioptions::where("ticket_item_id", $insertitem->id)->delete();
        $touroptions = $input['touroptions'];
        $options = [];
        if($touroptions){
            $options = json_decode($touroptions);
        }

        $contract_id = env('RAYNA_CONTRACT_ID');
        $transfer_id = env('RAYNA_TRANSFER_ID');

        foreach($options as $option){
            $insertoption = new Ticketitemapioptions();
            $insertoption->activityId = $input['activity_id'];
            $insertoption->ticketId = $input['ticket_id'];
            $insertoption->ticket_item_id = $insertitem->id;
            $insertoption->api_tour_id = $option->tour_id;
            $insertoption->api_tourOptionId = $option->option_id;
            $insertoption->api_contract_id = $contract_id;
            $insertoption->api_transferId = $transfer_id;
            $insertoption->save();
        }
        return response()->json(['status' => 'success']);
    }

    public function getitemdetails(Request $req){
        $item_id = $req->item_id;
        $item = Ticketitem::find($item_id);
        if(!$item){
            return response()->json(['status' => 'error', 'message' => 'Ticket item not available.']);
        }
        $options = Ticketitemapioptions::where('ticket_item_id', $item_id)->orderBy('id')->get();
        $html = '';
        foreach($options as $option){
            $html.='<div class="row optionDiv">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="required form-label">Tour ID</label>
                                <input type="text" name="tour_id" class="form-control tour_id" placeholder="Tour ID" value="'.$option->api_tour_id.'">
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="required form-label">Option ID</label>
                                <input type="text" name="option_id" class="form-control option_id" placeholder="Option ID" value="'.$option->api_tourOptionId.'">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <a href="javascript:;" class="addOption" style="font-size:18px;"><i class="fa fa-plus-circle" ></i></a>
                            <a href="javascript:;" class="deleteOption" style="font-size:18px;color:red;display:none;"><i class="fa fa-minus-circle"></i></a>
                        </div>
                    </div>';
        }

        return response()->json(['status' => 'success', 'item' => $item, 'html' => $html]);
    }

}
