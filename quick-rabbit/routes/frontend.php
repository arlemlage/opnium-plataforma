<?php

use App\Model\Article;
use Illuminate\Support\Facades\Route;

Route::middleware(['XSS', 'localization'])->group(function () {
    Route::any('/', 'FrontendController@index')->name('home');
    Route::get('register', 'FrontendController@registrationForm')
        ->name('register');
    Route::group(['namespace' => 'Auth', 'middleware' => ['localization']], function () {
        Route::any('/admin/login', 'LoginController@showLoginForm')->name('admin.login');
        Route::any('login', 'LoginController@loginRedirect')->name('login');
        Route::post('user-login', 'LoginController@login')->name('user-login');
        Route::any('reset-password-step-one', 'RecoverPasswordController@stepOne')
            ->name('reset-password-step-one');
        Route::any('check-email', 'RecoverPasswordController@checkEmail')
            ->name('check-email');
        Route::any('reset-password-step-two', 'RecoverPasswordController@stepTwo')
            ->name('reset-password-step-two');
        Route::any('check-question-answer', 'RecoverPasswordController@checkQuestionAnswer')
            ->name('check-question-answer');
        Route::any('reset-password-step-three', 'RecoverPasswordController@stepThree')
            ->name('reset-password-step-three');
        Route::any('reset-password', 'RecoverPasswordController@resetPassword')
            ->name('reset-password');
        Route::any('reset-password-success', 'RecoverPasswordController@resetPasswordSuccess')
            ->name('reset-password-success');

        //agent login
        Route::any('agent/login', 'LoginController@showLoginForm')->name('agent.login');

        //customer login
        Route::any('customer/login', 'LoginController@showLoginForm')->name('customer.login');

        Route::get('auth/facebook', 'SocialLoginController@redirectToFacebook')
            ->name('facebook.login');
        Route::get('auth/facebook/callback', 'SocialLoginController@facebookCallback')
            ->name('facebook.callback');

        Route::get('auth/google', 'SocialLoginController@redirectToGoogle');
        Route::get('auth/google/callback', 'SocialLoginController@googleCallback');

        Route::get('auth/github', 'SocialLoginController@redirectToGithub');
        Route::get('auth/github/callback', 'SocialLoginController@githubCallback');

        Route::get('auth/linkedin', 'SocialLoginController@redirectToLinkedin');
        Route::get('auth/linkedin/callback', 'SocialLoginController@linkedinCallback');
        Route::post('auth/linkedin/callback', 'SocialLoginController@linkedinCallback');

        Route::get('auth/envato', 'SocialLoginController@redirectToEnvato');
        Route::get('auth/envato/callback', 'SocialLoginController@envatoCallback');

    });

    Route::get('open-ticket', 'FrontendController@openTicket')
        ->name('open-ticket');
    Route::get('faq', 'FrontendController@faq')->name('faq');
    Route::get('article/{product_slug}', 'FrontendController@productWiseArticleGroups')
        ->name('product-wise-article-groups');
    Route::get('view-all/{group_slug}', 'FrontendController@viewAll')->name('viewAll');
    Route::get('all-articles', 'FrontendController@allArticles')->name('all-articles');
    Route::get('article/{product_slug?}/{slug}', 'FrontendController@articleDetails')->name('article-details');
    Route::get('blogs', 'FrontendController@blogs')->name('blogs');
    Route::get('blog-details/{slug}', 'FrontendController@blogDetails')->name('blog-details');
    Route::post('store-blog-comment', 'FrontendController@storeBlogComment')->name('store-blog-comment');
    Route::post('store-article-comment', 'FrontendController@storeArticleComment')->name('store-article-comment');
    Route::get('forum', 'FrontendController@forum')->name('forum');
    Route::get('login-from-forum', 'FrontendController@loginFromForum')->name('login-from-forum');
    Route::get('ask-question', 'FrontendController@askQuestion')->name('ask-question');
    Route::post('post-forum', 'FrontendController@postForum')->name('post-forum');
    Route::get('forum-comment/{slug}', 'FrontendController@forumComment')->name('forum-comment');
    Route::post('post-comment', 'FrontendController@postComment')->name('post-comment');
    Route::get('customization', 'FrontendController@customization')->name('customization');
    Route::get('contact', 'FrontendController@contact')->name('contact');
    Route::get('support-policy', 'FrontendController@supportPolicy')->name('support-policy');
    Route::get('about-us', 'FrontendController@aboutUs')->name('about-us');
    Route::get('our-services', 'FrontendController@ourServices')->name('our-services');
    Route::get('register', 'FrontendController@registrationForm')->name('register');
    Route::post('user-register', 'FrontendController@userRegister')->name('user-register');
    Route::get('resend-link/{email}', 'FrontendController@resendLink')->name('resend-link');
    Route::get('account/verify/{token}', 'FrontendController@verifyAccount')->name('user.verify');
    Route::post('store-message', 'FrontendController@storeMessage')->name('store-message');
    Route::get('page-details/{slug}', 'FrontendController@pageDetails')->name('page-details');
    // Temp chat
    Route::get('temp-chat', 'FrontendController@tempChat')->name('temp-chat');
    Route::post('send-message', 'FrontendController@sendMessage');
    Route::get('update-seen-status-from-guest', 'FrontendController@updateSeenStatus');
    Route::get('guest-close-chat/{group_id}', 'FrontendController@closeChat')->name('guest-close-chat');
    Route::get('vote-yes/{article_id}', function ($article_id) {
        $article = Article::find($article_id);
        $running = $article->vote_yes;
        $article->vote_yes = $running + 1;
        $article->save();
        session()->put('submit_article_vote_id', $article_id);
        session()->put('user_id', auth()->id());
        session()->put('vote', 'yes');
        return $article->vote_yes ?? 0;
    });

    Route::get('vote-no/{article_id}', function ($article_id) {
        $article = Article::find($article_id);
        $running = $article->vote_no;
        $article->vote_no = $running + 1;
        $article->save();
        session()->put('submit_article_vote_id', $article_id);
        session()->put('user_id', auth()->id());
        session()->put('vote', 'no');
        return $article->vote_no ?? 0;
    });

    Route::get('change-language', function () {
        $lan = request()->get('lan');
        session()->put('lan', $lan);
        return redirect()->back();
    })->name('change-language');

    Route::post('/pdf-download', 'FrontendController@pdfDownload')->name('pdf-download');
});
