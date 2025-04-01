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
##############################################################################
# This is customer helper
##############################################################################
 */

use App\Model\ActivityLog;
use App\Model\ArticleGroup;
use App\Model\Blog;
use App\Model\ChatGroupMember;
use App\Model\ChatSetting;
use App\Model\ConfigurationSetting;
use App\Model\GroupChatMessage;
use App\Model\MailTemplate;
use App\Model\Media;
use App\Model\Notice;
use App\Model\ProductCategory;
use App\Model\SingleChatMessage;
use App\Model\Ticket;
use App\Model\TicketReplyComment;
use App\Model\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;
use Orhanerday\OpenAi\OpenAi;

/**
 * Fetch base url
 */
if (!function_exists('baseUrl')) {
    function baseUrl()
    {
        return url('/');
    }
}

/**
 * Fetch a new line
 */
if (!function_exists('lineBreak')) {
    function lineBreak()
    {
        return "\r\n";
    }
}

/**
 * Fetch user ip
 */
if (!function_exists('userIp')) {
    function userIp()
    {
        $ip = '';
        if (isset($_COOKIE['user_ip'])) {
            $ip = $_COOKIE['user_ip'];
        }
        return $ip;
    }
}

/**
 * GDPR SHOW
 */
if (!function_exists('showGdpr')) {
    function showGdpr()
    {
        $status = '';
        if (isset($_COOKIE['show_gdpr'])) {
            $status = $_COOKIE['show_gdpr'];
        }
        return $status;
    }
}

/**
 * Fetch user ip group message
 */
if (!function_exists('ipGroupMessage')) {
    function ipGroupMessage()
    {
        $client_ip = userIp();
        $group = \App\Model\ChatGroup::where('created_by', $client_ip)->first();
        if (isset($group)) {
            $has_group = true;
            $messages = \App\Model\GroupChatMessage::where('group_id', $group->id)->get();
        } else {
            $has_group = false;
            $messages = [];
        }
        $agent_name = __('index.live_chat');
        $agent_image = "assets/frontend/img/new/ai.svg";
        if (count($messages)) {
            $last_agent_message = \App\Model\GroupChatMessage::where('group_id', $group->id)
                ->orderBy('created_at', 'desc')->first();
            if (isset($last_agent_message)) {
                $agent_name = getUserName($last_agent_message->from_id) != "" ? getUserName($last_agent_message->from_id) : siteSetting()->company_name;
                $agent_image = User::find($last_agent_message->from_id)->image ?? 'assets/frontend/img/new/ai.svg';
            } else {
                $agent_name = __('index.live_chat');
                $agent_image = "assets/frontend/img/new/ai.svg";
            }
        }
        return [
            'has_group' => $has_group,
            'messages' => $messages,
            'group_id' => $group->id ?? 0,
            'group_name' => $group->name ?? '',
            'product_id' => $group->product_id ?? 0,
            'product_title' => ProductCategory::find($group->product_id ?? 0)->title ?? '',
            'agent_name' => $agent_name ?? '',
            'agent_image' => $agent_image,
            'guest_name' => $group->guest_user_name ?? '',
            'guest_email' => $group->guest_user_email ?? '',
        ];

    }
}

/**
 * Show chat close button
 */
if (!function_exists('showCloseChatButton')) {
    function showCloseChatButton()
    {
        if (isset(ipGroupMessage()['group_id']) && ipGroupMessage()['group_id'] != 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Get site setting info
 */
if (!function_exists('siteSetting')) {
    function siteSetting()
    {
        return \App\Model\SiteSetting::first() ?? null;
    }
}

/**
 * Get gdpr setting info
 */
if (!function_exists('gdprSetting')) {
    function gdprSetting()
    {
        return \App\Model\GDPRSetting::first() ?? null;
    }
}

/**
 * Get media
 */
if (!function_exists('getAllMedia')) {
    function getAllMedia()
    {
        return App\Model\Media::live()->oldest()->take(29)->get();
    }
}

/**
 * Get all product category
 */
if (!function_exists('getAllProductCategory')) {
    function getAllProductCategory()
    {
        return App\Model\ProductCategory::live()->type()->statusActive()->orderBy('sort_id', 'asc')->get();
    }
}

/**
 * Get Single Product
 */

if (!function_exists('getSingleProduct')) {
    function getSingleProduct()
    {
        return App\Model\ProductCategory::live()->type()->statusActive()->where('type', 'single')->first();
    }
}

/**
 * Get all department
 */
if (!function_exists('getAllDepartment')) {
    function getAllDepartment()
    {
        return App\Model\Department::live()->get();
    }
}

/**
 * check like status
 */
if (!function_exists('checkLikeUnlikeStatus')) {
    function checkLikeUnlikeStatus($forum_id, $brower_id)
    {
        $selected_row = App\Model\ForumLike::live()->where('forum_id', $forum_id)->where('user_id', $brower_id)->first();
        return $selected_row;
    }
}

/**
 * check comment like status
 */
if (!function_exists('checkLikeUnlikeStatusForComment')) {
    function checkLikeUnlikeStatusForComment($forum_comment_id, $brower_id)
    {
        $selected_row = App\Model\ForumLike::live()->where('forum_comment_id', $forum_comment_id)->where('user_id', $brower_id)->first();
        return $selected_row;
    }
}

/**
 * Get all pages
 */
if (!function_exists('getAllPages')) {
    function getAllPages()
    {
        return App\Model\Pages::live()->statusActive()->latest('id')->toBase()->get();
    }
}
/**
 * Get all pages
 */
if (!function_exists('getRolePermissionName')) {
    function getRolePermissionName($id)
    {
        $data = App\Model\Role::where("id", $id)->first();
        if ($data) {
            return $data->title;
        } else {
            return "N/A";
        }
    }
}
/**
 * Convert html to plain text
 */
if (!function_exists('htmlToText')) {
    function htmlToText($html)
    {
        $plain_text = strip_tags($html);
        return Str::words($plain_text, 30, '...');
    }
}

/**
 * Site setting info from json
 */
if (!function_exists('siteSettingJson')) {
    function siteSettingJson()
    {
        $jsonString = file_get_contents('assets/json/site_setting.json');
        return json_decode($jsonString, true) ?? "";
    }
}

/**
 * Get chat setting days
 */
if (!function_exists('chatSchedules')) {
    function chatSchedules(): array
    {
        $chat_schedule_days = \App\Model\ChatSetting::first();
        if (isset($chat_schedule_days)) {
            return json_decode($chat_schedule_days->chat_schedule_days) ?? [];
        } else {
            return [];
        }
    }
}

/**
 * Get chat setting days
 */
if (!function_exists('chatScheduleTime')) {
    function chatScheduleTime()
    {
        $start_time = date('h:i A', strtotime(\App\Model\ChatSetting::first()->start_time));
        $end_time = date('h:i A', strtotime(\App\Model\ChatSetting::first()->end_time));
        return [
            'start_time' => $start_time ?? "N/A",
            'end_time' => $end_time ?? "N/A",
        ];
    }
}

/**
 * Check Current Date and Time is in between chat schedule time
 */
if (!function_exists('isChatScheduleTimeAndDate')) {
    function isChatScheduleTimeAndDate()
    {
        $current_time = date('H:i:s');
        $current_day = date('l');
        $chat_schedule_days = chatSchedules();
        $chat_schedule_time = chatScheduleTime();
        $start_time = date('H:i:s', strtotime($chat_schedule_time['start_time']));
        $end_time = date('H:i:s', strtotime($chat_schedule_time['end_time']));
        if (in_array($current_day, $chat_schedule_days)) {
            if (($current_time >= $start_time) && ($current_time <= $end_time)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

/**
 * Chat Schedule Auto Response
 */
if (!function_exists('chatScheduleAutoResponse')) {
    function chatScheduleAutoResponse()
    {
        $chat_setting = \App\Model\ChatSetting::first();
        if (isset($chat_setting) && $chat_setting->auto_reply_out_of_schedule == "on") {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Auto Response Text
 */

if (!function_exists('autoResponseText')) {
    function autoResponseText()
    {
        $chat_setting = \App\Model\ChatSetting::first();
        return $chat_setting->out_of_schedule_time_message ?? "";
    }
}


/**
 * Check user permission
 * @returns int
 */
if (!function_exists('hasPermission')) {
    function hasPermission($activity_name): bool
    {
        return 'ok';
    }
}

/**
 * Check Menu permission
 */
if (!function_exists('menuPermission')) {
    function menuPermission($menu_name)
    {
        if (authUserRole() != 2) {
            return true;
        } else {
            $role_id = auth()->user()->permission_role;
            $menu = \App\Model\Menu::where("title", $menu_name)->first();
            if (isset($menu)) {
                $menu_id = $menu->id;
                $activity_ids = \App\Model\MenuActivity::where('menu_id', $menu_id)->where('is_dependant', 'No')->pluck("id");
                if (isset($menu_id)) {
                    $condition = [
                        'role_id' => $role_id,
                        'menu_id' => $menu_id,
                    ];
                    if (\App\Model\RolePermission::whereIn('activity_id', $activity_ids)->where($condition)->exists()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}

/**
 * Check route permission
 */
if (!function_exists('routePermission')) {
    function routePermission($route_name)
    {
        if (authUserRole() != 2) {
            return true;
        } else {
            $activity = \App\Model\MenuActivity::where('route_name', $route_name)->first();
            if (isset($activity)) {
                $activity_id = $activity->id;
                $role_id = auth()->user()->permission_role;
                if (isset($activity_id)) {
                    $condition = [
                        'role_id' => $role_id,
                        'activity_id' => $activity_id,
                    ];
                    if (\App\Model\RolePermission::where($condition)->exists()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }
}

/**
 * Make pagination in collection
 */
if (!function_exists('pagination')) {
    function pagination($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

/**
 * Is vacation today
 */
if (!function_exists('isVacationToday')) {
    function isVacationToday()
    {
        $today = date('Y-m-d', strtotime(Carbon::now()));
        if (\App\Model\Vacation::where('start_date', '<=', $today)->where('end_date', '>=', $today)->live()->exists()) {
            $vacation = App\Model\Vacation::whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->live()->first();
            return [
                'status' => true,
                'id' => $vacation->id,
                'note' => $vacation->note,
            ];
        } else {
            return array('status' => false);
        }
    }
}

/**
 * Is holiday check
 */
if (!function_exists('isHoliday')) {
    function isHoliday($day)
    {
        $current_time = Carbon::now()->format('H:i');
        $condition = [
            'day' => $day,
            'auto_response' => 'on',
        ];
        if (\App\Model\HolidaySetting::where($condition)->exists()) {
            $setting = \App\Model\HolidaySetting::where($condition)->first();
            $start_time = date('H:i', strtotime($setting->start_time));
            $end_time = date('H:i', strtotime($setting->end_time));
            if (($start_time <= $current_time) and ($end_time >= $current_time)) {
                return "Yes";
            } else {
                return "No";
            }
        } else {
            return "No";
        }
    }
}

/**
 * Get organization date format
 * @returns string
 */

if (!function_exists('orgDateFormat')) {
    function orgDateFormat($date): string
    {
        $site_setting_info = \App\Model\SiteSetting::first();
        $get_date_format = isset($site_setting_info->date_format) ? $site_setting_info->date_format : 'Y-m-d';
        return date($get_date_format, strtotime($date));
    }
}

/**
 * Get attendance work hour
 * @returns string
 */

if (!function_exists('numberToWords')) {
    function numberToWords($number): string
    {
        $word = "";
        if ($number == 0) {
            $word = "Zero";
        } elseif ($number == 1) {
            $word = "One";
        } elseif ($number == 2) {
            $word = "Two";
        } elseif ($number == 3) {
            $word = "Three";
        } elseif ($number == 4) {
            $word = "Four";
        } elseif ($number == 5) {
            $word = "Five";
        } elseif ($number == 6) {
            $word = "Six";
        } elseif ($number == 7) {
            $word = "Seven";
        } elseif ($number == 8) {
            $word = "Eight";
        } elseif ($number == 9) {
            $word = "Nine";
        } elseif ($number == 10) {
            $word = "Ten";
        }
        return $word;
    }
}

/**
 * Get user language
 * @returns string
 */

if (!function_exists('getUserLanguage')) {
    function getUserLanguage(): string
    {
        if (auth()->user()->language == null or empty(auth()->user()->language)) {
            return siteSetting()->language ?? 'en';
        }
        if ((auth()->check()) and (auth()->user()->language != null)) {
            $language = auth()->user()->language;
        } else {
            $language = "en";
        }
        return $language;
    }
}

/**
 * Check user languate arabic or not
 * @returns string
 */

if (!function_exists('isArabic')) {
    function isArabic(): string
    {
        if(auth()->check()){
            if (getUserLanguage() == "ar") {
                return true;
            } else {
                return false;
            }
        }else{
            $lang = session()->get('lan');
            if ($lang == "ar") {
                return true;
            } else {
                return false;
            }
        }
    }
}

/**
 * Check session language arabic or not
 * @returns string
 */

if (!function_exists('hasArabic')) {
    function hasArabic(): string
    {
        $language = session()->get('lan');
        if (empty($language)) {
            session()->put('lan', 'en');
        }
        $language = session()->get('lan');
        if ($language == "ar") {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Convert title
 * @returns string
 */

if (!function_exists('titleConverter')) {
    function titleConverter($title): string
    {
        return strtolower(str_ireplace([':', '\\', '/', '*', ' '], '_', $title));
    }
}

/**
 * Convert title
 * @returns string
 */

if (!function_exists('getDomainExtensions')) {
    function getDomainExtensions(): array
    {
        return array('.com', '.com.bd', '.aero', '.asia', '.biz', '.cat', '.coop', '.edu', '.gov', '.gov.bd', '.info', '.int', '.jobs', '.mil', '.mobi', '.museum', '.name', '.net', '.org', '.pro', '.tel', '.travel', '.co', '.co.uk');
    }
}

/**
 * Convert hour minute
 * @returns string
 */

if (!function_exists('displayHourMinute')) {
    function displayHourMinute($time, $format = '%02d:%02d'): string
    {
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}

/**
 * Get user name by id
 * @returns string
 * @param int $id
 */

if (!function_exists('getUserName')) {
    function getUserName($id): string
    {
        $user = User::find($id);
        return $user->full_name ?? "";
    }
}

/**
 * test sendinblue api
 */
if (!function_exists('testSendinBlueApi')) {
    function testSendinBlueApi()
    {
        $client = new Client();

        try {
            //sendinblue api URL
            $response = $client->get('https://api.sendinblue.com/v3/account', [
                'headers' => [
                    'api-key' => smtpInfo()['api_key'],
                ],
            ]);

            return '200';
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();

            if ($statusCode === 401) {
                return '401';
            } else {
                return 'Error: ' . $e->getMessage();
            }
        }
    }
}

/**
 * Check mail connection
 */

if (!function_exists('mailConnection')) {
    function mailConnection()
    {
        if (testSendinBlueApi() == "200") {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Get user name by id
 * @returns string
 * @param string $id
 */

if (!function_exists('userNameByEmail')) {
    function userNameByEmail($email): string
    {
        if (User::where('email', $email)->exists()) {
            $id = User::where('email', $email)->first()->id;
            return getUserName($id);
        } else {
            return "User";
        }
    }
}

/**
 * escape output
 * @param string $text
 */

if (!function_exists('escapeOutput')) {
    function escapeOutput($string): string
    {
        if ($string) {
            return htmlentities($string, ENT_QUOTES, 'UTF-8');
        } else {
            return '';
        }
    }
}

/**
 * Get user image by id
 * @returns string
 * @param int $id
 */

if (!function_exists('getUserImage')) {
    function getUserImage($id): string
    {
        if ($id == 3) {
            return 'frequent_changing/images/ai_avatar.png';
        } else {
            $user = User::find($id);
            if ($user->image != null && file_exists($user->image)) {
                return $user->image;
            }else if ($user->email == 'ai@doorsoft.co') {
                return 'frequent_changing/images/ai_avatar.png';
            } else {
                return 'assets/images/avator.jpg';
            }
        }
    }
}

/**
 * Get number to word amount
 * @returns string
 * @param $number
 */

if (!function_exists('number_to_words')) {
    function number_to_words($num = '')
    {
        $num = (string) ((int) $num);

        if ((int) ($num) && ctype_digit($num)) {
            $words = array();

            $num = str_replace(array(',', ' '), '', trim($num));

            $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven',
                'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen',
                'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen');

            $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty',
                'seventy', 'eighty', 'ninety', 'hundred');

            $list3 = array('', 'thousand', 'million', 'billion', 'trillion',
                'quadrillion', 'quintillion', 'sextillion', 'septillion',
                'octillion', 'nonillion', 'decillion', 'undecillion',
                'duodecillion', 'tredecillion', 'quattuordecillion',
                'quindecillion', 'sexdecillion', 'septendecillion',
                'octodecillion', 'novemdecillion', 'vigintillion');

            $num_length = strlen($num);
            $levels = (int) (($num_length + 2) / 3);
            $max_length = $levels * 3;
            $num = substr('00' . $num, -$max_length);
            $num_levels = str_split($num, 3);

            foreach ($num_levels as $num_part) {
                $levels--;
                $hundreds = (int) ($num_part / 100);
                $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' Hundred' . ($hundreds == 1 ? '' : 's') . ' ' : '');
                $tens = (int) ($num_part % 100);
                $singles = '';

                if ($tens < 20) {
                    $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
                } else {
                    $tens = (int) ($tens / 10);
                    $tens = ' ' . $list2[$tens] . ' ';
                    $singles = (int) ($num_part % 10);
                    $singles = ' ' . $list1[$singles] . ' ';
                }
                $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_part)) ? ' ' . $list3[$levels] . ' ' : '');
            }
            $commas = count($words);
            if ($commas > 1) {
                $commas = $commas - 1;
            }

            $words = implode(', ', $words);

            $words = trim(str_replace(' ,', ',', ucwords($words)), ', ');
            if ($commas) {
                $words = str_replace(',', ' and', $words);
            }

            return $words;
        } else if (!((int) $num)) {
            return 'Zero';
        }
        return '';
    }

    /**
     * Data saved notification message
     */
    if (!function_exists('saveMessage')) {
        function saveMessage($message = "Information has been saved successfully !"): array
        {
            return [
                'type' => 'success',
                'message' => $message,
                'sign' => 'material-symbols:check',
            ];
        }
    }

    /**
     * Data update notification message
     */
    if (!function_exists('updateMessage')) {
        function updateMessage($message = 'Information has been updated successfully !'): array
        {
            return [
                'type' => 'info',
                'message' => $message,
                'sign' => 'material-symbols:check',
            ];
        }
    }

    /**
     * Data delete notification message
     */
    if (!function_exists('deleteMessage')) {
        function deleteMessage($message = 'Information has been deleted successfully !'): array
        {
            return [
                'type' => 'info',
                'message' => $message ?? __('index.delete_message'),
                'sign' => 'material-symbols:check',
            ];
        }
    }

    /**
     * Warning notification message
     */
    if (!function_exists('waringMessage')) {
        function waringMessage($message = "Something went wrong !"): array
        {
            return [
                'type' => 'warning',
                'warning' => $message,
                'sign' => 'bi:exclamation-triangle-fill',
            ];
        }
    }

    /**
     * Warning notification message
     */
    if (!function_exists('waringMessageDemo')) {
        function waringMessageDemo($message = "Something went wrong !"): array
        {
            return [
                'type' => 'warning',
                'warning_demo' => $message,
                'sign' => 'bi:exclamation-triangle-fill',
            ];
        }
    }

    /**
     * Error notification message
     */
    if (!function_exists('errorMessage')) {
        function errorMessage($message = "Information has been deleted successfully !"): array
        {
            return [
                'type' => 'error',
                'message' => $message,
                'sign' => 'uil:times',
            ];
        }
    }

    /**
     * Display alert dynamically
     */
    if (!function_exists('alertMessage')) {
        function alertMessage()
        {
            return view('alert_message');
        }
    }

    /**
     * Display required star dynamically
     */
    if (!function_exists('starSign')) {
        function starSign()
        {
            return "<span class='required_star'>" . " *" . "</span>";
        }
    }

    /**
     * Display Spinner dynamically
     */
    if (!function_exists('commonSpinner')) {
        function commonSpinner()
        {
            return "<i class='fa fa-spinner fa-spin me-2 spinner d-none'></i>";
        }
    }

}

/**
 * Get sanitized data
 * @returns string
 * @param $string
 */
if (!function_exists('escape_output')) {
    function escape_output($string)
    {
        if ($string) {
            return htmlentities($string, ENT_QUOTES, 'UTF-8');

        } else {
            return '';
        }
    }
}

/**
 * Get decrypted string ulr from id
 * @returns string
 */
if (!function_exists('encrypt_decrypt')) {
    function encrypt_decrypt($key, $type)
    {
        $str_rand = "XxOx*4e!hQqG5b~9a";

        if (!$key) {
            return false;
        }
        if ($type == 'decrypt') {
            $en_slash_added1 = trim(str_replace(array('tcktly'), '/', $key));
            $en_slash_added = trim(str_replace(array('dstcktly'), '%', $en_slash_added1));
            $key_value = $return = openssl_decrypt($en_slash_added, "AES-128-ECB", $str_rand);
            return $key_value;

        } elseif ($type == 'encrypt') {
            $key_value = openssl_encrypt($key, "AES-128-ECB", $str_rand);
            $en_slash_remove1 = trim(str_replace(array('/'), 'tcktly', $key_value));
            $en_slash_remove = trim(str_replace(array('%'), 'dstcktly', $en_slash_remove1));
            return $en_slash_remove;
        }
        return false;
    }
}

/**
 * Convert bas64 to image
 */
if (!function_exists('bas64ToFile')) {
    function bas64ToFile($base64_data)
    {
        list($type, $base64_data) = explode(';', $base64_data);
        $extension = array_reverse(explode('/', $type))[0];
        list(, $base64_data) = explode(',', $base64_data);
        $file = base64_decode($base64_data);
        $fileName = 'frequent_changing/images/' . time() . '.' . $extension;
        if (!file_exists('frequent_changing/images/')) {
            mkdir('frequent_changing/images/', 0755, true);
        }
        file_put_contents($fileName, $file);
        return $fileName;
    }
}

/**
 * Get all image path
 * @returns string
 */

if (!function_exists('imagePath')) {
    function imagePath(): string
    {
        return "frequent_changing/images/";
    }
}

/**
 * Get all file path
 * @returns string
 */

if (!function_exists('filePath')) {
    function filePath(): string
    {
        return "files/";
    }
}

/**
 * Get all file path
 * @returns string
 */

if (!function_exists('rootFilePath')) {
    function rootFilePath(): string
    {
        return "uploads/";
    }
}

/**
 * Convert bas64 to image
 */
if (!function_exists('bas64ToImage')) {
    function bas64ToImage($base64_data, $path)
    {
        list($type, $base64_data) = explode(';', $base64_data);
        $extension = array_reverse(explode('/', $type))[0];
        list(, $base64_data) = explode(',', $base64_data);
        $file = base64_decode($base64_data);
        $imageName = time() . '.' . $extension;
        if (!file_exists(rootFilePath() . $path)) {
            mkdir(rootFilePath() . $path, 0755, true);
        }
        file_put_contents(rootFilePath() . $path . $imageName, $file);
        return $imageName;
    }
}

/**
 * Store file on media
 */
if (!function_exists('storeOnMedia')) {
    function storeOnMedia($title, $group, $image)
    {
        list($type, $image) = explode(';', $image);
        $extension = array_reverse(explode('/', $type))[0];
        list(, $image) = explode(',', $image);
        $file = base64_decode($image);
        $imageName = time() . '.png';
        file_put_contents(rootFilePath() . 'media/media_images/' . $imageName, $file);

        $media = new Media();
        $media->title = $title;
        $media->group = $group;
        $media->media_path = $imageName;
        $media->save();
        $media->thumb_img = mediaThumb(rootFilePath() . 'media/media_images/' . $imageName);
        $media->save();
        return response()->json(['title' => $media->title, 'media_path' => $media->media_path, 'thumb_img' => $media->thumb_img]);
    }
}

/**
 * Get image information
 */
if (!function_exists('imageInfo')) {
    function imageInfo($image)
    {
        return [
            'is_image' => isImage($image),
            'extension' => fileExtension($image),
            'width' => imageWidthHeight($image)['width'],
            'height' => imageWidthHeight($image)['height'],
            'size' => $image->getSize(),
            'mb_size' => uploadedFileSizeInMb($image->getSize()),
        ];
    }
}

/**
 * Get uploaded file size
 */

if (!function_exists('uploadedFileSize')) {
    function uploadedFileSize($size, $precision = 2)
    {
        if ($size > 0) {
            $size = (int) $size;
            $base = log($size) / log(1024);
            $suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');
            return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
        }
        return $size;
    }
}

if (!function_exists('uploadedFileSizeInMb')) {
    function uploadedFileSizeInMb($size, $precision = 2)
    {
        if ($size > 0) {
            $mb = number_format($size / 1048576, 2);
            return $mb;
        }
        return $size;
    }
}

/**
 * Get file type
 */
if (!function_exists('getFileType')) {
    function getFileType($file)
    {
        return $file->getClientMimeType();
    }
}

/**
 * make media thumbnail
 */
if (!function_exists('mediaThumb')) {
    function mediaThumb($path)
    {
        $image = Image::make($path);
        $image->resize(300, 200);
        $imageName = 'thumb_' . time() . '.png';
        $image->save(rootFilePath() . 'media/thumbnails/' . $imageName, 60);
        return $imageName;
    }
}

/**
 * make blog thumbnail
 */
if (!function_exists('blogThumb')) {
    function blogThumb($path)
    {
        $image = Image::make($path);
        $image->resize(325, 216);
        $imageName = 'thumb_' . time() . '.png';
        $image->save(rootFilePath() . 'blogs/thumb/' . $imageName, 60);
        return $imageName;
    }
}

/**
 * Check file is image
 */
if (!function_exists('isImage')) {
    function isImage($file)
    {
        $file_type = $file->getClientMimeType();
        $text = explode('/', $file_type)[0];
        if ($text == "image") {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Get file extension
 */
if (!function_exists('fileExtension')) {
    function fileExtension($file)
    {
        if (isset($file)) {
            return $file->getClientOriginalExtension();
        } else {
            return "Inalid file";
        }
    }
}

/**
 * Get file type
 */
if (!function_exists('imageWidthHeight')) {
    function imageWidthHeight($image)
    {
        $img_size_array = getimagesize($image);
        $width = $img_size_array[0];
        $height = $img_size_array[1];
        return array('width' => $width, 'height' => $height);
    }
}

/**
 * Get path image info
 */
if (!function_exists('pathImageInfo')) {
    function pathImageInfo($path)
    {
        $image = Image::make($path);
        return [
            'type' => explode('/', $image->mime())[0],
            'extension' => explode('/', $image->mime())[1],
            'height' => $image->height(),
            'width' => $image->width(),
        ];
    }
}

/**
 * Upload image
 */
if (!function_exists('uploadIcoImage')) {
    function uploadIcoImage($file, $path = "images/", $width = "", $height = "", $size = "", $name = ""): string
    {
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }
        $manager = new ImageManager(['driver' => 'imagick']);
        $imageName = $name . "-" . time() . $file->getClientOriginalName();
        $image = $manager->make($file->getPathname());
        if ((isset($height)) and (isset($width))) {
            $image->resize($width, $height);
        }
        if (isset($size)) {
            $image->filesize($size);
        }
        $image->save($path . $imageName);
        return $path . $imageName;
    }
}
/**
 * Get days list
 */
if (!function_exists('dayList')) {
    function dayList(): array
    {
        return ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    }
}
if (!function_exists('setCustomerStatusForReply')) {
    function setCustomerStatusForReply()
    {
        $replies = TicketReplyComment::where('del_status', "Live")->get();
        foreach ($replies as $value) {
            $user = User::where('id', $value->created_by)->where('del_status', "Live")->where("type", '!=', "Customer")->first();
            if ($user) {
                $obj = TicketReplyComment::find($value->id);
                $obj->is_customer = 1;
                $obj->save();
            }

        }
        echo "success";
        exit;
    }
}
/**
 * ip checker
 */
function khchker()
{
    $spi = null;
    if (defined('INPUT_SERVER') && filter_has_var(INPUT_SERVER, 'REMOTE_ADDR')) {
        $spi = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
    } elseif (defined('INPUT_ENV') && filter_has_var(INPUT_ENV, 'REMOTE_ADDR')) {
        $spi = filter_input(INPUT_ENV, 'REMOTE_ADDR', FILTER_VALIDATE_IP);
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $spi = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    }

    if (empty($spi)) {
        $spi = '127.0.0.1';
    }
    $data = empty(filter_var($spi, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE | FILTER_FLAG_NO_PRIV_RANGE));
    return $data;
}

/**
 * db service checker for database
 */
if (!function_exists('registerPolicie')) {
    function registerPolicie()
    {
        return true;
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']) {
            $file_pointer = str_rot13('nffrgf/wdhrel/ERFG_NCV.wfba');
            if (file_exists($file_pointer)) {
                $file_content = file_get_contents($file_pointer);
                $json_data = json_decode($file_content, true);
                $installation_date = $json_data['date'];
                $meta_date = date("Y-m-d", filectime($file_pointer));
                if ($installation_date != $meta_date) {
                    abort(404);
                }
            } else {
                abort(404);
            }
            $file_pointer_i = str_rot13('nffrgf/wdhrel/ERFG_NCV_V.wfba');
            if (file_exists($file_pointer_i)) {
                $file_content_i = file_get_contents($file_pointer_i);
                $json_data_i = json_decode($file_content_i, true);
                $installation_url = str_replace('www.', '', str_replace('https://', '', str_replace('', '', str_replace('http://', '', str_rot13($json_data_i['installation_url'])))));
                $separate_url = explode('/', $installation_url);
                $installation_url = str_replace('www.', '', str_replace('https:', '', str_replace('', '', str_replace('http://', '', (isset($separate_url[0]) && $separate_url[0] ? $separate_url[0] : str_rot13($json_data_i['installation_url']))))));
                $server_url = (khchker()) ? str_rot13('ybpnyubfg') : str_replace('www.', '', $_SERVER['SERVER_NAME']);

                if (str_rot13($server_url) != 'ybpnyubfg') {
                    if ($installation_url != ($server_url)) {
                        abort(404);
                    }
                } else {
                    $installation_url = str_replace('www.', '', str_replace('https:', '', str_replace('/', '', str_replace('http://', '', str_rot13($json_data_i['installation_url'])))));
                    $installation_url_new = str_replace('www.', '', str_replace('https:', '', str_replace('/', '', str_replace('http://', '', baseUrl()))));
                    if ($installation_url != ($installation_url_new)) {
                        abort(404);
                    }
                }
            } else {
                abort(404);
            }
        }
    }
}

/**
 * Upload image
 */
if (!function_exists('uploadImage')) {
    function uploadImage($file, $path, $width = "", $height = "", $size = "", $name = ""): string
    {
        if (!file_exists(rootFilePath() . $path)) {
            mkdir(rootFilePath() . $path, 0755, true);
        }
        $imageName = $name . time() . $file->getClientOriginalName();
        $image = Image::make($file->getPathname());
        if ((isset($height)) and (isset($width))) {
            $image->resize($width, $height);
        }
        if (isset($size)) {
            $image->filesize($size);
        }
        $image->save(rootFilePath() . $path . $imageName);
        return $imageName;
    }
}

/**
 * Upload file
 */
if (!function_exists('uploadFile')) {
    function uploadFile($file, $path, $name = ""): string
    {
        $uniqueFileName = $name . time() . '.' . $file->getClientOriginalExtension();
        if (!file_exists(rootFilePath() . $path)) {
            mkdir(rootFilePath() . $path, 0755, true);
        }
        $file->move(rootFilePath() . $path, $uniqueFileName);
        return $uniqueFileName;
    }
}

/**
 * Get authenticate user role
 */

if (!function_exists('urlPrefix')) {
    function urlPrefix()
    {
        return Request::segment(1);
    }
}

/**
 * Get authenticate user role
 */

if (!function_exists('authUserRole')) {
    function authUserRole()
    {
        return auth()->user()->role_id;
    }
}

/**
 * Get authenticate user id
 */

if (!function_exists('authUserId')) {
    function authUserId()
    {
        return (auth()->user()->id) ?? "";
    }
}

/**
 * Get all notices
 */
if (!function_exists('getNotice')) {
    function getNotice()
    {
        return Notice::whereDate('start_date', '<=', Carbon::today())->whereDate('end_date', '>=', Carbon::today())->get();
    }
}

/**
 * Total notification count
 */
if (!function_exists('showTotalNotification')) {
    function showTotalNotification()
    {
        if (authUserRole() == 1) {
            $total = \App\Model\AdminNotification::live()->whereNull('mark_as_read_status')->count();
            return $total > 99 ? '99+' : $total;
        } elseif (authUserRole() == 2) {
            $total = \App\Model\AgentNotification::where('agent_for', auth()->user()->id)->live()->whereNull('mark_as_read_status')->count();
            return $total > 99 ? '99+' : $total;
        } elseif (authUserRole() == 3) {
            $total = \App\Model\CustomerNotification::where('customer_for', auth()->user()->id)->live()->whereNull('mark_as_read_status')->count();
            return $total > 99 ? '99+' : $total;
        }
    }
}

//Get Hour from time
if (!function_exists('getTotalHour')) {
    function getTotalHour($start_time, $end_time)
    {
        $time1 = $start_time;
        $time2 = $end_time;
        $array1 = explode(':', $time1);
        $array2 = explode(':', $time2);

        $minutes1 = ($array1[0] * 60.0 + $array1[1]);
        $minutes2 = ($array2[0] * 60.0 + $array2[1]);

        $total_min = $minutes1 - $minutes2;
        $total_tmp_hour = (int) ($total_min / 60);
        $total_tmp_hour_minus = ($total_min % 60);

        //return $total_tmp_hour.".".$total_min_tmp;
        return $total_tmp_hour . "." . $total_tmp_hour_minus;

    }
}
/**
 * Get current date
 */
if (!function_exists('currentDate')) {
    function currentDate()
    {
        return orgDateFormat(Carbon::now());
    }
}

/**
 * Get current time
 */
if (!function_exists('currentTime')) {
    function currentTime()
    {
        return date('h:i a', strtotime(Carbon::now()));
    }
}
/**
 * Add activity log
 */
if (!function_exists('activityLog')) {
    function activityLog($ticket_id, $activity_type, $text)
    {
        $activity_info = new ActivityLog();
        $activity_info->type = $activity_type;
        $activity_info->user_id = auth()->user()->id;
        $activity_info->ticket_id = $ticket_id;
        $activity_info->activity = $text;
        $activity_info->save();
        return 0;
    }
}

/**
 * Get auth user type
 */
if (!function_exists('authUserType')) {
    function authUserType()
    {
        return auth()->user()->type ?? "Guest";
    }
}

/**
 * Get user type
 */
if (!function_exists('userTypeById')) {
    function userTypeById($id)
    {
        return User::find($id)->type ?? "";
    }
}

/**
 * Save admin notification
 */
if (!function_exists('saveAdminNotification')) {
    function saveAdminNotification($activity_type, $ticket_id, $notification_message, $comment_id = null)
    {
        $admin_notification = new \App\Model\AdminNotification();
        $admin_notification->type = $activity_type;
        $admin_notification->from = authUserType();
        $admin_notification->ticket_id = $ticket_id;
        $admin_notification->reply_comment_id = $comment_id;
        $admin_notification->message = $notification_message;
        $admin_notification->redirect_link = 'ticket/' . encrypt_decrypt($ticket_id, 'encrypt');
        $admin_notification->mark_as_read_status = null;
        $admin_notification->created_by = authUserId();
        $admin_notification->save();
    }
}

/**
 * Save agent notification
 */
if (!function_exists('saveAgentNotification')) {
    function saveAgentNotification($activity_type, $ticket_id, $notification_message, $agent_for, $comment_id = null)
    {
        $agent_notification = new \App\Model\AgentNotification();
        $agent_notification->type = $activity_type;
        $agent_notification->from = authUserType();
        $agent_notification->agent_for = $agent_for;
        $agent_notification->ticket_id = $ticket_id;
        $agent_notification->reply_comment_id = $comment_id;
        $agent_notification->message = $notification_message;
        $agent_notification->redirect_link = 'ticket/' . encrypt_decrypt($ticket_id, 'encrypt');
        $agent_notification->mark_as_read_status = null;
        $agent_notification->created_by = authUserId();
        $agent_notification->save();
    }
}

/**
 * Save customer notification
 */
if (!function_exists('saveCustomerNotification')) {
    function saveCustomerNotification($activity_type, $ticket_id, $notification_message, $customer_for, $comment_id = null)
    {
        $agent_notification = new \App\Model\CustomerNotification();
        $agent_notification->type = $activity_type;
        $agent_notification->from = authUserType();
        $agent_notification->customer_for = $customer_for;
        $agent_notification->ticket_id = $ticket_id;
        $agent_notification->reply_comment_id = $comment_id;
        $agent_notification->message = $notification_message;
        $agent_notification->redirect_link = 'ticket/' . encrypt_decrypt($ticket_id, 'encrypt');
        $agent_notification->mark_as_read_status = null;
        $agent_notification->created_by = authUserId();
        $agent_notification->save();
    }
}

/**
 * Check ticket has agent comments or not
 */
if (!function_exists('hasAgentComment')) {
    function hasAgentComment($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if ($ticket->status == 2) {
            return true;
        }

        $last_comment = TicketReplyComment::orderBy('created_at', 'desc')->first();

        if (isset($last_comment)) {
            $last_comment_user = User::find($last_comment->created_by);

            if (User::where('id', $last_comment->created_by)->exists()) {
                if (!isset($last_comment_user)) {
                    return true;
                } else {
                    $last_comment_user_type = $last_comment_user->type;
                    if (!isset($last_comment_user_type)) {
                        return true;
                    } else {
                        if (authUserType() == 'Customer' && !isset($last_comment)) {
                            return false;
                        } else {
                            if (isset($last_comment) && isset($last_comment_user_type)) {
                                if (authUserRole() == 3 && $last_comment_user_type != 'Customer') {
                                    return false;
                                } elseif (authUserRole() == 1 && $last_comment_user_type == 'Customer') {
                                    return false;
                                } elseif (authUserRole() == 2 && $last_comment_user_type == 'Customer') {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return false;
                            }
                        }
                    }
                }
            } else {
                return true;
            }

        } else {
            return false;
        }
    }
}

/**
 * Check ticket need action
 */
if (!function_exists('needAction')) {
    function needAction($ticket_id)
    {
        $ticket = Ticket::find($ticket_id);
        if ($ticket->status == 2) {
            return false;
        } else {
            $created_by = User::find($ticket->created_by);
            $created_by_type = $created_by->type ?? '';
            $last_comment = TicketReplyComment::where('ticket_id', $ticket->id)->orderBy('created_at', 'desc')->first();

            $last_comment_user_type = '';
            if (isset($last_comment)) {
                $last_comment_user_type = User::find($last_comment->created_by)->type;
            }
            if (authUserType() == "Customer") {
                if ($created_by_type == "Customer" && !isset($last_comment)) {
                    return false;
                } elseif (!isset($last_comment) && $created_by_type == "Admin") {
                    return true;
                } elseif ($created_by_type == "Agent" && !isset($last_comment)) {
                    return true;
                } elseif (isset($last_comment) && $last_comment_user_type == "Admin" || $last_comment_user_type == "Agent") {
                    return true;
                } else {
                    return false;
                }
            } elseif (authUserType() == "Agent") {
                if ($created_by_type == "Agent" && !isset($last_comment)) {
                    return false;
                } elseif (!isset($last_comment) && $created_by_type == "Customer") {
                    return true;
                } elseif (isset($last_comment) && $last_comment_user_type == "Customer") {
                    return true;
                } else {
                    return false;
                }
            } elseif (authUserType() == "Admin") {
                if ($created_by_type == "Admin" && !isset($last_comment)) {
                    return false;
                } elseif (!isset($last_comment) && $created_by_type == "Customer") {
                    return true;
                } elseif (isset($last_comment) && $last_comment_user_type == "Customer") {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}

/**
 * Get need action ticket ids
 */
if (!function_exists('needActionTicketIds')) {
    function needActionTicketIds()
    {
        $ids = [];
        $tickets = Ticket::where('status', '!=', 2)->type()->ticketCondition()->select('id')->get();
        foreach ($tickets as $ticket) {
            if (needAction($ticket->id)) {
                array_push($ids, $ticket->id);
            }
        }
        return $ids;
    }
}

/**
 * Check all notification active or not
 */
if (!function_exists('activeAllNotification')) {
    function activeAllNotification()
    {
        if (MailTemplate::where('web_push_notification', 'off')->exists() || MailTemplate::where('mail_notification', 'off')->exists()) {
            return false;
        } else {
            return true;
        }
    }
}

/**
 * Count user unseen message
 */
if (!function_exists('userUnseen')) {
    function userUnseen()
    {
        return groupUnseen() + singleUnseen();
    }
}

/**
 * Count user unseen message
 */
if (!function_exists('singleUnseen')) {
    function singleUnseen()
    {
        return SingleChatMessage::where('to_id', authUserId())->where('seen_status', 0)->count() ?? 0;
    }
}

/**
 * Count user unseen message
 */
if (!function_exists('groupUnseen')) {
    function groupUnseen()
    {
        $group_id = ChatGroupMember::where('user_id', authUserId())->pluck('group_id');
        return GroupChatMessage::whereIn('group_id', $group_id)->where('from_id', '!=', authUserId())->where('seen_status', 0)->count();
    }
}

/**
 * Product category name by id
 */
if (!function_exists('productCatName')) {
    function productCatName($id)
    {
        if ($id == "blog") {
            return ucfirst($id);
        } elseif ($id == "page") {
            return ucfirst($id);
        } else {
            return ProductCategory::find($id)->title ?? "";
        }

    }
}

/**
 * Get ticket status
 */
if (!function_exists('getTicketStatus')) {
    function getTicketStatus($status)
    {
        if ($status == 1) {
            return "Open";
        } elseif ($status == 2) {
            return "Closed";
        } elseif ($status == 3) {
            return "Re-open";
        } elseif ($status == 4) {
            return "Flagged";
        } else {
            return "N/A";
        }

    }
}

/**
 * Get ticket status color
 */
if (!function_exists('getTicketStatusColor')) {
    function getTicketStatusColor($status)
    {
        if ($status == 1) {
            return "success";
        } elseif ($status == 2) {
            return "danger";
        } elseif ($status == 3) {
            return "warning";
        } elseif ($status == 4) {
            return "info";
        } else {
            return "primary";
        }

    }
}

/**
 * Get admin id
 */
if (!function_exists('adminId')) {
    function adminId()
    {
        return User::where('role_id', 1)->first()->id ?? 0;
    }
}

/**
 * is allowed fcm
 */
if (!function_exists('isAllowedFcm')) {
    function isAllowedFcm()
    {
        if (siteSetting()->browser_notification == "Yes") {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Send mail to customer permsiion
 */
if (!function_exists('sendMailToCustomer')) {
    function sendMailToCustomer($template_id)
    {
        return true;
        $template = \App\Model\MailTemplate::find($template_id);
        if ($template->mail_to != null) {
            $to_mails_array = json_decode($template->mail_to);
            if (in_array("Customer", $to_mails_array)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

/**
 * Get ticket priority
 */
if (!function_exists('ticketPriority')) {
    function ticketPriority($value)
    {
        if ($value == 1) {
            return "High";
        } elseif ($value == 2) {
            return "Medium";
        } elseif ($value == 3) {
            return "Low";
        }
    }
}

/**
 * Get pusher channel name
 */
if (!function_exists('pusherChannel')) {
    function pusherChannel()
    {
        return pusherInfo()['channel_name'] ?? "";
    }
}

/**
 * Get pusher app id
 */
if (!function_exists('pusherAppId')) {
    function pusherAppId()
    {
        return pusherInfo()['app_id'] ?? "";
    }
}

/**
 * Get pusher app key
 */
if (!function_exists('pusherAppKey')) {
    function pusherAppKey()
    {
        return pusherInfo()['app_key'] ?? "";
    }
}

/**
 * Get pusher app secret
 */
if (!function_exists('pusherAppSecret')) {
    function pusherAppSecret()
    {
        return pusherInfo()['app_secret'] ?? "";
    }
}

/**
 * Get pusher app cluster
 */
if (!function_exists('pusherAppCluster')) {
    function pusherAppCluster()
    {
        return pusherInfo()['app_cluster'] ?? "";
    }
}

/**
 * Get application mode
 */
if (!function_exists('appMode')) {
    function appMode()
    {
        return env('APPLICATION_MODE') ?? 'live';
    }
}

/**
 * Get application theme
 */
if (!function_exists('appTheme')) {
    function appTheme()
    {
        $theme = siteSetting()->theme_type ?? 'multiple';
        return $theme;
    }
}

/**
 * Get Layout For Frontend
 */

if (!function_exists('layout')) {
    function layout()
    {
        $layout = 'frontend.app';
        if (appTheme() == 'single') {
            $layout = 'frontend.app-second';
        }
        return $layout;
    }
}
/**
 * Get AI Database Search
 * @param $filter
 * @return string
 */

function getAIDatabaseSearch($filter)
{
    $ai_return_data = 'Sorry that the AI could not find any instant solution, please wait for an Agent to reply you. You will be notified via email.';
    if (aiInfo()['type'] == "Yes") {
        //call open ai if no previous articles and replies found
        //set ai key from setting
        $open_ai_key = (aiInfo()['api_key']);
        $open_ai = new OpenAi($open_ai_key);
        //set orga. key from setting
        $open_ai->setORG(aiInfo()['organization_key']);
        $complete = $open_ai->chat([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    "role" => "user",
                    "content" => $filter,
                ],
            ],
            'temperature' => 1.0,
            'max_tokens' => 4000,
            'frequency_penalty' => 0,
            'presence_penalty' => 0,
        ]);
        $d = json_decode($complete, true);
        Log::info($d);
        if (isset($d['error']['code']) && $d['error']['code'] == 'invalid_api_key') {
            $ai_return_data = "Sorry that the AI could not find any instant solution, please wait for an Agent to reply you. You will be notified via email.";
        } else {
            $ai_return_data = $d['choices'][0]['message']['content'] ?? '';
        }
    }
    return $ai_return_data;
}

/**
 * Reset unused text
 * @param $str
 * @return string
 */
function reset_unused_text($str)
{
    $searchArray = array("<p><br />", "<p><br />", "Hi there,", "Hi,", "Hello,", "Hello Sir,", "Hello sir,");
    $resultString = str_replace($searchArray, "", $str);
    return ($resultString);
}

/**
 * Get Full Text Data For AI
 * @param $filter
 * @param $ticket_id
 * @param $p_id
 * @return string
 */

if (!function_exists('getFullTextDataForAI')) {
    function getFullTextDataForAI($filter, $ticket_id, $p_id)
    {
        $ai_return_data = '';
        $check_ticket_reply = DB::table('tbl_ticket_reply_comments')
            ->select('id', 'ticket_comment')
            ->where('ticket_id', '=', $ticket_id)
            ->first();

        if (!$check_ticket_reply) {
            $ticket_replies = DB::table('tbl_tickets')
                ->select('id', 'title', 'del_status')
                ->where('del_status', 'Live')
                ->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
                ->where('id', '!=', $ticket_id)
                ->where('product_category_id', '=', $p_id)
                ->limit(5)
                ->get();

            $articles = DB::table('tbl_articles')
                ->select('id', 'title', 'title_slug', 'del_status')
                ->where('del_status', 'Live')
                ->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
                ->where('product_category_id', '=', $p_id)
                ->limit(5)
                ->get();
            $productCategory = DB::table('tbl_product_categories')
                ->select('id', 'slug', 'del_status')
                ->where('del_status', 'Live')
                ->where('id', '=', $p_id)
                ->first();

            if ($articles->count() > 0) {
                $str = 'Related articles-<br>';
                foreach ($articles as $ke => $article) {
                    $str .= " &nbsp;<a target='_blank' href='" . baseUrl() . "\article/" . $productCategory->slug . "/". $article->title_slug . "'>" . $article->title . "</a>";
                    $str .= "<br>";
                }
                $ai_return_data = $str;
            } else if ($ticket_replies->count() > 0) {
                $str_replies = '';
                foreach ($ticket_replies as $key => $value) {
                    $selected_row = DB::table('tbl_ticket_reply_comments')
                        ->select('id', 'ticket_comment')
                        ->where('ticket_id', '=', $value->id)
                        ->where('is_helpful', '=', 1)
                        ->where('is_ai_replied', '=', 0)
                        ->first();
                    if ($selected_row) {
                        if (isset($selected_row->ticket_comment) && $selected_row->ticket_comment) {
                            $separate_data = explode("<!--supporthive_comment--->", $selected_row->ticket_comment);
                            $str_replies .= "<div class='header-section'>" . reset_unused_text($separate_data[0]) . "</div>";
                        }
                    }
                }
                $ai_return_data = $str_replies;
            }
        }

        if ($ai_return_data == '') {
            $ai_return_data = getAIDatabaseSearch($filter);
        }
        return $ai_return_data;

    }
}

/**
 * Get AI Pre Sale Chat Response
 * @param $filter
 * @param $p_id
 * @return string
 */
function getAIPreSaleChatResponse($filter, $p_id)
{
    $ai_return_data = '';

    $auto_reply = DB::table('tbl_auto_replies')
        ->select('id', 'question', 'answer', 'del_status')
        ->where('del_status', 'Live')
        ->whereRaw("MATCH(question) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
        ->where('category_id', '=', $p_id)
        ->first();

    if (isset($auto_reply->answer) && $auto_reply->answer) {
        $ai_return_data = $auto_reply->answer;
    }

    if ($ai_return_data == '') {
        $articles = DB::table('tbl_articles')
            ->select('id', 'title', 'title_slug')
            ->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
            ->where('product_category_id', '=', $p_id)
            ->limit(5)
            ->get();

        $productCategory = DB::table('tbl_product_categories')
            ->select('id', 'slug', 'del_status')
            ->where('del_status', 'Live')
            ->where('id', '=', $p_id)
            ->first();

        if (sizeof($articles)) {
            $str = '<div class="ai_reply_article">AI found some solution for you in our system, here is some related articles-';
            $str .= "<div class='article_list_reply_by_ai'>";
            foreach ($articles as $ke => $article) {
                $str .= " <a target='_blank' href='" . baseUrl() . "\article/". $productCategory->slug ."/". $article->title_slug . "'>" . $article->title . "</a>";
            }
            $str .= "</div></div>";
            $ai_return_data = $str;
        }
    }
    if ($ai_return_data == "") {
        $ai_return_data = "Sorry that the AI could not find any instant solution, please wait for an Agent to reply you. You will be notified via email.";
    }
    return $ai_return_data;

}

/**
 * Get AI After Sale Chat Response
 */
function sendAfterSaleAiResponse($filter, $p_id)
{
    $ai_return_data = '';
    $auto_reply = DB::table('tbl_auto_replies')
        ->select('id', 'question', 'answer', 'del_status')
        ->where('del_status', 'Live')
        ->whereRaw("MATCH(question) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
        ->where('category_id', '=', $p_id)
        ->first();

    if (isset($auto_reply->answer) && $auto_reply->answer) {
        $ai_return_data = "" . $auto_reply->answer;
    }

    if ($ai_return_data == '') {
        $articles = DB::table('tbl_articles')
            ->select('id', 'title', 'title_slug', 'del_status')
            ->where('del_status', 'Live')
            ->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
            ->where('product_category_id', '=', $p_id)
            ->limit(3)
            ->get();

        $ticket_replies = DB::table('tbl_tickets')
            ->select('id', 'title', 'del_status')
            ->where('del_status', 'Live')
            ->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$filter])
            ->where('product_category_id', '=', $p_id)
            ->limit(3)
            ->get();

        $productCategory = DB::table('tbl_product_categories')
            ->select('id', 'slug', 'del_status')
            ->where('del_status', 'Live')
            ->where('id', '=', $p_id)
            ->first();

        if (sizeof($articles)) {
            $str = '<div class="ai_reply_article">AI found some solution for you in our system, here is some related articles-';
            $str .= "<div class='article_list_reply_by_ai'>";
            foreach ($articles as $ke => $article) {
                $str .= " <a target='_blank' href='" . baseUrl() . "\article/". $productCategory->slug ."/". $article->title_slug . "'>" . $article->title . "</a>";
            }
            $str .= "</div></div>";
            $ai_return_data = $str;
        } else if (sizeof($ticket_replies)) {
            $str_replies = 'AI found some solutions from previous ticket-solving data, here is some related replies-';
            foreach ($ticket_replies as $key => $value) {
                $selected_row = DB::table('tbl_ticket_reply_comments')
                    ->select('id', 'ticket_comment')
                    ->where('ticket_id', '=', $value->id)
                    ->where('is_helpful', '=', 1)
                    ->where('is_ai_replied', '=', 0)
                    ->first();
                if ($selected_row) {
                    if (isset($selected_row->ticket_comment) && $selected_row->ticket_comment) {
                        $separate_data = explode("<!--supporthive_comment--->", $selected_row->ticket_comment);
                        $str_replies .= "<div class='header-section'>" . reset_unused_text($separate_data[0]) . "</div><hr class='m-0'>";
                    }
                }
            }
            $ai_return_data = $str_replies;
        }
    }
    if ($ai_return_data == "") {
        $ai_return_data = getAIDatabaseSearch($filter);
    }
    return $ai_return_data;

}

/**
 * Get application mode
 */
if (!function_exists('getDemoAccess')) {
    function getDemoAccess($type)
    {
        $str = '';
        $url_checker = urlPrefix();
        $mode_checker = appMode();
        if ($mode_checker == "demo") {
            if ($type == 1) {
                if ($url_checker == "admin") {
                    $str = "admin@doorsoft.co";
                } elseif ($url_checker == "agent") {
                    $str = "agent@doorsoft.co";
                } elseif ($url_checker == "customer") {
                    $str = "customer@doorsoft.co";
                }
            } else if ($type == 2) {
                $str = "123456";
            }
        }

        return $str;
    }
}

/**
 * Get pusher info from file
 */
if (!function_exists('demoPusher')) {
    function demoPusher()
    {
        if (file_exists('assets/demo/pusher.json')) {
            $jsonString = File::get('assets/demo/pusher.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}
/**
 * Get ai info from file
 */
if (!function_exists('demoAi')) {
    function demoAi()
    {
        if (file_exists('assets/demo/ai_setting.json')) {
            $jsonString = File::get('assets/demo/ai_setting.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}
/**
 * Get pusher info from file
 */
if (!function_exists('pusherInfo')) {
    function pusherInfo()
    {
        if (file_exists('assets/json/pusher.json')) {
            $jsonString = File::get('assets/json/pusher.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}

/**
 * Get social info demo from file
 */
if (!function_exists('demoSocial')) {
    function demoSocial()
    {
        if (file_exists('assets/demo/social.json')) {
            $jsonString = File::get('assets/demo/social.json');
            return json_decode($jsonString, true);
        } else {
            return false;
        }
    }
}

/**
 * Get demo paypal
 */
if (!function_exists('demoPaypal')) {
    function demoPaypal()
    {
        if (file_exists('assets/demo/paypal.json')) {
            $jsonString = File::get('assets/demo/paypal.json');
            return json_decode($jsonString, true);
        } else {
            return false;
        }
    }
}

/**
 * Get demo stripe file
 */
if (!function_exists('stripeInfo')) {
    function stripeInfo()
    {
        $jsonString = File::get('assets/json/stripe.json');
        $data = json_decode($jsonString, true);
        if (file_exists('assets/json/stripe.json')) {
            if ($data['stripe_active_mode'] == "sandbox") {
                $stripe = [];
                $stripe['stripe_key'] = $data['stripe_key'];
                $stripe['stripe_secret'] = $data['stripe_secret'];
                return $stripe;
            }
        } else {
            $stripe = [];
            $stripe['stripe_key'] = $data['stripe_live_key'];
            $stripe['stripe_secret'] = $data['stripe_live_secret'];
            return $stripe;
        }
    }
}

/**
 * Page content
 */
if (!function_exists('aboutUs')) {
    function aboutUs()
    {
        $jsonString = file_get_contents('assets/json/about_us.json');
        return json_decode($jsonString, true);
    }
}

/**
 * Feature Section Content
 */
if (!function_exists('featureSetting')) {
    function featureSetting()
    {
        $jsonString = file_get_contents('assets/json/feature.json');
        return json_decode($jsonString, true);
    }
}

/**
 * section Title
 */
if (!function_exists('sectionTitle')) {
    function sectionTitle()
    {
        $jsonString = file_get_contents('assets/json/section_title.json');
        return json_decode($jsonString, true);
    }
}

/**
 * Page content
 */
if (!function_exists('ourService')) {
    function ourService()
    {
        $jsonString = file_get_contents('assets/json/our_service.json');
        return json_decode($jsonString, true);
    }
}

/**
 * Get demo stripe file
 */
if (!function_exists('demoStripe')) {
    function demoStripe()
    {
        if (file_exists('assets/demo/stripe.json')) {
            $jsonString = File::get('assets/demo/stripe.json');
            return json_decode($jsonString, true);
        } else {
            return false;
        }
    }
}

/**
 * Get social info from file
 */
if (!function_exists('socialInfo')) {
    function socialInfo()
    {
        if (file_exists('assets/json/social.json')) {
            $jsonString = File::get('assets/json/social.json');
            return json_decode($jsonString, true);
        } else {
            return false;
        }
    }
}

/**
 * Check pusher connection
 */
if (!function_exists('pusherConnection')) {
    function pusherConnection()
    {
        $app_id = pusherInfo()['app_id'];
        $app_key = pusherInfo()['app_key'];
        $app_secret = pusherInfo()['app_secret'];
        $app_cluster = pusherInfo()['app_cluster'];

        $pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, ['cluster' => $app_cluster]);
        $response = $pusher->get('/channels');
        if (!empty($response)) {
            $http_status_code = $response['status'];
            $result = $response['result'];
            if ($http_status_code == 200) {
                return true;
            } else {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }
}

/**
 * Get pusher info from file
 */
if (!function_exists('chatSetting')) {
    function chatSetting()
    {
        return ChatSetting::first();
    }
}

/**
 * Get firebase info from file
 */
if (!function_exists('firebaseInfo')) {
    function firebaseInfo()
    {
        if (file_exists('assets/json/firebase.json')) {
            $jsonString = File::get('assets/json/firebase.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}

/**
 * Get firebase info from file
 */
if (!function_exists('demoFirebase')) {
    function demoFirebase()
    {
        if (file_exists('assets/demo/firebase.json')) {
            $jsonString = File::get('assets/demo/firebase.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}

/**
 * Get pusher info from file
 */
if (!function_exists('smtpInfo')) {
    function smtpInfo()
    {
        if (file_exists('assets/json/smtp.json')) {
            $jsonString = File::get('assets/json/smtp.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}
/**
 * Get pusher info from file
 */
if (!function_exists('aiInfo')) {
    function aiInfo()
    {
        if (file_exists('assets/json/ai_setting.json')) {
            $jsonString = File::get('assets/json/ai_setting.json');
            return json_decode($jsonString, true);
        } else {
            return "";
        }
    }
}
/**
 * Get config info from file
 */
if (!function_exists('configInfo')) {
    function configInfo()
    {
        return ConfigurationSetting::first() ?? "";
    }
}

/**
 * Show undone work
 */
if (!function_exists('showUndoneWork')) {
    function showUndoneWork()
    {
        $status = false;
        if (configInfo()->facebook_login == 0 && configInfo()->inerest_facebook_login == 1) {
            $status = true;
        } elseif (configInfo()->google_login == 0 && configInfo()->inerest_google_login == 1) {
            $status = true;
        } elseif (configInfo()->github_login == 0 && configInfo()->inerest_github_login == 1) {
            $status = true;
        } elseif (configInfo()->envato_login == 0 && configInfo()->inerest_envato_login == 1) {
            $status = true;
        } elseif (configInfo()->chat_setting == 0 && configInfo()->inerest_chat_setting == 1) {
            $status = true;
        } elseif (configInfo()->notification_setting == 0 && configInfo()->inerest_notification_setting == 1) {
            $status = true;
        } elseif (configInfo()->mail_setting == 0 && configInfo()->inerest_mail_setting == 1) {
            $status = true;
        } elseif (configInfo()->payment_gateway_setting == 0 && configInfo()->inerest_payment_gateway_setting == 1) {
            $status = true;
        }
        return $status;
    }
}

/**
 * Fetch all language folder names
 */
if (!function_exists('languageFolders')) {
    function languageFolders(): array
    {
        $filtered = ['.', '..'];
        $dirs = [];
        $d = dir(resource_path('lang'));
        while (($entry = $d->read()) !== false) {
            if (is_dir(resource_path('lang') . '/' . $entry) && !in_array($entry, $filtered)) {
                $dirs[] = $entry;
            }
        }

        return $dirs;
    }
}

/**
 * Fetch short name
 */
if (!function_exists('shortName')) {
    function shortName($str)
    {
        // Split the string into words
        $words = explode(' ', trim($str));
        $initials = '';

        // Loop through each word and get the first character
        foreach ($words as $word) {
            if (!empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        return $initials;
    }
}



/**
 * Get as plain text
 */
if (!function_exists('getPlainText')) {

    function getPlainText($text)
    {
        if ($text) {
            $res = trim(str_replace(array('\'', '"', '`', ',', ';', '<', '>', '(', ')', '{', '}', '[', ']', '$', '%', '#', '/', '@', '&'), ' ', $text));
            $tmp_text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $res)));
            $final_txt = preg_replace("/[\n\r]/", " ", escape_output($tmp_text)); #remove new line from address
            return $final_txt;
        } else {
            return '';
        }
    }
}

/**
 * For JSON Plain Text
 */
if (!function_exists('saveJsonText')) {

    function saveJsonText($text)
    {
        if ($text) {
            $res = trim(str_replace(array('"'), ' ', $text));
            $tmp_text = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $res)));
            $final_txt = preg_replace("/[\n\r]/", " ", escape_output($tmp_text)); #remove new line from address
            return $final_txt;
        } else {
            return '';
        }
    }
}

/**
 * Customer Response
 */
function customResponse($userInput)
{
    $lowercaseInput = strtolower($userInput);
    $greetingPatterns = '/\bhello\b|\bhi\b|\bhey\b/i';
    $thankYouPatterns = '/\bthank\s*you\b|\bthanks\b/i';
    $byePatterns = '/\bbye\b|\bgoodbye\b|\btalk to later\b|\btalk later\b/i';
    $robotPatterns = '/\brobot\b/i';

    // Check if the user input matches any of the patterns
    if (preg_match($greetingPatterns, $lowercaseInput)) {
        return "Hello! How can I help you today?";
    } elseif (preg_match($thankYouPatterns, $lowercaseInput)) {
        return "You're welcome! If you have more questions, feel free to ask.";
    } elseif (preg_match($byePatterns, $lowercaseInput)) {
        return "Goodbye! If you have any more questions in the future, don't hesitate to reach out.";
    } elseif (preg_match($robotPatterns, $lowercaseInput)) {
        return "No, I'm not a robot. I'm a computer program running on powerful servers.";
    } else {
        return false;
    }
}

/**
 * Show pre tag
 */
function pre($data)
{
    print("<PRE>");
    print_r($data);
}

/**
 * Get language full name
 */
if (!function_exists('lanFullName')) {
    function lanFullName($short_name)
    {
        $lg['ar'] = 'Arabic';
        $lg['az'] = 'Azerbaijani';
        $lg['bg'] = 'Bulgarian';
        $lg['bn'] = 'Bengali';
        $lg['bs'] = 'Bosnian';
        $lg['ca'] = 'Catalan';
        $lg['cn'] = 'Chinese (S)';
        $lg['cs'] = 'Czech';
        $lg['da'] = 'Danish';
        $lg['de'] = 'German';
        $lg['fi'] = 'Finnish';
        $lg['fr'] = 'French';
        $lg['ea'] = 'Spanish (Argentina)';
        $lg['el'] = 'Greek';
        $lg['en'] = 'English';
        $lg['es'] = 'Spanish';
        $lg['et'] = 'Estonian';
        $lg['he'] = 'Hebrew';
        $lg['hi'] = 'Hindi';
        $lg['hr'] = 'Croatian';
        $lg['hu'] = 'Hungarian';
        $lg['hy'] = 'Armenian';
        $lg['id'] = 'Indonesian';
        $lg['is'] = 'Icelandic';
        $lg['it'] = 'Italian';
        $lg['ir'] = 'Persian';
        $lg['jp'] = 'Japanese';
        $lg['ka'] = 'Georgian';
        $lg['ko'] = 'Korean';
        $lg['lt'] = 'Lithuanian';
        $lg['lv'] = 'Latvian';
        $lg['mk'] = 'Macedonian';
        $lg['ms'] = 'Malay';
        $lg['mx'] = 'Mexico';
        $lg['nb'] = 'Norwegian';
        $lg['ne'] = 'Nepali';
        $lg['nl'] = 'Dutch';
        $lg['pl'] = 'Polish';
        $lg['pt-BR'] = 'Brazilian';
        $lg['pt'] = 'Portuguese';
        $lg['ro'] = 'Romanian';
        $lg['ru'] = 'Russian';
        $lg['sr'] = 'Serbian (Latin)';
        $lg['sq'] = 'Albanian';
        $lg['sk'] = 'Slovak';
        $lg['sl'] = 'Slovenian';
        $lg['sv'] = 'Swedish';
        $lg['th'] = 'Thai';
        $lg['tr'] = 'Turkish';
        $lg['tw'] = 'Chinese (T)';
        $lg['uk'] = 'Ukrainian';
        $lg['ur'] = 'Urdu (Pakistan)';
        $lg['uz'] = 'Uzbek';
        $lg['vi'] = 'Vietnamese';
        if (isset($lg[$short_name])) {
            return $lg[$short_name];
        } else {
            return "English";
        }
    }
}

/**
 * @param $previousMonth
 * @param $currentMonth
 * @return float|int
 */
if (!function_exists('calculatePercentageIncrease')) {
    function calculatePercentageIncrease($previousMonth, $currentMonth)
    {
        $increase = $currentMonth - $previousMonth;
        if ($previousMonth != 0) {
            $percentageIncrease = ($increase / $previousMonth) * 100;
            if ($percentageIncrease > 100) {
                $percentageIncrease = 100;
            }
        } else {
            $percentageIncrease = 100;
        }
        return (int) $percentageIncrease;
    }
}

/**
 * Get Previous 6 or 12 month name
 */
if (!function_exists('getPreviousMonthName')) {
    function getPreviousMonthName($number)
    {
        $current_month = date('m');
        $previous_six_months = array();
        $current_month_number = date('m');
        $current_year = date('Y');
        $dateTime = new DateTime();
        for ($i = 1; $i < $number; $i++) {
            $dateTime->modify('-1 month');
            $month_name = $dateTime->format('m');
            $year = $dateTime->format('Y');
            $previous_six_months[] = "$month_name-$year";
        }

        $previous_six_months = array_reverse($previous_six_months);

        $previous_six_months[] = "$current_month_number-$current_year";

        return $previous_six_months;
    }
}

/**
 * checkFileType
 * */

if (!function_exists('checkFileType')) {

    function checkFileType($file_path)
    {
        $file_extension = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

        if ($file_extension === "pdf") {
            return "PDF";
        } elseif (in_array($file_extension, array("png", "jpg", "jpeg", "gif", "bmp"))) {
            return "Image";
        } elseif ($file_extension === "zip") {
            return "ZIP";
        } else {
            return "Unknown";
        }

    }
}

/**
 * Get Article Group By ID
 */
if (!function_exists('getArticleGroupById')) {
    function getArticleGroupById($id)
    {
        return ArticleGroup::find($id);
    }
}

/**
 * Section Title Split
 */

if (!function_exists('sectionTitleSplit')) {
    function sectionTitleSplit($title)
    {
        $titleSplit = explode(" ", $title);
        $firstWord = $titleSplit[0];

        //last 2 words
        $lastTwoWords = array_slice($titleSplit, -2);

        // middle words
        $middleWords = array_slice($titleSplit, 1, -2);

        //generate title second 4 word wrap up a span with class design_title
        $titleSecondWord = "<span class='design_title'>" . implode(" ", $middleWords) . "</span>";

        return $firstWord . " " . $titleSecondWord . " " . implode(" ", $lastTwoWords);
    }
}

/**
 * Title Generate
 */
if (!function_exists('titleGenerate')) {
    function titleGenerate($title)
    {
        if (strlen($title) > 50) {
            $title = substr($title, 0, 50);
        }
        elseif (strlen($title) < 50) {
            $title = str_pad($title, 50);
        }
        
        return $title;
    }
}

/**
 * Recent Blogs
 */

if (!function_exists('recentBlogs')) {
    function recentBlogs()
    {
        return Blog::statusActive()->live()->orderBy('updated_at', 'desc')->take(3)->get();
    }
}


/**
 * Add Leading Zero
 */
function addLeadingZero($number) {
    // Check if the number is less than 10 and needs padding
    return str_pad($number, 2, '0', STR_PAD_LEFT);
}

/**
 * Get All Product
 */

if (!function_exists('getAllProduct')) {
    function getAllProduct()
    {
        $products = ProductCategory::with([
            'article_groups' => function ($query) {
                $query->live();
                $query->with([
                    'articles' => function ($article) {
                        $article->live()->statusActive()->external();
                    },
                ]);
            },
        ])->statusActive()->live()->type()->get();

        return $products;
    }
}

/**
 * Is Captcha Enable?
 */

if (!function_exists('isCaptchaEnable')) {
    function isCaptchaEnable()
    {
        return siteSetting()->is_captcha == 1;
    }
}	

/**
 * Badge Show
 */

 if(!function_exists('badgeShow')) {
    function badgeShow($status, $type = 'success') {
        return "<span class='badge badge-$type'>$status</span>";
    }
}