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
  # This is Stripe Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\RecurringPaymentDate;
use App\Model\Ticket;
use App\Model\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe;

class StripeController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe($ticket_id)
    {
        $payment = RecurringPaymentDate::find(encrypt_decrypt($ticket_id,'decrypt'));
        if(!$payment){
            $ticket_info = Ticket::findOrFail(encrypt_decrypt($ticket_id,'decrypt'));
        }
        $ticket_info = '';
        Session::put('ticket_id',encrypt_decrypt($ticket_id,'decrypt'));
        return view('payment.stripe',compact('ticket_info', 'payment'));
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        Stripe\Stripe::setApiKey(stripeInfo()['stripe_secret']);
        $ticket_info = Ticket::findOrFail(Session::get('ticket_id'));
        $amount = (int)$request->amount;
        $charge = Stripe\Charge::create ([
                "amount" => $amount < 50 ? $amount * 100 : $amount,
                "currency" => "USD",
                "source" => $request->stripeToken,
                "description" => "Stripe payemnt"
        ]);
        $identify = [
            'ticket_id' => Session::get('ticket_id'),
            'customer_id' => Auth::id()
        ];
        $data = [
            'ticket_id' => Session::get('ticket_id'),
            'customer_id' => Auth::id(),
            'payment_method' => "stripe",
            'transaction_id' => $charge->balance_transaction,
            'payment_amount' => $charge->amount,
            'currency' => $charge->currency ?? 'USD',
            'transaction_time' => Carbon::now(),
            'payment_status' => "Paid",
            'transaction_status' => "SUCCESS"
        ];
        Transaction::updateOrInsert($identify,$data);

        Ticket::find(Session::get('ticket_id'))->update(array('payment_status' => 'Paid'));

        return redirect()->route('payment-history')->with('message','Payment Successfull');
    }
}
