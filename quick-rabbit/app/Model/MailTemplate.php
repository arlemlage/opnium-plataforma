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
  # This is Mail Template Model
  ##############################################################################
 */

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailTemplate extends Model
{
    protected $table = "tbl_mail_templates";
    protected $guarded = [];
    public $timestamps = true;
    protected $appends = ['need_customer','need_admin_agent'];

    /**
     * Call boot method
     */
    public static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->created_by = Auth::user()->id;
            $post->updated_by = Auth::user()->id;
        });

    }

    /**
     * Return this template need for customer or not
     */
    public function getNeedCustomerAttribute() {
        if(($this->event_key == "open_ticket")
            OR ($this->event_key == "auto_email_reply")
            OR ($this->event_key == "reply_ticket_by_admin_agent")
            OR ($this->event_key == "close_ticket")
            OR ($this->event_key == "reopen_ticket")
            OR ($this->event_key == "chat_message_by_admin_agent")
            OR ($this->event_key == "chat_close")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Return this template need for admin/agent or not
     */
    public function getNeedAdminAgentAttribute() {
        if(($this->event_key == "open_ticket")
            OR ($this->event_key == "reply_ticket_by_customer")
            OR ($this->event_key == "assign_agent")
            OR ($this->event_key == "close_ticket")
            OR ($this->event_key == "reopen_ticket")
            OR ($this->event_key == "chat_message_by_customer")
            OR ($this->event_key == "assign_cc_on_ticket")
            OR ($this->event_key == "chat_close")) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Define relation with mail template type table
     */
    public function getMailTemplateType(): BelongsTo
    {
        return $this->belongsTo(MailTemplateType::class, 'type_id', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }


    /**
     * Get mail subject
     */
    public static function getMailSubject($subject_for,$template_id,$ticket_id,$agent_id ="") {
        $template = MailTemplate::find($template_id);
        $ticket = Ticket::find($ticket_id);
        if($subject_for == "customer") {
            $mail_sub = $template->customer_mail_subject;
        } elseif ($subject_for == "admin_agent") {
            $mail_sub = $template->admin_agent_mail_subject;
        }
        $mail_sub = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_sub);
        $mail_sub = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_sub);
        $mail_sub = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_sub);
        $mail_sub = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_sub);
        $mail_sub = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_sub);
        $mail_sub = str_replace(array("[agent_name]"), array(getUserName($agent_id)), $mail_sub);
        $mail_sub = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_sub);
        $mail_sub = str_replace(array("[user_type]"), array(authUserType()), $mail_sub);
        $mail_sub = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_sub);
        return $mail_sub;
    }
    /**
     * Static function to fetch mail body
     */
    public static function getMailBody($body_for,$template_id,$ticket_id,$agent_id = "",$comment_id="") {
        $template = MailTemplate::find($template_id);
        $ticket = Ticket::find($ticket_id);
        if($body_for == "customer") {
           $mail_body = $template->customer_mail_body;
        } elseif($body_for == "admin_agent") {
            $mail_body = $template->admin_agent_mail_body;
        }

        $mail_body = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_body);
        $mail_body = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_body);
        $mail_body = str_replace(array("[ticket_description]"), array($ticket->ticket_content ?? ""), $mail_body);
        $mail_body = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_body);
        $mail_body = str_replace(array("[agent_name]"), array(getUserName($agent_id)), $mail_body);
        $mail_body = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_body);
        $mail_body = str_replace(array("[user_type]"), array(authUserType()), $mail_body);
        $mail_body = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_body);
        if(!empty($comment_id)) {
            $comment = TicketReplyComment::find($comment_id)->ticket_comment;
            if(isset($comment)) {
                $mail_body = str_replace(array("[reply]"), array($comment ?? ""), $mail_body);
            }
        }
        return $mail_body;
    }

    /**
     * Fetch to emails
     */
    public static function getToEmails($template_id,$ticket_id) {
        $ticket = Ticket::find($ticket_id);
        $to_emails = [];
      
        foreach (User::whereIn('id',$ticket->agent_ids_in_array)->live()->select('email')->get() as $user) {
            array_push($to_emails,$user->email);
        }

        $final_emails = array_unique($to_emails);
        if (($key = array_search(Auth::user()->email, $final_emails)) !== false) {
            unset($final_emails[$key]);
        }
        return $final_emails;
         
    }

    /**
     * Fetch cc emails
     */
    public static function getCCEmails($template_id) {
        $cc_mails = MailTemplate::find($template_id)->mail_cc;
        if(isset($cc_mails)) {
            return  explode(',', $cc_mails);
        } else {
            return [];
        }
    }

    /**
     * Fetch BCC emails
     */
    public static function getBCCEmails($template_id) {
        $bcc_mails = MailTemplate::find($template_id)->mail_bcc;
        if(isset($bcc_mails)) {
            return  explode(',', $bcc_mails);
        } else {
            return [];
        }
    }

    public static function singleStringConvert($event,$field,$for,$from_type) {
        $template_info = MailTemplate::where('event_key',$event)->first();
        if($for == "admin_agent") {
            if($field == "subject") {
                $mail_data = $template_info->admin_agent_mail_subject;
            } elseif($field == "body") {
                $mail_data = $template_info->admin_agent_mail_body;
            }
        } elseif($for == "customer") {
            if($field == "subject") {
                $mail_data = $template_info->customer_mail_subject;
            } elseif($field == "body") {
                $mail_data = $template_info->customer_mail_body;
            }
        }

        $mail_data = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_data);
        $mail_data = str_replace(array("[user_type]"), array($from_type ?? ""), $mail_data);
        $mail_data = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_data);
        return $mail_data;
    }

    /**
     * Find CC MAIL SUBJECT
     */
    public static function ccMailSubject($email,$comment="") {
        $template_info = MailTemplate::where('event_key','assign_cc_on_ticket')->first();
        $ticket = Ticket::find($comment->ticket_id);
        $mail_subject = $template_info->admin_agent_mail_subject;

        $mail_subject = str_replace(array("EMAIL_ADDRESS"), array($email ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_subject);
        $mail_subject = str_replace(array("[ticket_description]"), array($ticket->ticket_content ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_subject);
        $mail_subject = str_replace(array("[user_type]"), array(authUserType()), $mail_subject);
        $mail_subject = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_subject);
        if(!empty($comment)) {
            $comment = TicketReplyComment::find($comment->id)->ticket_comment;
            if(isset($comment)) {
                $mail_subject = str_replace(array("[reply]"), array($comment ?? ""), $mail_subject);
            }
        }
        return $mail_subject;
    }

    /**
     * Find cc mail body
     */
    public static function ccMailBody($email,$comment = "") {
        $template_info = MailTemplate::where('event_key','assign_cc_on_ticket')->first();
        $ticket = Ticket::find($comment->ticket_id);
        $mail_body = $template_info->admin_agent_mail_body;

        $mail_body = str_replace(array("EMAIL_ADDRESS"), array($email ?? ""), $mail_body);
        $mail_body = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_body);
        $mail_body = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_body);
        $mail_body = str_replace(array("[ticket_description]"), array($ticket->ticket_content ?? ""), $mail_body);
        $mail_body = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_body);
        $mail_body = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_body);
        $mail_body = str_replace(array("[user_type]"), array(authUserType()), $mail_body);
        $mail_body = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_body);
        if(!empty($comment)) {
            $comment = TicketReplyComment::find($comment->id)->ticket_comment;
            if(isset($comment)) {
                $mail_body = str_replace(array("[reply]"), array($comment ?? ""), $mail_body);
            }
        }
        return $mail_body;
    }

    /**
     * Find CC MAIL SUBJECT
     */
    public static function assignAgentMailSubject($email,$ticket_id) {
        $template_info = MailTemplate::where('event_key','assign_agent')->first();
        $ticket = Ticket::find($ticket_id);
        $mail_subject = $template_info->admin_agent_mail_subject;
        $user = User::where('email',$email)->first();
        $mail_subject = str_replace(array("agent_name"), array($user->full_name ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_subject);
        $mail_subject = str_replace(array("[ticket_description]"), array($ticket->ticket_content ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_subject);
        $mail_subject = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_subject);
        $mail_subject = str_replace(array("[user_type]"), array(authUserType()), $mail_subject);
        $mail_subject = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_subject);
        return $mail_subject;
    }

    /**
     * Find CC MAIL SUBJECT
     */
    public static function assignAgentMailBody($email,$ticket_id) {
        $template_info = MailTemplate::where('event_key','assign_agent')->first();
        $ticket = Ticket::find($ticket_id);
        $mail_body = $template_info->admin_agent_mail_body;
        $user = User::where('email',$email)->first();

        $mail_body = str_replace(array("[agent_name]"), array($user->full_name ?? ""), $mail_body);
        $mail_body = str_replace(array("[ticket_subject]"), array($ticket->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[ticket_no]"), array($ticket->ticket_no ?? ""), $mail_body);
        $mail_body = str_replace(array("[priority]"), array(ticketPriority($ticket->priority)), $mail_body);
        $mail_body = str_replace(array("[ticket_description]"), array($ticket->ticket_content ?? ""), $mail_body);
        $mail_body = str_replace(array("[product_name]"), array($ticket->getProductCategory->title ?? ""), $mail_body);
        $mail_body = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_body);
        $mail_body = str_replace(array("[customer_name]"), array(getUserName($ticket->customer_id)), $mail_body);
        $mail_body = str_replace(array("[user_type]"), array(authUserType()), $mail_body);
        $mail_body = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_body);
        return $mail_body;
    }

    /**
     * Find CC MAIL SUBJECT
     */
    public static function chatMailData($for,$email,$field,$group_id) {
        $template_info = MailTemplate::where('event_key','chat_close')->first();
        $group = ChatGroup::find($group_id);
        if($for == "admin_agent") {
            if($field == "subject") {
                $mail_data = $template_info->admin_agent_mail_subject;
            } elseif($field == "body") {
                $mail_data = $template_info->admin_agent_mail_body;
            }
        } elseif($for == "customer") {
            if($field == "subject") {
                $mail_data = $template_info->customer_mail_subject;
            } elseif($field == "body") {
                $mail_data = $template_info->customer_mail_body;
            }
        }

        $user = User::where('email',$email)->first();
        $mail_data = str_replace(array("[agent_name]"), array($user->full_name ?? ""), $mail_data);
        $mail_data = str_replace(array("[product_name]"), array(ProductCategory::find($group->product_id)->title ?? ""), $mail_data);
        $mail_data = str_replace(array("[site_name]"), array(siteSetting()->company_name ?? ""), $mail_data);
        $mail_data = str_replace(array("[customer_name]"), array(getUserName($user->full_name)), $mail_data);
        $mail_data = str_replace(array("[user_type]"), array(authUserType()), $mail_data);
        $mail_data = str_replace(array("[date_time]"), array(currentDate().' at '.currentTime()), $mail_data);
        return $mail_data;
    }
}
