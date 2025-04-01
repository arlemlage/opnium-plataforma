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
  # This is Report Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Ticket;
use App\Model\Feedback;
use App\Model\Attendance;
use App\Model\Transaction;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Illuminate\Contracts\Foundation\Application;

class ReportController extends Controller
{
     /**
     * Activity Report
     */
    public function agentReport()
    {
        $obj = null;
        $agent = request()->get('agent');
        $start_date = !empty(request()->get('start_date'))? date('Y-m-d', strtotime(request()->get('start_date'))):null;
        $end_date = !empty(request()->get('end_date'))? date('Y-m-d', strtotime(request()->get('end_date'))):null;
        $type_id = request()->get('type_id');
        $order_by = request()->get('order_by');
        
        $obj = Ticket::with(['getCreatedBy'])->where('status', 2)->where('del_status', 'Live');

        if(!empty($agent)){
            $obj->whereRaw('FIND_IN_SET("'.encrypt_decrypt($agent,'decrypt').'", assign_to_ids)');
        }
        if(!empty($start_date)){
            $obj->whereDate('created_at', '>=', $start_date);
        }
        if(!empty($end_date)){
            $obj->whereDate('created_at', '<=', $end_date);
        }
        if(!empty($order_by)){
            $obj->orderBy('id', $order_by);
        }

        $obj->orderBy('duration', 'DESC');
        $obj = $obj->paginate(150);
        
        $all_agents = User::where('del_status', 'Live')->where('role_id', 2)->get();
        $agent_id = $agent;
        return view('report.agent-performance-report', compact('all_agents', 'obj','agent_id','start_date','end_date','order_by'));
    }

    /**
     * Support history report
     * @return Application|Factory|View
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function supportHistoryReport()
    {
        $purchase_code = request()->get('purchase_code');
        $customer_id = request()->get('customer');
        $agent_id = request()->get('agent');
        $obj = Ticket::live()->where('status', 2);
        if(!empty($purchase_code)){
            $obj->where('envato_p_code', $purchase_code);
        }
        if(!empty($customer_id)){
            $obj->where('customer_id', encrypt_decrypt($customer_id,'decrypt'));
        }
        if(!empty($agent_id)){
            $obj->whereRaw('FIND_IN_SET("'.encrypt_decrypt($agent_id,'decrypt').'", assign_to_ids)');
        }
        $obj->orderBy('duration', 'DESC');
        $results = $obj->get();
        $all_agents = User::live()->agent()->get();
        $all_customers = User::live()->customer()->get();
        return view('report.support-history-report', compact('all_agents', 'all_customers', 'results','purchase_code','customer_id','agent_id'));
    }
    /**
     * Transaction report
     * @return Application|Factory|View
     */
    public function transactionReport() {
        $ticket_id = request()->get('ticket_id');
        $customer_id = request()->get('customer_id');
        $from_date = request()->get('from_date');
        $to_date = request()->get('to_date');
        $transaction_id = request()->get('transaction_id');
        $gateway = request()->get('gateway');

        $payment = Transaction::query();
        if(isset($ticket_id) && $ticket_id){
            $payment->where('ticket_id',encrypt_decrypt($ticket_id,'decrypt'));
        }
        if(isset($customer_id) && $customer_id){
            $payment->where('customer_id',encrypt_decrypt($customer_id,'decrypt'));
        }

        if(isset($transaction_id) && $transaction_id){
            $payment->where('transaction_id',"LIKE","%{$transaction_id}%");
        }
        if(isset($gateway) && $gateway){
            $payment->where('payment_method',$gateway);
        }

        if ((isset($from_date)) && $from_date OR (isset($to_date) && $to_date)) {
            if (isset($from_date) && !isset($to_date)) {
                $payment->whereDate('updated_at',date($from_date));
            }
            if (isset($to_date) && !isset($from_date)) {
                $payment->whereDate('updated_at','<=',date($to_date));
            }
            if (isset($from_date) AND isset($to_date)) {
                $payment->whereBetween('updated_at', [date($from_date), date($to_date)]);
            }
        }

        $results = $payment->oldest()->get();

        $tickets = Ticket::live()->where('paid_support','Yes')->get();
        $customerIds = Ticket::where('paid_support','Yes')->live()->pluck('customer_id');
        $customers = User::whereIn('id',$customerIds)->get();
        return view('report.transaction_report',compact('results','tickets','customers','ticket_id','customer_id','from_date','to_date','transaction_id','gateway'));
    }

    /**
     * Attendance report
     */
    public function attendanceReport() {
        $data = Attendance::query();
         $user_id = request()->get('user_id');
         $from_date  = request()->get('from_date');
         $to_date  = request()->get('to_date');
         if(!empty($user_id)){
             $data->where('user_id',encrypt_decrypt($user_id,'decrypt'));
         }
         if (!empty($from_date) && empty($to_date)) {
             $data->whereDate('attendance_date',date($from_date));
         }
         if (!empty($to_date) && empty($from_date)) {
             $data->whereDate('attendance_date','<=',date($to_date));
         }
         if (!empty($from_date) AND !empty($to_date)) {
             $data->whereBetween('attendance_date', [date($from_date), date($to_date)]);
         }
         
         $data->orderBy('id','asc');
         $results = $data->get();
         $users = User::where('role_id','!=',3)->get();
         $user = User::find($user_id);
         $download = request()->get('download');
         if(isset($download) && $download == "Yes"){
             $report = PDF::loadView('attendance.pdf_report',compact('results','user','from_date','to_date'));
             return $report->download('attendance report' . '.pdf');
         } else{
             return view('report.attendance_report',compact('results','users','user','user_id','from_date','to_date'));
         }
    }

    /**
     * Customer feedback report
     */
    public function index()
    {
        $agent_id = request()->get('agent');
        $start_date = !empty(request()->get('start_date'))? date('Y-m-d', strtotime(request()->get('start_date'))):null;
        $end_date = !empty(request()->get('end_date'))? date('Y-m-d', strtotime(request()->get('end_date'))):null;
        $order_by = request()->get('order_by');

        $obj = Feedback::join('tbl_tickets', 'tbl_feedbacks.ticket_id', '=', 'tbl_tickets.id')
            ->select('tbl_feedbacks.*', 'tbl_tickets.ticket_no', 'tbl_tickets.title', 'tbl_tickets.customer_id', 'tbl_tickets.assign_to_ids')
            ->where('tbl_feedbacks.del_status', 'Live');

        if(!empty($agent_id)){
            $obj->whereRaw('FIND_IN_SET("'.encrypt_decrypt($agent_id,'decrypt').'", tbl_tickets.assign_to_ids)');
        }
        if(!empty($start_date)){
            $obj->whereDate('tbl_feedbacks.created_at', '>=', $start_date);
        }
        if(!empty($end_date)){
            $obj->whereDate('tbl_feedbacks.created_at', '<=', $end_date);
        }
        if(!empty($order_by)){
            $obj->orderBy('tbl_feedbacks.id', $order_by);
        }
        $obj->orderBy('id', 'DESC');
        $obj = $obj->get();
        $all_agents = User::where('del_status', 'Live')->where('role_id', 2)->get();

        return view('report.customer-feedback-report', compact('all_agents', 'obj','agent_id','start_date','end_date','order_by'));
    }
}
