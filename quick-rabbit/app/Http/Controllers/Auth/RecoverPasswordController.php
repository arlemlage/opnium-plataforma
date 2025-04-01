<?php
/*
##############################################################################
# AI Powered Customer Support Portal and Knowledgebase System
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
##############################################################################
# This is Recover Password Auth Controller
##############################################################################
 */

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class RecoverPasswordController extends Controller
{
    /**
     * Email validation form
     * @return \Illuminate\View\View
     */
    public function stepOne()
    {
        return view('frontend.reset_password');
    }

    /**
     * Check Email
     * @return \Illuminate\View\View
     */
    public function checkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required'], ['email.required' => __('index.email_required')]);
        if (User::where('email', $request->email)->exists()) {
            $email = $request->email;
            $userType = User::where('email', $request->email)->first()->type;
            Session::put('login_route', $userType); 
            return redirect()->route('reset-password-step-two', ['email' => $email]);
        } else {
            Session::put('rp_email', $request->email);
            return redirect(route('reset-password-step-one'))->with(errorMessage(__('index.email_not_found')));
        }
    }

    /**
     * Redirect to check question answer
     * @return \Illuminate\View\View
     */
    public function stepTwo()
    {
        $email = request()->get('email');
        if (User::where('email', $email)->exists()) {
            $jsonString = File::get(storage_path('sampleQustions.json'));
            $questions = json_decode($jsonString, true);
            return view('frontend.reset_password', compact('email', 'questions'));
        } else {
            return redirect(route('reset-password-step-one'))->with(errorMessage('Invalid Email address.'));
        }

    }

    /**
     * Check Question Answer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkQuestionAnswer(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'question' => 'required',
            'answer' => 'required',
        ],
            [
                'email.required' => __('index.email_required'),
                'question.required' => __('index.question_required'),
                'answer.required' => __('index.answer_required'),
            ]);
        $conditions = [
            'email' => $request->email,
            'question' => $request->question,
            'answer' => $request->answer,
        ];
        $email = $request->email;

        if (User::where($conditions)->exists()) {
            return redirect()->route('reset-password-step-three', ['email' => $email]);
        } else {
            Session::put('rp_question', $request->question);
            Session::put('rp_answer', $request->answer);
            return redirect()->route('reset-password-step-two', ['email' => $email])->with('message', __('index.invalid_question_answer'));
        }
    }

    /**
     * Redirect to password form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function stepThree()
    {
        $email = request()->get('email');
        if (User::where('email', $email)->exists()) {
            return view('frontend.reset_password', compact('email'));
        } else {
            return redirect()->route('reset-password-step-two', ['email' => $email])->with(errorMessage('Invalid Email address.'));
        }
    }

    /**
     * Reset Password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        if (appMode() == "demo") {
            abort(405);
        }
        $this->validate($request,
            [
                'email' => 'required',
                'new_password' => 'required|min:6|max:10',
                'confirm_password' => 'required|same:new_password',
            ],
            [
                'new_password.required' => __('index.new_password_required'),
                'new_password.min' => __('index.new_pass_min_6'),
                'new_password.max' => __('index.new_password_max_10'),
                'confirm_password.required' => __('index.confirm_password_required'),
                'confirm_password.same' => __('index.confirm_password.same'),
            ]);

        $email = request()->get('email');
        if (User::where('email', $email)->exists()) {
            User::where('email', $email)->update(['password' => Hash::make($request->confirm_password)]);
            $route = Session::get('login_route');
            return redirect()->route('reset-password-success');
        } else {
            return redirect()->route('reset-password-step-two', ['email' => $email])->with(errorMessage('Invalid Email address.'));
        }

    }

    public function resetPasswordSuccess()
    {
        return view('frontend.reset_password');
    }
}
