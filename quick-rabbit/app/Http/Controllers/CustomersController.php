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
  # This is Customers Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\CustomerNote;
use App\Model\SiteSetting;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $obj = User::query()->where('role_id', 3);
        $obj->orderBy('id','DESC');
        $obj = $obj->get();
        return view('customers.index', compact('obj'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.add_edit');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $generated_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
        $site_setting_info = SiteSetting::first();
        if($request->ajax()){
            if (!empty($request->first_name) && !empty($request->last_name) && !empty($request->email) && filter_var($request->email, FILTER_VALIDATE_EMAIL) && !empty($request->status)){
                $check_exist = User::where('email', $request->email)->first();
                if(isset($request->mobile) && $request->mobile) {
                    $check_mobile_exists = User::where('mobile', $request->mobile)->first();
                }
                if (!empty($check_exist)){
                    $data = [
                        'first_name'=>(($request->first_name=='')?__('index.first_name_required'):''),
                        'last_name'=>(($request->last_name=='')?__('index.last_name_required'):''),
                        'email'=> __('index.email.unique'),
                        'status'=>0
                    ];
                    return  $data;
                }

                if (!empty($check_mobile_exists)){
                    $data = [
                        'first_name'=>(($request->first_name=='')?__('index.first_name_required'):''),
                        'last_name'=>(($request->last_name=='')?__('index.last_name_required'):''),
                        'mobile'=> __('index.mobile.unique'),
                        'status'=>0
                    ];
                    return  $data;
                }
                $obj = new User();
                $obj->setting_id = !empty($site_setting_info)? $site_setting_info->id:1;
                $obj->role_id = 3;
                $obj->type = 'Customer';
                $obj->first_name = $request->first_name;
                $obj->last_name = $request->last_name;
                $obj->email = $request->email;
                $obj->mobile = $request->mobile ?? null;
                $obj->password = Hash::make($generated_password);
                $obj->need_change_password = true;
                $obj->plain_password = $generated_password;
                $obj->status = !empty($request->status)? $request->status:null;
                $obj->created_by = Auth::user()->id;
                $obj->save();

                User::sendVerificationEmail($obj->email);

                $to_email = [$request->email];

                if (!empty($to_email)){
                    $mail_data = [
                        'to' => $to_email,
                        'subject' => 'Welcome to '.siteSetting()->company_name ?? "Supporty",
                        'user_name' => $obj->full_name,
                        'body' => 'Your login credentials have been given below. Please login into your account and change your password.',
                        'email' => $obj->email,
                        'password' => $generated_password,
                        'login_url' => route('customer.login'),
                        'view' => 'create-new-customer-mail',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }

                $selected_customer_id = $obj->id;
                $customers = User::where('del_status', 'Live')->where('role_id', 3)->get();

                $all_customer_options = '';
                foreach ($customers as $t){
                    $selected = ($t->id==$selected_customer_id)?"selected":"";
                    $all_customer_options .= '<option value="'.$t->id.'" '.$selected.'>'.$t->first_name.' '.$t->last_name.'('.$t->email.')</option></br>';
                }
                $all_customer_options = explode('</br>', $all_customer_options);

                $data = [
                    'msg'=>'Customer has been stored successfully',
                    'status'=>1,
                    'all_customer_options'=>$all_customer_options,
                    'selected_customer_id'=>$selected_customer_id,
                ];
                return  $data;
            }
            else{
                $is_valid = 1;
                if (!empty($request->email) && !filter_var($request->email, FILTER_VALIDATE_EMAIL)){
                    $is_valid = 0;
                }
                $data = [
                    'first_name'=>(($request->first_name=='')?__('index.first_name_required'):''),
                    'last_name'=>(($request->last_name=='')?__('index.last_name_required'):''),
                    'email'=> (!empty($request->email)? (($is_valid==1)? '':__('index.email.email')):__('index.email_required')),
                    'status'=>0
                ];
                return  $data;
            }
        } else {
            $this->validate($request,[
                'first_name' => 'required|max:191',
                'last_name' => 'required|max:191',
                'email' => 'required|email|max:50|unique:tbl_users',
                'status' => 'required',
            ],[
                'first_name.required' => __('index.first_name_required'),
                'first_name.max' => __('index.first_name_max_191'),
                'last_name.required' => __('index.last_name_required'),
                'last_name.max' => __('index.last_name_max_191'),
                'email.required' => __('index.email_required'),
                'email.email' => __('index.valid_email.email'),
                'email.unique' => __('index.email.unique'),
                'email.max' => __('index.email_max_50'),
                'status.required' => __('index.status_required'),
            ]);

            $obj = new User();
            $obj->setting_id = !empty($site_setting_info)? $site_setting_info->id:1;
            $obj->role_id = 3;
            $obj->type = 'Customer';
            $obj->first_name = $request->first_name;
            $obj->last_name = $request->last_name;
            $obj->email = $request->email;
            $obj->mobile = $request->mobile ?? null;
            $obj->password = Hash::make($generated_password);;
            $obj->plain_password = $generated_password;
            $obj->need_change_password = true;
            $obj->status = !empty($request->status)? $request->status:null;
            $obj->created_by = Auth::user()->id;

            $to_email = [$request->email];

            if ($obj->save()){
                if (!empty($request->note) && !empty($request->note[0])){
                    foreach($request->note as $n){
                        $customer_note = new CustomerNote();
                        $customer_note->customer_id = $obj->id;
                        $customer_note->note = $n;
                        $customer_note->save();
                    }
                }
                
                User::sendVerificationEmail($obj->email);
                
                if (!empty($to_email)){
                    $mail_data = [
                        'to' => $to_email,
                        'subject' => 'Welcome to '.siteSetting()->company_name ?? "Quick Rabbit",
                        'user_name' => $obj->full_name,
                        'body' => 'Your login credentials has been given below. Please login to your account and change your password.',
                        'email' => $obj->email,
                        'password' => $generated_password,
                        'login_url' => route('customer.login'),
                        'view' => 'create-new-customer-mail',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
                return redirect('customer')->with(saveMessage());
            }else{
                return redirect()->back()->with(waringMessage());
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = User::find($id);
        $notes = CustomerNote::where('customer_id', $id)->where('del_status', 'Live')->get();
        return view('customers.view', compact('obj', 'notes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = User::find($id);
        return view('customers.add_edit', compact('obj'));
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
        if(appMode() == "demo") {
            abort(405);
        }
        $this->validate($request,[
            'first_name' => 'required|max:191',
            'last_name' => 'required|max:191',
            'email' => 'required|email|max:50',
            'mobile' => 'unique:tbl_users,mobile, ' . $id . '',
            'status' => 'required',
        ],[
            'first_name.required' => __('index.first_name_required'),
            'first_name.max' => __('index.first_name_max_191'),
            'last_name.required' => __('index.last_name_required'),
            'last_name.max' => __('index.last_name_max_191'),
            'email.required' => __('index.email_required'),
            'email.email' => __('index.valid_email.email'),
            'email.max' => __('index.email_max_50'),
            'status.required' => __('index.status_required'),
            'mobile.unique' => __('index.mobile.unique'),
        ]);

        $generated_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
        $site_setting_info = SiteSetting::first();

        $id = encrypt_decrypt($id, 'decrypt');
        $obj = User::find($id);
        $obj->setting_id = !empty($site_setting_info)? $site_setting_info->id:1;
        $obj->role_id = 3;
        $obj->type = 'Customer';
        $obj->first_name = $request->first_name;
        $obj->last_name = $request->last_name;
        $obj->mobile = $request->mobile ?? '';
        $obj->password = Hash::make($generated_password);
        $obj->plain_password = $generated_password;
        $obj->status = !empty($request->status)? $request->status:null;
        $obj->created_by = Auth::user()->id;

        if($request->email !== $obj->email) {
            if(User::where('email',$request->email)->exists()) {
                return redirect()->back()->with([
                    'email_error'=>'The Email is already registered.',
                    'email' => $request->email
                ]);
            } else {
                $obj->update(array('email' => $request->email));
                User::sendVerificationEmail($request->email);
                $obj->is_email_verified = 0;
            }
        }

        if (!empty($request->note) && !empty($request->note[0])){
            CustomerNote::whereIn('customer_id',array($id))->delete();
            foreach($request->note as $n){
                $customer_note = new CustomerNote();
                $customer_note->customer_id = $id;
                $customer_note->note = $n;
                $customer_note->save();
            }
        }

        if ($obj->save()){
            return redirect('customer')->with(updateMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = encrypt_decrypt($id, 'decrypt');
        $obj = User::find($id);
        $obj->del_status = "Deleted";
        $obj->email = $obj->email.'-deleted';
        $obj->save();
        $obj->delete();
        return redirect('customer')->with(deleteMessage());
    }

    /**
     * Reset customer password
     */
    public function resetCustomerPassword($customer_id) {
        if(appMode() == "demo") {
            abort(405);
        }
        $customer = User::findOrFail(encrypt_decrypt($customer_id,'decrypt'));
        $generated_password = substr(md5(uniqid(random_int(0, 50), true)), 0, 6);
        $customer->plain_password = $generated_password;

        $mail_data = [
            'to' => array('name'=>"",'email'=>$customer->email),
            'subject' => "Temporary login credentials",
            'user_name' => $customer->full_name,
            'body' => 'Your temporary login credentials have been given below. Please login into your account and change your password.',
            'email' => $customer->email,
            'password' => $generated_password,
            'login_url' => route('customer.login'),
            'view' => 'create-new-customer-mail',
        ];

        MailSendController::sendMailToUser($mail_data);

        $customer->password = Hash::make($generated_password);
        $customer->need_change_password = true;
        $customer->save();
        return redirect()->route('customer.index')->with(updateMessage());
    }
}
