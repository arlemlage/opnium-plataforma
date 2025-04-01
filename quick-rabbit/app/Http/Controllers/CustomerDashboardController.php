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
  # This is Customer Dashboard Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\RecurringPayment;
use App\Model\RecurringPaymentDate;
use App\Model\Transaction;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDashboardController extends Controller
{
    /**
     * Redirect to customer dashboard
     */
     public function dashboard() {
        $today = Carbon::today();
        return view('customer-activity.dashboard', compact('today'));
    }

    /**
     * Customer payment history
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function paymentHistory() {
         $data = Transaction::where('customer_id',Auth::id());
         $results = $data->oldest()->get();
         return view('customer-activity.payment_history',compact('results'));
    }

    /**
     * Recurring payments
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function recurringPayment() {
        $data = RecurringPaymentDate::where('customer_id',Auth::id());
        $results = $data->orderBy('recurring_payment_date','desc')->get();
        return view('customer-activity.recurring-payment.payment_list',compact('results'));
    }

    /**
     * Select payment method view
     */
    public function selectPaymentMethod($payment_id) {
        $payment = RecurringPaymentDate::findOrFail(encrypt_decrypt($payment_id,'decrypt'));
        return view('customer-activity.recurring-payment.select_payment_method',compact('payment'));
    }
}
