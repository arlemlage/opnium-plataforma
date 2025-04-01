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
  # This is Payment Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    /**
     * Payment request form
     * @param $ticket_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function makePayment($ticket_id) {
        Session::put('ticket_id',encrypt_decrypt($ticket_id,'decrypt'));
        $ticket_info = Ticket::findOrFail(encrypt_decrypt($ticket_id,'decrypt'));
        return view('payment.select_payment_method',compact('ticket_info'));
    }

    /**
     * Process Payment Request
     * @param Request $request
     * @param $ticket_id
     * @return Request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function processPayment(Request $request, $payment_id){
        if(appMode() == "demo") {
            abort(405);
        }
        $this->validate($request,['payment_method'=>'required']);
        Session::put('payment_from',$request->payment_from);
        Session::put('payment_amount', $request->payment_amount);
        $payment_method = $request->payment_method;
        if($payment_method === "paypal"){
            return Redirect::route('process-paypal-transaction',$payment_id);
        } elseif ($payment_method === "stripe"){
            return Redirect::route('stripe-payment',$payment_id);
        } else{
            return view('make_payment',$payment_id);
        }

    }
}
