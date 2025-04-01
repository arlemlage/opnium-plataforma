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
  # This is Feedback Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Feedback List
     * @return \Illuminate\Http\Response
     */
    public function index($ids){
        $ids = explode('&', $ids);
        $ticket_id = $ids[0];
        $customer_id = $ids[1];
        $site_setting_info = \App\Model\SiteSetting::first();

        $check = Feedback::where('customer_id', encrypt_decrypt($customer_id, 'decrypt'))
                ->where('ticket_id', encrypt_decrypt($ticket_id, 'decrypt'))->first();
        if(empty($check)){
            return view('customer-activity.feedback.feedback-form', compact('ticket_id', 'customer_id', 'site_setting_info'));
        }
        else {
            return view('customer-activity.feedback.feedback-expire-page', compact('site_setting_info'));
        }
    }

    /**
     * Store a newly created feedback
     */
    public function store(Request $request){
        $site_setting_info = \App\Model\SiteSetting::first();
        $ticket_id = encrypt_decrypt($request->ticket_id, 'decrypt');
        $customer_id = encrypt_decrypt($request->customer_id, 'decrypt');

        $check = Feedback::where('customer_id', $customer_id)
            ->where('ticket_id', $ticket_id)->first();

        if (empty($check)){
            $feedback = new Feedback();
            $feedback->ticket_id = $ticket_id;
            $feedback->customer_id = $customer_id;
            $feedback->rating = empty($request->rating)? 0:$request->rating;
            $feedback->review = $request->review;
            $feedback->created_by = encrypt_decrypt($request->customer_id, 'decrypt');
            $feedback->updated_by = encrypt_decrypt($request->customer_id, 'decrypt');
            $feedback->save();

            return view('customer-activity.feedback.thank-you-page', compact('site_setting_info'));
        }else{
            return view('customer-activity.feedback.feedback-expire-page', compact('site_setting_info'));
        }
    }

}
