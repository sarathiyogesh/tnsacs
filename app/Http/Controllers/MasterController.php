<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Extras;
use App\Models\Cms;
use App\Models\Genre;
use App\Models\Tag;
use App\Models\ActivityTagMap;
use App\Models\Category;
use App\Models\Subject;
use App\Models\Categorygallery;
use Auth;
use DB;
use Session;
use Validator;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\CountryCity;
use App\Models\Sitelog;
use App\Models\Faq;

class MasterController extends Controller
{
    function __construct(){
        $this->middleware('permission:genre-view|genre-add|genre-edit', ['only' => ['genrepage', 'genreview']]);
        $this->middleware('permission:genre-add', ['only' => ['addgenre']]);
        $this->middleware('permission:genre-edit', ['only' => [ 'updategenre', 'deletegenre']]);

        $this->middleware('permission:tags-view|tags-add|tags-edit', ['only' => ['tagpage', 'tagview']]);
        $this->middleware('permission:tags-add', ['only' => ['addtag']]);
        $this->middleware('permission:tags-edit', ['only' => [ 'updatetag', 'deletetag']]);

        $this->middleware('permission:country-view|country-add|country-edit', ['only' => ['countrypage', 'countryview']]);
        $this->middleware('permission:country-add', ['only' => ['addcountry']]);
        $this->middleware('permission:country-edit', ['only' => [ 'updatecountry', 'deletecountry']]);

        $this->middleware('permission:city-view|city-add|city-edit', ['only' => ['citypage', 'cityview']]);
        $this->middleware('permission:city-add', ['only' => ['addcity']]);
        $this->middleware('permission:city-edit', ['only' => [ 'updatecity', 'deletecity']]);

        $this->middleware('permission:course-category', ['only' => ['categorypage','categoryview','addcategorypage','addcategory','updatecategory','editcategorypage','deletecategory']]);
        $this->middleware('permission:course-subject', ['only' => ['subjectpage','subjectview','addsubjectpage','addsubject','updatesubject','editsubjectpage','deletesubject']]);
    }

    //Genre start
    public function genrepage(){
        try{
            return view('masters.genre');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function genreview(Request $req){
        try{
            $search = $req->search;
            $records = Genre::where('genre_id','!=','');
            if($search){
                $records = $records->where('genre_name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('genre_name','ASC')->take(500)->get();
            $html = view('masters.genre-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addgenre(Request $input) {
        $rules = [
            'genre_name' => 'required|unique:genre'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $insert = new Genre();
        $insert->genre_name = $data['genre_name'];
        $insert->genre_name_slug = Str::slug($data['genre_name'], '-');
        $insert->save();
        return response()->json(['status'=>'success', 'msg'=>'Genre created successfully']);
    }

    public function updategenre(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_genre_name' => 'required|unique:genre,genre_name,'.$id.',genre_id'
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $update = Genre::find($id);
        $update->genre_name = $data['edit_genre_name'];
        $update->genre_name_slug = Str::slug($data['edit_genre_name'], '-');
        $update->save();
        return response()->json(['status'=>'success', 'msg'=>'Genre updated successfully']);
    }

    public function deletegenre(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = Genre::find($id);
        $delete->delete();
        return response()->json(['status'=>'success', 'msg'=>'Genre deleted successfully']);
    }
    //Genre end


    //Tag start
    public function tagpage(){
        try{
            return view('masters.tag');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function tagview(Request $req){
        try{
            $search = $req->search;
            $records = Tag::where('tag_id','!=','');
            if($search){
                $records = $records->where('tag_name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('tag_name','ASC')->take(500)->get();
            $html = view('masters.tag-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addtag(Request $input) {
        $rules = [
            'tag_name' => 'required|unique:tags'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $insert = new Tag();
        $insert->tag_name = $data['tag_name'];
        $insert->tag_name_slug = Str::slug($data['tag_name'], '-');
        $insert->save();
        return response()->json(['status'=>'success', 'msg'=>'Tag created successfully']);
    }

    public function updatetag(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_tag_name' => 'required|unique:tags,tag_name,'.$id.',tag_id'
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $update = Tag::find($id);
        $update->tag_name = $data['edit_tag_name'];
        $update->tag_name_slug = Str::slug($data['edit_tag_name'], '-');
        $update->save();

        ActivityTagMap::where('tag_id',$id)->delete();

        return response()->json(['status'=>'success', 'msg'=>'tag updated successfully']);
    }

    public function deletetag(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = Tag::find($id);
        $delete->delete();

        ActivityTagMap::where('tag_id',$id)->delete();

        return response()->json(['status'=>'success', 'msg'=>'Tag deleted successfully']);
    }
    //Tag end

    //================COURSE MASTER START================
    //Category start
        public function categorypage(){
            try{
                return view('masters.category');
            }catch (Exception $e) {
                return back()->with('error', $e->getMessage().'__'.$e->getLine());
            }
        }

        public function categoryview(Request $req){
            try{
                $search = $req->search;
                $records = Category::where('id','!=','');
                if($search){
                    $records = $records->where('cat_name', 'LIKE', '%'.$search.'%');
                }
                $records = $records->orderBy('cat_name','ASC')->take(500)->get();
                $html = view('masters.category-table', compact('records'))->render();
                return response()->json(['status' => 'success', 'data' => $html]);
            }catch (Exception $e) {
                return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
            }
        }

        public function addcategorypage(){
            try{
                return view('masters.add-category');
            }catch (Exception $e) {
                return back()->with('error', $e->getMessage().'__'.$e->getLine());
            }
        }

        public function addcategory(Request $request){
           try{
                $input = $request->all();
                $rules = ['categoryName' => 'required|unique:category,cat_name|max:255'];
                $validation = Validator::make($input, $rules);
                if($validation->fails()){
                    return back()->withErrors($validation)->withInput();
                }
                $insert = new Category();
                $insert->cat_name = $input['categoryName'];
                $insert->slug = Str::slug($input['categoryName'], '-');
                $insert->status = $input['status'];
                $insert->save();
                Sitelog::savelog('category','add','success','New Category created',$insert->id);
                return back()->with('success', 'New category created successfully');
           }catch(\Exception $e){
                Sitelog::savelog('category','add','error',$e->getMessage().'__'.$e->getLine(),0);
                return back()->with('error',$e->getMessage().'__'.$e->getLine());
           }
        }

        public function updatecategory(Request $request){
            try{
                $input = $request->all();
                $id = $input['edit_id'];
                $rules = ['categoryName' => 'required|unique:category,cat_name,'.$id.'|max:255'];
                $validation = Validator::make($input, $rules);
                if($validation->fails()){
                    return back()->withErrors($validation)->withInput();
                }
                $update = Category::find($id);
                $update->cat_name = $input['categoryName'];
                $update->slug = Str::slug($input['categoryName'], '-');
                $update->status = $input['status'];
                $update->save();
                Sitelog::savelog('category','edit','success','Category updated',$update->id);
                return back()->with('success', 'Category updated successfully');
            }catch(\Exception $e){
                Sitelog::savelog('category','edit','error',$e->getMessage().'__'.$e->getLine(),0);
                return back()->with('error',$e->getMessage().'__'.$e->getLine());
            }
        }

        public function editcategorypage($id){
            try{
                $category = Category::find($id);
                if(!$category){
                    return back();
                }
                return view('masters.edit-category',compact('category'));
            }catch (Exception $e) {
                return back()->with('error', $e->getMessage().'__'.$e->getLine());
            }
        }

        public function deletecategory(Request $input) {
            $data = $input->all();
            $id = $data['id'];
            $delete = Category::find($id);
            $delete->delete();

            return response()->json(['status'=>'success', 'msg'=>'Category deleted successfully']);
        }
    //Category end

    //Subject start
    public function subjectpage(){
        try{
            return view('masters.subject');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function subjectview(Request $req){
        try{
            $search = $req->search;
            $records = Subject::where('id','!=','');
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('name','ASC')->take(500)->get();
            $html = view('masters.subject-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addsubjectpage(){
        try{
            return view('masters.add-subject');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function addsubject(Request $request){
        try{
            $input = $request->all();
            $rules = ['name' => 'required|unique:subjects,name|max:255'];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $insert = new Subject();
            $insert->name = $input['name'];
            $insert->slug = Str::slug($input['name'], '-');
            $insert->status = $input['status'];
            $insert->save();
            Sitelog::savelog('subject','add','success','New subject created',$insert->id);
            return back()->with('success', 'New subject created successfully');
        }catch(\Exception $e){
            Sitelog::savelog('subject','add','error',$e->getMessage().'__'.$e->getLine(),0);
            return back()->with('error',$e->getMessage().'__'.$e->getLine());
        }
    }

    public function updatesubject(Request $request){
        try{
            $input = $request->all();
            $id = $input['edit_id'];
            $rules = ['name' => 'required|unique:subjects,name,'.$id.',id|max:255'];
            $validation = Validator::make($input, $rules);
            if($validation->fails()){
                return back()->withErrors($validation)->withInput();
            }
            $update = Subject::find($id);
            $update->name = $input['name'];
            $update->slug = Str::slug($input['name'], '-');
            $update->status = $input['status'];
            $update->save();
             Sitelog::savelog('subject','edit','success','Subject updated',$update->id);
            return back()->with('success', 'Subject updated successfully');
        }catch(\Exception $e){
            Sitelog::savelog('subject','edit','error',$e->getMessage().'__'.$e->getLine(),0);
            return back()->with('error',$e->getMessage().'__'.$e->getLine());
        }
    }

    public function editsubjectpage($id){
        try{
            $subject = Subject::find($id);
            if(!$subject){
                return back();
            }
            return view('masters.edit-subject',compact('subject'));
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function deletesubject(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = Subject::find($id);
        $delete->delete();

        return response()->json(['status'=>'success', 'msg'=>'Subject deleted successfully']);
    }
    //Subject end
    //================COURSE MASTER END================   

    




    //country start
    public function countrypage(){
        try{
            return view('masters.country.country');
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function countryview(Request $req){
        try{
            $search = $req->search;
            $records = Country::latest();
            if($search){
                $records = $records->where('country_name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('country_name','ASC')->take(15)->get();
            $html = view('masters.country.country-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcountry(Request $input) {
        $rules = [
            'country_name' => 'required|unique:countries,country_name',
            'country_code' => 'required|unique:countries,country_code',
            'phone_code' => 'required|unique:countries,phone_code',
            'country_image' => 'required|mimes:jpg,jpeg,png,svg',
            'country_description' => 'required',
            'status' => 'required'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $country_image = '';
            if($input->hasFile('country_image')) {
                $destinationPath = 'uploads/gallery/'; // upload path
                $file = $input->file('country_image');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $country_image = $destinationPath.$fileName;
            }
        $data['country_image'] = $country_image;
        $insert = Country::create($data);
        if($insert->save()){
            return response()->json(['status'=>'success', 'msg'=>'country is created successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function countryedit(Request $req){
        $find = Country::find($req->id);
        if($find){
            return response()->json(['status'=>'success', 'record'=>$find]);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function updatecountry(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_country_name' => 'required|unique:countries,country_name,'.$id,
            'edit_country_code' => 'required|unique:countries,country_code,'.$id,
            'edit_phone_code' => 'required|unique:countries,phone_code,'.$id,
            'edit_status' => 'required',
            'edit_country_image' => 'required|mimes:jpg,jpeg,png,svg',
            'edit_country_description' => 'required'
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $country_image = '';
        if($input->hasFile('edit_country_image')) {
            $destinationPath = 'uploads/gallery/'; // upload path
            $file = $input->file('edit_country_image');
            $original_name = pathinfo($file, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension(); // getting file extension
            $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            $country_image = $destinationPath.$fileName;
        }
        

        $find = Country::find($id);
        $data['country_name'] = $input['edit_country_name'];
        $data['country_code'] = $input['edit_country_code'];
        $data['phone_code'] = $input['edit_phone_code'];
        $data['status'] = $input['edit_status'];
        $data['country_description'] = $input['edit_country_description'];
        $data['country_image'] = $country_image;

        if($find){
            $find->update($data);
            return response()->json(['status'=>'success', 'msg'=>'country is updated successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);

    }

    public function deletecountry(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = Country::find($id);
        $delete->delete();
        return response()->json(['status'=>'success', 'msg'=>'country is deleted successfully']);
    }
    //Country end

    //city start
    public function citypage(){
        try{
            $countries = Country::where('status', 'active')->get();
            return view('masters.city.city', compact('countries'));
        }catch (Exception $e) {
            return back()->with('error', $e->getMessage().'__'.$e->getLine());
        }
    }

    public function cityview(Request $req){
        try{
            $search = $req->search;
            $records = CountryCity::latest();
            if($search){
                $records = $records->where('name', 'LIKE', '%'.$search.'%');
            }
            $records = $records->orderBy('name','ASC')->take(15)->get();
            $html = view('masters.city.city-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function addcity(Request $input) {
        $rules = [
            'name' => 'required|unique:country_cities,name',
            'image' => 'required|mimes:jpg,jpeg,png,svg',
            'description' => 'required',
            'status' => 'required',
            'country_id' => 'required'
        ];
        $data = $input->all();
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $country_image = '';
            if($input->hasFile('image')) {
                $destinationPath = 'uploads/gallery/'; // upload path
                $file = $input->file('image');
                $original_name = pathinfo($file, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension(); // getting file extension
                $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
                $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
                $image = $destinationPath.$fileName;
            }
        $data['image'] = $image;
        $insert = CountryCity::create($data);
        if($insert->save()){
            return response()->json(['status'=>'success', 'msg'=>'city is created successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function cityedit(Request $req){
        $find = CountryCity::find($req->id);
        if($find){
            return response()->json(['status'=>'success', 'record'=>$find]);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);
    }

    public function updatecity(Request $input) {
        $data = $input->all();
        $id = $data['edit_id'];
        $rules = [
            'edit_name' => 'required|unique:country_cities,name,'.$id,
            'edit_status' => 'required',
            'edit_image' => 'nullable|mimes:jpg,jpeg,png,svg',
            'edit_description' => 'required',
            'edit_country_id' => 'required'
        ];
        $validation = Validator::make($data, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'validation', 'msg' => $validation->messages()]);
        }
        $city_image = '';
        if($input->hasFile('edit_image')) {
            $destinationPath = 'uploads/gallery/'; // upload path
            $file = $input->file('edit_image');
            $original_name = pathinfo($file, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension(); // getting file extension
            $fileName = rand(11111, 99999).'_'.$file->getClientOriginalName(); // renameing image
            $upload_success = $file->move($destinationPath, $fileName); // uploading file to given path
            $city_image = $destinationPath.$fileName;
        }
        

        $find = CountryCity::find($id);
        $data['name'] = $input['edit_name'];
        $data['code'] = $input['edit_code'];
        $data['phone_code'] = $input['edit_phone_code'];
        $data['status'] = $input['edit_status'];
        $data['description'] = $input['edit_description'];
        $data['country_id'] = $input['edit_country_id'];
        if($city_image){
            $data['image'] = $city_image;
        }

        if($find){
            $find->update($data);
            return response()->json(['status'=>'success', 'msg'=>'city is updated successfully']);
        }
        return response()->json(['status'=>'error', 'msg'=>'Please try again.']);

    }

    public function deletecity(Request $input) {
        $data = $input->all();
        $id = $data['id'];
        $delete = CountryCity::find($id);
        $delete->delete();
        return response()->json(['status'=>'success', 'msg'=>'city is deleted successfully']);
    }

    // faq

    public function faqcreate(){
        return view('faq/create');
    }

    public function faqsave(Request $req){
        $input = $req->all();
        $rules =[
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }

        $insert = new Faq();
        $insert->question = $input['question'];
        $insert->answer = $input['answer'];
        $insert->status = $input['status'];
        $insert->save();
        return back()->with('success', 'New faq is saved successfully');
    }

    public function faqview(){
        $records = Faq::paginate(10);
        return view('faq.view', compact('records'));
    }

    public function faqlist(Request $req){
        try{
            $search = $req->search;
            $records = Faq::orderBy('id', 'ASC');
            if($search){
                $records = $records->where('question', 'LIKE', '%'.$search.'%')->orWhere('answer', 'LIKE', '%'.$search.'%');
            }
            $records = $records->paginate(10);
            $html = view('faq.view-table', compact('records'))->render();
            return response()->json(['status' => 'success', 'data' => $html]);
        }catch (Exception $e) {
            return response()->json(['status' => 'error', 'msg' => $e->getMessage().'__'.$e->getLine()]);
        }
    }

    public function faqedit($id){
        $records = Faq::find($id);
        return view('faq/edit', compact('records'));
    }

    public function faqupdate(Request $req){
        $input = $req->all();
        $rules =[
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required'
        ];
        $validation = Validator::make($input, $rules);
         if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        $update = Faq::find($input['editid']);
        $update->question = $input['question'];
        $update->answer = $input['answer'];
        $update->status = $input['status'];
        $update->save();

        return back()->with('success', 'Faq details is updated successfully');

    }

}
