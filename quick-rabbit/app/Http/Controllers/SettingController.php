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
  # This is Setting Controller
  ##############################################################################
 */

namespace App\Http\Controllers;

use App\Model\AiSetting;
use App\Model\ChatSetting;
use App\Model\GDPRSetting;
use App\Model\MailSetting;
use App\Model\SiteSetting;
use App\Model\MailTemplate;
use App\Model\TicketSetting;
use Illuminate\Http\Request;
use App\Model\PaymentSetting;
use App\Model\ProductCategory;
use App\Model\IntegrationSetting;
use App\Model\SocialLoginSetting;
use App\Model\ChatProductSequence;
use Illuminate\Support\Facades\DB;
use App\Model\ConfigurationSetting;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Model\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function siteSetting(){
        $data = SiteSetting::find(1);
        $time_zones = DB::table('tbl_time_zone')->where('del_status', 'Live')->orderBy('zone_name','asc')->get();
        return view('setting.site_setting', compact('time_zones', 'data'));
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aiSetting(){
        $data = AiSetting::find(1);
        return view('setting.ai_setting', compact('data'));
    }
    /**
     * update site setting data
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateSiteSetting(Request  $request){

        $this->validate($request,[
            'company_name' => 'required|max:100',
            'title' => 'required|max:100',
            'email' => 'required|email|max:50',
            'phone' => 'required|max:20',
            'skype' => 'required|max:50',
            'address' => 'required|max:300',
            'footer' => 'required|max:300',
            'footer_text' => 'required|max:255',
            'banner_text' => 'required|max:200',
            'banner_slogan' => 'required|max:200',
            'date_format' => 'required',
            'timezone' => 'required',
            'language' => 'required',
            'support_policy' => 'required',
            'is_captcha' => 'required',
        ],[
            'company_name.required' => __('index.company_name_required'),
            'title.required' => __('index.title_required'),
            'email.required' => __('index.email_required'),
            'email.email' => __('index.valid.email'),
            'phone.required' => __('index.phone_required'),
            'address.required' => __('index.address_required'),
            'footer.required' => __('index.footer_required'),
            'footer_text.required' => __('index.footer_text_required'),
            'banner_text.required' => __('index.banner_text_required'),
            'banner_slogan.required' => __('index.banner_slogan_required'),
            'date_format.required' => __('index.date_format_required'),
            'timezone.required' => __('index.timezone.required'),
            'language.required' => __('index.language_required'),
            'support_policy.required' => __('index.support_policy_required'),
            'company_name.max' => __("index.company_max_100"),
            'title.max' => __("index.site_title_max_100"),
            'email.max' => __("index.email_max_50"),
            'phone.max' => __("index.phone_max_20"),
            'address.max' => __("index.address_max_300"),
            'footer.max' => __("index.footer_max_300"),
            'banner_text.max' => __("index.banner_text_max_200"),
            'banner_slogan.max' => __("index.banner_slogan_200"),
        ]);

        $site_setting = SiteSetting::where('del_status', 'Live')->first();
        if (empty($site_setting)){
            $site_setting = new SiteSetting();
        }

        $site_setting->company_name = saveJsonText($request->company_name);
        $site_setting->title = saveJsonText($request->title);
        $site_setting->email = saveJsonText($request->email);
        $site_setting->phone = saveJsonText($request->phone);
        $site_setting->skype = saveJsonText($request->skype);
        $site_setting->address = saveJsonText($request->address);
        $site_setting->g_map_url = saveJsonText($request->g_map_url);
        $site_setting->footer = saveJsonText($request->footer);
        $site_setting->footer_text = saveJsonText($request->footer_text);
        $site_setting->banner_text = saveJsonText($request->banner_text);
        $site_setting->banner_slogan = saveJsonText($request->banner_slogan);
        $site_setting->date_format = saveJsonText($request->date_format);
        $site_setting->timezone = saveJsonText($request->timezone);
        $site_setting->language = saveJsonText($request->language);
        $site_setting->website_url = saveJsonText($request->website_url);
        $site_setting->facebook_url = saveJsonText($request->facebook_url);
        $site_setting->linked_in_url = saveJsonText($request->linked_in_url);
        $site_setting->twitter_url = saveJsonText($request->twitter_url);
        $site_setting->dribble_url = saveJsonText($request->dribble_url);
        $site_setting->instagram_url = saveJsonText($request->instagram_url);
        $site_setting->pinterest_url = saveJsonText($request->pinterest_url);
        $site_setting->support_policy = $request->support_policy;
        $site_setting->is_captcha = saveJsonText($request->is_captcha);

        if($site_setting->logo == Null) {
            return redirect()->back()->with('logo_error','The Logo field is required.');
        }

        if($request->file('logo')) {
            $logo = $request->file('logo');
            if(! isImage($logo)) {
                return redirect()->back()->with('logo_error','The Logo should be valid image');
            }
            $image_info = imageInfo($logo);

            $allowed_extension = array('jpg','jpeg','png');

            if(! in_array($image_info['extension'],$allowed_extension)) {
                return redirect()->back()->with('logo_error','The Logo should be type of jpg, jpeg or png.');
            }

            if($image_info['width'] != 250 OR $image_info['height'] != 45) {
                return redirect()->back()->with('logo_error','The Logo should be size of width: 250px and height: 45px');
            }

            if (uploadedFileSizeInMb($logo->getSize()) > 2){
                return redirect()->back()->with('logo_error','The Logo should be size of 2MB');
            }

            $site_setting->logo = uploadImage($logo,'settings/');
        }
        
        if($site_setting->icon == Null) {
            return redirect()->back()->with('icon_error','The Icon field is required.');
        }

        if($request->file('icon')) {
            $icon = $request->file('icon');

            if(! isImage($icon)) {
                return redirect()->back()->with('icon_error','The Icon should be valid image');
            }

            $image_info = imageInfo($icon);
            if($image_info['extension'] !== 'ico') {
                return redirect()->back()->with('icon_error','The Icon should be type of ico.');
            }

            if($image_info['width'] > 100 OR $image_info['height'] > 100) {
                return redirect()->back()->with('icon_error','The Icon should be on size of width: 100px and height: 100px');
            }

            if (uploadedFileSizeInMb($icon->getSize()) > 1){
                return redirect()->back()->with('icon_error','The Icon should be size of 1MB');
            }

            $site_setting->icon = uploadFile($icon,'settings/');
        }
        if($site_setting->save()){
            $newJsonString = json_encode($site_setting, JSON_PRETTY_PRINT);
            file_put_contents(base_path('assets/json/site_setting.json'), stripslashes($newJsonString));
            return redirect()->route('site-setting')->with(updateMessage());
        } else{
            return redirect()->route('site-setting')->with(waringMessage());
        }
    }
/**
     * update ai setting data
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAiSetting(Request  $request){

        $this->validate($request,[
            'api_key' => 'required_if:type, yes',
            'organization_key' => 'required_if:type,yes',
        ],[
            'api_key.required' => __('index.api_key_required'),
            'organization_key.required' => __('index.organization_key_required')
        ]);

        $ai_setting = AiSetting::where('del_status', 'Live')->first();
        if (empty($ai_setting)){
            $ai_setting = new AiSetting();
        }

        $ai_setting->api_key = saveJsonText($request->api_key);
        $ai_setting->type = saveJsonText($request->type);
        $ai_setting->organization_key = saveJsonText($request->organization_key);
        //update data for demo only.    
        if(appMode() == "demo") {
            $newJsonString = json_encode($ai_setting, JSON_PRETTY_PRINT);
            file_put_contents(base_path('assets/demo/ai_setting.json'), stripslashes($newJsonString));
        }

        if($ai_setting->save()){
            $newJsonString = json_encode($ai_setting, JSON_PRETTY_PRINT);
            file_put_contents(base_path('assets/json/ai_setting.json'), stripslashes($newJsonString));
            return redirect()->route('ai-setting')->with(updateMessage());
        } else{
            return redirect()->route('ai-setting')->with(waringMessage());
        }
    }

    /**
     * Ticket setting form
     * @return \Illuminate\Http\Response
     */
    public function ticketSetting()
    {
        $obj = TicketSetting::first();
        if(! isset($obj)) {
            TicketSetting::insert(['created_at' => now()]);
            $obj = TicketSetting::first();
        }
        return view('setting.ticket_setting', compact('obj'));
    }

    /**
     * Update ticket setting
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateTicketSetting(Request $request)
    {
        $this->validate($request,[
            'default_sign' => 'max:100'
        ]);

        $obj = TicketSetting::first();
        if (empty($obj)){
            $obj = new TicketSetting();
        }
        
        $obj->allow_s_ticket = saveJsonText($request->allow_s_ticket) ?? 'off';
        $obj->closed_ticket_rating = saveJsonText($request->closed_ticket_rating) ?? 'off';
        $obj->auto_email_reply = saveJsonText($request->auto_email_reply) ?? 'off';
        $obj->default_sign = saveJsonText($request->default_sign) ?? 'Regards,&#13;&#10;'.siteSetting()->title.' Support';

        if ($obj->save()){
            return redirect('ticket-setting')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Chat setting form
     * @return \Illuminate\Http\Response
     */
    public function chatSetting()
    {
        $data = ChatSetting::first();
        if(! isset($data)) {
            ChatSetting::insert(['created_at' => now()]);
            $data = ChatSetting::first();
        }
        return view('setting.chat_setting', compact('data'));
    }

    /**
     * Update chat setting
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateChatSetting(Request $request)
    {
        //chat setting restriction checking
        
        $this->validate($request,[
            'out_of_schedule_time_message' => 'max:200',
            'channel_name' => 'max:100',
            'app_id' => 'max:200',
            'app_key' => 'max:200',
            'app_secret' => 'max:200',
            'app_cluster' => 'max:20'
        ]);

        $this->validate($request,[
            'out_of_schedule_time_message' => 'required_if:auto_reply_out_of_schedule,on'
        ],[
            'out_of_schedul_time_message.required_if' => __('index.notification_setting_required')
        ]);
        $chat_setting_info = ChatSetting::first();
        if (empty($chat_setting_info)){
            $chat_setting_info = new ChatSetting();
        }
        $chat_setting_info->chat_widget_show = !empty($request->chat_widget_show)? $request->chat_widget_show:null;
        $chat_setting_info->chat_schedule_days = !empty($request->chat_schedule_days)? json_encode($request->chat_schedule_days):null;
        $chat_setting_info->start_time = !empty($request->start_time)? saveJsonText($request->start_time):null;
        $chat_setting_info->end_time = !empty($request->end_time)? saveJsonText($request->end_time):null;
        $chat_setting_info->auto_reply_out_of_schedule = !empty($request->auto_reply_out_of_schedule)? saveJsonText($request->auto_reply_out_of_schedule): 'off';
        $chat_setting_info->out_of_schedule_time_message = saveJsonText($request->out_of_schedule_time_message) ?? Null;

        $pusher_data['channel_name'] = saveJsonText($request->channel_name) ?? 'channel_name';
        $pusher_data['app_id'] = saveJsonText($request->app_id) ?? 'app_id';
        $pusher_data['app_key'] = saveJsonText($request->app_key) ?? 'app_key';
        $pusher_data['app_secret'] = saveJsonText($request->app_secret) ?? 'app_secret';
        $pusher_data['app_cluster'] = saveJsonText($request->app_cluster) ?? 'app_cluster';
        $newJsonString = json_encode($pusher_data, JSON_PRETTY_PRINT);

        if(appMode() == "demo") {
            file_put_contents(base_path('assets/demo/pusher.json'), stripslashes($newJsonString));
        } else {
            $running_pusher_info = pusherInfo();
            file_put_contents(base_path('assets/json/pusher.json'), stripslashes($newJsonString));
            $chat_setting_info->pusher_info = $newJsonString;
            $this->updateCredintial($running_pusher_info,pusherInfo());
        }
        
        if ($chat_setting_info->save()){    
            ConfigurationSetting::first()->update(array('chat_setting' => true));        
            return redirect('chat-setting')->with(updateMessage());
        }else{
            Session::flash('error', ' Information has not been stored successfully. Error!');
            return redirect()->back();
        }
    }

    /**
     * Update the Pusher credentials in app.js
     * @param  string  $old_value
     * @param  string  $new_value
     * @return void
     */
    public function updateCredintial($old_value,$new_value) {
        $appJsPath = base_path('js/app.js'); // Read the contents of app.js
        $appJsContents = File::get($appJsPath); // Replace the Pusher credentials
        $newAppJsContents = str_replace($old_value,$new_value,$appJsContents); // Write the modified contents back to app.js
        File::put($appJsPath, $newAppJsContents);
    }

    /**
     * Update chat Agent
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateChatAgent(Request $request) {
        ProductCategory::find($request->product_id)->update(array('first_chat_agent_id' => $request->agent_id));
        return redirect()->route('chat-sequence-setting')->with(updateMessage());
    }
    /**
     * Integration Setting form
     * @return \Illuminate\Http\Response
     */
    public function integrationSetting()
    {
        $data = IntegrationSetting::first();
        if(! isset($data)) {
            IntegrationSetting::insert(['created_at' => now()]);
            $data = IntegrationSetting::first();
        }
        return view('setting.integration_setting', compact('data'));
    }

     /**
     * Update Integration Setting
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateIntegrationSetting(Request $request)
    {
        //chat setting restriction checking
         
        $this->validate($request,[
            'envato_api_key' => 'max:100'
        ]);

        $integration = IntegrationSetting::firstOrCreate(['created_by'=>Auth::id()]);
        $integration->envato_set_up = !empty($request->envato_set_up)? $request->envato_set_up:'off';
        $integration->envato_api_key = !empty($request->envato_api_key)?saveJsonText($request->envato_api_key):null;
        $integration->ticket_submit_on_support_period_expired = !empty($request->ticket_submit_on_support_period_expired)? 'Yes' : 'No';

        if ($integration->save()){
            return redirect('integration-setting')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Mail setting form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function mailSetting(){
        if(appMode() == "demo") {
            $jsonString = file_get_contents('assets/demo/smtp.json');
        } else {
            $jsonString = file_get_contents('assets/json/smtp.json');
        }
        
        $mail_setting_info = json_decode($jsonString,true);
        return view('setting.mail_setting', compact('mail_setting_info'));
    }

    /**
     * Update mail setting
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateMailSetting(Request $request){          
        
        $this->validate($request,[
            'mail_driver' => 'required|string|max:100',
            'mail_host' => 'required|string|max:100',
            'mail_port' => 'required|max:100',
            'mail_encryption' => 'required|string|max:15',
            'mail_username' => 'required|email|string|max:100',
            'mail_password' => 'required|string|max:100',
            'mail_from' => 'required|email|string|max:100',
            'mail_fromname' => 'required|string|max:100',
            'api_key' => 'required|string|max:200',
        ],[
            'mail_driver.required' => __('index.mail_driver_required'),
            'mail_host.required' => __('index.mail_host_required'),
            'mail_port.required' => __('index.mail_port_required'),
            'mail_encryption.required' => __('index.mail_encryption_required'),
            'mail_username.email' => __('index.mail_username_email'),
            'mail_password.required' => __('index.mail_password_required'),
            'mail_from.email' => __('index.mail_from_email'),
            'mail_fromname.required' => __('index.mail_fromname_required'),
            'api_key.required' => __('index.api_key_required'),
        ]);
        
        $mail_setting_info = MailSetting::first();
        $mail_setting_info->mail_driver = saveJsonText(escape_output($request->mail_driver));
        $mail_setting_info->mail_host = saveJsonText(escape_output($request->mail_host));
        $mail_setting_info->mail_port = saveJsonText(escape_output($request->mail_port));
        $mail_setting_info->mail_encryption = saveJsonText(escape_output($request->mail_encryption));
        $mail_setting_info->mail_username = saveJsonText(escape_output($request->mail_username));
        $mail_setting_info->mail_password = saveJsonText(escape_output($request->mail_password));
        $mail_setting_info->mail_from = saveJsonText(escape_output($request->mail_from));
        $mail_setting_info->from_name = saveJsonText(escape_output($request->mail_fromname));

        if ($mail_setting_info->save()){
            $smtp_data['mail_driver'] = saveJsonText($request->mail_driver);
            $smtp_data['mail_host'] = saveJsonText($request->mail_host);
            $smtp_data['mail_port'] = saveJsonText($request->mail_port);
            $smtp_data['mail_encryption'] = saveJsonText($request->mail_encryption);
            $smtp_data['mail_username'] = saveJsonText($request->mail_username);
            $smtp_data['mail_password'] = saveJsonText($request->mail_password);
            $smtp_data['mail_from'] = saveJsonText($request->mail_from);
            $smtp_data['from_name'] = saveJsonText($request->mail_fromname) ?? siteSetting()->company_name;
            $smtp_data['api_key'] = saveJsonText($request->api_key);
            $newJsonString = json_encode($smtp_data, JSON_PRETTY_PRINT);
            if(appMode() == "demo") {
                file_put_contents(base_path('assets/demo/smtp.json'), stripslashes($newJsonString));
            } else {
                file_put_contents(base_path('assets/json/smtp.json'), stripslashes($newJsonString));
            }
            ConfigurationSetting::first()->update(array('mail_setting' => true));
            return redirect()->back()->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * All mail template list
     */
    public function showAllTemplates(){
        $data = MailTemplate::latest('id')->get();
        return view('setting.mail_template_lists', compact('data'));
    }

    /**
     * Mail template edit form
     */
    public function editAllTemplate($id){
        $id = encrypt_decrypt($id, 'decrypt');
        $mail_template_info = MailTemplate::find($id);
        $users = ['Admin', 'Assigned Agents', 'Customer', 'All Agents',"Assigned CC"];
        return view('setting.mail_template_edit', compact('mail_template_info', 'users', 'id'));
    }

    /**
     * Update all mail template
     */
    public function updateAllTemplate(Request $request, $id){
        $id = encrypt_decrypt($id, 'decrypt');
        $mail_template_info = MailTemplate::find($id);
        $mail_template_info->customer_mail_subject = escape_output($request->customer_mail_subject);
        $mail_template_info->admin_agent_mail_subject = escape_output($request->admin_agent_mail_subject);
        $mail_template_info->customer_mail_body = $request->customer_mail_body;
        $mail_template_info->admin_agent_mail_body = $request->admin_agent_mail_body;
        $mail_template_info->mail_to = empty($request->mail_to)? null:json_encode($request->mail_to);

        if ($mail_template_info->save()){
            return redirect('mail-templates')->with(saveMessage());
        }else{
            return redirect()->back()->with(waringMessage());
        }
    }

    /**
     * Payment gateway setting form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function paymentGatewaySetting () {
        $data = PaymentSetting::first();
        if(!isset($data)){
            PaymentSetting::create([
                'ssl_active' => "Inactive",
                'paypal_active' => "Inactive",
                'stripe_active' => "Inactive"
            ]);
            $data = PaymentSetting::first();
            return view('setting.payment_gateway_setting',compact('data'));
        }else{
            return view('setting.payment_gateway_setting',compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePaymentGatewaySetting(Request $request)
    {
        $this->validate($request,[
            'paypal_client_id' => 'max:500',
            'paypal_client_secret' => 'max:500',
            'paypal_app_id' => 'max:500',
            'stripe_key' => 'max:500',
            'stripe_secret' => 'max:500',
        ]);
        $setting = PaymentSetting::firstOrFail();
        $setting->paypal_active = $request->paypal_active ?? "Inactive";
        $setting->paypal_client_id = $request->paypal_client_id;
        $setting->paypal_client_secret = $request->paypal_client_secret;
        $setting->paypal_app_id = $request->paypal_app_id;
        $setting->paypal_active_mode = $request->paypal_active_mode ?? "sanbox";
        $setting->stripe_active = $request->stripe_active ?? "Inactive";
        $setting->stripe_key = $request->stripe_key;
        $setting->stripe_secret = $request->stripe_secret;
        $setting->stripe_active_mode = $request->stripe_active_mode ?? "sanbox";
        $setting->save();

        $stripe_data['stripe_active'] = saveJsonText($request->stripe_active) ?? "Inactive";
        $stripe_data['stripe_key'] = saveJsonText($request->stripe_key);
        $stripe_data['stripe_secret'] = saveJsonText($request->stripe_secret);
        $stripe_data['stripe_active_mode'] = saveJsonText($request->stripe_active_mode) ?? "sanbox";
        
        $stripeJsonString = json_encode($stripe_data, JSON_PRETTY_PRINT);
        if(appMode() == "demo") {
            file_put_contents(base_path('assets/demo/stripe.json'), stripslashes($stripeJsonString));
        } else {
            file_put_contents(base_path('assets/json/stripe.json'), stripslashes($stripeJsonString));
        }

        $paypal_data['paypal_active'] = saveJsonText($request->paypal_active) ?? 'Active';
        $paypal_data['paypal_active_mode'] = saveJsonText($request->paypal_active_mode) ?? 'sanbox';
        $paypal_data['paypal_client_id'] = saveJsonText($request->paypal_client_id);
        $paypal_data['paypal_client_secret'] = saveJsonText($request->paypal_client_secret);
        $paypal_data['paypal_app_id'] = saveJsonText($request->paypal_app_id) ?? 'paypal_app_id';
        $paypalJsonString = json_encode($paypal_data, JSON_PRETTY_PRINT);

        if(appMode() == "demo") {
            file_put_contents(base_path('assets/demo/paypal.json'), stripslashes($paypalJsonString));
        } else {
            file_put_contents(base_path('assets/json/paypal.json'), stripslashes($paypalJsonString));
        }
        ConfigurationSetting::first()->update(array('payment_gateway_setting' => true));
        return redirect()->route('payment-gateway-setting')->with(updateMessage());
    }

    /**
     * Social Login setting form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function socialLoginSettingForm() {
        $data = SocialLoginSetting::first();
        if(!isset($data)){
            SocialLoginSetting::create([
                'redirect_base_url' => URL::to('/')
            ]);
            $data = PaymentSetting::first();
            return view('setting.social_login_setting',compact('data'));
        }else{
            return view('setting.social_login_setting',compact('data'));
        }
    }

    /**
     * Update social login setting
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateSocialLogin(Request $request) {
          
        $this->validate($request,[
            'google_client_id' => 'max:200',
            'google_client_secret' => 'max:200',
            'github_client_id' => 'max:200',
            'github_client_secret' => 'max:200',
            'linkedin_client_id' => 'max:200',
            'linkedin_client_secret' => 'max:200',
            'envato_client_id' => 'max:200',
            'envato_client_secret' => 'max:200'
        ]);

        $social_setting = SocialLoginSetting::first();
        $social_setting->redirect_base_url = URL::to('/');
        
        $social_setting->google_login = $request->google_login ?? "Inactive";
        $social_setting->google_client_id = $request->google_client_id ?? 'google_client_id';
        $social_setting->google_client_secret = $request->google_client_secret ?? 'google_client_secret';
        if($request->google_login) {
            ConfigurationSetting::first()->update(array('google_login' => true));
        } else {
            ConfigurationSetting::first()->update(array('google_login' => false));
        }

        $social_setting->github_login = $request->github_login ?? "Inactive";
        $social_setting->github_client_id = $request->github_client_id ?? 'github_client_id';
        $social_setting->github_client_secret = $request->github_client_secret ?? 'github_client_secret';
        if($request->github_login) {
            ConfigurationSetting::first()->update(array('github_login' => true));
        } else {
            ConfigurationSetting::first()->update(array('github_login' => false));
        }

        $social_setting->linkedin_login = $request->linkedin_login ?? "Inactive";
        $social_setting->linkedin_client_id = $request->linkedin_client_id ?? 'linkedin_client_id';
        $social_setting->linkedin_client_secret = $request->linkedin_client_secret ?? 'linkedin_client_secret';
        if($request->linkedin_login) {
            ConfigurationSetting::first()->update(array('linkedin_login' => true));
        } else {
            ConfigurationSetting::first()->update(array('linkedin_login' => false));
        }

        $social_setting->envato_login = $request->envato_login ?? "Inactive";
        $social_setting->envato_client_id = $request->envato_client_id ?? 'envato_client_id';
        $social_setting->envato_client_secret = $request->envato_client_secret ?? 'envato_client_secret';
        if($request->envato_login) {
            ConfigurationSetting::first()->update(array('envato_login' => true));
        } else {
            ConfigurationSetting::first()->update(array('envato_login' => false));
        }

        // Save as json
        $social_setting_data['redirect_base_url'] = saveJsonText(URL::to('/'));

        $social_setting_data['facebook_login'] = saveJsonText($request->facebook_login) ?? "Inactive";
        $social_setting_data['facebook_client_id'] = saveJsonText($request->facebook_client_id) ?? 'facebook_client_id';
        $social_setting_data['facebook_client_secret'] = saveJsonText($request->facebook_client_secret) ?? 'facebook_client_secret';

        $social_setting_data['google_login'] = saveJsonText($request->google_login) ?? "Inactive";
        $social_setting_data['google_client_id'] = saveJsonText($request->google_client_id) ?? 'google_client_id';
        $social_setting_data['google_client_secret'] = saveJsonText($request->google_client_secret) ?? 'google_client_secret';

        $social_setting_data['github_login'] = saveJsonText($request->github_login) ?? "Inactive";
        $social_setting_data['github_client_id'] = saveJsonText($request->github_client_id) ?? 'github_client_id';
        $social_setting_data['github_client_secret'] = saveJsonText($request->github_client_secret) ?? 'github_client_secret';

        $social_setting_data['linkedin_login'] = saveJsonText($request->linkedin_login) ?? "Inactive";
        $social_setting_data['linkedin_client_id'] = saveJsonText($request->linkedin_client_id) ?? 'linkedin_client_id';
        $social_setting_data['linkedin_client_secret'] = saveJsonText($request->linkedin_client_secret) ?? 'linkedin_client_secret';

        $social_setting_data['envato_login'] = saveJsonText($request->envato_login) ?? "Inactive";
        $social_setting_data['envato_client_id'] = saveJsonText($request->envato_client_id) ?? 'envato_client_id';
        $social_setting_data['envato_client_secret'] = saveJsonText($request->envato_client_secret) ?? 'envato_client_secret';

        $social_setting_data['twitter_login'] = saveJsonText($request->twitter_login) ?? "Inactive";
        $social_setting_data['twitter_client_id'] = saveJsonText($request->twitter_client_id) ?? 'twitter_client_id';
        $social_setting_data['twitter_client_secret'] = saveJsonText($request->twitter_client_secret) ?? 'twitter_client_secret';
        $social_setting->save();
        $newJsonString = json_encode($social_setting_data, JSON_PRETTY_PRINT);
        if(appMode() == "demo") {
            file_put_contents(base_path('assets/demo/social.json'), stripslashes($newJsonString));
        } else {
            file_put_contents(base_path('assets/json/social.json'), stripslashes($newJsonString));
        }
        
        return redirect()->route('social-login-setting')->with(updateMessage());
    }

    /**
     * Notification setting form
     *
     * @return \Illuminate\Http\Response
     */
    public function notificationSetting()
    {
        $obj = MailTemplate::oldest('id')->get();
        return view('setting.notification_setting', compact('obj'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateNotificationSetting(Request $request)
    {
        
         $this->validate($request,[
            'channel_name' => 'max:100',
            'pusher_app_id' => 'max:100',
            'app_key' => 'max:100',
            'app_secret' => 'max:100',
            'app_cluster' => 'max:10',
            'api_key' => 'max:200|required_if:browser_notification,==,1',
            'auth_domain' => 'max:200|required_if:browser_notification,==,1',
            'project_id' => 'max:200|required_if:browser_notification,==,1',
            'database_url' => 'max:200|required_if:browser_notification,==,1',
            'storage_bucket' => 'max:200|required_if:browser_notification,==,1',
            'messaging_sender_id' => 'max:200|required_if:browser_notification,==,1',
            'app_id' => 'max:200|required_if:browser_notification,==,1',
            'measurement_id' => 'max:200|required_if:browser_notification,==,1',
            'server_key' => 'max:200|required_if:browser_notification,==,1',
            'key_pair' => 'max:200|required_if:browser_notification,==,1',
        ],[
            'api_key.required_if' => __('index.api_key_required_if'),
            'auth_domain.required_if' => __('index.auth_domain_required_if'),
            'project_id.required_if' => __('index.project_id_required_if'),
            'database_url.required_if' => __('index.database_url_required_if'),
            'storage_bucket.required_if' => __('index.storage_bucket_required_if'),
            'messaging_sender_id.required_if' => __('index.messaging_sender_id_required_if'),
            'app_id.required_if' => __('index.app_id_required_if'),
            'measurement_id.required_if' => __('index.measurement_id_required_if'),
            'server_key.required_if' => __('index.server_key_required_if'),
            'key_pair.required_if' => __('index.key_pair_required_if'),
        ]);

        $pusher_data['channel_name'] = saveJsonText($request->channel_name) ?? 'channel_name';
        $pusher_data['app_id'] = saveJsonText($request->pusher_app_id) ?? 'app_id';
        $pusher_data['app_key'] = saveJsonText($request->app_key) ?? 'app_key';
        $pusher_data['app_secret'] = saveJsonText($request->app_secret) ?? 'app_secret';
        $pusher_data['app_cluster'] = saveJsonText($request->app_cluster) ?? 'app_cluster';
        $newJsonString = json_encode($pusher_data, JSON_PRETTY_PRINT);
        if(appMode() == "demo") {
            file_put_contents(base_path('assets/demo/pusher.json'), stripslashes($newJsonString));
        } else {
            $running_pusher_info = pusherInfo();
            file_put_contents(base_path('assets/json/pusher.json'), stripslashes($newJsonString));
            $this->updateCredintial($running_pusher_info,pusherInfo());
        }

        if(isset($request->browser_notification) && $request->browser_notification == 1) {
            SiteSetting::first()->update(array('browser_notification' => 'Yes'));
            $firebase_data['api_key'] = saveJsonText($request->api_key);
            $firebase_data['auth_domain'] = saveJsonText($request->auth_domain);
            $firebase_data['project_id'] = saveJsonText($request->project_id);
            $firebase_data['database_url'] = saveJsonText($request->database_url);
            $firebase_data['storage_bucket'] = saveJsonText($request->storage_bucket);
            $firebase_data['messaging_sender_id'] = saveJsonText($request->messaging_sender_id);
            $firebase_data['app_id'] = saveJsonText($request->app_id);
            $firebase_data['measurement_id'] = saveJsonText($request->measurement_id);
            $firebase_data['server_key'] = saveJsonText($request->server_key);
            $firebase_data['key_pair'] = saveJsonText($request->key_pair);
            $newJsonString = json_encode($firebase_data, JSON_PRETTY_PRINT);
            if(appMode() == "demo") {
                file_put_contents(base_path('assets/demo/firebase.json'), stripslashes($newJsonString));
            } else {
                $running_firebase_info = firebaseInfo();
                file_put_contents(base_path('assets/json/firebase.json'), stripslashes($newJsonString));
                $this->updateCredintial($running_firebase_info,firebaseInfo());
            }
            
        } else {
            SiteSetting::first()->update(array('browser_notification' => 'No'));
        }

        ConfigurationSetting::first()->update(array('notification_setting' => true));  

        if (!empty($request->disable_notifications) && ($request->disable_notifications=='1')){
            foreach (MailTemplate::all() as $template) {
                MailTemplate::find($template->id)->update([
                    'web_push_notification' => 'on',
                    'mail_notification' => 'on',
                ]);
            }
            return redirect('notification-setting')->with(updateMessage());
        } else {
            if (!empty($request->template_ids)){
                foreach ($request->template_ids as $key=>$val){
                    $obj = MailTemplate::find($val);
                    $obj->web_push_notification = $request->web_push_notification[$key];
                    $obj->mail_notification = $request->mail_notification[$key];
                    $obj->save();
                }
              
                return redirect('notification-setting')->with(updateMessage());
            } else{
                return redirect()->back()->with(waringMessage());
            }
        }
    }

    /**
     * Chat sequence form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function chatSequenceSetting() {
        $products = ProductCategory::live()->type()->sort()->get();
        $departments = Department::where('del_status','Live')->get();
        return view('setting.chat_sequence_setting',compact('products', 'departments'));
    }
     /**
     * Sort chat sequence agent
     */
    public function sortAgent(Request $request, $id) {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            foreach($arr as $sortOrder => $id){
                $agent = ChatProductSequence::find($id);
                $agent->sort_id = $sortOrder+1;
                $agent->save();
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    /**
     * Update chat sequence setting
     * @param Request $request
     * @return Request
     */
    public function updateChatSequenceSetting(Request $request) {
        return $request;
    }

    /**
     * GDPR Setting form
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function gdprSetting() {
        $data = GDPRSetting::first();
        if(!isset($data)){
            GDPRSetting::create([
                'created_at' => now()
            ]);
            $data = GDPRSetting::first();
            return view('setting.gdpr_setting',compact('data'));
        }else {
            return view('setting.gdpr_setting',compact('data'));
        }
    }

    /**
     * Update GDPR Setting
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function updateGDPRSetting(Request $request) {
        $this->validate($request,[
            'cookie_message_title' => 'max:100',
            'cookie_message' => 'max:300',
        ]);

        $row = GDPRSetting::first();
        $row->enable_gdpr = saveJsonText($request->enable_gdpr) ?? 'off';
        $row->view_cookie_notification_bar = saveJsonText($request->view_cookie_notification_bar) ?? 'off';
        $row->cookie_message_title = saveJsonText($request->cookie_message_title) ?? 'off';
        $row->cookie_message = saveJsonText($request->cookie_message);
        $row->policy_message_on_reg_form = saveJsonText($request->policy_message_on_reg_form) ?? 'off';
        $row->save();

         $gdpr_data['enable_gdpr'] = saveJsonText($request->enable_gdpr) ?? 'off';
         $gdpr_data['view_cookie_notification_bar'] = saveJsonText($request->view_cookie_notification_bar) ?? 'off';
         $gdpr_data['cookie_message_title'] = saveJsonText($request->cookie_message_title) ?? 'off';
         $gdpr_data['cookie_message'] = saveJsonText($request->cookie_message) ?? 'off';
         $gdpr_data['policy_message_on_reg_form'] = saveJsonText($request->policy_message_on_reg_form) ?? 'off';
         $newJsonString = json_encode($gdpr_data, JSON_PRETTY_PRINT);
         file_put_contents(base_path('assets/json/gdpr.json'), stripslashes($newJsonString));
        return redirect()->route('gdpr-setting')->with(updateMessage());
    }

    /**
     * About Us Setting
     */
    public function aboutUsSetting() {
        return view('setting.about_us_setting');
    }

     /**
     * Update About Us Setting
     */
    public function updatAboutSetting(Request $request) {
        $this->validate($request,[
            'about_us_content' => 'required',
            'about_us_image' => 'mimes:jpeg,jpg,png|dimensions:width=624,height=348|max:2048'
        ],[
            'about_us_content.required' => __('index.about_us_required')
        ]);
        $data['about_us_content'] = $request->about_us_content;
        if($request->file('logo')) {
            $data['about_us_image'] = uploadFile($request->file('logo'),'settings/','about-us');
        } else {
            $data['about_us_image'] = aboutUs()['about_us_image'] ?? '';
        }

        if($request->file('about_us_image_bottom')) {
            $data['about_us_image_bottom'] = uploadFile($request->file('about_us_image_bottom'),'settings/','about-us-bottom');
        } else {
            $data['about_us_image_bottom'] = aboutUs()['about_us_image_bottom'] ?? '';
        }
        $steps_txt = '';
        $description_txt = '';
        $icon = '';
        foreach($request->steps as $key=>$val){
            $steps_txt.=$val;
            $description_txt.=$request->descriptions[$key];
            if(isset($request->icon[$key])){
                $icon .= uploadFile($request->icon[$key],'settings/','about-us_'.$key);
            }else{
                $icon .= $request->old_icon[$key];
            }
            if(sizeof($request->steps) - 1>$key){
                $steps_txt.="|||";
                $description_txt.="|||";
                $icon .= "|||";
            }
        }
        $data['title'] = saveJsonText($request->title) ?? '';
        $data['offer'] = $request->offer ?? '';
        $data['milestone_title'] = saveJsonText($request->milestone_title) ?? '';
        $data['our_work_area_title'] = saveJsonText($request->our_work_area_title) ?? '';
        $data['milestone_title_description'] = saveJsonText($request->milestone_title_description) ?? '';
        $data['card_label_one'] = saveJsonText($request->card_label_one) ?? '';
        $data['card_label_one'] = saveJsonText($request->card_label_one) ?? '';
        $data['card_label_one_quantity'] = saveJsonText($request->card_label_one_quantity) ?? '0';
        $data['card_label_two'] = saveJsonText($request->card_label_two) ?? '';
        $data['card_label_two_quantity'] = saveJsonText($request->card_label_two_quantity) ?? '0';
        $data['card_label_three'] = saveJsonText($request->card_label_three) ?? '';
        $data['card_label_three_quantity'] = saveJsonText($request->card_label_three_quantity) ?? '0';
        $data['card_label_four'] = saveJsonText($request->card_label_four) ?? '';
        $data['card_label_four_quantity'] = saveJsonText($request->card_label_four_quantity) ?? '0';
        $data['our_work_steps'] = $steps_txt;
        $data['our_work_descriptions'] = $description_txt;
        $data['icon'] = $icon;
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/json/about_us.json'), stripslashes($newJsonString));
        return redirect()->route('about-us-setting')->with(updateMessage());

    }

    /**
     * Our Service Setting
     */
    public function ourServicesSetting() {
        return view('setting.our_service_setting');
    }

     /**
     * Update Our Service Setting
     */
    public function updatServiceSetting(Request $request) {
        $data['service_page_title'] = saveJsonText($request->service_page_title) ?? '';
        $data['sr_section_one_text'] = saveJsonText($request->sr_section_one_text) ?? '';
        $data['sr_section_one_content'] = saveJsonText($request->sr_section_one_content) ?? '';
        $data['sr_section_two_text'] = saveJsonText($request->sr_section_two_text) ?? '';
        $data['sr_section_two_content'] = saveJsonText($request->sr_section_two_content) ?? '';
        $data['sr_section_three_text'] = saveJsonText($request->sr_section_three_text) ?? '';
        $data['sr_section_three_content'] = saveJsonText($request->sr_section_three_content) ?? '';
        $data['sr_section_four_text'] = saveJsonText($request->sr_section_four_text) ?? '';
        $data['sr_section_four_content'] = saveJsonText($request->sr_section_four_content) ?? '';
        $data['sr_section_five_text'] = saveJsonText($request->sr_section_five_text) ?? '';
        $data['sr_section_five_content'] = saveJsonText($request->sr_section_five_content) ?? '';
        $data['sr_section_six_text'] = saveJsonText($request->sr_section_six_text) ?? '';
        $data['sr_section_six_content'] = saveJsonText($request->sr_section_six_content) ?? '';

        // Feature Section
        $data['feature_section_title'] = saveJsonText($request->feature_section_title) ?? '';
        $data['feature_section_sub_title'] = saveJsonText($request->feature_section_sub_title) ?? '';
        $data['sr_box_one_title'] = saveJsonText($request->sr_box_one_title) ?? '';
        $data['sr_box_one_content'] = saveJsonText($request->sr_box_one_content) ?? '';
        $data['sr_box_two_title'] = saveJsonText($request->sr_box_two_title) ?? '';
        $data['sr_box_two_content'] = saveJsonText($request->sr_box_two_content) ?? '';
        $data['sr_box_three_title'] = saveJsonText($request->sr_box_three_title) ?? '';
        $data['sr_box_three_content'] = saveJsonText($request->sr_box_three_content) ?? '';
        $data['sr_box_four_title'] = saveJsonText($request->sr_box_four_title) ?? '';
        $data['sr_box_four_content'] = saveJsonText($request->sr_box_four_content) ?? '';

        if($request->file('section_one_image')) {
            $data['section_one_image'] = uploadFile($request->file('section_one_image'),'settings/','our-service-one');
        } else {
            $data['section_one_image'] = ourService()['section_one_image'] ?? '';
        }

        if($request->file('section_two_image')) {
            $data['section_two_image'] = uploadFile($request->file('section_two_image'),'settings/','our-service-two');
        } else {
            $data['section_two_image'] = ourService()['section_two_image'] ?? '';
        }

        if($request->file('section_three_image')) {
            $data['section_three_image'] = uploadFile($request->file('section_three_image'),'settings/','our-service-three');
        } else {
            $data['section_three_image'] = ourService()['section_three_image'] ?? '';
        }

        if($request->file('section_four_image')) {
            $data['section_four_image'] = uploadFile($request->file('section_four_image'),'settings/','our-service-four');
        } else {
            $data['section_four_image'] = ourService()['section_four_image'] ?? '';
        }

        if($request->file('section_five_image')) {
            $data['section_five_image'] = uploadFile($request->file('section_five_image'),'settings/','our-service-five');
        } else {
            $data['section_five_image'] = ourService()['section_five_image'] ?? '';
        }

        if($request->file('section_six_image')) {
            $data['section_six_image'] = uploadFile($request->file('section_six_image'),'settings/','our-service-six');
        } else {
            $data['section_six_image'] = ourService()['section_six_image'] ?? '';
        }

        if($request->file('box_one_icon')) {
            $data['box_one_icon'] = uploadFile($request->file('box_one_icon'),'settings/','our-service-box-one');
        } else {
            $data['box_one_icon'] = ourService()['box_one_icon'] ?? '';
        }

        if($request->file('box_two_icon')) {
            $data['box_two_icon'] = uploadFile($request->file('box_two_icon'),'settings/','our-service-box-two');
        } else {
            $data['box_two_icon'] = ourService()['box_two_icon'] ?? '';
        }

        if($request->file('box_three_icon')) {
            $data['box_three_icon'] = uploadFile($request->file('box_three_icon'),'settings/','our-service-box-three');
        } else {
            $data['box_three_icon'] = ourService()['box_three_icon'] ?? '';
        }

        if($request->file('box_four_icon')) {
            $data['box_four_icon'] = uploadFile($request->file('box_four_icon'),'settings/','our-service-box-four');
        } else {
            $data['box_four_icon'] = ourService()['box_four_icon'] ?? '';
        }
        
        $newJsonString = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents(base_path('assets/json/our_service.json'), stripslashes($newJsonString));
        return redirect()->route('our-services-setting')->with(updateMessage());

    }

    /**
     * Theme Setting
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function themeSetting()
    {
        $data = SiteSetting::find(1);
        return view('setting.theme_setting',compact('data'));
    }

    /**
     * Update Theme Setting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateThemeSetting()
    {
        $type = request()->get('type');

        $site_setting = SiteSetting::where('del_status', 'Live')->first();
        if (empty($site_setting)){
            $site_setting = new SiteSetting();
        }
        $site_setting->theme_type = $type;
        if($site_setting->save()){
            return redirect()->route('theme-setting')->with(updateMessage());
        } else{
            return redirect()->route('theme-setting')->with(waringMessage());
        }
    }
}
