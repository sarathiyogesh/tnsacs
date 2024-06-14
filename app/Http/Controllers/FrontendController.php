<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use Spatie\Permission\Models\Role;
use Validator;
use Hash;
use App\Models\User;
use DB;
use Mail;
use Str;
use Session;
use Auth;
use App\Models\Faq;
use App\Models\Blog;
use App\Models\Modules;
use App\Models\Modulechapter;
use App\Models\Certificate;
use App\Models\Modulehistory;
use App\Models\Modulechapterhistory;

class FrontendController extends Controller
{
    
    public function signup(){
        return view('frontend.signup');
    }

    public function blogpage(){
        return view('frontend.blog');
    }

    public function blogdetails(){
        return view('frontend.blog-details');
    }

    public function signuppost(Request $req){
        $input = $req->all();
        $rules = ['fullname' => 'required', 'email' => 'required|email', 'password' => 'required|min:6'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            //return $validation->messages();
            return back()->withInput()->withErrors($validation);
        }

        $otp = rand(10000, 99999);

        $insert = new User();
        $insert->name = $input['fullname'];
        $insert->email = $input['email'];
        $insert->password = Hash::make('password');
        $insert->email_otp = $otp;
        $insert->type='online';
        $insert->status = 'inactive';
        $insert->verify_time = time();
        $insert->save();

        //mail
        // try{
        //     Mail::send("emails.signup_otp",['user' => $insert], function($message) use ($input){
        //         $message->from(env('ADMIN_EMAIL'), env('ADMIN_NAME')) ;
        //         $message->to($input['email'], $input['fullname'])->subject("Signup verfication");
        //     });
        // }catch (Exception $e) {
            
        // }
        $code = encrypt($insert->id);
        return redirect('signup/verify/'.$code)->with('success', 'OTP sent to your email. Please verify');
    }

    public function signupverify($code){
        $id = decrypt($code);
        $user = User::where('id', $id)->where('status', 'inactive')->first();
        if($user){
            return view('frontend.signup_otp', compact('code', 'user'));
        }
        return redirect('/');
    }

    public function signupverifypost(Request $req){
        $input = $req->all();
        $rules = ['otp' => 'required|integer|digits:5'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        $id = decrypt($input['code']);
        $check = User::where('id', $id)->where('status', 'inactive')->where('email_otp', $input['otp'])->first();
        if($check){
            $check->email_otp = NULL;
            $check->status = 'active';
            $check->save();
            return redirect('/signin')->with('success', 'Email verification completed successfully.');
        }
        return back()->with('error', 'Please enter valid OTP');
    }

    public function login(){
        return view('frontend.login');
    }

    public function signinpost(Request $req){
        $input = $req->all();
        $rules = ['email' => 'required|email', 'password' => 'required'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        if(Auth::attempt(['email' => $req->email, 'password' => $req->password, 'type' => 'online', 'status' => 'active'])){

            if(Session::has('redirect') && Session::get('redirect') != ''){
                return redirect(Session::get('redirect'));
            }
            return redirect('/');
            // $otp = rand(10000, 99999);
            // $user = User::find(Auth::id());
            // $user->email_otp = $otp;
            // $user->save();
            // Auth::logout();
            // Session::flush();
            // $code = encrypt($user->id);

            //mail
            // try{
            //     Mail::send("emails.login_otp",['user' => $user], function($message) use ($user){
            //         $message->from(env('ADMIN_EMAIL'), env('ADMIN_NAME')) ;
            //         $message->to($user->email, $user->fullname)->subject("Login verfication");
            //     });
            // }catch (Exception $e) {
                
            // }

            return redirect('/signin/verify/'.$code)->with('success', 'OTP sent to your email. Please verify');;
        }
        return back()->with('error', 'Please enter valid credentials.');
    }


    public function signinverify($code){
        $id = decrypt($code);
        $user = User::where('id', $id)->where('status', 'active')->first();
        if($user){
            return view('frontend.login_otp', compact('code', 'user'));
        }
        return redirect('/');
    }

    public function signinverifypost(Request $req){
        $input = $req->all();
        $rules = ['otp' => 'required|integer|digits:5'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return back()->withErrors($validation)->withInput();
        }
        $id = decrypt($input['code']);
        $check = User::where('id', $id)->where('status', 'active')->where('email_otp', $input['otp'])->first();
        if($check){
            $check->email_otp = NULL;
            $check->save();
            Auth::loginUsingId($check->id);
            if(Session::has('redirect') && Session::get('redirect') != ''){
                return redirect(Session::get('redirect'));
            }
            return redirect('/');
        }
        return back()->with('error', 'Please enter valid OTP');
    }



    public function logout(){
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function index(){
        $faqs = Faq::where('status', 'active')->orderBy('id', 'ASC')->get();
        $blogs = Blog::where('status', 'active')->latest()->take(3)->get();
        return view('frontend.index', compact('faqs', 'blogs'));
    }

    public function modules(){
        $modules = Modules::where('status','active')->take(10)->get();
        return view('frontend.modules',compact('modules'));
    }

    public function moduledetails($slug){
        if(!Auth::check()){
            Session::put('redirect',\URL::to('module-details/'.$slug));
            return redirect('signin');
        }
        $module = Modules::where('status','active')->where('slug',$slug)->first();
        if(!$module){
            return back();
        }
        $totalminutes = Modulechapter::where('status','active')->where('module_id',$module->id)->sum('duration');
        $large = Modulechapter::where('status','active')->where('module_id',$module->id)->orderBy('duration','DESC')->first();
        if($large){
            $large = $large->duration;
        }else{
            $large = 0;
        }
         $small = Modulechapter::where('status','active')->where('module_id',$module->id)->orderBy('duration','ASC')->first();
        if($small){
            $small = $small->duration;
        }else{
            $small = 0;
        }
        $chapters = Modulechapter::where('status','active')->where('module_id',$module->id)->take(50)->get();

        //update history
            $uh = Modulehistory::where('user_id',Auth::id())->where('module_id',$module->id)->first();
            if(!$uh){
                $iuh = new Modulehistory();
                $iuh->user_id = Auth::id();
                $iuh->module_id = $module->id;
                $iuh->viewed_date = date('Y-m-d');
                $iuh->completed_status = 'no';
                $iuh->save();
            }
        //update history

        return view('frontend.module-details',compact('module','totalminutes','chapters','small','large'));
    }

    public function modulechapter($slug,$chapter_id){
        if(!Auth::check()){
            Session::put('redirect',\URL::to('module-details/'.$slug));
            return redirect('signin');
        }
        $module = Modules::where('status','active')->where('slug',$slug)->first();
        if(!$module){
            return back();
        }
        $chapter = Modulechapter::where('status','active')->where('module_id',$module->id)->where('id',$chapter_id)->first();
        if(!$chapter){
             return back();
        }
        $chapters = Modulechapter::where('status','active')->where('module_id',$module->id)->take(50)->get();


         //update history
            $uh = Modulechapterhistory::where('user_id',Auth::id())->where('module_id',$module->id)->where('chapter_id',$chapter->id)->first();
            if(!$uh){
                $iuh = new Modulechapterhistory();
                $iuh->user_id = Auth::id();
                $iuh->module_id = $module->id;
                $iuh->chapter_id = $chapter->id;
                $iuh->viewed_date = date('Y-m-d');
                $iuh->completed_status = 'no';
                $iuh->save();
            }
        //update history

        return view('frontend.module-chapter',compact('module','chapter','chapters'));
    }

    public function modulechapterhistoryupdate(Request $req){
        try{
            if(!Auth::check()){
                 return response()->json(['status'=>'error','msg'=>'Login required']);
            }
            $module_id = decrypt($req->get('module_id'));
            $chapter_id = decrypt($req->get('chapter_id'));
            $uc = Modulechapterhistory::where('user_id',Auth::id())->where('module_id',$module_id)->where('chapter_id',$chapter_id)->where('completed_status','!=','yes')->first();
            if($uc){
                $uc->completed_status = 'yes';
                $uc->completed_date = date('Y-m-d');
                $uc->total_duration = $req->get('duration');
                $uc->save();

                $total_chapter = Modulechapter::where('module_id',$module_id)->where('id',$chapter_id)->count();
                $completed_chapter = Modulechapterhistory::where('user_id',Auth::id())->where('module_id',$module_id)->count();
                if($total_chapter == $completed_chapter){
                    $um = Modulehistory::where('module_id', $module_id)->where('user_id', Auth::id())->first();
                    if($um){
                        $um->completed_date = date('Y-m-d');
                        $um->completed_status = 'yes';
                        $um->save();
                    }
                }
                return response()->json(['status'=>'success','msg'=>'Updated']);
            }else{
                return response()->json(['status'=>'success','msg'=>'Already updated']);
            }
        }catch(\Exception $e){
            return response()->json(['status'=>'error','msg'=>$e->getMessage().'_'.$e->getLine()]);
        }
    }

    public function savecertificate(Request $req){
        $input = $req->all();
        $rules = ['first_name' => 'required', 'last_name' => 'required', 'gender' => 'required', 'address' => 'required'];
        $validation = Validator::make($input, $rules);
        if($validation->fails()){
            return response()->json(['status' => 'error', 'msg' => $validation->messages()->first()]);
        }

        $new = new Certificate();
        $new->first_name = $input['first_name'];
        $new->last_name = $input['last_name'];
        $new->gender = $input['gender'];
        $new->address = $input['address'];
        $new->module_id = $input['module_id'];
        $new->save();

        return response()->json(['status' => 'success', 'msg' => 'Certificate details has been submitted successfully']);
    }


}
