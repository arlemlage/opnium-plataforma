<?php

use App\Http\Controllers\MailSendController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;


include 'helper.php';
include 'frontend.php';
include 'chat.php';


Route::middleware('XSS')->group(function () {
    // Common routes for auth only
    Route::middleware(['auth', 'set_locale'])->group(function () {
        Route::get('get-all-unread-notification', 'NotificationController@index');
        Route::get('/all-notification', 'NotificationController@allNotification')
            ->name('all-notification');
        Route::get('/mark-as-read/{id}', 'NotificationController@markAsRead')
            ->name('mark-as-read');
        Route::delete('/delete-notification/{id}', 'NotificationController@destroy')
            ->name('delete-notification');
        Route::any('mark-as-read-all', 'NotificationController@makrAsReadAll');
        Route::delete('delete-all-notification', 'NotificationController@deleteAll');
        Route::get('get-authenticated-user-info', 'NotificationController@getAuthenticatedUser');
        Route::get('get-notification-info/{id}', 'NotificationController@getNotificationInfo');

        Route::get('web-notification', 'NotificationController@webNotification')
            ->name('web-notification');
        Route::post('/store-token', 'NotificationController@storeToken')->name('store.token');

        // Chart
        Route::get('chart-data', 'DashboardController@chartData')
            ->name('chart-data');
        Route::get('ticket-by-category', 'DashboardController@ticketByCategory')->name('ticket-by-category');

    });

    Route::put('update-password', 'ProfileController@changePassword')
        ->name('update-password');

    Route::middleware(['auth', 'verify_email', 'set_locale', 'has_permission'])->group(function () {

        Route::resource('testimonial', 'TestimonialController');

        // Admin/Agent/Customer common activity route
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');        
        Route::get('change-password', 'ProfileController@changePasswordForm')
            ->name('change-password');

        Route::get('edit-profile', 'ProfileController@profileEditForm')
            ->name('edit-profile');
        Route::put('update-profile', 'ProfileController@updateProfile')
            ->name('update-profile');
        Route::get('set-security-question', 'ProfileController@securityQuestionForm')
            ->name('set-security-question');
        Route::put('save-security-question', 'ProfileController@saveSecurityQuestion')
            ->name('save-security-question');        
        Route::get('ticket-convert-to-article/{ticket_id}', 'TicketController@ticketConvertToArticle');
        Route::post('convert-ticket-to-article', 'ArticleController@store');
        Route::view('user-home', 'user_home')->name('user-home');

        // Only admin/agent
        Route::middleware('admin_agent')->group(function () {            

            // Settings Route
            Route::get('social-login-setting', 'SettingController@socialLoginSettingForm')
                ->name('social-login-setting');
            Route::put('update-social-login-setting', 'SettingController@updateSocialLogin')
                ->name('update-social-login-setting');

            Route::resource('custom-fields', 'CustomFieldController');
            Route::get('ticket-setting', 'SettingController@ticketSetting')
                ->name('ticket-setting');
            Route::put('update-ticket-setting', 'SettingController@updateTicketSetting')
                ->name('update-ticket-setting');

            Route::get('chat-setting', 'SettingController@chatSetting')
                ->name('chat-setting');
            Route::put('update-chat-setting', 'SettingController@updateChatSetting')
                ->name('update-chat-setting');

            Route::get('chat-sequence-setting', 'SettingController@chatSequenceSetting')
                ->name('chat-sequence-setting');
            Route::post('sort-agent-chat-sequence', 'SettingController@sortAgent')
                ->name('sort-agent-chat-sequence');
            Route::post('update-chat-sequence-setting/{id}', 'SettingController@updateChatSequenceSetting')
                ->name('update-chat-sequence-setting');
            Route::get('update-chat-agent', 'SettingController@updateChatAgent')
                ->name('update-chat-agent');

            Route::resource('departments', 'DepartmentController');

            Route::get('integration-setting', 'SettingController@integrationSetting')
                ->name('integration-setting');
            Route::put('update-integration-setting', 'SettingController@updateIntegrationSetting')
                ->name('update-integration-setting');

            Route::get('mail-setting', 'SettingController@mailSetting')
                ->name('mail-setting');
            Route::put('update-mail-setting', 'SettingController@updatemailSetting')
                ->name('update-mail-setting');

            Route::get('notification-setting', 'SettingController@notificationSetting')
                ->name('notification-setting');
            Route::put('update-notification-setting', 'SettingController@updateNotificationSetting')
                ->name('update-notification-setting');

            Route::get('payment-gateway-setting', 'SettingController@paymentGatewaySetting')
                ->name('payment-gateway-setting');
            Route::put('update-payment-gateway-setting', 'SettingController@updatePaymentGatewaySetting')
                ->name('update-payment-gateway-setting');

            Route::get('gdpr-setting', 'SettingController@gdprSetting')
                ->name('gdpr-setting');
            Route::put('update-gdpr-setting', 'SettingController@updateGDPRSetting')
                ->name('update-gdpr-setting');

            Route::get('about-us-setting', 'SettingController@aboutUsSetting')
                ->name('about-us-setting');
            Route::put('update-about-us-setting', 'SettingController@updatAboutSetting')
                ->name('update-about-us-setting');

            Route::get('our-services-setting', 'SettingController@ourServicesSetting')
                ->name('our-services-setting');
            Route::put('update-our-services-setting', 'SettingController@updatServiceSetting')
                ->name('update-our-services-setting');

            Route::get('product-category-sorting', 'ProductCategoryController@shortPage')
                ->name('product-category-sorting');
            Route::post('sort-product-category', 'ProductCategoryController@sortProductCategory')
                ->name('sort-product-category');
            Route::resource('tag', 'TagController');
            Route::resource('article-group', 'ArticleGroupController');
            Route::resource('media', 'MediaController');
            Route::get('article-group-sorting', 'ArticleGroupController@shortPage')
                ->name('article-group-sorting');
            Route::post('sort-article-group', 'ArticleGroupController@sortData')
                ->name('sort-article-group');

            Route::get('article-sorting', 'ArticleController@shortPage')
                ->name('article-sorting');
            Route::post('sort-article', 'ArticleController@sortData')
                ->name('sort-article');

            Route::resource('blog-categories', 'BlogCategoryController');

            Route::resource('agent', 'AgentController');
            Route::resource('attendance', 'AttendanceController');
            Route::resource('notices', 'NoticeController');
            Route::resource('role', 'RoleController');
            Route::resource('recurring-payments', 'RecurringPaymentController');
            Route::resource('customer', 'CustomersController');
            Route::post('reset-customer-password/{customer_id}', 'CustomersController@resetCustomerPassword')
                ->name('reset-customer-password');

            Route::put('update-holiday-setting', 'VacationController@updateHolidaySetting')->name('update-holiday-setting');
            Route::resource('task-lists', 'TaskController');
            Route::get('task-calendar', 'TaskController@taskCalendr')->name('task-calendar');
            Route::put('update-task-status/{id}', 'TaskController@updateTaskStatus')->name('update-task-status');
            Route::get('view-all-notification', 'NotificationController@view');
            Route::get('mark-as-read-unread/{id}', 'NotificationController@markAsRead');
            Route::DELETE('notification-destroy/{id}', 'NotificationController@destroy')->name('notification-destroy');
            Route::get('notification-delete/{id}', 'NotificationController@destroy')->name('notification-delete');
            Route::get('agent-report', 'ReportController@agentReport')->name('agent-report');
            Route::get('support-history-report', 'ReportController@supportHistoryReport')->name('support-history-report');
            Route::get('customer-feedback-report', 'ReportController@index')->name('customer-feedback-report');
            Route::get('transaction-report', 'ReportController@transactionReport')
                ->name('transaction-report');
            Route::get('attendance-report', 'ReportController@attendanceReport')
                ->name('attendance-report');
            Route::get('check-in-out', 'AttendanceController@checkInOut')
                ->name('check-in-out');
            Route::any('in-attendance', 'AttendanceController@inAttendance')
                ->name('in-attendance');
            Route::any('out-attendance', 'AttendanceController@outAttendance')
                ->name('out-attendance');
        });

        // Only customer
        Route::middleware('customer')->group(function () {
            Route::get('closing-ticket-feedback/{ids}', 'FeedbackController@index');
            Route::post('post-ticket-review', 'FeedbackController@store');
            Route::get('article-list', 'ArticleController@customerArticleList')
                ->name('customer-article-list');
            Route::get('article-view/{id}', 'ArticleController@customerArticleView');
            Route::post('article-review/{id}', 'ArticleController@customerArticleReview');
            Route::get('payment-history', 'CustomerDashboardController@paymentHistory')
                ->name('payment-history');
            Route::get('recurring-payment', 'CustomerDashboardController@recurringPayment')
                ->name('recurring-payment');
            Route::get('select-payment-method/{payment_id}', 'CustomerDashboardController@selectPaymentMethod')
                ->name('select-payment-method');
            Route::get('make-payment/{ticket_id}', 'PaymentController@makePayment')
                ->name('make-payment');
            Route::post('process-payment/{ticket_id}', 'PaymentController@processPayment')
                ->name('process-payment');
            // Paypal
            Route::get('process-paypal-transaction/{ticket_id}', 'PaypalController@processTransaction')
                ->name('process-paypal-transaction');
            Route::get('create-transaction', 'PaypalController@createTransaction')
                ->name('createTransaction');
            Route::get('success-transaction', 'PaypalController@successTransaction')
                ->name('successTransaction');
            Route::get('cancel-transaction', 'PaypalController@cancelTransaction')
                ->name('cancelTransaction');
            // Stripe
            Route::get('stripe/{ticket_id}', 'StripeController@stripe')
                ->name('stripe-payment');
            Route::post('stripe', 'StripeController@stripePost')
                ->name('stripe.post');           
        });

        // Only admin
        Route::middleware('admin')->group(function () {
            Route::get('activity-log-list', 'ActivityLogController@index');
        });
    });
    /**
     * Commonly ticket details activity
     */
    Route::middleware('auth')->group(function () {
        Route::get('dashboard-tickets', 'DashboardController@getTickets')
            ->name('dashboard-tickets');
        Route::get('get-tickets', 'TicketActivityController@getTickets')
            ->name('get-tickets');
        Route::get('ticket-title-search', 'TicketActivityController@ticketTitleSearch')
            ->name('ticket-title-search');
        Route::get('autocomplete-data', 'TicketActivityController@autocompleteData')
            ->name('autocomplete-data');
        Route::post('check-relevant-verification', 'TicketActivityController@checkRelevantVerificationOfProductCat')
            ->name('check-relevant-verification');
        Route::get('flag-ticket/{ticket_id}', 'TicketActivityController@flagTicket')
            ->name('flag-ticket');
        Route::get('editor-mentioned-data', 'TicketActivityController@getEditorMentionedData')
            ->name('editor-mentioned-data');
        Route::post('set-ticket-assign-priority', 'TicketActivityController@setTicketAssignPriority')
            ->name('set-ticket-assign-priority');
        Route::get('ticket-close-reopen/{ticket_id}/{ticket_status}', 'TicketActivityController@ticketCloseReopen')
            ->name('ticket-close-reopen');
        Route::get('ticket-close-directly/{ticket_id}/{ticket_status}', 'TicketActivityController@ticketCloseReopenList')
            ->name('ticket-close-reopen');
        Route::get('ticket-archived/{ticket_id}', 'TicketActivityController@archivedTicket')
            ->name('ticket-archived');
        Route::get('ticket-close/{ticket_id}', 'TicketActivityController@archivedTicket')
            ->name('ticket-close');
        Route::post('add-customer-note', 'TicketActivityController@addCustomerNote')
            ->name('add-customer-note');
        Route::post('add-ticket-note', 'TicketActivityController@addTicketNote')
            ->name('add-ticket-note');
        Route::post('add-ticket-cc', 'TicketActivityController@addTicketCC')
            ->name('add-ticket-cc');
        Route::get('customer-note-list', 'TicketActivityController@customerNoteList')
            ->name('customer-note-list');
        Route::post('get-article-searched-data', 'TicketActivityController@getArticleSearchedData')
            ->name('get-article-searched-data');

        Route::post('send-payment-request', 'TicketActivityController@sendPaymentRequest')
            ->name('send-payment-request');
        Route::get('open-new-chat/{id}', 'TicketActivityController@createChatGroup')
            ->name('open-new-chat');
    });

});

// Routes without global xss
Route::middleware(['auth', 'set_locale'])->group(function () {
    Route::middleware('admin_agent')->group(function () {
        Route::get('site-setting', 'SettingController@siteSetting')->name('site-setting');
        Route::put('update-site-setting', 'SettingController@updateSiteSetting')->name('update-site-setting');
        Route::get('theme-setting', 'SettingController@themeSetting')->name('theme-setting');
        Route::get('update-theme-setting', 'SettingController@updateThemeSetting')->name('update-theme-setting');
        Route::get('ai-setting', 'SettingController@aiSetting')->name('ai-setting');
        Route::put('update-ai-setting', 'SettingController@updateAiSetting')->name('update-ai-setting');
        Route::get('mail-templates', 'SettingController@showAllTemplates')
            ->name('mail-templates');
        Route::get('mail-templates-edit/{id}', 'SettingController@editAllTemplate')
            ->name('mail-templates-edit');
        Route::put('mail-template-update/{id}', 'SettingController@updateAllTemplate')
            ->name('mail-template-update');
        Route::resource('canned-message', 'CannedMessageController');
        Route::resource('articles', 'ArticleController');
        Route::resource('blog', 'BlogController');
        Route::resource('product-category', 'ProductCategoryController');
        Route::resource('faq', 'FaqController');
        Route::resource('pages', 'PagesController');
        Route::resource('vacations', 'VacationController');
        Route::resource('holiday-setting', 'HolidaySettingController');
        Route::resource('ai_replies', 'AutoReplyController');
        Route::controller(FeatureController::class)->group(function () {
            Route::get('feature-setting', 'index')->name('feature-setting');
            Route::put('feature-setting', 'update')->name('feature-setting-update');
        });        

        Route::controller(SectionTitleController::class)->group(function () {
            Route::get('section-title', 'index')->name('section-title');
            Route::put('section-title', 'update')->name('section-title-update');
        });
    });
    Route::resource('ticket', 'TicketController');
    Route::get('ai-checking-instant-solution/{ticket_id}', 'TicketController@aiCheckingInstantSolution');
    Route::get('set-ai-reply', 'TicketActivityController@setAiReply');
    Route::post('posting-replay-in-ticket', 'TicketActivityController@postingReplayInTicket')
        ->name('posting-replay-in-ticket');
    Route::post('update-reply-comment/{comment_id}', 'TicketActivityController@updateReplyComment')
        ->name('update-reply-comment');
});

Route::get('update-checker', 'UpdateController@index')->name('update-checker');
Route::get('success-validation', 'FrontendController@successValidation')->name('success-validation');
Route::get('/internal-error', 'FrontendController@internalError')->name('internal-error');

