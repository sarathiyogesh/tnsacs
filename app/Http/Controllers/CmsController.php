<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MediaRequest;
use App\Models\Pages;
use App\Models\Customfieldsection;
use App\Models\Customfield;
use App\Models\Customfieldmeta;
use Illuminate\Support\Facades\Auth;
use Validator;

class CmsController extends Controller
{

    public function cmspage()
    {
        $pages = Pages::where('status', 'active')->get();
        return view("cms.index", compact('pages'));
    }

    public function cmspagetemplate($id)
    {
        $pages = Pages::find($id);
        if($pages){
           return view("cms.pagetemplate", compact('pages')); 
        }
        return back();
    }

    public function cmspagecontent($id)
    {
        $page = Pages::find($id);
        if($page){
            $custom_fields = Customfield::Page($id)->select('asset_master_id','custom_fields_section_id','user_id')->groupBy('custom_fields_section_id','asset_master_id','user_id')->get();
           return view("cms.pagecontent", compact('page','custom_fields')); 
        }
        return back();
    }

    public function contenttemplate(Request $req)
    {   
        $input = $req->all();
        $asset_master_id = $input['cms_page_id'];
        $custom_fields = Customfield::Page($asset_master_id)->select('asset_master_id','custom_fields_section_id','user_id')->groupBy('asset_master_id','custom_fields_section_id','user_id')->get();
        $template = 'yes';
        $customfield_preview_template = view('cms.customfield_preview_template')->with('custom_fields', $custom_fields)->with('asset_master_id',$asset_master_id)->with('template',$template)->render();
        return response()->json(['status'=>'success','template'=>$customfield_preview_template]);
    }

    public function contenttemplateposition(Request $req){
        try{
            $input = $req->all();
            $sec_id = $req->sec_id;
            $positions = $req->positions;
            $i = 1;
            foreach($positions as $po) {
                $update = Customfield::Section($sec_id)->where('id',$po)->first();
                if($update){
                     $update->sort_order = $i;
                     $update->save();
                     $i++;
                }
            }
            return response()->json(['status'=>'success','msg'=>'Position updated']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcustomfields(Request $req){
        try{
            $input = $req->all();
            $add_type = $input['add_type'];
            $update_field_id = $input['update_field_id'];
            $section_id = $input['section_id'];
            $field_type = $input['field_type'];
            $label_name = $input['label_name'];
            $field_slug = \Str::slug($input['field_slug'], '_');
            $column_length = $input['field_column_length'];
            $is_required = $input['is_required'];
            $options = $input['options'];
            $asset_master_id = $input['cms_page_id'];
            //validation
                $rules = [
                            'field_type' => 'required',
                            'label_name' => 'required',
                            'field_slug' => 'nullable|sometimes|unique:custom_fields,field_slug',
                        ];
                $msg = [];
                $validation = Validator::make($input, $rules, $msg);
                if ($validation->fails()) {
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages()]);
                }
            //validation
                $list = ['basic_detail', 'site_detail', 'photos', 'depreciation', 'funding'];
                if(in_array($section_id, $list)){
                    $custom_fields_section_id = NULL;
                    $default_fields_section_id = $section_id;
                    $section_name = \Str::slug('custom fields', '_');
                }else{
                    $section_id = decrypt($section_id);
                    $exist = Customfieldsection::where('id', $section_id)->where('user_id', Auth::id())->first();
                    if(!$exist){
                        return response()->json(['status'=>'error', 'msg' => 'Selected Section not found']);
                    }
                    $custom_fields_section_id = $exist->id;
                    $default_fields_section_id = NULL;
                    $section_name = \Str::slug($exist->section_name, '_');
                }
                if($add_type == 'add'){
                    $insert = new Customfield();
                    $msg = 'New field added';
                }else{
                    $msg = 'Field updated';
                    $insert = Customfield::find(decrypt($input['update_field_id']));
                    if(!$insert){
                        return response()->json(['status'=>'error','msg'=>'Field not found']);
                    }
                }
                $insert->custom_fields_section_id = $custom_fields_section_id;
                $insert->default_fields_section_id = $default_fields_section_id;
                $insert->field_type = $field_type;
                $insert->label_name = $label_name;
                $insert->field_slug = \Str::slug($field_slug, '_');
                $insert->column_length = $column_length;
                $insert->is_required = $is_required;
                $insert->asset_master_id = $asset_master_id;
                $insert->status = 'active';
                $insert->user_id = Auth::id();
                $insert->save();

                if($insert->field_slug == '') {
                    $field_slug = $section_name.'-'.$insert->id;
                    $insert->field_slug = \Str::slug($field_slug, '_');
                    $insert->save();
                }

                $delete = Customfieldmeta::where('custom_field_id', $insert->id)->delete();
                if($field_type == 'dropdown' || $field_type == 'checkbox' || $field_type == 'radio'){
                    $options = json_decode($options);
                    foreach($options as $option){
                        $insertmeta = new Customfieldmeta();
                        $insertmeta->field_value = $option;
                        $insertmeta->custom_field_id = $insert->id;
                        $insertmeta->save();
                    }
                }
                return response()->json(['status'=>'success','msg'=>$msg]);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }


    public function addcustomfieldssection(Request $req){
        try{
            $input = $req->all();
            $asset_master_id = $input['cms_page_id'];
            $sec_name = $input['sec_name'];

            //validation
                $rules = [ 'sec_name' => 'required' ];
                $msg = ['required'=>'Section name required'];
                $validation = Validator::make($input, $rules, $msg);
                if ($validation->fails()) {
                    return response()->json(['status'=>'validation', 'validation'=>$validation->messages()]);
                }
            //validation

            $insert = new Customfieldsection();
            $insert->asset_master_id = $asset_master_id;
            $insert->user_id = Auth::id();
            $insert->section_name = $sec_name;
            $insert->save();
            return response()->json(['status'=>'success','msg'=>'New section added']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }


    public function removecustomfieldssection(Request $req){
        try{
            $input = $req->all();
            $asset_master_id = $input['cms_page_id'];
            $sec_id = decrypt($input['sec_id']);
            $section_info = Customfieldsection::where('id',$sec_id)->where('user_id', Auth::id())->where('asset_master_id', $asset_master_id)->first();
            if($section_info){
                $custom_field_id = Customfield::where('custom_fields_section_id', $sec_id)->pluck('id');
                Customfield::where('custom_fields_section_id', $sec_id)->delete();
                Customfieldmeta::whereIn('custom_field_id', $custom_field_id)->delete();
                Customfieldsection::where('id', $sec_id)->delete();
                return response()->json(['status'=>'success','msg'=>'Section removed']);
            }
            return response()->json(['status'=>'error','msg'=>'Section not found']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function removecustomfieldssingle(Request $req){
        try{
            $input = $req->all();
            $asset_master_id = $input['cms_page_id'];
            $field_id = decrypt($input['field_id']);
            $custom_fields_info = Customfield::where('id',$field_id)->where('user_id', Auth::id())->where('asset_master_id', $asset_master_id)->first();
            if($custom_fields_info){
                Customfield::where('id', $field_id)->delete();
                Customfieldmeta::where('custom_field_id', $field_id)->delete();
                return response()->json(['status'=>'success','msg'=>'Field removed']);
            }
            return response()->json(['status'=>'error','msg'=>'Field not found']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function editcustomfieldssingle(Request $req){
        try{
            $input = $req->all();
            $asset_master_id = $input['cms_page_id'];
            $field_id = decrypt($input['field_id']);
            $custom_fields_info = Customfield::where('id',$field_id)->where('user_id', Auth::id())->where('asset_master_id', $asset_master_id)->first();
            if($custom_fields_info){
                $info = [];
                if($custom_fields_info->default_fields_section_id == NULL){
                    $section_name = Customfieldsection::section_name($custom_fields_info->custom_fields_section_id);
                    $info['sec_id'] = encrypt($custom_fields_info->custom_fields_section_id);
                }else{
                    $section_name = Customfield::section_name($custom_fields_info->default_fields_section_id);
                    $info['sec_id'] = $custom_fields_info->default_fields_section_id;
                }
                $info['section_name'] = $section_name;
                $info['column_length'] = $custom_fields_info->column_length;
                $info['field_type'] = $custom_fields_info->field_type;
                $info['label_name'] = $custom_fields_info->label_name;
                $info['is_required'] = $custom_fields_info->is_required;
                $info['update_field_id'] = encrypt($custom_fields_info->id);
                $options = [];
                if($custom_fields_info->field_type == 'dropdown' || $custom_fields_info->field_type == 'checkbox' || $custom_fields_info->field_type == 'radio'){
                    $meta_info = Customfieldmeta::where('custom_field_id', $field_id)->orderBy('id', 'ASC')->select('field_value')->get();
                    foreach($meta_info as $meta){
                        array_push($options, $meta->field_value);
                    }
                    $info['options'] = $options;
                }
                return response()->json(['status'=>'success','info'=>$info]);
            }
            return response()->json(['status'=>'error','msg'=>'Field not found']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }


    public function cmscontentupdate(Request $req){
        try{
            $input = $req->all();
            $page_id = $input['page_id'];
            $section_id = $input['section_id'];
            $custom_fields_info = Customfield::Section($section_id)->Page($page_id)->select('default_fields_section_id','asset_master_id','field_slug','field_type','id')->get();
            foreach ($custom_fields_info as $info) {
                if($req->has($info->field_slug)) {
                    $update = Customfield::find($info->id);
                    $update->field_value = $input[$info->field_slug];
                    $update->save();
                }
            }
            return response()->json(['status'=>'success','msg'=>'Content updated']);
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'__'.$e->getLine()]);
        }
    }


}
