<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extras;
use App\Models\Cms;
use App\Models\Categorygallery;
use Auth;
use DB;
use Session;
use Validator;
use Illuminate\Support\Str;
use App\Models\Sitelog;
use App\Models\Modules;
use App\Models\Modulechapter;
use App\Models\Certificate;
use App\Exports\CertificateExcel;
use Maatwebsite\Excel\Facades\Excel;

class ModuleController extends Controller
{
    function __construct(){
       
    }

    public function modulecreate(){
        return view('modules/create');
    }

    public function modulesave(Request $req){
        $input = $req->all();
        $rules =[
            'title' => 'required|unique:modules,title',
            'category' => 'required',
            'description' => 'required',
            'banner_image' => 'required',
            'status' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        $slug = \Str::slug($input['title'], '-');


        $insert = new Modules();
        $insert->title = $input['title'];
        $insert->slug = $slug;
        $insert->category = $input['category'];
        $insert->banner_image = $input['banner_image'];
        $insert->description = $input['description'];
        $insert->status = $input['status'];
        $insert->save();
        return back()->with('success', 'New module created successfully');
    }

    public function moduleview(){
        $records = Modules::paginate(10);
        return view('modules.view', compact('records'));
    }

    public function modulelist(Request $req){
        try{
            $search = $req->search;
            $records = Modules::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('title', 'LIKE', '%'.$search.'%')->orWhere('description', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('modules.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function moduleedit($id){
        $record = Modules::find($id);
        if(!$record){
            return back();
        }
        $chapters = Modulechapter::where('module_id',$id)->take(50)->get();
        return view('modules/edit', compact('record','chapters'));
    }

    public function moduleupdate(Request $req){
        $input = $req->all();
         $rules =[
            'title' => 'required|unique:modules,title,'.$input['editid'],
            'category' => 'required',
            'description' => 'required',
            'banner_image' => 'required',
            'status' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        $slug = \Str::slug($input['title'], '-');
        $update = Modules::find($input['editid']);
        $update->title = $input['title'];
        $update->slug = $slug;
        $update->category = $input['category'];
        $update->banner_image = $input['banner_image'];
        $update->description = $input['description'];
        $update->status = $input['status'];
        $update->save();

        return back()->with('success', 'Module details updated successfully');

    }

    public function addmodulechapter(Request $req){
        $input = $req->all();
        $record = Modules::find($input['editid']);
        if(!$record){
            return response()->json(['status'=>'error','msg'=>'Record not found']);
        }
         $rules =[
            'title' => 'required',
            'duration' => 'required|integer',
            'description' => 'required',
            'url' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
        }
        $insert = new Modulechapter();
        $insert->title = $input['title'];
        $insert->duration = $input['duration'];
        $insert->description = $input['description'];
        $insert->video_url = $input['url'];
        $insert->module_id = $input['editid'];
        $insert->status = 'active';
        $insert->save();
        return response()->json(['status'=>'success','msg'=>'New chapter added successfully']);
    }

    public function updatemodulechapter(Request $req){
        $input = $req->all();
        $record = Modules::find($input['editid']);
        if(!$record){
            return response()->json(['status'=>'error','msg'=>'Record not found']);
        }
        $chapter = Modulechapter::find($input['chapter_id']);
        if(!$chapter){
            return response()->json(['status'=>'error','msg'=>'Record not found']);
        }
         $rules =[
            'title' => 'required',
            'duration' => 'required|integer',
            'description' => 'required',
            'url' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return response()->json(['status'=>'error','msg'=>$validation->messages()->first()]);
        }
        $chapter->title = $input['title'];
        $chapter->duration = $input['duration'];
        $chapter->description = $input['description'];
        $chapter->video_url = $input['url'];
        $chapter->save();
        return response()->json(['status'=>'success','msg'=>'Chapter updated successfully']);
    }

    public function certificates(){
        return view('modules.certificate-view');
    }

    public function certificateslist(Request $req){
        $search = $req->search;
        $records = Certificate::orderBy('id', 'DESC');
        if($search){
            $records = $records->where('first_name', 'LIKE', '%'.$search.'%')->orWhere('last_name', 'LIKE', '%'.$search.'%');
        }
        $records = $records->paginate(10);
        $html = view('modules.certificate-view-table', compact('records'))->render();
        return response()->json(['status' => 'success', 'data' => $html]);
    }

    public function certificatesexcel (){
        return Excel::download(new CertificateExcel, 'certificates.xlsx');
    }

}
