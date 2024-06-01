<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Str;
use DB;
use Validator;
use App\Models\Blog;
use App\Models\User;
use App\Models\BlogTag;
use App\Models\Utility;
use Auth;
use App\Models\BlogCategoryMap;
use App\Models\BlogTagMap;

class BlogController extends Controller
{

    //Post
    public function viewpost(){
        
        return view('blogs.posts.view');
    }

    public function getpost(Request $req){
        try{
            $search = $req->search;
            $records = Blog::orderBy('post_id','DESC');
            if($search){
                $records = $records->where('post_title', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);

            foreach($records as $record){
                $record->author = User::getName($record->posted_by);
            }
            $html = view('blogs.posts.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addpost(){
        return View('blogs.posts.create');
    }

    public function savepost(Request $req){
         try{
            $data = $req->all();
            $rules = [
                'title' => 'required|unique:blogs,title|min:1|max:5000',
                'status' => 'required',
                'description' => 'required'
            ];
            $message = [ 'required' => 'this field is required.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }

            $data['slug'] = \Str::slug($data['title'], '_');


           // Featured image validation
            if(isset($data['post_featured_string']) && $data['post_featured_string']){
                $filename = Str::random(6).'-'.time().'.jpg';
                $upload = Utility::uploadPostFile($data['post_featured_string'], $filename);
                if($upload){
                    // new image is uploaded remove the old one
                    if($data['featured_image']){
                        $file = explode('/',$data['featured_image']);
                        $file = end($file);
                        Utility::deleteUploadedPostFile($file);
                    }
                    // set new uploaded file URL
                    $data['featured_image'] = $upload;
                }
            }

            $data['posted_by'] = Auth::user()->id;

            $save = BlogPost::savePost($data);

            //return Response::json(['status'=>'success','post_id'=>$save]);
        return response()->json(['status' => 'success', 'msg' => 'New post is created successfully.']);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function getpostslug(Request $req){
        $title = $req->title;
        $slug = \Str::slug($title, '_');
         return response()->json(['status' => 'success', 'slug' => $slug]);
    }

    public function changestatus(Request $req){
        try{
            $post_id = $req->input('post_id');
            $post = BlogPost::where('post_id',$post_id)->first();
            if($post){
                if($post->status == 'inactive'){
                    $post->status = 'active'; 
                }else{
                    $post->status = 'inactive';
                }
                if($post->save()){
                    return response()->json(['status'=>'success','msg'=>'Status is changed successfully.']);
                }
            }
            return response()->json(['status'=>'error','msg'=>'Error processing your request.']);
        }catch(Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->messages()]);
        }
    }

    public function editpost($post_id){
        $categories = BlogCategory::getAll();
        $subcategories = BlogCategory::getAll();
        $tags = BlogTag::getAll();

        $record = BlogPost::find($post_id);
        $selected_categories = BlogCategoryMap::where('post_id',$post_id)->where('type','parent')->pluck('category_id')->toArray();
        $selected_subcategories = BlogCategoryMap::where('post_id',$post_id)->where('type','child')->pluck('category_id')->toArray();
        
        $chosenTags = BlogTagMap::where('post_id',$post_id)->pluck('tag_id')->toArray();
        // $selected_tags = BlogTag::whereIn('tag_id',$chosenTags)->select('tag_name as text')->get();

        return view('blogs.posts.edit', compact('record','categories','tags', 'selected_categories', 'selected_subcategories', 'chosenTags'));
    }


    public function updatepost(Request $req){
        try{
            $data = $req->all();
            $data['categories'] = explode(',', $data['categories']);
            $data['tags'] = explode(',', $data['tags']);
            $rules = [
                'post_title' => 'required|min:1|max:5000|unique:blog_post,post_title,'.$req->post_id.',post_id',
                'status' => 'required',
                'post_featured_string' => 'nullable|mimes:jpg,jpeg,png,svg'
            ];
            $message = [ 'required' => 'this field is required.', 'mimes' => 'Please check your image format.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
            }

            // $data['post_title_slug'] = \Str::slug($data['post_title'], '_');


           // Featured image validation
            if(isset($data['post_featured_string']) && $data['post_featured_string']){
                $filename = Str::random(6).'-'.time().'.jpg';
                $upload = Utility::uploadPostFile($data['post_featured_string'], $filename, 720, '');
                if($upload){
                    // new image is uploaded remove the old one
                    if($data['featured_image']){
                        $file = explode('/',$data['featured_image']);
                        $file = end($file);
                        Utility::deleteUploadedPostFile($file);
                    }
                    // set new uploaded file URL
                    $data['featured_image'] = $upload;
                }
            }

            $data['updated_by'] = Auth::user()->id;

            $save = BlogPost::updatePost($data);

            //return Response::json(['status'=>'success','post_id'=>$save]);
        return response()->json(['status' => 'success', 'msg' => 'Post is updated successfully.']);

        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

}
