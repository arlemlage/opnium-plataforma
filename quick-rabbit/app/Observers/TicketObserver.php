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
  # This is Ticket Observer
  ##############################################################################
 */

namespace App\Observers;

use App\Http\Controllers\MailSendController;
use App\Model\HolidaySetting;
use App\Model\MailTemplate;
use App\Model\Ticket;
use App\Model\TicketSetting;
use App\Model\User;
use App\Model\Vacation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Model\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        // Mail send activity
        $template_info = MailTemplate::where('event_key','open_ticket')->first();
        if(isset($template_info) && $template_info->mail_notification == "on" && isset($ticket->id)) {
            $email_info = Ticket::emailInfo($ticket->id,$template_info->id);
        }
        // Send mail to admin/agent if opened by customer
        if (authUserType() == "Customer") {
           if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
           }

           $ticket->notify('open_ticket_by_customer');
        }

        // Send mail to admin/agent/customer if opened by admin/agent
        if(authUserType() == "Agent") {
            // Send mail to admin/agent
            if(isset($template_info) && $template_info->mail_notification == "on" && isset($ticket->id)) {
                $email_info = Ticket::emailInfo($ticket->id,$template_info->id);
            }

            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            // Send mail to customer
            if (isset($email_info) && isset($ticket->getCustomer->email) && !empty($email_info['customer_mail_subject']) && !empty($email_info['customer_mail_body'])){
                $mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => $email_info['customer_mail_subject'],
                    'body' => $email_info['customer_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            $ticket->notify('open_ticket_by_agent');
        }

        // Send mail to agent/customer if opened by admin
        if(authUserType() == "Admin") {
            // Send mail to admin/agent
            if(isset($template_info) && $template_info->mail_notification == "on" && isset($ticket->id)) {
                $email_info = Ticket::emailInfo($ticket->id,$template_info->id);
            }
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            // Send mail to customer
            if (isset($email_info) && isset($ticket->getCustomer->email) && !empty($email_info['customer_mail_subject']) && !empty($email_info['customer_mail_body'])){
                $mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => $email_info['customer_mail_subject'],
                    'body' => $email_info['customer_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            $ticket->notify('open_ticket_by_admin');
        }

        // Send auto reply to customer
        $ticket_setting_info = TicketSetting::first();
        if(isset($ticket_setting_info) && $ticket_setting_info->auto_email_reply == 'on') {
            $auto_reploy_template = MailTemplate::where('event_key','auto_email_reply')->first();
            if(isset($auto_reploy_template)) {
                $email_info = Ticket::emailInfo($ticket->id,$auto_reploy_template->id);
            }
            if (isset($email_info) && isset($ticket->getCustomer->email) && !empty($email_info['customer_mail_subject']) && !empty($email_info['customer_mail_body'])){
                $mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => $email_info['customer_mail_subject'],
                    'body' => $email_info['customer_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
        }
        // Send holiday mail to customer
        $today = Carbon::now()->format('l');
        if(isHoliday($today) == "Yes") {
            $holiday_setting = HolidaySetting::where("day",$today)->first();
            if(isset($holiday_setting) && isset($holiday_setting->mail_subject) && isset($holiday_setting->mail_body)) {
                $holiday_mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => $holiday_setting->mail_subject,
                    'ticket_id' => encrypt_decrypt($ticket->id,'encrypt'),
                    'body' => nl2br($holiday_setting->mail_body),
                    'view' => 'vacation_holiday_template',
                ];
                MailSendController::sendMailToUser($holiday_mail_data);
            }
        }

        // Send vacation mail to customer
        $vacation_info = Vacation::where('del_status', 'Live')
            ->whereDate('start_date', '<=',date('Y-m-d'))
            ->whereDate('end_date', '>=',date('Y-m-d'))
            ->first();

        if (isset($vacation_info)  && ($vacation_info->auto_response == "on") && isset($vacation_info->mail_subject) && isset($vacation_info->mail_body)){
            $vacation_mail_data = [
                'to' => [$ticket->getCustomer->email],
                'subject' => $vacation_info->mail_subject,
                'ticket_id' => encrypt_decrypt($ticket->id,'encrypt'),
                'body' => nl2br($vacation_info->mail_body),
                'view' => 'vacation_holiday_template',
            ];
            MailSendController::sendMailToUser($vacation_mail_data);
        }

        // Send holiday mail to customer
        $today = Carbon::now()->format('l');
        if(isHoliday($today) == "Yes") {
            $holiday_setting = HolidaySetting::where("day",$today)->first();
            if(isset($holiday_setting) && isset($holiday_setting->mail_subject) && isset($holiday_setting->mail_body)) {
                $holiday_mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => $holiday_setting->mail_subject,
                    'ticket_id' => encrypt_decrypt($ticket->id,'encrypt'),
                    'body' => $holiday_setting->mail_body,
                    'view' => 'vacation_holiday_template',
                ];
                MailSendController::sendMailToUser($holiday_mail_data);
            }
        }
    }

    /**
     * Handle notification to admin/agent when ticket open by customer
     *
     * @param \App\Model\Ticket
     * @return void
     */
    public function notifyAdminAgent(Ticket $ticket) {
        // Save activity log and notification
        $template_info = MailTemplate::where('event_key','open_ticket')->first();
        $activity_type = "created";
        $notification_message = "A new ticket Ticket ID : ".$ticket->ticket_no." has been opened by customer ".getUserName(Auth::id())." on ".currentDate()." at " .currentTime();
        // Save activity log
        activityLog($ticket->id, $activity_type,$notification_message);
        // Save Admin notification
        saveAdminNotification($activity_type,$ticket->id,$notification_message);
        // Send push notification to admin
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\AdminNotification($notification_message));
        }
        // Send browser notification to admin
        if(isAllowedFcm()) {
            User::getFcm(adminId(),"New Ticket Created By Customer",$notification_message);
        }

        // Save agent notification
        if(sizeof($ticket->agent_ids_in_array) > 0) {
            foreach ($ticket->agent_ids_in_array as $agent_id) {
                saveAgentNotification($activity_type,$ticket->id,$notification_message,$agent_id); // Save agent notification
                // Send browser notification to agent
                if(isAllowedFcm()) {
                    User::getFcm($agent_id,"New Ticket Created By Customer",$notification_message);
                }
            }
            // Send push notification to agent
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AgentNotification($ticket->agent_ids_in_array, $notification_message));
            }
        }
    }

    /**
     * Handle notification to customer/agent when ticket open by admin
     *
     * @param \App\Model\Ticket
     * @return void
     */
    public function notifyAgentCustomer(Ticket $ticket) {
        $template_info = MailTemplate::where('event_key','open_ticket')->first();
        // Save activity log and notification
        $activity_type = "created";
        $notification_message = "A new ticket Ticket ID : ".$ticket->ticket_no." has been opened by admin ".getUserName(Auth::id())." on ".currentDate()." at " .currentTime();
        activityLog($ticket->id, $activity_type,$notification_message); // Save activity log
        saveAdminNotification($activity_type,$ticket->id,$notification_message); // Save Admin notification

        // Save agent notification
        if(sizeof($ticket->agent_ids_in_array) > 0) {
            foreach ($ticket->agent_ids_in_array as $agent_id) {
                saveAgentNotification($activity_type,$ticket->id,$notification_message,$agent_id); // Save agent notification
                // Send browser notification to agent
                if(isAllowedFcm()) {
                    User::getFcm($agent_id,"New Ticket Created By Admin",$notification_message);
                }
            }
            // Send push notification to agent
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AgentNotification($ticket->agent_ids_in_array, $notification_message));
            }
        }

        // Save customer notification
        saveCustomerNotification($activity_type,$ticket->id,$notification_message,$ticket->getCustomer->id);
        // Send web push notification to customer
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\CustomerNotification($ticket->getCustomer->id, $notification_message));
        }
    }

     /**
     * Handle notification to customer/admin when ticket open by agent
     *
     * @param \App\Model\Ticket
     * @return void
     */
    public function notifyAdminCustomer(Ticket $ticket) {
        $template_info = MailTemplate::where('event_key','open_ticket')->first();
        // Save activity log and notification
        $activity_type = "created";
        $notification_message = "A new ticket Ticket ID : ".$ticket->ticket_no." has been opened by agent ".getUserName(Auth::id())." on ".currentDate()." at " .currentTime();
        activityLog($ticket->id, $activity_type,$notification_message); // Save activity log
        // Admin notification
        saveAdminNotification($activity_type,$ticket->id,$notification_message);
        // Send push notification to admin
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\AdminNotification($notification_message));
        }
        // Send browser notification to admin
        if(isAllowedFcm()) {
            User::getFcm(adminId(),"New Ticket Opened By Agent",$notification_message);
        }

        $agent_ids = $ticket->agent_ids_in_array;
        if(authUserRole() == 2) {
            if (($key = array_search(Auth::id(), $agent_ids)) !== false) {
                unset($agent_ids[$key]);
            }
        }

        // Save agent notification
        if(sizeof($agent_ids) > 0) {
            foreach ($agent_ids as $agent_id) {
                saveAgentNotification($activity_type,$ticket->id,$notification_message,$agent_id); // Save agent notification
                // Send browser notification to agent
                if(isAllowedFcm()) {
                    User::getFcm($agent_id,"New Ticket Created By Admin",$notification_message);
                }
            }
            // Send push notification to agent
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AgentNotification($agent_ids, $notification_message));
            }
        }

        // Save customer notification
        saveCustomerNotification($activity_type,$ticket->id,$notification_message,$ticket->getCustomer->id);
        // Send web push notification to customer
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\CustomerNotification($ticket->getCustomer->id, $notification_message));
        }
    }

    /**
     * Handle ticket close event
     *
     * @param \App\Model\Ticket
     * @return void
     */
    public function closeTicket(Ticket $ticket) {
        $template_info = MailTemplate::where('event_key','close_ticket')->first();
        if(isset($template_info) && $template_info->mail_notification == 'on' && isset($ticket->id)) {
            $email_info = Ticket::emailInfo($ticket->id,$template_info->id);
        }

        if (authUserType() == "Admin") {
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            // Send mail to customer
            if(sendMailToCustomer($template_info->id)) {
                if(isset($ticket->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }

            $this->notifyOnClose('admin',$ticket->id);
        } elseif(authUserType() == "Agent") {
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            // Send mail to customer
            if(sendMailToCustomer($template_info->id)) {
                if(isset($ticket->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }
            $this->notifyOnClose('agent',$ticket->id);
        }

        // Send rating email to customer
        $ticket_setting_info = TicketSetting::first();
            if ($ticket_setting_info->closed_ticket_rating == 'on'){
                $mail_data = [
                    'to' => [$ticket->getCustomer->email],
                    'subject' => 'Rate the support you received from ticket Ticket ID : '.$ticket->ticket_no,
                    'customer_info' => !empty($ticket->getCustomer)? $ticket->getCustomer:null,
                    'ticket_info' => !empty($ticket)? $ticket:null,
                    'ticket_view_url' => 'ticket/'.encrypt_decrypt($ticket->id, 'encrypt'),
                    'ticket_view_feedback' => 'closing-ticket-feedback/'.encrypt_decrypt($ticket->id, 'encrypt').'&'.encrypt_decrypt($ticket->getCustomer->id, 'encrypt'),
                    'view' => 'customer-ticket-feedback-mail',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
    }

    /**
     * Handle ticket reopen event
     *
     * @param \App\Model\Ticket
     * @return void
     */
    public function reopenTicket(Ticket $ticket) {
        $template_info = MailTemplate::where('event_key','reopen_ticket')->first();
        if(isset($template_info) && $template_info->mail_notification == 'on' && isset($ticket->id)) {
            $email_info = Ticket::emailInfo($ticket->id,$template_info->id);
        }
        if (authUserType() == "Admin") {
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            // Send mail to customer
            if(sendMailToCustomer($template_info->id)) {
                if(isset($ticket->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }

            $this->notifyOnReopen('admin',$ticket->id);
        } elseif(authUserType() == "Agent") {
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'cc' => $email_info['cc_emails'],
                    'bcc' => $email_info['bcc_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            // Send mail to customer
            if(sendMailToCustomer($template_info->id)) {
                if(isset($ticket->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }

            $this->notifyOnReopen('agent',$ticket->id);
        } elseif(authUserType() == "Customer") {
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'cc' => $email_info['cc_emails'],
                    'bcc' => $email_info['bcc_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
           
            $this->notifyOnReopen('customer',$ticket->id);
        }
    }

    /**
     * Notify agent and customer on ticket close
     */
    public function notifyOnClose($closed_by,$ticket_id) {
        $template_info = MailTemplate::where('event_key','close_ticket')->first();
        $ticket_info = Ticket::find($ticket_id);
        $ticket_id = $ticket_info->id;
        $activity_type = 'closed';
        $notification_message = 'An '.lcfirst(authUserType()).' '.getUserName(Auth::id()).' has been closed the ticket Ticket ID :'.$ticket_info->ticket_no.' on '.currentDate().' at '.currentTime();
        activityLog($ticket_info->ticket_no, $activity_type,$notification_message);
        $agent_ids = $ticket_info->agent_ids_in_array;

        if ($closed_by == "admin") {
            if(sizeof($agent_ids) > 0) {
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket_info->id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Ticket Closed By Admin", $notification_message);
                    }
                }
                // Send push notification to agent
                if (isset($template_info) && $template_info->web_push_notification == 'on' && pusherConnection()) {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
            // Save customer notification
            saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id);
            // Send web push notification to customer
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\CustomerNotification($ticket_info->getCustomer->id, $notification_message));
            }
        } elseif($closed_by == "agent") {
            if(sizeof($agent_ids) > 0) {
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket_id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Ticket Closed By Agent", $notification_message);
                    }
                }
                // Send push notification to agent
                if (isset($template_info) && $template_info->web_push_notification == 'on' && pusherConnection()) {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
            // Admin notification
            saveAdminNotification($activity_type,$ticket_id,$notification_message);
            // Send push notification to admin
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AdminNotification($notification_message));
            }
            // Send browser notification to admin
            if(isAllowedFcm()) {
                User::getFcm(adminId(),"Ticket Closed By Agent",$notification_message);
            }
            // Save customer notification
            saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id);
            // Send web push notification to customer
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\CustomerNotification($ticket_info->getCustomer->id, $notification_message));
            }
        }
    }

    /**
     * Notify agent and customer on ticket reopen
     */
    public function notifyOnReopen($reopened_by,$ticket_id) {
        $template_info = MailTemplate::where('event_key','reopen_ticket')->first();
        $ticket_info = Ticket::find($ticket_id);
        $agent_ids = $ticket_info->agent_ids_in_array;
        $activity_type = 'reopened';
        $notification_message = 'An '.lcfirst(authUserType()).' '.getUserName(Auth::id()).' has been reopened the ticket Ticket ID : '.$ticket_info->ticket_no.' on '.currentDate().' at '.currentTime();
        activityLog($ticket_info->ticket_no, $activity_type,$notification_message);

        if ($reopened_by == "admin") {
            if(sizeof($agent_ids) > 0) {
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket_info->id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Ticket Reopened By Admin", $notification_message);
                    }
                }
                // Send push notification to agent
                if ($template_info->web_push_notification == 'on') {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
            // Save customer notification
            saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id);
            // Send web push notification to customer
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\CustomerNotification($ticket_info->getCustomer->id, $notification_message));
            }
        } elseif ($reopened_by == "agent") {
            if(sizeof($agent_ids) > 0) {
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket_id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Ticket Reopened By Agent", $notification_message);
                    }
                }
                // Send push notification to agent
                if ($template_info->web_push_notification == 'on') {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
            // Admin notification
            saveAdminNotification($activity_type,$ticket_id,$notification_message);
            // Send push notification to admin
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AdminNotification($notification_message));
            }
            // Send browser notification to admin
            if(isAllowedFcm()) {
                User::getFcm(adminId(),"Ticket Reopened By Agent",$notification_message);
            }
            // Save customer notification
            saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id);
            // Send web push notification to customer
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\CustomerNotification($ticket_info->getCustomer->id, $notification_message));
            }
        } if ($reopened_by == "customer") {
            if(sizeof($agent_ids) > 0) {
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket_info->id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Ticket Reopened By Customer", $notification_message);
                    }
                }
                // Send push notification to agent
                if ($template_info->web_push_notification == 'on') {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
        }
    }

}
