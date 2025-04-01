<?php
/*
##############################################################################
# AI Powered Customer Support Portal and Knowledgebase System
##############################################################################
# AUTHOR:        Door Soft
##############################################################################
# EMAIL:        info@doorsoft.co
##############################################################################
# COPYRIGHT:        RESERVED BY Door Soft
##############################################################################
# WEBSITE:        https://www.doorsoft.co
###################################groupSeenStatusUpdate###########################################
# This is Chat Controller
##############################################################################
 */

namespace App\Http\Controllers\Chat;

use App\Events\GroupChat;
use App\Events\GuestMessage;
use App\Events\MakeSeen;
use App\Events\SingleChat;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailSendController;
use App\Model\ChatGroup;
use App\Model\ChatGroupMember;
use App\Model\GroupChatMessage;
use App\Model\MailTemplate;
use App\Model\ProductCategory;
use App\Model\SingleChatMessage;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class ChatController extends Controller
{
    /**
     * Redirect to chat page
     */
    public function chatPage()
    {
        $users = User::live()->where('id', '!=', 3)->where('role_id', '!=', 3)->where('id', '!=', Auth::id())->get();
        $user_group_ids = ChatGroupMember::where('user_id', Auth::id())->pluck('group_id');
        $groups = ChatGroup::whereIn('id', $user_group_ids)->orderBy('last_message_at', 'DESC')->get();
        $products = ProductCategory::live()->sort()->get();
        return view('chat.chat_page', compact('users', 'groups', 'products'));
    }
    /**
     * Get auth user last single chat id
     */
    public function getLastSingleChatId()
    {
        if (SingleChatMessage::where('to_id', Auth::id())->exists()) {
            return SingleChatMessage::where('to_id', Auth::id())->orderBy('created_at', 'desc')->first()->from_id;
        } else {
            return "no-message";
        }
    }

    /**
     * Check user has group
     */
    public function checkUserHasFriend()
    {
        if (User::where('id', '!=', Auth::id())->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Check user has group
     */
    public function checkUserHasGroup()
    {
        if (ChatGroupMember::where('user_id', Auth::id())->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get auth user last group chat id
     */
    public function getLastGroupChatId()
    {
        return GroupChatMessage::where('from_id', Auth::id())->orderBy('created_at', 'desc')->first()->group_id ?? "no-message";
    }

    /**
     * Get single chat box
     */
    public function sineChatBox()
    {
        $user_id = request()->get('user_id');
        $user = User::find($user_id);
        $messages = SingleChatMessage::where(function ($query) use ($user_id) {
            $query->where('from_id', Auth::id());
            $query->where('to_id', $user_id);
            $query->orWhere('to_id', Auth::id());
            $query->where('from_id', $user_id);
        })->orderBy('created_at', 'asc')
            ->get();
        $from_id = Auth::id();
        $to_id = $user->id;
        return view('chat.single_chat_box', compact('user', 'from_id', 'to_id', 'messages'));
    }

    /**
     * Send single message
     */
    public function sendSingleMessage(Request $request)
    {
        if (isset($request->message) or !empty($request['files'])) {
            $to_id = $request->to_id;
            $from_id = Auth::id();
            $row = new SingleChatMessage();
            $row->from_id = $from_id;
            $row->to_id = $to_id;

            if (isset($request->message)) {
                $domain_lis = getDomainExtensions();
                if (Str::endsWith($request->message, $domain_lis) && !Str::startsWith($request->message, 'http')) {
                    $row->message = "https://" . $request->message;
                } else {
                    $row->message = $request->message;
                }
                if ($row->save()) {
                    $this->callEventInSingleChat($from_id, $to_id, $row);
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(array('status' => false));
                }
            }

        } else {
            return response()->json(array('status' => false));
        }
    }

    /**
     * Call event to send or receive single chat message
     */
    public function callEventInSingleChat($from_id, $to_id, $row)
    {
        $message_type = '';
        if ($from_id == Auth::id()) {
            $message_type = 'outgoing_message';
        } elseif ($to_id == Auth::id()) {
            $message_type = "incoming_message";
        }

        $sender = [
            'id' => $row->sender->id,
            'name' => $row->sender->full_name,
            'image' => $row->sender->image,
        ];

        $receiver = [
            'id' => $row->receiver->id,
            'name' => $row->receiver->full_name,
            'image' => $row->receiver->image,
        ];

        $message = [
            'text' => $row->message,
            'file' => $row->file,
            'message_time' => $row->message_time,
            'is_link' => $row->is_link,
            'is_file' => $row->is_file,
            'is_image' => $row->is_file,
            'seen_status' => $row->seen_status,
        ];
        if (pusherConnection()) {
            event(new SingleChat($message_type, $sender, $receiver, $message));
        }
    }

    /**
     * Update seen status
     */
    public function singleSeenStatusUpdate()
    {
        $condition = array('from_id' => request()->get('to_id'), 'to_id' => Auth::id(), 'seen_status' => 0);
        $count = SingleChatMessage::where($condition)->count();
        SingleChatMessage::where($condition)->update(array('seen_status' => request()->get('status')));
        event(new MakeSeen("single", request()->get('to_id')));
        return response()->json(['total' => $count]);
    }

    /**
     * Update seen status
     */
    public function groupSeenStatusUpdate()
    {
        $condition = [
            'group_id' => (int) request()->get('group_id'),
            'seen_status' => 0,
        ];
        $count = GroupChatMessage::where($condition)->where('from_id', '!=', authUserId())->count();

        $target_user = GroupChatMessage::where('from_id', '!=', authUserId())->orderBy('created_at', 'desc')->first()->from_id;
        if ($target_user == 0) {
            $browser_id = ChatGroup::where('id', request()->get('group_id'))->first()->created_by;
            event(new MakeSeen("guest", (int) $browser_id));
        } else {
            event(new MakeSeen("group", $target_user));
        }
        if ($count > 0) {
            GroupChatMessage::where($condition)->where('from_id', '!=', authUserId())->update(array('seen_status' => request()->get('status')));
            return response()->json(['total' => $count, 'status' => true]);
        } else {
            return response()->json(['total' => $count, 'status' => false]);
        }
    }

    /**
     * Get group chat box
     */
    public function groupChatBox()
    {
        $group_id = request()->get('group_id');
        $from_id = Auth::id();
        $messages = GroupChatMessage::where('group_id', $group_id)->get();
        $group = ChatGroup::with('members')->find($group_id);
        return view('chat.group_chat_box', compact('group_id', 'messages', 'group', 'from_id'));
    }

    /**
     * send default message to recever from ai response
     */
    public function sendAfterSaleAiResponse($group_id, $message, $product_id, $skip = '')
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;
        $ai_message = '';
        if ($skip == '') {
            $ai_message = sendAfterSaleAiResponse($message, $product_id);
        } else {
            $status = true;
            $ai_message = $message;
        }

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }

    /**
     * send default message to recever from ai response
     */
    public function sendPreSaleAiResponse($group_id, $message, $product_id, $skip = '')
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;
        $ai_message = '';
        if ($skip == '') {
            $ai_message = getAIPreSaleChatResponse($message, $product_id);
        } else {
            $status = true;
            $ai_message = $message;
        }

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }
    /**
     * send default message to recever from ai response
     */
    public function sendPreSaleAiResponseDefault($group_id)
    {
        $from_id = 3;
        $from_type = "Agent";
        $row = new GroupChatMessage();
        $row->from_id = $from_id;
        $row->user_type = $from_type;
        $row->group_id = $group_id;

        $ai_message = 'Hello! How can I assist you today?';

        $domain_lis = getDomainExtensions();
        if (Str::endsWith($ai_message, $domain_lis) && !Str::startsWith($ai_message, 'http')) {
            $row->message = "https://" . $ai_message;
        } else {
            $row->message = $ai_message;
        }
        $row->save();
        ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
        $this->callEventInGroupMessage($from_id, $row);
        $this->callGuestEventIn($from_id, $row);
    }

    /**
     * Send group chat message
     */
    public function sendGroupMessage(Request $request)
    {
        if (isset($request->message) or !empty($request['files'])) {
            $group_id = $request->group_id;
            $group_info = ChatGroup::find($group_id);
            $from_id = Auth::id();
            $from_type = Auth::user()->type;
            $row = new GroupChatMessage();
            $row->from_id = $from_id;
            $row->user_type = $from_type;
            $row->group_id = $group_id;

            $product_id = $group_info->product_id;
            $need_validation = false;
            $need_close_chat = false;
            $is_verified = session('is_verified');
            $need_show_agent_button = true;
            $chat_type = 'agent';
            if (isset($request->message)) {
                $domain_lis = getDomainExtensions();
                if (Str::endsWith($request->message, $domain_lis) && !Str::startsWith($request->message, 'http')) {
                    $row->message = "https://" . $request->message;
                } else {
                    $row->message = $request->message;
                }
                if ($group_info->user_type != 'guest') {
                    // Mail send
                    if ($from_type == "Customer") {
                        if (!GroupChatMessage::where('group_id', $group_id)->where('user_type', "Customer")->exists()) {
                            $template_info = MailTemplate::where('event_key', 'chat_message_by_customer')->first();
                            $members = ChatGroupMember::where('group_id', $group_id)->where('user_id', '!=', Auth::id())->pluck('user_id');
                            $emails = User::whereIn('id', $members)->pluck('email')->toArray();
                            if (isset($template_info) && $template_info->mail_notification == "on") {
                                $mail_data = [
                                    'to' => $emails,
                                    'subject' => MailTemplate::singleStringConvert('chat_message_by_customer', 'subject', 'admin_agent', $from_type),
                                    'body' => MailTemplate::singleStringConvert('chat_message_by_customer', 'body', 'admin_agent', $from_type),
                                    'chat_message' => $row->message,
                                    'view' => 'cc-mail-template',
                                ];
                                MailSendController::sendMailToUser($mail_data);
                            }
                        }

                        if (aiInfo()['type'] == "Yes") {
                            if ($request->message == "After Sale Support" || $request->message == "Pre Sale Query") {
                                $need_show_agent_button = false;
                                $request->session()->put('chat_type', $request->message);
                                if ($request->message == "After Sale Support") {
                                    $product_details = \App\Model\ProductCategory::find($product_id)->verification;
                                    if ($product_details == 1 && $is_verified != "Yes") {
                                        $need_validation = true;
                                    } else {
                                        $request->session()->put('is_verified', "Yes");
                                        $this->sendPreSaleAiResponseDefault($group_id);
                                    }
                                    return response()->json(['status' => true, 'is_verified' => ($is_verified), 'need_validation' => ($need_validation), 'chat_type' => ($request->message), 'need_show_agent_button' => $need_show_agent_button, 'need_close_chat' => $need_close_chat, 'message' => $request->message, 'product' => ProductCategory::find($product_id)->title, 'product_id' => $product_id, 'group_id' => $group_id]);
                                } else {
                                    $this->sendPreSaleAiResponseDefault($group_id);
                                }
                            } else {
                                $request->session()->put('new_message', $request->message);

                                if (customResponse($request->message)) {
                                    $need_show_agent_button = false;
                                    $chat_type = 'skip';
                                    //custom text provide in chat.
                                    $this->sendPreSaleAiResponse($group_id, customResponse($request->message), $product_id, '1');
                                } else {
                                    $chat_type = session('chat_type');
                                    $is_agent_connected = session('is_agent_connected');
                                    if (!$is_agent_connected) {
                                        if ($chat_type == "Pre Sale Query") {
                                            if ($request->message == "Yes, I got that answer.") {
                                                $need_close_chat = true;
                                            } else if ($request->message == "No, I need agent support.") {                                                
                                                if(chatScheduleAutoResponse() && !isChatScheduleTimeAndDate()){
                                                    $need_show_agent_button = false;
                                                    $request->session()->put('is_agent_connected', "No");
                                                    $responseText = autoResponseText();
                                                    $this->sendPreSaleAiResponse($group_id, $responseText, $product_id, '1');
                                                }else{
                                                    $need_show_agent_button = false;
                                                    $request->session()->put('is_agent_connected', "Yes");
                                                    $this->sendPreSaleAiResponse($group_id, "Please wait we are assigning an agent for you.", $product_id, '1');
                                                }                                                
                                            } else {
                                                $this->sendPreSaleAiResponse($group_id, $request->message, $product_id, '');
                                            }
                                        } else if ($chat_type == "After Sale Support") {
                                            if ($is_verified == "Yes") {
                                                if ($request->message == "Yes, I got that answer.") {
                                                    $need_close_chat = true;
                                                } else if ($request->message == "No, I need agent support.") {
                                                    if(chatScheduleAutoResponse() && !isChatScheduleTimeAndDate()){
                                                        $need_show_agent_button = false;
                                                        $request->session()->put('is_agent_connected', "No");
                                                        $responseText = autoResponseText();
                                                        $this->sendPreSaleAiResponse($group_id, $responseText, $product_id, '1');
                                                    }else{
                                                        $need_show_agent_button = false;
                                                        $request->session()->put('is_agent_connected', "Yes");
                                                        $this->sendPreSaleAiResponse($group_id, "Please wait we are assigning an agent for you.", $product_id, '1');
                                                    }
                                                    
                                                } else {
                                                    $this->sendAfterSaleAiResponse($group_id, $request->message, $product_id, '');
                                                }
                                            } else {
                                                $need_validation = true;
                                            }

                                        }
                                    } else {
                                        if ($request->message == "Yes, I got that answer.") {
                                            $need_close_chat = true;
                                        }
                                        $need_show_agent_button = false;
                                    }
                                }

                            }
                        }
                    } elseif ($from_type == "Admin" || $from_type == "Agent") {

                        if (!GroupChatMessage::where('group_id', $group_id)->where('user_type', "Admin")->orWhere('user_type', "Agent")->exists()) {
                            $template_info = MailTemplate::where('event_key', 'chat_message_by_admin_agent')->first();
                            $members = ChatGroupMember::where('group_id', $group_id)->where('user_id', '!=', Auth::id())->pluck('user_id');
                            $emails = User::whereIn('id', $members)->where('type', 'Customer')->pluck('email')->toArray();
                            // Send mail to admin/agent
                            if (isset($template_info) && $template_info->mail_notification == "on") {
                                $mail_data = [
                                    'to' => $emails,
                                    'subject' => MailTemplate::singleStringConvert('chat_message_by_admin_agent', 'subject', 'customer', $from_type),
                                    'body' => MailTemplate::singleStringConvert('chat_message_by_admin_agent', 'body', 'customer', $from_type),
                                    'chat_message' => $row->message,
                                    'view' => 'cc-mail-template',
                                ];
                                MailSendController::sendMailToUser($mail_data);
                            }
                        }
                    }
                    // Mail send end
                } elseif ($group_info->user_type == 'guest' && $group_info->guest_user_email != null) {
                    if ($from_type == "Admin" || $from_type == "Agent") {
                        if (!GroupChatMessage::where('group_id', $group_id)->where('user_type', "Admin")->orWhere('user_type', "Agent")->exists()) {
                            $g_mail_data = [
                                'to' => array($group_info->guest_user_email),
                                'subject' => "New chat message on " . siteSetting()->company_name ?? '',
                                'body' => "There is a new chat message on " . siteSetting()->company_name . " by " . authUserType() . " on " . currentDate() . " at " . currentTime() . ". Please visit the site and check your inbox.",
                                'chat_message' => $row->message,
                                'view' => 'cc-mail-template',
                            ];
                            MailSendController::sendMailToUser($g_mail_data);
                        }
                    }
                }

                $row->save();
                ChatGroup::findOrFail($group_id)->update(['last_message_at' => now()]);
                $this->callEventInGroupMessage($from_id, $row);
                $this->callGuestEventIn($from_id, $row);

            }
            return response()->json(['status' => true, 'is_verified' => ($is_verified), 'need_validation' => ($need_validation), 'chat_type' => ($chat_type), 'need_show_agent_button' => $need_show_agent_button, 'need_close_chat' => $need_close_chat, 'message' => $request->message, 'product' => ProductCategory::find($product_id)->title, 'product_id' => $product_id, 'group_id' => $group_id]);
        } else {
            return response()->json(array('status' => false));
        }
    }

    /**
     * Call event in group chat
     * @param $from_id
     * @param $row
     * @return void
     */

    public function callEventInGroupMessage($from_id, $row)
    {
        if ($from_id == Auth::id()) {
            $message_type = 'outgoing_message';
        } else {
            $message_type = "incoming_message";
        }

        $sender = [
            'id' => $row->sender['id'],
            'name' => $row->sender['full_name'],
            'image' => $row->sender['image'],
        ];

        $receiver_id = "";
        $memb_chat = ChatGroupMember::where('group_id', $row->group_id)->where('user_id', '!=', Auth::id())->first();
        if (isset($memb_chat)) {
            $receiver_id = $memb_chat->user_id;
        }

        $group = [
            'id' => $row->group->id,
            'name' => $row->group->name,
            'receiver_id' => $receiver_id,
        ];

        $message = [
            'text' => $row->message,
            'file' => $row->file,
            'message_time' => $row->message_time,
            'is_link' => $row->is_link,
            'is_file' => $row->is_file,
            'is_image' => $row->is_file,
            'seen_status' => $row->seen_status,
        ];
        if (pusherConnection()) {
            event(new GroupChat($message_type, $sender, $group, $message));
        }
    }

    /**
     * Call event for guest
     */
    public function callGuestEventIn($from_id, $row)
    {
        $message_type = "incoming_message";
        $sender = [
            'id' => $row->sender['id'],
            'name' => $row->sender['full_name'],
            'image' => $row->sender['image'],
        ];

        $group = [
            'id' => $row->group->id,
            'name' => $row->group->name,
            'created_by' => $row->group->created_by,
        ];

        $message = [
            'text' => $row->message,
            'file' => $row->file,
            'message_time' => $row->message_time,
            'is_link' => $row->is_link,
            'is_file' => $row->is_file,
            'is_image' => $row->is_file,
            'seen_status' => $row->seen_status,
        ];
        if (pusherConnection()) {
            event(new GuestMessage($message_type, $sender, $group, $message));
        }
    }

    /**
     * Check user exists on group
     */
    public function checkUserGroup()
    {
        $user_id = request()->get('user_id');
        $group_id = request()->get('group_id');
        if (ChatGroupMember::where('user_id', $user_id)->where('group_id', $group_id)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get auth user id
     */
    public function authUserId()
    {
        return Auth::id();
    }

    /**
     * Close chat
     */
    public function closeChat($group_id)
    {
        $group = ChatGroup::findOrFail($group_id);
        $chat_history = GroupChatMessage::where('group_id', $group->id)->where('user_type', '!=', 'forward')->orderBy('created_at', 'asc')->get();
        $file_name = $group->name;

        if (count($chat_history)) {
            $data_array[] = array('User Type', 'Message', 'Time');

            foreach ($chat_history as $chat) {
                $data_array[] = array(
                    'User Type' => $chat->user_type,
                    'Message' => $chat->message,
                    'Time' => $chat->created_at->format('Y-m-d h:i A'),
                );
            }
            $this->saveExcel($data_array, $file_name); // Save the excel file

            $template_info = MailTemplate::where('event_key', 'chat_close')->first();
            if (isset($template_info) && $template_info->mail_notification == "on") {
                $group_members = ChatGroupMember::where('group_id', $group->id)->pluck('user_id');
                // Send mail to customer
                if ($group->user_type != 'guest') {
                    $customer_email = User::whereIn('id', $group_members)->where('type', 'Customer')->first()->email;
                    if (isset($customer_email)) {
                        $mail_data = [
                            'to' => array($customer_email),
                            'subject' => MailTemplate::chatMailData('customer', $customer_email, 'subject', $group_id),
                            'body' => MailTemplate::chatMailData('customer', $customer_email, 'body', $group_id),
                            'file_name' => $file_name . '.xls',
                            'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                            'view' => 'cc-mail-template',
                        ];
                        MailSendController::sendMailToUser($mail_data);
                    }
                }if ($group->user_type == 'guest' && $group->guest_user_email != null) {

                    if (isset($group->guest_user_email)) {
                        $mail_data = [
                            'to' => array($group->guest_user_email),
                            'subject' => "Your chat transcript from " . siteSetting()->company_name ?? '',
                            'body' => "A chat has been closed on " . siteSetting()->company_name . " by " . authUserType() . " on " . currentDate() . " at " . currentTime() . " You can open another chat if you have further query.",
                            'file_name' => $file_name . '.xls',
                            'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                            'view' => 'cc-mail-template',
                        ];
                        MailSendController::sendMailToUser($mail_data);
                    }
                }

                // Send mail to admin/agent
                $admin_agent_emails = User::whereIn('id', $group_members)->where('type', '!=', 'Customer')->pluck('email');
                foreach ($admin_agent_emails as $email) {
                    $mail_data = [
                        'to' => array($email),
                        'subject' => MailTemplate::chatMailData('admin_agent', $email, 'subject', $group_id),
                        'body' => MailTemplate::chatMailData('admin_agent', $email, 'body', $group_id),
                        'file_name' => $file_name . '.xls',
                        'file_path' => 'assets/chat_files/' . $file_name . '.xls',
                        'view' => 'cc-mail-template',
                    ];
                    MailSendController::sendMailToUser($mail_data);
                }
            }

        }
        Session::forget('chat_type');
        Session::forget('is_agent_connected');
        Session::forget('is_verified');
        // Delete group and group message
        GroupChatMessage::whereIn('group_id', array($group_id))->delete();
        $group->delete();
        return Redirect::to('/live-chat')->with(updateMessage("Chat has been closed successfully!"));
    }

    /**
     * Save xl file
     */
    public function saveExcel($customer_data, $file_name)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            ob_end_clean();
            $Excel_writer->save('assets/chat_files/' . $file_name . '.xls');
        } catch (Exception $e) {
            return;
        }
    }

    /**
     * export xl file
     */
    public function exportExcel($customer_data, $file_name)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {
            $spreadSheet = new Spreadsheet();
            $spreadSheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(20);
            $spreadSheet->getActiveSheet()->fromArray($customer_data);
            $Excel_writer = new Xls($spreadSheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename=' . '"' . $file_name . '.xls.' . '"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $Excel_writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }

    public function forwardChat()
    {
        $group_id = request()->get('group_id');
        $agent_id = request()->get('agent_id');

        $group = ChatGroup::find($group_id);
        $members = ChatGroupMember::where('group_id', $group->id)->pluck('user_id');
        $running_agent = User::whereIn('id', $members)->where('role_id', '!=', 3)->first()->id;
        $chat_group = ChatGroupMember::where('group_id', $group->id)->where('user_id', $running_agent)->first();
        $chat_group->user_id = $agent_id;
        $chat_group->save();

        GroupChatMessage::insert([
            'from_id' => Auth::id(),
            'user_type' => "forward",
            'group_id' => $group->id,
            'message' => getUserName(authUserId()) . ' has been forwarded chat to ' . getUserName($agent_id),
            'created_at' => now(),
        ]);

        $mail_data = [
            'to' => [User::find($agent_id)->email],
            'subject' => "Chat forwarded on " . siteSetting()->company_name ?? "",
            'body' => "An " . authUserType() . " has been forwarded a chat " . $group->name . " to " . getUserName($agent_id) . " on " . currentDate() . " at " . currentTime() . ".Please login to the site and check your inbox.",
            'view' => 'cc-mail-template',
        ];
        MailSendController::sendMailToUser($mail_data);

        return response()->json(['status' => true]);
    }

    /**
     * Fetch agent
     */
    public function searchAgent()
    {
        $search_key = request()->get('search_key');
        $user = User::live();
        $user->where('role_id', '!=', 3);
        if (isset($search_key)) {
            $user->where('first_name', "LIKE", "%$search_key%");
            $user->orWhere('last_name', "LIKE", "%$search_key%");
        }
        $user->where('id', '!=', Auth::id());
        $users = $user->get();
        return view('chat.user_list', compact('users'));
    }

    /**
     * Search group
     */
    public function searchGroup()
    {
        $search_key = request()->get('search_key');
        $group = ChatGroup::query();
        if (isset($search_key)) {
            $group->where('name', "LIKE", "%$search_key%");
        }
        if (Auth::user()->role_id == 3) {
            $group->where("created_by", Auth::id());
        } else {
            $user_group_ids = ChatGroupMember::where('user_id', Auth::id())->pluck('group_id');
            $group->whereIn('id', $user_group_ids);
        }
        $groups = $group->get();
        return view('chat.group_list', compact('groups'));
    }

}
