<?php

namespace App\Providers;

use App\Model\GroupChatMessage;
use App\Model\Ticket;
use App\Model\TicketReplyComment;
use App\Observers\GroupChatObserver;
use App\Observers\TicketCommentObserver;
use App\Observers\TicketObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            \SocialiteProviders\Envato\EnvatoExtendSocialite::class . '@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Ticket::observe(TicketObserver::class);
        TicketReplyComment::observe(TicketCommentObserver::class);
        GroupChatMessage::observe(GroupChatObserver::class);
        $APPLICATION_MODE = appMode();
        if ($APPLICATION_MODE == "demo") {
            $request_v = (request());
            $request_path = $request_v->path();
            if (isset($request_v['_method']) && $request_v['_method'] == "DELETE") {
                abort(405);                
            }
            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-profile") {
                abort(405);
            }
            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-password") {
                abort(405);
            }
            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "save-security-question") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-site-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-ai-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "mail-template-update") {
                abort(405);
            }
            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "feature-setting") {
                abort(405);
            }
            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "section-title") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-social-login-setting") {
                abort(405);
            }

             if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-ticket-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-chat-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "sort-agent-chat-sequence") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-chat-sequence-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-integration-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-mail-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-notification-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-payment-gateway-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-gdpr-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-about-us-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-our-services-setting") {
                abort(405);
            }

            if (isset($request_v['_method']) && $request_v['_method'] == "PUT" && $request_path === "update-our-services-setting") {
                abort(405);
            }

            $url = request()->segment(1);
            $restricted_urls = [];
            if (in_array($url, $restricted_urls)) {
                abort(405);
            }
        }

    }
}
