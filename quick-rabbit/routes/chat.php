<?php
use Illuminate\Support\Facades\Route;
$segment = Request::segment(1);

Route::get('chat/get-pusher-info',function () {
   return response()->json([
       'data' => pusherInfo()
   ]);
});

Route::group(['namespace' => 'Chat','middleware' => ['auth','set_locale']],function (){
    Route::get('live-chat','ChatController@chatPage')
        ->name('live-chat');
});

Route::group(['prefix'=>'chat','namespace' => 'Chat','middleware' => ['auth','set_locale']],function() {
    Route::get('get-auth-user-id','ChatController@authUserId')
        ->name('get-auth-user-id');
    Route::get('check-user-has-friend','ChatController@checkUserHasFriend')
        ->name('check-user-has-friend');
    Route::get('single-chat-box','ChatController@sineChatBox')
        ->name('single-chat-box');
    Route::post('send-single-chat-message','ChatController@sendSingleMessage')
        ->name('single-chat-message');
    Route::get('update-single-message-status','ChatController@singleSeenStatusUpdate')
        ->name('update-single-message-status');
    Route::get('get-user-single-chat-id','ChatController@getLastSingleChatId')
        ->name('get-user-single-chat-id');
    Route::get('check-envato-product/{product_id}','HelperController@checkEnvatoProduct')
        ->name('check-envato-product');
    Route::post('create-group','HelperController@createGroup')
        ->name('create-group');
    Route::get('check-user-has-group','ChatController@checkUserHasGroup')
        ->name('check-user-has-group');
    Route::get('group-chat-box','ChatController@groupChatBox')
        ->name('group-chat-box');
    Route::get('update-group-message-status','ChatController@groupSeenStatusUpdate')
        ->name('update-group-message-status');
    Route::post('send-group-chat-message','ChatController@sendGroupMessage')
        ->name('send-group-chat-message');
    Route::get('check-user-group','ChatController@checkUserGroup')
        ->name('check-user-group');
    Route::get('get-user-group-chat-id','ChatController@getLastGroupChatId')
        ->name('get-user-group-chat-id');
    Route::get('close-chat/{group_id}','ChatController@closeChat')
        ->name('close-chat');
    Route::get('forward-chat','ChatController@forwardChat')
        ->name('forward-chat');
    Route::get('search-agent','ChatController@searchAgent');  
    Route::get('search-group','ChatController@searchGroup');  
});

