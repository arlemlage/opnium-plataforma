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
  # This is User Model
  ##############################################################################
 */

namespace App\Model;

use App\Scopes\Live;
use App\Scopes\AI;
use App\Mail\SendMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use App\Http\Controllers\MailSendController;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable 
{
    use Notifiable;
    use SoftDeletes;
    use HasApiTokens;

    /**
     * Boot function of model
     */
    public static function boot() {
        parent::boot();
        static::addGlobalScope(new Live);
    }

    /**
     * Define table name
     * @var string
     */
    protected $table = "tbl_users";
    /**
     * Define fillable field
     * @var string
     */
    protected $guarded = [];
    /**
     * Define hidden field
     * @var string
     */
    protected $hidden = ['password', 'remember_token',];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define guard for table
     * @var string
     */
    protected $appends = ['role_name','full_name','type_name','last_message','pair_key','total_unseen_message','last_single_chat_id','last_group_chat_id','ticket_ids','browser_notification'];

    /**
     * Get role name attribute to append
     */
    public function getRoleNameAttribute() {
        return Role::find($this->permission_role)->title ?? 'N/A';
    }

    /**
     * Get image attribute to append
     */
    public function getImageAttribute($value)
    {
        if($value != Null && file_exists(rootFilePath().'user_photos/'.$value)) {
            return rootFilePath().'user_photos/'.$value;
        } else {
            return 'assets/images/avator.jpg';
        }
    }
    /**
    *  Append full name
    * @return string
    */
    public function getFullNameAttribute(): string
    {
        return $this->first_name. ' '.$this->last_name;
    }

    /**
     * Get browser notification attribute
     */
    public function getBrowserNotificationAttribute() {
        if(authUserRole() == 3) {
            return false;
        } else {
            if(siteSetting()->browser_notification == "Yes") {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get last message attribute to append
     */
    public function getLastMessageAttribute()
    {
        $last_message = [];
        $last_message['message'] = '';
        $last_message['seen_status'] = '';
        $last_message['from_id'] = '';
        $message = SingleChatMessage::where(function ($query) {
                $query->where('from_id',Auth::id());
                $query->where('to_id',$this->id);
                $query->orWhere('to_id',Auth::id());
                $query->where('from_id',$this->id);
            })->orderBy('created_at','desc')->first();
        if(isset($message)) {
            $last_message['message'] = $message->message;
            $last_message['seen_status'] = $message->seen_status;
            $last_message['from_id'] = $message->from_id;
            return $last_message;

        } else {
            return $last_message;
        }
    }

    /**
     * Get pair key attribute to append
     */
    public function getPairKeyAttribute() {
        return Auth::id().'_'.$this->id;
    }

    /**
     * Get total unseen message attribute to append
     */
    public function getTotalUnseenMessageAttribute() {
        $single = SingleChatMessage::where('to_id',Auth::id())->where('seen_status',0)->count() ?? 0;
        $group_id = ChatGroupMember::where('user_id',Auth::id())->pluck('group_id');
        $group_message = GroupChatMessage::whereIn('id',$group_id)->where('seen_status',0)->count() ?? 0;
        return $single + $group_message;
    }

    /**
     * Get last single chat id attribute to append
     */
    public function getLastSingleChatIdAttribute() {
        return SingleChatMessage::where('from_id',Auth::id())->orderBy('created_at','desc')->first()->to_id ?? "";
    }

    /**
     * Get last group chat id attribute to append
     */
    public function getLastGroupChatIdAttribute() {
        return GroupChatMessage::where('from_id',Auth::id())->orderBy('created_at','desc')->first()->to_id ?? "";
    }

    /**
     * Get assigned ticket ids
     */
    public function getTicketIdsAttribute() {
        if(authUserRole() == 2) {
            // IF agent not assigned to any product
            if($this->product_cat_ids == Null) {
                return Ticket::pluck('id')->toArray();
            }
            $product_cat_ids = explode(',',$this->product_cat_ids);
            foreach ($product_cat_ids AS $index => $value){
                $product_cat_ids[$index] = (int)$value;
            }

            $from_product_ticket_ids = Ticket::live()->whereIn('product_category_id',$product_cat_ids)->pluck('id')->toArray();

            $from_assigned_ticket_ids = DB::table('tbl_tickets')->where('del_status','Live')->whereRaw('FIND_IN_SET("'.auth()->user()->id.'", tbl_tickets.assign_to_ids)')->pluck('id')->toArray();

            return array_unique(array_merge($from_product_ticket_ids,$from_assigned_ticket_ids));

        } else {
            return [];
        }
    }

    /**
     * Define relation with user table
     */
    public function getCreatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    /**
    *  Append type name
    * @return string
    */
    public function getTypeNameAttribute(): string
    {
        if($this->role_id == 1){
            $type_name = "Admin";
        } elseif($this->role_id == 2){
            $type_name = "Agent";
        } elseif($this->role_id == 3){
            $type_name = "Customer";
        } else{
            $type_name = "Admin";
        }
        return $type_name;
    }

    /**
     * Generate employee id
     * @return string
     */
    protected static function getEmployeeId()
    {
        $lastEmployeeId = User::latest('id')->whereNotNull('employee_id')->first();
        $newEmployeeId = str_pad(1, 4, "0", STR_PAD_LEFT);
        if ($lastEmployeeId) {
            $lastOrderNumber = $lastEmployeeId->employee_id;
            if ($lastOrderNumber != null) {
                $newSerialNumber = $lastOrderNumber + 1;
                $newEmployeeId = str_pad($newSerialNumber, 4, "0", STR_PAD_LEFT);;
            } else {
                $newEmployeeId = str_pad(1, 4, "0", STR_PAD_LEFT);
            }
        }
        if (User::where('employee_id', $newEmployeeId)->exists()) {
            User::getEmployeeId();
        }
        return $newEmployeeId;
    }

    /**
     *Define relation with role
     * @return BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     *Define relation with department
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class,'department_id','id');
    }

    /**
     *Define relation with permissions
     * @return hasMany
     */
    public function permissions(): hasMany
    {
        return $this->hasMany(UserPermission::class,'user_id','id');
    }

    /**
    *  Define relation with document
    * @return array
    */
    public function notes() : HasMany
    {
        return $this->hasMany(CustomerNote::class,'customer_id','id');
    }


    /**
     * Scope to find admin
     */
    public function scopeAdmin($query) {
        return $query->where('role_id', 1);
    }

    /**
     * Scope to find agent
     */
    public function scopeAgent($query) {
        return $query->where('role_id', 2);
    }

    /**
     * Scope to find customers
     */
    public function scopeCustomer($query) {
        return $query->where('role_id', 3);
    }

    /**
     * Static function to get FCM
     */
    public static function sendBrowserPush($title,$message) {
        event(new \App\Events\BrowserPush(userIp(),$title,$message));
    }

    /**
     * For firebase notification
     */
    public static function getFcm($user_id,$title,$message) {
        // Used firebase API base URL to send firebase browser notification
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::where('id',$user_id)->whereNotNull('device_key')->pluck('device_key')->all();

        $serverKey = firebaseInfo()['server_key'];
        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ]
        ];
    
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
        
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
       
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
    }

   
    /**
     * Send mail to user
     */
    public static function sendMail($mail_data) {
        Mail::to($mail_data['to'])
        ->send(new SendMail($mail_data));
    }

    /**
     * Resend verification email
     */
    public static function sendVerificationEmail(string $email)
    {
        $token = Str::random(64);
        $user = User::where("email",$email)->first();
        UserVerify::updateOrInsert(['user_id' => $user->id],['user_id' => $user->id, 'token' => $token]);
        
        $mail_data = [
            'to' => array($email),
            'user_name' => $user->full_name,
            'token' => $token,
            'subject' => 'Email verification link',
            'view' => 'email-verification-template',
        ];
        MailSendController::sendMailToUser($mail_data);

    }

    /**
     * Get client ip
     * Used external cdn for get user ip
     */
    public static function getClientIp() {
        // Use cdn to get client ip address
        $ipaddress = Http::get('https://api.ipify.org?format=json');
        return $ipaddress['ip'];
    }

    /**
     * Not fetch AI user
     */
    public function scopeNotAI($query) {
        return $query->where('email', "!=", "ai@doorsoft.co");
    }

}
