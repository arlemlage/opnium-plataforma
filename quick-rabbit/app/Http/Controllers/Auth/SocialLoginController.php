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
  # This is Social Login Auth Controller
  ##############################################################################
 */

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\MailSendController;

class SocialLoginController extends Controller
{
    /**
 * Login Using Facebook
 */
 public function redirectToFacebook()
 {
    if(configInfo()->facebook_login == 0) {
        abort(503);
    }
    return Socialite::driver('facebook')->redirect();
 }
/**
     * facebook Callback.
     *
     * @return void
     */
 public function facebookCallback(){
  try {
        $fb_user = Socialite::driver('facebook')->user();
        if(User::where('email',$fb_user->getEmail())->exists()) {
            $user = User::where('email',$fb_user->getEmail())->first();
            $user->is_email_verified = true;
            $user->need_change_password = false;
            $user->save();
            $user_id = $user->id;
            if($user->role_id != 3) {
                return redirect()->route('customer.login')->with('message','Your email address already used in another role.');
            } else {                
                Auth::loginUsingId($user_id);
            }
        } else {
            $identify = ['facebook_id' => $fb_user->getId()];
            $data = [
                'registered_from' => 'social',
                'role_id' => 3,
                'type' => 'Customer',
                'first_name' => explode(' ',$fb_user->getName())[0],
                'last_name' => explode(' ',$fb_user->getName())[1],
                'email' => $fb_user->getEmail(),
                'facebook_id' => $fb_user->getId(),
                'auth_type'=> 'facebook',
                'is_email_verified' => true,
                'need_change_password' => false,
                'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6))
            ];
            User::updateOrInsert($identify,$data);
            $fb_user_id = User::where('email',$fb_user->getEmail())->customer()->first()->id;
            Auth::loginUsingId($fb_user_id);
        }
       

        return redirect()->route('dashboard');
       } catch (\Throwable $th) {
          throw $th;
       }
   }

   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        if(configInfo()->google_login == 0) {
            abort(503);
        }
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function googleCallback()
    {
        try {
            $g_user = Socialite::driver('google')->user();
            if(User::where('email',$g_user->email)->exists()) {
                $user = User::where('email',$g_user->email)->first();
                $user->is_email_verified = true;
                $user->need_change_password = false;
                $user->save();
                $user_id = $user->id;
                if($user->role_id != 3) {
                    return redirect()->route('customer.login')->with('message','Your email address already used in another role.');
                } else {
                    Auth::loginUsingId($user_id);
                }
            } else {
                $identify = array('google_id' => $g_user->id,'email' => $g_user->email);
                $tmp_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
                $customer_full_name = (explode(' ',$g_user->name)[0] ?? 'First Name')." ". explode(' ',$g_user->name)[1] ?? "Last Name";
                $data = [
                    'registered_from' => 'social',
                    'role_id' => 3,
                    'type' => 'Customer',
                    'first_name' => explode(' ',$g_user->name)[0] ?? 'Name',
                    'last_name' => explode(' ',$g_user->name)[1] ?? 'Name',
                    'email' => $g_user->email,
                    'google_id'=> $g_user->id,
                    'auth_type'=> 'google',
                    'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6)),
                    'is_email_verified' => true,
                    'need_change_password' => false,
                ];

                $mail_data = [
                    'to' => array('name'=>"",'email'=>$g_user->email),
                    'subject' => "Temporary login credentials",
                    'user_name' => $customer_full_name,
                    'body' => 'Your temporary login credentials have been given below. Please login into your account and change your password.',
                    'email' => $g_user->email,
                    'password' => $tmp_password,
                    'login_url' => route('customer.login'),
                    'view' => 'create-new-customer-mail',
                ];
        
                MailSendController::sendMailToUser($mail_data);

                User::updateOrInsert($identify,$data);
                $g_user_id = User::where('email',$g_user->email)->customer()->first()->id;
                Auth::loginUsingId($g_user_id);
            }
            return redirect()->route('dashboard');

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function redirectToGithub()
    {
        if(configInfo()->github_login == 0) {
            abort(503);
        }
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        try {
            $gh_user = Socialite::driver('github')->user();
            if(User::where('email',$gh_user->email)->exists()) {
                $user = User::where('email',$gh_user->email)->first();
                $user->is_email_verified = true;
                $user->need_change_password = false;
                $user->save();
                $user_id = $user->id;
                if($user->role_id != 3) {
                    return redirect()->route('customer.login')->with('message','Your email address already used in another role.');
                } else {
                    Auth::loginUsingId($user_id);
                }
            } else {
                 $identify = array('github_id' => $gh_user->id,'email' => $gh_user->email);
                 $tmp_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
                 $customer_full_name = (explode(' ',$gh_user->name)[0] ?? 'First Name')." ". explode(' ',$gh_user->name)[1] ?? "Last Name";
                $data = [
                    'registered_from' => 'social',
                    'role_id' => 3,
                    'type' => 'Customer',
                    'first_name' => explode(' ',$gh_user->name)[0] ?? 'First Name',
                    'last_name' => explode(' ',$gh_user->name)[1] ?? "Last Name",
                    'email' => $gh_user->email,
                    'github_id'=> $gh_user->id,
                    'auth_type'=> 'github',
                    'password' => Hash::make($tmp_password),
                    'is_email_verified' => true,
                    'need_change_password' => false
                ];

                User::updateOrInsert($identify,$data);
                $gh_user_id = User::where('email', $gh_user->email)->customer()->first();


                $mail_data = [
                    'to' => array('name'=>"",'email'=>$gh_user->email),
                    'subject' => "Temporary login credentials",
                    'user_name' => $customer_full_name,
                    'body' => 'Your temporary login credentials have been given below. Please login into your account and change your password.',
                    'email' => $gh_user->email,
                    'password' => $tmp_password,
                    'login_url' => route('customer.login'),
                    'view' => 'create-new-customer-mail',
                ];
        
                MailSendController::sendMailToUser($mail_data);


                Auth::login($gh_user_id);
            }

            return redirect('/dashboard');
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }


    public function redirectToLinkedin()
    {
        if(configInfo()->linkedin_login == 0) {
            abort(503);
        }
        return Socialite::driver('linkedin')->redirect();
    }

    public function linkedinCallback(){
        try {
            $ln_user = Socialite::driver('linkedin')->user();

            if(User::where('email',$ln_user->email)->exists()) {
                $user = User::where('email',$ln_user->email)->first();
                $user_id = $user->id;
                $user->is_email_verified = true;
                $user->need_change_password = false;
                $user->save();
                if($user->role_id != 3) {
                    return redirect()->route('customer.login')->with('message','Your email address already used in another role.');
                } else {
                    Auth::loginUsingId($user_id);
                }
            } else {
                $identify = array('linkedin_id' => $ln_user->id,'email' => $ln_user->email);
                $tmp_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
                $customer_full_name = (explode(' ',$ln_user->name)[0] ?? 'First Name')." ". explode(' ',$ln_user->name)[1] ?? "Last Name";

                $data = [
                    'registered_from' => 'social',
                    'role_id' => 3,
                    'type' => 'Customer',
                    'first_name' => explode(' ',$ln_user->name)[0] ?? 'First Name',
                    'last_name' => explode(' ',$ln_user->name)[1] ?? 'First Name',
                    'email' => $ln_user->email,
                    'linkedin_id'=> $ln_user->id,
                    'auth_type'=> 'linkedin',
                    'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6)),
                    'is_email_verified' => true,
                    'need_change_password' => false,
                ];
                $mail_data = [
                    'to' => array('name'=>"",'email'=>$ln_user->email),
                    'subject' => "Temporary login credentials",
                    'user_name' => $customer_full_name,
                    'body' => 'Your temporary login credentials have been given below. Please login into your account and change your password.',
                    'email' => $ln_user->email,
                    'password' => $tmp_password,
                    'login_url' => route('customer.login'),
                    'view' => 'create-new-customer-mail',
                ];
        
                MailSendController::sendMailToUser($mail_data);

                User::updateOrInsert($identify,$data);
                $ln_user_id = User::where('email',$ln_user->email)->customer()->first()->id;
                Auth::loginUsingId($ln_user_id);
            }

            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect('customer/login')->with(errorMessage("Something wrong with Linkedin Login"));
        }
    }


    public function redirectToEnvato()
    {
        if(configInfo()->envato_login == 0) {
            abort(503);
        }
        return Socialite::driver('envato')->redirect();
    }

    public function envatoCallback(){
        try {
            $en_user = Socialite::driver('envato')->user();

            if(User::where('email',$en_user->email)->exists()) {
                $user = User::where('email',$en_user->email)->first();
                $user->is_email_verified = true;
                $user->need_change_password = false;
                $user->save();
                $user_id = $user->id;
                if($user->role_id != 3) {
                    return redirect()->route('customer.login')->with('message','Your email address already used in another role.');
                } else {
                    Auth::loginUsingId($user_id);
                }
            } else {
                $identify = array('envato_id' => $en_user->id,'email' => $en_user->email);
                $tmp_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
                $customer_full_name = (explode(' ',$en_user->name)[0] ?? 'First Name')." ". explode(' ',$en_user->name)[1] ?? "Last Name";

                $data = [
                    'registered_from' => 'social',
                    'role_id' => 3,
                    'type' => 'Customer',
                    'first_name' => explode(' ',$en_user->name)[0] ?? 'First Name',
                    'last_name' => explode(' ',$en_user->name)[1] ?? 'Last Name',
                    'email' => $en_user->email,
                    'envato_id'=> $en_user->id,
                    'auth_type'=> 'envato',
                    'password' => Hash::make(substr(md5(uniqid(random_int(0, 50), true)), 0, 6)),
                    'is_email_verified' => true,
                    'need_change_password' => false,
                ];

                $mail_data = [
                    'to' => array('name'=>"",'email'=>$en_user->email),
                    'subject' => "Temporary login credentials",
                    'user_name' => $customer_full_name,
                    'body' => 'Your temporary login credentials have been given below. Please login into your account and change your password.',
                    'email' => $en_user->email,
                    'password' => $tmp_password,
                    'login_url' => route('customer.login'),
                    'view' => 'create-new-customer-mail',
                ];
        
                MailSendController::sendMailToUser($mail_data);

                User::updateOrInsert($identify,$data);
                $en_user_id = User::where('email',$en_user->email)->customer()->first()->id;
                Auth::loginUsingId($en_user_id);
            }
            return redirect()->route('dashboard');
        } catch (Exception $e) {
            return redirect('customer/login')->with(errorMessage("Something wrong with Envato Login"));
        }
    }
}
