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
  # This is Recurring Payment Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\ProductCategory;
use App\Model\RecurringPayment;
use App\Model\RecurringPaymentDate;
use App\Model\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class RecurringPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = request()->get('customer_id');
        $start_date = !empty(request()->get('start_date'))? date('Y-m-d', strtotime(request()->get('start_date'))):'';
        $end_date = !empty(request()->get('end_date'))? date('Y-m-d', strtotime(request()->get('end_date'))):'';
        
        $data = RecurringPayment::query();
        if(appTheme() == 'single'){
            $product_category = ProductCategory::where('del_status','Live')->where('type','single')->pluck('id');
            $data->whereIn('product_cat_ids', $product_category);
        }
        if(!empty($start_date)){
            $data->whereDate('created_at', '>=', $start_date);
        }
        if(!empty($end_date)){
            $data->whereDate('created_at', '<=', $end_date);
        }
        if(!empty($customer_id)){
            $data->where('customer_id',encrypt_decrypt($customer_id,'decrypt'));
        }

        $results = $data->get();
        $customers = User::customer()->live()->get();
        return view('recurring-payment.recurring_payment_list',compact('results','customers','start_date','end_date','customer_id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $customers = User::where('role_id', 3)->where('id', '!=', 3)->where('del_status', 'Live')->get();

        return view('recurring-payment.recurring_payment_add_edit',compact('product_category','customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|max:100',
            'payment_period_in_days' => 'required|max:3',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'max:100'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'payment_period_in_days.max' => __('index.payment_period_in_days_max_3'),
            'start_date.required' => __('index.start_date_field_required'),
            'end_date.required' => __("index.end_date_field_required")
        ]);
        $row = new RecurringPayment();
        $row->title = $request->title;
        $row->start_date = date("Y-m-d",strtotime($request->start_date));
        $row->end_date = date("Y-m-d",strtotime($request->end_date));
        $row->customer_id = $request->customer_id;
        $row->payment_period_in_days = $request->payment_period_in_days;
        $row->description = $request->description;
        $row->amount = $request->amount;
        $row->product_cat_ids = empty($request->product_cat_ids)?null:implode(',', $request->product_cat_ids);
        $row->save();
        $startDate = date("Y-m-d",strtotime($request->start_date));
        $endDate = date("Y-m-d",strtotime($request->end_date));
        $dateRange = CarbonPeriod::create($startDate, $endDate);
        $payment_dates = [];
        foreach ($dateRange as $date) {
           $payment_dates[] = $date;
        }
        $total_dates = count($payment_dates);
        $loop_count = (int) $total_dates / $request->payment_period_in_days;
        $date = $payment_dates[0];
        for($i=0;$i<$loop_count;$i++) {
            $r_d = new RecurringPaymentDate();
            $r_d->recurring_id = $row->id;
            $r_d->customer_id = $row->customer_id;
            $r_d->recurring_payment_date = date('Y-m-d',strtotime($date));
            $r_d->payment_amount = $row->amount;
            $r_d->payment_status = "Unpaid";
            $r_d->save();
            $new_date = $date->addDays($request->payment_period_in_days);
            $date = $new_date;
        }
        return redirect()->route('recurring-payments.index')->with(saveMessage());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $results = RecurringPaymentDate::where('recurring_id',encrypt_decrypt($id,'decrypt'))->orderBy('recurring_payment_date','DESC')->get();
        return view('recurring-payment.details',compact('results'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = RecurringPayment::findOrFail(encrypt_decrypt($id,'decrypt'));
        $product_category = ProductCategory::live()->type()->pluck('title', 'id');
        $customers = User::where('role_id', 3)->where('id', '!=', 3)->where('del_status', 'Live')->get();

        return view('recurring-payment.recurring_payment_add_edit',compact('product_category','customers','data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $this->validate($request,[
            'title' => 'required|max:100',
            'payment_period_in_days' => 'required|max:3',
            'start_date' => 'required',
            'end_date' => 'required',
            'description' => 'max:100'
        ],[
            'title.required' => __('index.title_required'),
            'title.max' => __('index.title_max_100'),
            'payment_period_in_days.max' => __('index.payment_period_in_days_max_3'),
            'start_date.required' => __('index.start_date_field_required'),
            'end_date.required' => __("index.end_date_field_required")
        ]);
        $row = RecurringPayment::findOrFail(encrypt_decrypt($id,'decrypt'));
        $row->title = $request->title;
        $row->start_date = date("Y-m-d",strtotime($request->start_date));
        $row->end_date = date("Y-m-d",strtotime($request->end_date));
        $row->customer_id = $request->customer_id;
        $row->payment_period_in_days = $request->payment_period_in_days;
        $row->description = $request->description;
        $row->amount = $request->amount;
        $row->product_cat_ids = empty($request->product_cat_ids)?null:implode(',', $request->product_cat_ids);
        $row->save();
        $startDate = date("Y-m-d",strtotime($request->start_date));
        $endDate = date("Y-m-d",strtotime($request->end_date));
        $dateRange = CarbonPeriod::create($startDate, $endDate);
        $payment_dates = [];
        foreach ($dateRange as $date) {
           array_push($payment_dates,$date);
        }
        $total_dates = count($payment_dates);
        $loop_count = (int) $total_dates / $request->payment_period_in_days;
        RecurringPaymentDate::whereIn('recurring_id',array($row->id))->delete();
        $date = $payment_dates[0];
        for($i=0;$i<$loop_count;$i++) {
            $r_d = new RecurringPaymentDate();
            $r_d->recurring_id = $row->id;
            $r_d->customer_id = $row->customer_id;
            $r_d->recurring_payment_date = date('Y-m-d',strtotime($date));
            $r_d->payment_amount = $row->amount;
            $r_d->payment_status = "Unpaid";
            $r_d->save();
            $new_date = $date->addDays($request->payment_period_in_days);
            $date = $new_date;
        }
        return redirect()->route('recurring-payments.index')->with(updateMessage());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RecurringPayment::findOrFail(encrypt_decrypt($id,'decrypt'))->delete();
        return redirect()->route('recurring-payments.index')->with(deleteMessage());
    }
}
