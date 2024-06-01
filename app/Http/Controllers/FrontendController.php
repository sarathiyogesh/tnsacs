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
<<<<<<< HEAD
use App\Models\Blog;
=======
use App\Models\Modules;
use App\Models\Modulechapter;
>>>>>>> 77e7f921b88476be4ad77af413b091dda9432d69

class FrontendController extends Controller
{
    
    public function signup(){
        return view('frontend.signup');
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
            $otp = rand(10000, 99999);
            $user = User::find(Auth::id());
            $user->email_otp = $otp;
            $user->save();
            Auth::logout();
            Session::flush();
            $code = encrypt($user->id);

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
        $small = Modulechapter::where('status','active')->where('module_id',$module->id)->orderBy('duration','DESC')->take(1)->sum('duration');
        $large = Modulechapter::where('status','active')->where('module_id',$module->id)->orderBy('duration','ASC')->take(1)->sum('duration');
        $chapters = Modulechapter::where('status','active')->where('module_id',$module->id)->take(50)->get();
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
        return view('frontend.module-chapter',compact('module','chapter','chapters'));
    }


}
