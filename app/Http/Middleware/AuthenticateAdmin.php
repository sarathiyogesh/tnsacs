<?php 
namespace App\Http\Middleware;

use Closure;
use Session;
use Auth;
use Illuminate\Contracts\Auth\Guard;

class AuthenticateAdmin {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest())
        {
            if ($request->ajax()){
                return response('Unauthorized.', 401);
            }else{
                return redirect()->guest('/manage/console/login');
            }
        }elseif($request->user()->type != 'admin'){
            Session::flush();
            Auth::logout();
            return redirect()->guest('/manage/console/login');
        }

        return $next($request);
    }   

}
