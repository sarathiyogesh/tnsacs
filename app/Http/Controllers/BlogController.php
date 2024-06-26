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
            $records = Blog::orderBy('date','DESC');
            if($search){
                $records = $records->where('title', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);

            foreach($records as $record){
                $record->author = User::getName($record->created_by);
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
                'date' => 'required|date',
                'feature_image' => 'required',
                //'description' => 'required',
                'short_description' => 'required'
            ];
            $message = [ 'required' => 'this field is required.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $data['slug'] = \Str::slug($data['title'], '-');
            $data['created_by'] = Auth::user()->id;
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            $save = Blog::create($data);
            return back()->with('success', 'New post is created successfully');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function editpost($post_id){
        $record = Blog::find($post_id);
        return view('blogs.posts.edit', compact('record'));
    }


    public function updatepost(Request $req){
        try{
            $data = $req->all();
            $rules = [
                'title' => 'required|min:1|max:5000|unique:blogs,title,'.$req->editId.',id',
                'status' => 'required',
                'date' => 'required|date',
                'feature_image' => 'required',
                //'description' => 'required',
                'short_description' => 'required'
            ];
            $message = [ 'required' => 'this field is required.'];
            $validation = Validator::make($data, $rules, $message);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $data['slug'] = \Str::slug($data['title'], '-');
            $data['date'] = date('Y-m-d', strtotime($data['date']));
            $save = Blog::find($req->editId)->update($data);
            return back()->with('success', 'Post details has been updated successfully');
            return response()->json(['status' => 'success', 'msg' => 'Post is updated successfully.']);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

}
