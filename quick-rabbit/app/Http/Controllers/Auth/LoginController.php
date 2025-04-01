<?php
/*
  ##############################################################################
  # AI Powered Customer Support Portal and Knowledgebase System
  ##############################################################################
  # AUTHOR:		Door Soft
  ##############################################################################
  # EMAIL:		info@doorsoft.co
  ##############################################################################
  # COPYRIGHT:		RESERVED BY Door Soft
  ##############################################################################
  # WEBSITE:		https://www.doorsoft.co
  ##############################################################################
  # This is Login Auth Controller
  ##############################################################################
 */

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Login form
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if(Auth::check()) {
            $request_route = \Request::route()->getName();
            $login_route = Session::get('login_route');
            if($request_route==$login_route){
                return redirect()->route('user-home');
            }            
            $user = Auth::user();
            $user_type =  Auth::user()->type;

            $user->online_status = 0;
            $user->last_logout_time = now();
            $user->save();
            Auth::logout();
            session()->flush();
            session()->regenerate();
            $msg = '';
           
            if($user_type=="Admin"){
                $msg = __('index.logged_out_msg_admin');
            }elseif($user_type=="Agent"){
                $msg = __('index.logged_out_msg_agent');
            }elseif($user_type=="Customer"){
                $msg = __('index.logged_out_msg_customer');
            }
            return redirect()->route($request_route)->with('message',$msg); 
        } else {
            $previous_url = url()->previous();
            $base_url = url('/');
            $is_like_forum = Session::get('is_like_forum');
            if($previous_url == $base_url.'/forum' || str_contains($previous_url,'forum-comment')) {
                if($is_like_forum != 1) {
                    Session::put('redirect_link',route('ask-question'));
                }else{
                    Session::put('redirect_link',$previous_url);
                }
            }else if(str_contains($previous_url,'article')) {                
                Session::put('redirect_link',$previous_url);
            }else if(str_contains($previous_url,'blog-details')) {                
                Session::put('redirect_link',$previous_url);
            }else{
                Session::put('redirect_link',$previous_url);
            }
            $request_route = \Request::route()->getName();
            Session::put('login_route',$request_route);
            return view('frontend.login');
        }
        
    }

    /**
     * Handle login request.
     * @param \Illuminate\Http\Request $request
     * @throws \Illuminate\Validation\ValidationException
     */

    public function login(Request $request)
    {
        $this->validate($request,
            ['email'=>'required|regex:/(.+)@(.+)\.(.+)/i','password'=>'required'],
            [
                'email.required' => __('index.email_required'),
                'email.regex' => __('index.valid_email.email'),
                'password.required' => __('index.password_required')
            ]
        );

        $login_route = Session::get('login_route');
        $type = "";
        if ($login_route == 'admin.login') {
            $type = "Admin";
        } elseif ($login_route == "agent.login") {
            $type = "Agent";
        } elseif($login_route == "customer.login") {
            $type = "Customer";
        }

        $credintials =  [
            'email'=>$request->get('email'),
            'password'=>$request->get('password'),
            'type' => $type
        ];

        if (Auth::guard()->attempt($credintials,$request->remember)) {
            if(Auth::User()->status != 1) {
                Auth::logout();
                return redirect()->back()->withInput($request->only('email', 'remember'))->with('message',__('index.temp_inactive'));
            }
            Session::put('u_r_p',$request->password);
            $redirect_link = session()->get('redirect_link');
            if(!empty($redirect_link) && $redirect_link != url('/').'/' && !str_contains($redirect_link,'install')) {
                return redirect($redirect_link);
            } else {
                $auth_user = Auth::user();
                $auth_user->online_status = 1;
                $auth_user->language = getUserLanguage();
                $auth_user->browser_id = userIp();
                $auth_user->language = session()->get('lan');
                $auth_user->save();
                return redirect()->intended(route('user-home'));
            }
            Session::forget('is_like_forum');
        } else {
            Session::put('type', 'danger');
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->with('message',__('index.email_password_not_valid'));
        }
    }

    /**
     * Default redirect link
     */
    public function loginRedirect(){
        return redirect('/');
    }

}
