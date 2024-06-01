<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view("media.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view("media.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MediaRequest $request)
    {
        // $input = $request->input();
        // $fileUrl = '';
        // if ($request->hasFile('mediaFile')) {
        //     $file = $request->file('mediaFile');
        //     $destinationPath = 'backend/uploads/media/'; // upload path
        //     $getName = $file->getClientOriginalName();
        //     $fileName = $getName; // renameing image
        //     $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
        //     $img_url = $destinationPath . $fileName;
        //     $fileUrl = asset($img_url);
        // }
        // $insert = new Media();
        // $insert->vendor_id = $this->vendor->id;
        // $insert->image_link = $fileUrl;
        // $insert->created_by = Auth::id();
        // $insert->status = "active";
        // $insert->save();
        // return back()->with("success", "New media added successfully");
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function updatemediastatus(Request $req) {
        $input = $req->input('id');
        $media = Media::find($input);
        $status = $media->status == "active" ? $current = "inactive" : $current = "active";
        $media->status = $current;
        $media->save();
        return response()->json(["status" => "success", "current" => ucfirst($current), "msg" => "Updated Successfully"]);
    }

    public function mediatemplate(Request $req) {
        $options = $this->getmediatemplateoptions($req);
        return view("media.mediatemplate",compact('options'));
    }

    public function searchmediadata(Request $req) {
         try {
            $input = $req->all();
            $records = Media::where("status", "!=", "deleted");
            $records = $records->orderBy('id', 'DESC')->paginate(5);
            $options = $this->getmediatemplateoptions($req);
            return view('media.media_data_table',compact('records','options'))->render();
        } catch (Exception $e) {
            return response()->json(["status" => "failure", "msg" => $e->getMessage()]);
        }
    }

    public function getmediatemplateoptions($req) {
        $options = [];
        if(!$req->has('select')) { $options['select'] = 'no'; }else{ $options['select'] = $req->select; }
        if(!$req->has('select_type')) { $options['select_type'] = 'single'; }else{ $options['select_type'] = $req->select_type; }
        if(!$req->has('delete')) { $options['delete'] = 'no'; }else{ $options['delete'] = $req->delete; }
        if(!$req->has('input_name')) { $options['input_name'] = 'image_holder_input'; }else{ $options['input_name'] = $req->input_name; }
        //if(!$req->has('copy')) { $options['copy'] = false; }else{ $options['copy'] = $req->copy; }
        return $options;
    }


    public function mediaupload(Request $request){
       try {
            $input = $request->input();
            $fileUrl = '';
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $destinationPath = 'backend/uploads/media/';
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();

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
                    $filename_withoutextension = pathinfo($tmp_name,PATHINFO_FILENAME);

                //insert 
                    $insert = new Media();
                    $insert->image_link = $img_url;
                    $insert->file_path = $destinationPath;
                    $insert->file_extension = $extension;
                    $insert->file_name = $filename_withoutextension;
                    $insert->created_by = Auth::id();
                    $insert->status = "active";
                    $insert->save();

                return response()->json(['status'=>'success','input'=>$input], 200);
            }else{
                return response()->json(['status'=>'error','msg'=>'Errorrrr'], 404);
            }
       }catch(\Exception $e) {
            return response()->json(['status'=>'error','msg'=>$e->getMessage()], 404);  
       }
        
    }



}
