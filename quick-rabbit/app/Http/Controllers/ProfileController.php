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
  # This is Profile Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Profile edit form
     * @return \Illuminate\View\View
     */
    public function profileEditForm()
    {
        return view('profile.edit_profile');
    }

    /**
     * Handle update profile request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateProfile(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'mobile' => 'required|max:20',
            'email' => 'required|email|string|max:50'
        ],[
            'first_name.required' => __('index.first_name_required'),
            'first_name.max' => __('index.first_name_max_191'),
            'last_name.required' => __('index.last_name_required'),
            'last_name.max' => __('index.last_name_max_191'),
            'mobile.required' => __('index.phn_no_required'),
            'mobile.max' => __('index.mobile_max_20'),
            'email.required' => __('index.email_required'),
            'email.email' => __('index.valid_email.email'),
            'email.max' => __('index.email_max_50'),
        ]);
        $admin = Auth::user();
        $admin->first_name = $request->first_name;
        $admin->last_name = $request->last_name;
        if($request->email !== $admin->email) {
            if(User::where('email',$request->email)->exists()) {
                return redirect()->back()->with([
                    'email_error'=> __('index.email.unique'),
                    'email' => $request->email
                ]);
            } else {
                $admin->update(array('email' => $request->email));
                User::sendVerificationEmail($request->email);
                $admin->is_email_verified = 0;
            }
        }
        if($request->mobile !== $admin->mobile) {
            if(User::where('mobile',$request->mobile)->exists()) {
                return redirect()->back()->with([
                    'mobile_error'=> __('index.mobile.unique'),
                    'mobile' => $request->mobile
                ]);
            } else {
                $admin->update(array('mobile' => $request->mobile));
            }
        }
        if(!empty($request->image_url)) {
            $admin->image = bas64ToImage($request->image_url,'user_photos/');
        }
        $admin->save();
        return redirect()->route('edit-profile')->with(updateMessage());
    }

    /**
     * Admin change password form
     * @return \Illuminate\View\View
     */
    public function changePasswordForm(): \Illuminate\View\View
    {
        return view('profile.change_password');
    }

    /**
     * Handle admin change password request
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request,[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password'
        ],
        [
            'old_password.required' => __('index.old_password_required'),
            'new_password.required' => __('index.new_password_required'),
            'new_password.min' => __('index.new_pass_min_6'),
            'confirm_password.required' => __('index.confirm_password_required'),
            'confirm_password.same' => __('index.confirm_password.same'),
        ]
        );
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $current_password = Auth::user()->password;
        if(Hash::check($old_password, $current_password)){
            Auth::user()->update(['password'=>Hash::make($new_password),'need_change_password' => false]);
            return redirect()->route('change-password')->with(updateMessage('Password has been changed successfully!'));
        } else{
            return redirect()->route('change-password')->with('error','Old Password not match!');
        }
    }

    /**
     * Set change password form
     * @return \Illuminate\View\View
     */
    public function setPasswordForm(): \Illuminate\View\View
    {
        $route = route('customer.set-password');
        return view('profile.set_password',compact('route'));
    }

    /**
     * Handle set password request
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setPassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request,[
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required'
        ],
        [
            'password.required' => __('index.password.required'),
            'confirm_password.required' => __('index.confirm_password_required'),
            'password.same' => __('index.password.same'),
        ]
        );
        Auth::user()->update(['password'=>Hash::make($request->password)]);
        return redirect()->route('set-password')->with(updateMessage('Password has been changed successfully!'));
    }

    /**
     * Security question setting form
     * @return \Illuminate\View\View
     */
    public function securityQuestionForm(): \Illuminate\View\View
    {
        $jsonString = File::get(storage_path('sampleQustions.json'));
        $questions = json_decode($jsonString, true);
        return view('profile.set_security_question',compact('questions'));
    }

    /**
     * Handle security question set request
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function saveSecurityQuestion(Request $request) {
        $this->validate($request,
            [
                'question' => 'required',
                'answer' => 'required'
            ],
            [
                'question.required' => __('index.question_required'),
                'answer.required' => __('index.answer_required'),
            ]
        );
        $user = Auth::user();
        $user->question = $request->question;
        $user->answer = $request->answer;
        $user->save();
        return redirect()->route('set-security-question')->with(updateMessage());
    }
}
