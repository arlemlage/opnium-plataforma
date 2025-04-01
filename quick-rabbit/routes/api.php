<?php

use App\Model\ArticleGroup;
use App\Model\ChatGroup;
use App\Model\ConfigurationSetting;
use App\Model\Department;
use App\Model\Forum;
use App\Model\ForumComment;
use App\Model\ForumLike;
use App\Model\IntegrationSetting;
use App\Model\ProductCategory;
use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::post('user-login', 'ApiController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('user-information', 'ApiController@userInformation');
    Route::get('get-notifications', 'ApiController@getAllNotification');
    Route::put('read-all-notification', 'ApiController@makrAsReadAll');
    Route::delete('delete-all-notification', 'ApiController@deleteAll');
    Route::put('mark-as-read/{id}', 'ApiController@markAsRead');
    Route::delete('delete-notification/{id}', 'ApiController@deleteNotification');
});

Route::get('pusher-info', function () {
    return pusherInfo();
});

Route::get('firebase-info', function () {
    return firebaseInfo();
});

Route::get('user-ip', function () {
    return userIp();
});

Route::get('check-email-exists', function () {
    $email = request()->get('email');
    if (User::where('email', $email)->exists()) {
        return true;
    } else {
        return false;
    }
});

Route::get('check-mobile-exists', function () {
    $mobile = request()->get('mobile');
    if (User::where('mobile', $mobile)->exists()) {
        return true;
    } else {
        return false;
    }
});

Route::get('task-lists', function () {
    return \App\Model\Task::live()->get();
});

Route::get('date-wise-tasks/{assign_date}', function ($assign_date) {
    $data = \App\Model\Task::query();
    $date = date('Y-m-d', strtotime($assign_date));
    $data->where('work_date', $date);
    $results = $data->get();
    $agents = \App\Model\User::live()->where('role_id', 2)->get();
    $tickets = \App\Model\Ticket::where('status', '!=', 2)->select('id', 'title')->get();
    return view('task.day_wise_task_list', compact('results', 'assign_date', 'agents', 'tickets'));
});

Route::get('/product-wise-groups/{product_category_id}', function ($product_category_id) {
    return ArticleGroup::where('product_category', $product_category_id)->get();
});

Route::get('/group-wise-articles/{article_gorup_id}', function ($article_gorup_id) {
    return App\Model\Article::where('article_group_id', $article_gorup_id)->get();
});

Route::get('/search-product', function () {
    $query = request()->get('query');
    $products = ProductCategory::where('title', "LIKE", "%$query%")->live()->statusActive()->select('id', 'title', 'slug')->get();
    return view('frontend.product_search_result', compact('products'));
});

Route::get('task-status-change-form/{task_id}', function ($task_id) {
    $task = \App\Model\Task::findOrFail($task_id);
    $route = route('update-task-status', $task_id);
    return view('task.task_status_change_form', compact('task', 'route'));
})->middleware('localization');

Route::get('get-product-wise-article-group/{product_id}/{lan}', function ($product_id, $lan) {
    $groups = \App\Model\ArticleGroup::with([
        'articles' => function ($query) {
            $query->external()->live();
        },
    ])->where('product_category', $product_id)->live()->take(8)->sort()->get();
    return view('frontend.article_groups', compact('groups', 'product_id', 'lan'));
});

Route::get('search-result', function () {
    $query = request()->get('query');
    $lan = request()->get('lan');
    $product_id = request()->get('product_id');

    if (isset($query)) {
        $query_length = Str::length($query);
        //start article data
        $article = \App\Model\Article::live()->statusActive()->external();
        //for full text search
        $article->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
        if (isset($product_id)) {
            $article->where('product_category_id', $product_id);
        }
        $article->take(10);
        $article->live();
        $article->select('id', 'title', 'title_slug', 'product_category_id', 'article_group_id');
        $articles = $article->get();
        if($article->count() <= 0){
            $articleGroup = ArticleGroup::where('title', "LIKE", "%$query%")->live();
            if(isset($product_id)){
                $articleGroup->where('product_category', $product_id);
            }
            $articleGroup = $articleGroup->pluck('id');
            $article = \App\Model\Article::live()->statusActive()->external();
            $article->whereIn('article_group_id', $articleGroup);
            $article->take(10);
            $article->live();
            $article->select('id', 'title', 'title_slug', 'product_category_id', 'article_group_id');
            $articles = $article->get();
        }
        //end article data

        // start FAQ data
        $faq = \App\Model\Faq::live()->statusActive();
        //for full text search
        $faq->whereRaw("MATCH(question) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
        if (isset($product_id)) {
            $faq->where('product_category_id', $product_id);
        }
        $faq->live();
        $faq->take(10);
        $faq->select('id', 'question', 'answer');
        $faqs = $faq->get();
        //end FAQ data

        //start blog data
        $blog = \App\Model\Blog::query();
        //for full text search
        $blog->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
        $blog->live();
        $blog->take(10);
        $blogs = $blog->select('id', 'title', 'slug')->get();
        //end blogs data
        //start article data
        $page = \App\Model\Pages::query();
        //for full text search
        $page->whereRaw("MATCH(title) AGAINST(? IN NATURAL LANGUAGE MODE)", [$query]);
        $page->live()->statusActive();
        $page->take(10);
        $pages = $page->select('id', 'title', 'slug')->get();
        //end page data

        $aiData = getAIDatabaseSearch($query);

        return view('frontend.search_result', compact('articles', 'blogs', 'pages', 'faqs', 'lan', 'query_length', 'aiData', 'product_id'));

    }

});

Route::get('/common-lang', function () {
    return response()->json([
        'are_you_sure' => __('index.are_you_sure'),
        'cannot_revert' => __('index.cannot_revert'),
        'ok' => __('index.ok'),
        'cancel' => __('index.cancel'),
    ]);
});

Route::get('/filter-media', function () {
    $title = request()->get('title');
    $group = request()->get('group');
    $media = \App\Model\Media::live();
    if ($group != "All") {
        $media->where('group', $group);
    }
    if ($title) {
        $media->where('title', "LIKE", "%$title%");
    }
    $data = $media->take(24)->get();
    return view('helper.media_loop', compact('data'));
});

Route::get('fetch-custom-field/{product_category_id}', function ($product_category_id) {
    $department = request()->get('department');
    if($department != null){
        $product_field = \App\Model\CustomField::where('product_category_id', $product_category_id)->where('department_id', $department)->live()->where('status', 'Active')->firstOrFail();
    }else{        
        $product_field = \App\Model\CustomField::where('product_category_id', $product_category_id)->live()->where('status', 'Active')->firstOrFail();
    }
    $custom_field_data = [];
    $custom_field_type = !empty($product_field->custom_field_type) ? json_decode($product_field->custom_field_type) : [];
    $custom_field_label = !empty($product_field->custom_field_label) ? json_decode($product_field->custom_field_label) : [];
    $custom_field_option = !empty($product_field->custom_field_option) ? json_decode($product_field->custom_field_option) : [];
    $custom_field_required = !empty($product_field->custom_field_required) ? json_decode($product_field->custom_field_required) : [];

    $data = [
        'custom_field_data' => $custom_field_data,
        'custom_field_type' => $custom_field_type,
        'custom_field_label' => $custom_field_label,
        'custom_field_option' => $custom_field_option,
        'custom_field_required' => $custom_field_required,
    ];
    return view('helper.custom_field', $data);
});

Route::get('get-product-chat-sequence/{product_id}', function ($product_id) {
    $chat_product = \App\Model\ChatProduct::where('product_id', $product_id)->first();
    if (!isset($chat_product)) {
        \App\Model\ChatProduct::insert(['product_id' => $product_id]);
        $chat_product = \App\Model\ChatProduct::where('product_id', $product_id)->first();
    }
    $agent_ids = \App\Model\ProductCategory::assignedAgents($product_id);
    foreach ($agent_ids as $key => $agent) {
        $identify = ['chat_product_id' => $chat_product->id, 'agent_id' => $agent];
        $data = [
            'chat_product_id' => $chat_product->id,
            'agent_id' => $agent,
            'sort_id' => $key + 1,
        ];
        \App\Model\ChatProductSequence::updateOrInsert($identify, $data);
    }
    $chat_sequence_data = \App\Model\ChatProductSequence::orderBy('sort_id', 'asc')->where('chat_product_id', $chat_product->id)->get();
    return view('setting.chat_sequence_form', compact('chat_sequence_data', 'chat_product'));
});

Route::get('get-product-wise-agents/{product_id}', function ($product_id) {
    $type = request()->get('type');
    if ($type == 'product') {
        $agent_ids = \App\Model\ProductCategory::assignedAgents($product_id);
        $agents = \App\Model\User::whereIn('id', $agent_ids)->agent()->get();
        $product = \App\Model\ProductCategory::find($product_id);
    }

    if ($type == 'department') {
        $pId = ProductCategory::live()->where('type', 'single')->first()->id;
        $agent_ids = \App\Model\User::where('department_id', $product_id)->where('product_cat_ids', $pId)->pluck('id')->toArray();
        $agents = \App\Model\User::whereIn('id', $agent_ids)->agent()->get();
        $product = \App\Model\Department::find($product_id);
    }

    return view('setting.chat_agent_form', compact('agents', 'product'));
});

Route::get('envato-validation', function () {
    $integration_info = IntegrationSetting::first();
    if (isset($integration_info)) {
        $api_key = $integration_info->envato_api_key;
        $username = request()->get('username');
        $purchase_code = request()->get('purchase_code');
        $product_code = \App\Model\ProductCategory::find(request()->get('product_category_id'))->envato_product_code;
        if (!empty($username) && !empty($purchase_code)) {
            if (($integration_info->envato_set_up == 'on') && ($integration_info->envato_api_key != null)) {
                $url = 'https://api.envato.com/v3/market/author/sale?code=' . $purchase_code;
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; Envato API Wrapper PHP)');
                $header = array();
                $header[] = 'Content-length: 0';
                $header[] = 'Content-type: application/json';
                $header[] = 'Authorization: Bearer ' . $api_key;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                $data = curl_exec($ch);
                curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                $response = json_decode($data, true);

                if (!$response || (isset($response['error']) && $response['error'] == "Blocked")) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Purchase information is not valid!',
                    ]);
                } else {
                    if (isset($response['error']) && $response['error'] == 404) {
                        return response()->json([
                            'status' => false,
                            'message' => $response['description'],
                        ]);
                    }

                    if (isset($response['buyer']) && $response['buyer'] != $username) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Purchase information is not valid!',
                        ]);
                    }

                    if ($response['item']['id'] != $product_code) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Purchase information is not valid!',
                        ]);
                    }

                    if (date('Y-m-d') > date('Y-m-d', strtotime($response['supported_until']))) {

                        if ($integration_info->ticket_submit_on_support_period_expired == "No") {
                            return response()->json([
                                'status' => false,
                                'message' => 'Support period is expired! Renew your support period',
                            ]);
                        }
                    }
                    return response()->json([
                        'status' => true,
                        'message' => 'Success',
                        'data' => $response,
                    ]);
                }

            }
        }
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Something wrong with verification. Please contact with admin',
        ]);
    }
});

Route::get('get-product-code', function () {
    $str = request()->get('title');
    $str_arr = explode(" ", $str);
    preg_match_all('/(?<=\b)\w/iu', $str, $matches);
    $str_separate = mb_strtoupper(implode('', $matches[0]));
    $str_len = strlen(mb_strtoupper(implode('', $matches[0])));

    $final_output_1 = '';
    $final_output_2 = '';
    $final_output_3 = '';

    if ($str_len == 1) {
        $final_output_1 = substr($str, 0, 3);
        $final_output_2 = substr($str, 0, 2) . substr($str, 3, 1);
        $final_output_3 = substr($str, 0, 2) . substr($str, 4, 1);
        if (ProductCategory::where('product_code', $final_output_1)->doesntExist()) {
            return strtoupper($final_output_1);
        }
        if (ProductCategory::where('product_code', $final_output_1)->exists()) {
            return strtoupper($final_output_2);
        }
        if (ProductCategory::where('product_code', $final_output_2)->exists()) {
            return strtoupper($final_output_3);
        }
    } else if ($str_len == 2) {
        $str_arr = explode(" ", $str);
        $final_output_1 = substr($str_arr[0], 0, 2) . substr($str_arr[1], 0, 1);
        $final_output_2 = substr($str_arr[0], 0, 2) . substr($str_arr[1], 1, 1);
        $final_output_3 = substr($str_arr[0], 0, 2) . substr($str_arr[1], 2, 1);
        if (ProductCategory::where('product_code', $final_output_1)->doesntExist()) {
            return strtoupper($final_output_1);
        }
        if (ProductCategory::where('product_code', $final_output_1)->exists()) {
            return strtoupper($final_output_2);
        }
        if (ProductCategory::where('product_code', $final_output_2)->exists()) {
            return strtoupper($final_output_3);
        }
    } else {
        $final_output_1 = substr(mb_strtoupper(implode('', $matches[0])), 0, 3);
        $final_output_2 = substr(mb_strtoupper(implode('', $matches[0])), 0, 2) . substr($str_arr[2], 1, 1);
        $final_output_3 = substr(mb_strtoupper(implode('', $matches[0])), 0, 2) . substr($str_arr[2], 2, 1);
        if (ProductCategory::where('product_code', $final_output_1)->doesntExist()) {
            return strtoupper($final_output_1);
        }
        if (ProductCategory::where('product_code', $final_output_1)->exists()) {
            return strtoupper($final_output_2);
        }
        if (ProductCategory::where('product_code', $final_output_2)->exists()) {
            return strtoupper($final_output_3);
        }

    }
});

Route::get('check-browser-id/{unique_id}', function ($unique_id) {
    if (User::where('browser_id', $unique_id)->exists()) {
        return true;
    } else {
        return false;
    }
    if (ChatGroup::where('created_by', $unique_id)->exists()) {
        return true;
    } else {
        return false;
    }
});

Route::post('make-valid-url', function (Request $request) {
    $message = $request->message;
    $domain_lis = getDomainExtensions();
    if (Str::endsWith($message, $domain_lis) && !Str::startsWith($message, 'http')) {
        $url_message = "https://" . $message;
    } else {
        $url_message = $message;
    }
    return $url_message;
});

Route::post('forum-like-unlike-post', function (Request $request) {
    $id = $request->id;
    $current_total = $request->current_total;
    $status = $request->status;
    $brower_id = $request->brower_id;
    $type = isset($request->type) ?? null;
    if ($type != 'reply' || $type == null) {
        $check_old_like_unlick_status = checkLikeUnlikeStatus(encrypt_decrypt($id, 'decrypt'), $brower_id);

        $ruturn_status = array();
        $ruturn_status['status'] = false;

        if ((isset($check_old_like_unlick_status) && $check_old_like_unlick_status->status == 1 && $status == 1)) {
            $ruturn_status['status'] = false;
            $ruturn_status['msg'] = "Already like added!";
        } else if (!$check_old_like_unlick_status && $status == 2) {
            $ruturn_status['status'] = false;
            $ruturn_status['msg'] = "You did not provide like yet!";
        } else {

            if ($status == 1) {
                $ruturn_status['updated_counter'] = $current_total + 1;
                $row = new ForumLike();
                $row->status = $status;
                $row->user_id = $brower_id;
                $row->forum_id = encrypt_decrypt($id, 'decrypt');
                $row->save();
                //increment the like counter
                Forum::findOrFail(encrypt_decrypt($id, 'decrypt'))->update(array('total_like_counter' => ($current_total + 1)));
            } else {

                $ruturn_status['updated_counter'] = $current_total - 1;
                //decrement the like counter
                Forum::findOrFail(encrypt_decrypt($id, 'decrypt'))->update(array('total_like_counter' => ($current_total - 1)));
                //update delete status
                $id = encrypt_decrypt($id, 'decrypt');
                $obj = ForumLike::where("forum_id", $id)->where("del_status", "Live")->first();
                $obj->del_status = "Deleted";
                $obj->save();

            }
            $ruturn_status['status'] = true;
        }
    } else {
        $check_old_like_unlick_status = checkLikeUnlikeStatusForComment(encrypt_decrypt($id, 'decrypt'), $brower_id);

        $ruturn_status = array();
        $ruturn_status['status'] = false;

        if ((isset($check_old_like_unlick_status) && $check_old_like_unlick_status->status == 1 && $status == 1)) {
            $ruturn_status['status'] = false;
            $ruturn_status['msg'] = "Already like added!";
        } else if (!$check_old_like_unlick_status && $status == 2) {
            $ruturn_status['status'] = false;
            $ruturn_status['msg'] = "You did not provide like yet!";
        } else {

            if ($status == 1) {
                $ruturn_status['updated_counter'] = $current_total + 1;
                $row = new ForumLike();
                $row->status = $status;
                $row->user_id = $brower_id;
                $row->forum_comment_id = encrypt_decrypt($id, 'decrypt');
                $row->save();
                //increment the like counter
                ForumComment::findOrFail(encrypt_decrypt($id, 'decrypt'))->update(array('total_like_counter' => ($current_total + 1)));
            } else {

                $ruturn_status['updated_counter'] = $current_total - 1;
                //decrement the like counter
                ForumComment::findOrFail(encrypt_decrypt($id, 'decrypt'))->update(array('total_like_counter' => ($current_total - 1)));
                //update delete status
                $id = encrypt_decrypt($id, 'decrypt');
                $obj = ForumLike::where("forum_comment_id", $id)->where("del_status", "Live")->first();
                $obj->del_status = "Deleted";
                $obj->save();
            }
            $ruturn_status['status'] = true;
        }
    }

    echo json_encode($ruturn_status);
});

Route::put('update-config', function () {
    $setting_type = request()->get('setting_type');
    if ($setting_type == "facebook_login") {
        ConfigurationSetting::first()->update(array('inerest_facebook_login' => false));
    } elseif ($setting_type == "google_login") {
        ConfigurationSetting::first()->update(array('inerest_google_login' => false));
    } elseif ($setting_type == "github_login") {
        ConfigurationSetting::first()->update(array('inerest_github_login' => false));
    } elseif ($setting_type == "linkedin_login") {
        ConfigurationSetting::first()->update(array('inerest_linkedin_login' => false));
    } elseif ($setting_type == "envato_login") {
        ConfigurationSetting::first()->update(array('inerest_envato_login' => false));
    } elseif ($setting_type == "chat_setting") {
        ConfigurationSetting::first()->update(array('inerest_chat_setting' => false));
    } elseif ($setting_type == "notification_setting") {
        ConfigurationSetting::first()->update(array('inerest_notification_setting' => false));
    } elseif ($setting_type == "mail_setting") {
        ConfigurationSetting::first()->update(array('inerest_mail_setting' => false));
    } elseif ($setting_type == "payment_gateway_setting") {
        ConfigurationSetting::first()->update(array('inerest_payment_gateway_setting' => false));
    }
});
