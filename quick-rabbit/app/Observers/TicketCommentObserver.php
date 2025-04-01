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
  # This is Ticket Comment Observer
  ##############################################################################
 */

namespace App\Observers;

use App\Http\Controllers\MailSendController;
use App\Mail\SendMail;
use App\Model\MailTemplate;
use App\Model\Ticket;
use App\Model\TicketReplyComment;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TicketCommentObserver
{
    /**
     * Handle the TicketReplyComment "creating" event.
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function creating(TicketReplyComment $ticketReplyComment)
    {
        $ticketReplyComment->created_by = Auth::user()->id;
        $ticketReplyComment->updated_by = Auth::user()->id;
    }

    /**
     * Handle the TicketReplyComment "created" event.
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function created(TicketReplyComment $ticketReplyComment)
    {
        if(authUserType() == "Customer") {
            // Mail send activity
            $template_info = MailTemplate::where('event_key','reply_ticket_by_customer')->first();
            $ticket_id = $ticketReplyComment->ticket_id;
            if(isset($template_info) && $template_info->mail_notification == 'on' && isset($ticket_id)) {
                $email_info = Ticket::emailInfo($ticket_id,$template_info->id,$ticketReplyComment->id);
            }
            // Send mail to admin/agent
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket_id, 'encrypt'),
                    'comment_id' => encrypt_decrypt($ticketReplyComment->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }
            // Notify admin and agent
            $ticketReplyComment->notify('replied_by_customer');

        } elseif (authUserType() == "Admin") {
            $template_info = MailTemplate::where('event_key','reply_ticket_by_admin_agent')->first();
            $template_id = $template_info->id;
            $ticket_info = Ticket::find($ticketReplyComment->ticket_id);

            if(isset($template_info) && $template_info->mail_notification == "on" && isset($ticket_info->id)) {
                $email_info = Ticket::emailInfo($ticket_info->id,$template_info->id,$ticketReplyComment->id);
            }

            // Send mail to agent's
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket_info->id, 'encrypt'),
                    'comment_id' => encrypt_decrypt($ticketReplyComment->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            // Send mail to customer
            if(sendMailToCustomer($template_id)) {
                if(isset($ticket_info->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket_info->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket_info->id, 'encrypt'),
                        'comment_id' => encrypt_decrypt($ticketReplyComment->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }
            // Notify agent and customer
            $ticketReplyComment->notify('replied_by_admin');
        } elseif (authUserType() == "Agent") {
            // Mail send activity
            $template_info = MailTemplate::where('event_key','reply_ticket_by_admin_agent')->first();
            $template_id = $template_info->id;
            $ticket_info = Ticket::find($ticketReplyComment->ticket_id);

            if(isset($template_info) && $template_info->mail_notification == "on" && isset($ticket_info->id)) {
                $email_info = Ticket::emailInfo($ticket_info->id,$template_info->id,$ticketReplyComment->id);
            }
            // Send mail to agent's
            if (isset($email_info) && count($email_info['to_emails']) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])){
                $mail_data = [
                    'to' => $email_info['to_emails'],
                    'subject' => $email_info['admin_agent_mail_subject'],
                    'body' => $email_info['admin_agent_mail_body'],
                    'ticket_id' => encrypt_decrypt($ticket_info->id, 'encrypt'),
                    'comment_id' => encrypt_decrypt($ticketReplyComment->id, 'encrypt'),
                    'view' => 'ticket_related_template',
                ];
                MailSendController::sendMailToUser($mail_data);
            }

            // Send mail to customer
            if(sendMailToCustomer($template_id)) {
                if(isset($ticket_info->getCustomer->email) && isset($email_info['customer_mail_subject']) && isset($email_info['customer_mail_body'])) {
                    $mail_data = [
                        'to' => [$ticket_info->getCustomer->email],
                        'subject' => $email_info['customer_mail_subject'],
                        'body' => $email_info['customer_mail_body'],
                        'ticket_id' => encrypt_decrypt($ticket_info->id, 'encrypt'),
                        'comment_id' => encrypt_decrypt($ticketReplyComment->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }
            // Notify admin and customer
            $ticketReplyComment->notify('replied_by_agent');
        }

        // Send mail to assigned CC On Ticket
        $cc_template_info = MailTemplate::where('event_key','assign_cc_on_ticket')->first();
        if(isset($cc_template_info) ) {
            $ticketReplyComment->sendCCMail();
        }
    }

    /**
     * Handle the to send ticket cc mail send event
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function sendCCMail(TicketReplyComment $ticketReplyComment) {
        $ticket_info = Ticket::find($ticketReplyComment->ticket_id);
        if (isset($ticket_info->ticket_cc)) {
            $cc_email = explode(',',$ticket_info->ticket_cc);
            foreach ($cc_email as $email) {
                $mail_data = [
                    'to' => array($email),
                    'subject' => MailTemplate::ccMailSubject($email,$ticketReplyComment),
                    'body' => MailTemplate::ccMailBody($email,$ticketReplyComment),
                    'view' => 'cc-mail-template',
                    'ticket_info_url' => route('ticket-info',encrypt_decrypt($ticketReplyComment->ticket_id,'encrypt'))
                ];
                MailSendController::sendMailToUser($mail_data);
            }
        }
    }

    /**
     * Handle the to send notification to admin/agent when replied by customer
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function notifyAdminAgent(TicketReplyComment $ticketReplyComment) {
        // Save activity log and notification
        $ticket_info = Ticket::find($ticketReplyComment->ticket_id);
        $template_info = MailTemplate::where('event_key','reply_ticket_by_customer')->first();
        $activity_type = 'commented';
        $notification_message = "New comment has been placed on the ticket Ticket ID : ".$ticket_info->ticket_no." by ".getUserName(Auth::id()). " on ".currentDate(). " at ". currentTime();
        // Save activity log
        activityLog($ticket_info->id, $activity_type,$notification_message);
        // Admin notification
        saveAdminNotification($activity_type,$ticket_info->id,$notification_message,$ticketReplyComment->id);

        // Send push notification to admin
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection() ) {
            event(new \App\Events\AdminNotification($notification_message));
        }
        // Send browser notification to admin
        if(isAllowedFcm()) {
            User::getFcm(adminId(),"New Ticket Comment From Customer",$notification_message);
        }

        // Agent notification
        $agent_ids = $ticket_info->agent_ids_in_array;
        if(sizeof($agent_ids) > 0) {
            foreach ($agent_ids as $agent_id) {
                // Save agent notification
                saveAgentNotification($activity_type, $ticket_info->id, $notification_message, $agent_id, $ticketReplyComment->id);
                // Send browser notification to agent
                if (isAllowedFcm()) {
                    User::getFcm($agent_id, "New Ticket Comment From Customer", $notification_message);
                }
            }
            // Send push notification to agent
            if (isset($template_info) && $template_info->web_push_notification == 'on' && pusherConnection()) {
                event(new \App\Events\AgentNotification($agent_ids, $notification_message));
            }
        }
    }

    /**
     * Handle the to send notification to customer/agent when replied by admin
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function notifyAgentCustomer(TicketReplyComment $ticketReplyComment) {
        $template_info = MailTemplate::where('event_key','reply_ticket_by_admin_agent')->first();
        $ticket_info = Ticket::find($ticketReplyComment->ticket_id);
        $activity_type = 'commented';
        $notification_message = "New comment has been placed on the ticket Ticket ID : ".$ticket_info->ticket_no." by ".getUserName(Auth::id()). " on ".currentDate(). " at ". currentTime();
        activityLog($ticket_info->id, $activity_type,$notification_message);

        $agent_ids = $ticket_info->agent_ids_in_array;
        if(sizeof($agent_ids) > 0) {
            foreach ($agent_ids as $agent_id) {
                // Save agent notification
                saveAgentNotification($activity_type,$ticket_info->id,$notification_message,$agent_id,$ticketReplyComment->id);
                // Send browser notification
                if(isAllowedFcm()) {
                    User::getFcm($agent_id,"New Comment From Admin",$notification_message);
                }
            }
            // Send web push notification to agent
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AgentNotification($agent_ids, $notification_message));
            }
        }
        // Save customer notification
        saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id,$ticketReplyComment->id);
        // Send web push notification to customer
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\CustomerNotification($ticket_info->customer_id, $notification_message));
        }
    }

    /**
     * Handle the to send notification to customer/admin when replied by agent
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function notifyAdminCustomer(TicketReplyComment $ticketReplyComment) {
        $template_info = MailTemplate::where('event_key','reply_ticket_by_admin_agent')->first();
        $ticket_info = Ticket::find($ticketReplyComment->ticket_id);
        // Save activity log and notification
        $activity_type = 'commented';
        $notification_message = "New comment has been placed on the ticket Ticket ID : ".$ticket_info->ticket_no." by ".getUserName(Auth::id()). " on ".currentDate(). " at ". currentTime();
        activityLog($ticket_info->id, $activity_type,$notification_message);
        // Admin notification
        saveAdminNotification($activity_type,$ticket_info->id,$notification_message,$ticketReplyComment->id);
        // Send push notification to admin
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\AdminNotification($notification_message));
        }
        // Send browser notification to admin
        if(isAllowedFcm()) {
            User::getFcm(adminId(),"New Ticket Comment From Agent",$notification_message);
        }

       $agent_ids = $ticket_info->agent_ids_in_array;
        if(sizeof($agent_ids) > 0) {
            foreach ($agent_ids as $agent_id) {
                // Save agent notification
                saveAgentNotification($activity_type,$ticket_info->id,$notification_message,$agent_id,$ticketReplyComment->id);
                // Send browser notification
                if(isAllowedFcm()) {
                    User::getFcm($agent_id,"New Comment From Agent",$notification_message);
                }
            }
            // Send web push notification to agent
            if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
                event(new \App\Events\AgentNotification($agent_ids, $notification_message));
            }
        }
        // Save customer notification
        saveCustomerNotification($activity_type,$ticket_info->id,$notification_message,$ticket_info->getCustomer->id,$ticketReplyComment->id);
        // Send web push notification to customer
        if(isset($template_info) && $template_info->web_push_notification == "on" && pusherConnection()) {
            event(new \App\Events\CustomerNotification($ticket_info->customer_id, $notification_message));
        }
    }

    /**
     * Handle the TicketReplyComment "updating" event.
     *
     * @param  \App\Model\TicketReplyComment  $ticketReplyComment
     * @return void
     */
    public function updating(TicketReplyComment $ticketReplyComment)
    {
        $ticketReplyComment->updated_by = Auth::user()->id;
    }


}
