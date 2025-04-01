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
  # This is Make Recurring Payment Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class MakeRecurringPayment extends Controller
{
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processPaypalTransaction(Request $request, $payment_id)
    {
        $ticket_info = Ticket::findOrFail(encrypt_decrypt($ticket_id,'decrypt'));
        Session::put('ticket_id',encrypt_decrypt($ticket_id,'decrypt'));
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $ticket_info->amount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()->route('make-payment',$ticket_id)->with('error', 'Something went wrong.');

        } else {
            return redirect()->route('make-payment',$ticket_id)->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successPaypalTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $status = $response['status'];
            $purches_units = $response['purchase_units'];
            foreach ($purches_units as $purches_unit) {
                $payment_result = $purches_unit['payments']['captures'];
                foreach ($payment_result as $payment){
                    $tran_id = $payment['id'];
                    $tran_amount = $payment['amount']['value'];

                    $identify = [
                        'ticket_id' => Session::get('ticket_id'),
                        'customer_id' => Auth::id()
                    ];
                    $data = [
                        'ticket_id' => Session::get('ticket_id'),
                        'customer_id' => Auth::id(),
                        'payment_method' => "paypal",
                        'transaction_id' => $tran_id,
                        'payment_amount' => $tran_amount,
                        'currency' => $payment['amount']['currency_code'],
                        'transaction_time' => Carbon::now(),
                        'payment_status' => "Paid",
                        'transaction_status' => $status
                    ];
                    Transaction::updateOrInsert($identify,$data);

                    Ticket::find(Session::get('ticket_id'))->update(array('payment_status' => 'Paid'));
                }
            }
            return redirect()
                ->route('customer.dashboard')
                ->with('message', 'Payment Successfull');
        } else {
            return redirect()
                ->route('createTransaction')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelPaypalTransaction(Request $request)
    {
        return redirect()
            ->route('parent.payments')
            ->with('error', $response['message'] ?? 'You have canceled the transaction.');
    }
}
