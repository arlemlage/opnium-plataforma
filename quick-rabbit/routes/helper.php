<?php

use App\Model\Tag;
use App\Model\Blog;
use App\Model\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('fetch-cookie',function(Request $request) {
    $cookieValue = $request->cookie('user_ip');
    return $cookieValue;
});
Route::view('/file-div','file_div');

Route::get('clear', function (){
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    dd('Done');
});


Route::get('set-locale/{language}',function ($language){
    $user = Auth::user();
    $user->language = $language;
    $user->save();
    session()->forget('lan');
    app()->setLocale($language);
    $message = __('index.language_changed_successfully');
    return redirect()->back();
})->name('set-locale');

Route::get('ticket-info/{id}',function ($id){
   $ticket = \App\Model\Ticket::findOrFail(encrypt_decrypt($id,'decrypt'));
   return view('frontend.ticket_info',compact('ticket'));
})->name('ticket-info');

Route::get('/ticket-link',function () {
    $ticket_id = request()->get('ticket_id');
    $comment_id = request()->get('comment_id');
    if(Auth::check()) {
        session()->forget('redirect_link');
        if(isset($comment_id)) {
            return \Illuminate\Support\Facades\Redirect::to('/ticket/'.$ticket_id.'?comment_id='.$comment_id);
        } else {
            return \Illuminate\Support\Facades\Redirect::to('/ticket/'.$ticket_id);
        }
    } else {
        session()->put('redirect_link',route('ticket-link',['ticket_id' => $ticket_id,'comment_id'=>$comment_id]));
        return redirect('/');
    }
})->name('ticket-link');

Route::get('allow-browser-notification','NotificationController@allowBrowserNotification');

/**
 * Logout Route Admin, Agent, Customer
 */
Route::get('logout',function (){
    if(Auth::check()) {
        $user = Auth::user();
        $user->online_status = 0;
        $user->last_logout_time = now();
        $user->save();
        Auth::logout();
        session()->flush();
        session()->regenerate();
        return redirect()->route('home');
    } else {
        return redirect()->route('home');
    }
})->name('logout');

Route::group(['middleware' => 'auth'],function () {
    Route::post('store-token','HomeController@storeToken')->name('store.token');
    Route::post('send-web-notification', 'WebNotificationController@sendWebNotification')
        ->name('send.web-notification');
    Route::get('web-notification', 'HomeController@webNotification')
        ->name('web-notification');
});

Route::get('menu-activity',function () {
    return \App\Model\Menu::setMenus();
})->name('menu-activity');

Route::get('mail-info/{template_id}/{ticket_id}',function ($template_id,$ticket_id){
    return \App\Model\MailTemplate::getMailBody("admin_agent",$template_id,$ticket_id);
});

Route::get('ticket-mail-info/{ticket_id}/{template_id}',function ($ticket_id,$template_id){
    return \App\Model\Ticket::emailInfo($ticket_id,$template_id);
});

Route::post('bas64-to-image',function() {
    return bas64ToFile(request()->get('image'));
});

Route::post('store-on-media',function() {
    return storeOnMedia(request()->get('title'),request()->get('group'),request()->get('image'));
});

Route::delete('delete-image',function() {
    $image_url = request()->get('image_url');
    if(file_exists($image_url)) {
        unlink($image_url);
    }
});

Route::get('set-collapse', function() {
    session()->put('is_collapse',request()->get('status'));
});

Route::get('web-push',function () {
   return event(new \App\Events\AdminNotification("A ticket Ticket No TEA #1 has been closed by admin Mr  Admin on 01/04/2023 at 12:56 pm"));
});

Route::get('check-web-push',function () {
    \App\Model\User::getFcm(1,"Ticket Closed By Admin","A new ticket Ticket No TEA #1 has been opened by admin Mr Admin on 01/04/2023 at 12:56 pm");
 });

Route::get('browser-push',function () {
    return event(new \App\Events\BrowserPush('1',"hi","Message for you"));
 });

Route::get('insert-index',function() {
    foreach( Article::all() as $article) {
        Article::find($article->id)->update(array('tag_ids' => null));
    }
});

Route::get('send-mail','MailSendController@index');

Route::get('replace-string',function() {
    foreach(App\Model\User::whereNotNull('image')->get() as $obj) {
        $replacedData = str_replace('images/', '', $obj->image);
        $obj->image = $replacedData;
        $obj->save();
    }
    return "done";
});

Route::get('move-files',function() {
    // Move media images
    foreach(DB::table('tbl_medias')->get() as $file) {
        $sourcePath = 'files/media_assets/'.$file->media_path;
        $destinationPath = rootFilePath().'media/media_images/'.$file->media_path;
        if(file_exists($sourcePath)) {
            rename($sourcePath, $destinationPath);
        }
    }
    // Move media thumbs
    foreach(DB::table('tbl_medias')->get() as $file) {
        $sourcePath = 'files/media_assets/'.$file->thumb_img;
        $destinationPath = rootFilePath().'media/thumbnails/'.$file->thumb_img;
        if(file_exists($sourcePath)) {
            rename($sourcePath, $destinationPath);
        }
    }

    // Move user photos
    foreach(DB::table('tbl_users')->get() as $file) {
       if($file->image != Null) {
            $sourcePath = 'images/'.$file->image;
            $destinationPath = rootFilePath().'user_photos/'.$file->image;
            if(file_exists($sourcePath)) {
                rename($sourcePath, $destinationPath);
            }
       }
    }

    // Move blogs
    foreach(DB::table('tbl_blogs')->get() as $file) {
        if($file->image != Null) {
             $sourcePath = 'images/'.$file->image;
             $destinationPath = rootFilePath().'blogs/'.$file->image;
             if(file_exists($sourcePath)) {
                 rename($sourcePath, $destinationPath);
             }
        }
     }

     // Move ticket files 
    foreach(DB::table('tbl_ticket_files')->get() as $file) {
        if($file->file_path != Null) {
             $sourcePath = 'files/'.$file->file_path;
             $destinationPath = rootFilePath().'tickets/ticket_attachments/'.$file->file_path;
             if(file_exists($sourcePath)) {
                 rename($sourcePath, $destinationPath);
             }
        }
     }
     // Move ticket comment files
    foreach(DB::table('tbl_ticket_comment_files')->get() as $file) {
        if($file->file_path != Null) {
             $sourcePath = 'files/'.$file->file_path;
             $destinationPath = rootFilePath().'tickets/comment_attachments/'.$file->file_path;
             if(file_exists($sourcePath)) {
                 rename($sourcePath, $destinationPath);
             }
        }
     }
    return 'done';
});

Route::post('subscribe_store',function() {
    $email = request()->post('email');
    $check = DB::table('tbl_subscribers')->where('email',$email)->first();
    if($check == Null) {
        DB::table('tbl_subscribers')->insert(['email' => $email]);
    }else{
        return [
            'status' => 'error',
            'message' => 'You have already subscribed to our newsletter'
        ];
    }
    return [
        'status' => 'success',
        'message' => 'You have successfully subscribed to our newsletter'
    ];
});
