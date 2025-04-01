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
  # This is Ticket Model
  ##############################################################################
 */

namespace App\Model;

use App\Http\Controllers\MailSendController;
use Carbon\Carbon;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    protected $table = "tbl_tickets";
    protected $guarded = [];
    public    $timestamps = true;
    protected $appends = array('agent_ids_in_array','assign_agent_names','last_comment','ticket_duration');
    protected $observables = array('notifyAdminAgent','notifyAgentCustomer','notifyAdminCustomer','closeTicket','reopenTicket','assignAgent');

    /**
     * Fire observer when opened by customer
     */
    public function notify($event) {
        if($event == 'open_ticket_by_customer') {
            $this->fireModelEvent('notifyAdminAgent');
        } elseif($event == 'open_ticket_by_admin') {
            $this->fireModelEvent('notifyAgentCustomer');
        } elseif($event == 'open_ticket_by_agent') {
            $this->fireModelEvent('notifyAdminCustomer');
        }
    }

    /**
     * Fire close ticket observer
     */
    public function closeTicket() {
        $app_demo = config('app.app_demo');
        if(isset($app_demo) && $app_demo=="ds"){

        }else{
            $this->fireModelEvent('closeTicket', false);
        }
    }

    /**
     * Fire reopen ticket observer
     */
    public function reopenTicket() {
        $this->fireModelEvent('reopenTicket', false);
    }

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

        static::updating(function ($post) {
            $post->updated_by = Auth::user()->id;
        });
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getUpdatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getAssignToTicketUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to_id', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getProductCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id', 'id');
    }

    /**
     * Define relation with user table
     */
    public function getCustomer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }

    /**
     * Define relation with reply comments table
     */
    public function getReplyComments(): HasMany
    {
        return $this->hasMany(TicketReplyComment::class, 'ticket_id', 'id');
    }

    /**
     * Define relation with ticket files table
     */
    public function ticket_files(): HasMany
    {
        return $this->hasMany(TicketFile::class,'ticket_id','id');
    }

    /**
     * Define relation with department table
     */
    public function getDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    /**
     * Get agent ids attribute to append
     */
    public function getAgentIdsInArrayAttribute() {
        $agent_ids = explode(',',$this->assign_to_ids);
        foreach ($agent_ids AS $index => $value){
            $agent_ids[$index] = (int)$value;
        }
        return $agent_ids;
    }

    /**
     * Get assigned names
     */
    public function getAssignAgentNamesAttribute() {
        $agent_names = '';
        $i = 0;
        $length = count($this->agent_ids_in_array);
        foreach ($this->agent_ids_in_array as $agent_id) {
            if($i == $length -1) {
                $end = '';
            } else {
                $end = ', ';
            }
            $agent_names.= getUserName($agent_id). $end;
        }
        return $agent_names;
    }

    /**
     * Get last comment
     */
    public function getLastCommentAttribute() {
        $last_comment = TicketReplyComment::where('ticket_id',$this->id)
            ->orderBy('created_at','desc')->first();

        if(isset($last_comment)) {
            if(User::where('id',$last_comment->created_by)->exists()) {
                $last_comment_user_name = User::find($last_comment->created_by)->full_name;
                $last_comment_user_type = User::find($last_comment->created_by)->type;
                return $last_comment_user_type.' - ' .$last_comment_user_name;
            } else {
                return "N/A";
            }
            
        } else {
            return "N/A";
        }
    }

    /**
     * Get ticket duration
     */
    public function getTicketDurationAttribute() {
        if($this->closing_date != Null) {
            $startTime = Carbon::parse($this->create_at);
            $finishTime = Carbon::parse($this->closing_date);
            $totalDuration = $finishTime->diffInSeconds($startTime);
            return gmdate('h:i', $totalDuration);
        } else {
            return "N/A";
        }
    }

    /**
     * Get email information
     */
    public static function emailInfo($ticket_id,$template_id,$comment_id="") {
        return [
          'to_emails' => MailTemplate::getToEmails($template_id,$ticket_id),
          'cc_emails' => MailTemplate::getCCEmails($template_id),
          'bcc_emails' => MailTemplate::getBCCEmails($template_id),
          'customer_mail_subject' => MailTemplate::getMailSubject("customer",$template_id,$ticket_id),
          'admin_agent_mail_subject' => MailTemplate::getMailSubject("admin_agent",$template_id,$ticket_id),
          'customer_mail_body' => MailTemplate::getMailBody("customer",$template_id,$ticket_id,"",$comment_id),
          'admin_agent_mail_body' => MailTemplate::getMailBody("admin_agent",$template_id,$ticket_id,"",$comment_id)
        ];
    }

    /**
     * Send mail to new assign agents
     */
    public static function newAssignedAgents($agent_ids,$ticket_id) {
        $ticket = Ticket::find($ticket_id);
        $template_info = MailTemplate::where('event_key','assign_agent')->first();
        $new_agent_emails = User::whereIn('id',$agent_ids)->pluck('email');
        $new_agent_names = [];
        foreach ($agent_ids as $agent_id) {
            array_push($new_agent_names,User::find($agent_id)->full_name);
        }
        if(isset($template_info) && $template_info->mail_notification == 'on' && isset($ticket_id)) {
            $email_info = Ticket::emailInfo($ticket_id,$template_info->id);
             if (isset($email_info) && count($new_agent_emails) && !empty($email_info['admin_agent_mail_subject']) && !empty($email_info['admin_agent_mail_body'])) {
                 foreach ($new_agent_emails as $email) {
                     $mail_data = [
                        'to' => array($email),
                        'subject' => MailTemplate::assignAgentMailSubject($email,$ticket_id),
                        'body' => MailTemplate::assignAgentMailBody($email,$ticket_id),
                        'ticket_id' => encrypt_decrypt($ticket->id, 'encrypt'),
                        'view' => 'ticket_related_template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                 }
            }
        }

        if(authUserType() == "Admin") {
            if(sizeof($agent_ids) > 0) {
                $activity_type = 'mentioned';
                $notification_message = 'An admin '.getUserName(Auth::id()).' has been mentioned someone of the ticket '.$ticket->ticket_no.' on '.currentDate().' at '.currentTime();
                activityLog($ticket->ticket_no, $activity_type,$notification_message);
                foreach ($agent_ids as $agent_id) {
                    // Save agent notification
                    saveAgentNotification($activity_type, $ticket->id, $notification_message, $agent_id);
                    // Send browser notification to agent
                    if (isAllowedFcm()) {
                        User::getFcm($agent_id, "Mentioned On Ticket", $notification_message);
                    }
                }
                // Send push notification to agent
                if ($template_info->web_push_notification == 'on') {
                    event(new \App\Events\AgentNotification($agent_ids, $notification_message));
                }
            }
        } elseif (authUserType() == "Agent") {
             $activity_type = '';
            $notification_message = 'An agent '.getUserName(Auth::id()).' has been mentioned someone of the ticket '.$ticket->ticket_no.' on '.currentDate().' at '.currentTime();
            // Admin notification
            saveAdminNotification($activity_type,$ticket_id,$notification_message);
            // Send push notification to admin
            if($template_info->web_push_notification == "on") {
                event(new \App\Events\AdminNotification($notification_message));
            }
            // Send browser notification to admin
            if(isAllowedFcm()) {
                User::getFcm(adminId(),"Mentioned Someone On Ticket",$notification_message);
            }
        }
    }

    /**
     * Scope to get user wise ticket
     */
    public function scopeTicketCondition($query) {
        if(authUserRole() == 1) {
            return $query->live();
        } elseif(authUserRole() == 2) {
            $product_category = explode(',',auth()->user()->product_cat_ids);
            return $query->whereIn('product_category_id', $product_category);
        } elseif(authUserRole() == 3) {
            return $query->where('customer_id',authUserId())->live();
        }
    }

    /**
     * Scope Type Single Product Category Ticket and Multiple Product Category Ticket
     */

     public function scopeType($query){
        if(appTheme() == 'single'){
            $productId = ProductCategory::where('type','single')->first()->id;
            return $query->where('product_category_id', $productId);
        }

        if(appTheme() == 'multiple'){
            $productIds = ProductCategory::where('type','multiple')->pluck('id');
            return $query->whereIn('product_category_id', $productIds);
        }
     }

}
