<section class="sidebar">
    <h2 id="segment-fetcher" class="display-none" data-id="{{ Request::segment(1) }}">&nbsp;</h2>
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left info">

        </div>
    </div>
    @php
        $url = ucfirst(Request::segment(1));
    @endphp


    <div id="left_menu_to_scroll">
        <ul class="sidebar-menu" data-widget="tree">
            <li class="parent-menu">
                <a href="{{ route('user-home') }}" class="child-menu">
                    <iconify-icon icon="lets-icons:home-duotone" width="18"></iconify-icon>                        
                    <span class="match_bold"> @lang ('index.home')</span>
                </a>
            </li>
            @if (authUserRole() == 1 || authUserRole() == 2)
                @if (routePermission('dashboard'))
                    <li class="parent-menu">
                        <a href="{{ route('dashboard') }}" class="child-menu">
                            <iconify-icon icon="solar:graph-new-up-bold-duotone" width="18"></iconify-icon>
                            <span class="match_bold"> @lang ('index.dashboard')</span>
                        </a>
                    </li>
                @endif
            @endif
            @if (authUserRole() != 3)
                @if (menuPermission('Tickets'))
                    @if (authUserRole() != 3)
                        <li class="parent-menu treeview">
                            <a href="#">
                                <iconify-icon icon="solar:ticket-bold-duotone" width="18"></iconify-icon>
                                <span>@lang ('index.tickets')</span>
                            </a>
                            <ul class="treeview-menu">
                                <li>
                                    <a href="{{ url('ticket/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_ticket')
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ url('ticket') }}" class="child-menu match_bold">
                                        @lang ('index.ticket_list')
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                @if (menuPermission('Customers'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:user-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.customers')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('customer.create'))
                                <li>
                                    <a href="{{ url('customer/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_customer')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('customer.index'))
                                <li>
                                    <a href="{{ url('customer') }}" class="child-menu match_bold">
                                        @lang ('index.customer_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (menuPermission('Task and Calendar'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:calendar-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.task_and_calendar')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('task-lists.index'))
                                <li>
                                    <a href="{{ route('task-lists.index') }}" class="child-menu match_bold">
                                        @lang ('index.task_list')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('task-calendar'))
                                <li>
                                    <a href="{{ url('task-calendar') }}" class="child-menu match_bold">
                                        @lang ('index.task_calendar')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Article Group'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:book-bookmark-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.article_group')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('article-group.create'))
                                <li>
                                    <a href="{{ url('article-group/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_article_group')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('article.index'))
                                <li>
                                    <a href="{{ url('article-group') }}" class="child-menu match_bold">
                                        @lang ('index.article_group_list')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('article-group-sorting'))
                                <li>
                                    <a href="{{ url('article-group-sorting') }}" class="child-menu match_bold">
                                        @lang ('index.article_group_sorting')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Article'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:bookmark-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.article')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('article.create'))
                                <li>
                                    <a href="{{ url('articles/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_article')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('article.index'))
                                <li>
                                    <a href="{{ url('articles') }}" class="child-menu match_bold">
                                        @lang ('index.article_list')
                                    </a>
                                </li>
                            @endif

                        </ul>
                    </li>
                @endif
                @if (menuPermission('Blog'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:bill-list-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.blog')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('blog-categories.index'))
                                <li>
                                    <a href="{{ url('blog-categories') }}" class="child-menu match_bold">
                                        @lang ('index.blog_categories')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('blog.create'))
                                <li>
                                    <a href="{{ url('blog/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_blog')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('blog.index'))
                                <li>
                                    <a href="{{ url('blog') }}" class="child-menu match_bold">
                                        @lang ('index.blog_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Notice'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:bell-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.notice')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('notices.create'))
                                <li>
                                    <a href="{{ route('notices.create') }}" class="child-menu match_bold">
                                        @lang ('index.add_notice')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('notices.index'))
                                <li>
                                    <a href="{{ route('notices.index') }}" class="child-menu match_bold">
                                        @lang ('index.notice_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Report'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:video-frame-replace-line-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.report')</span>
                        </a>
                        <ul class="treeview-menu">
                            @if (routePermission('agent-report'))
                                <li>
                                    <a href="{{ url('agent-report') }}" class="child-menu match_bold">
                                        @lang ('index.agent_report')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('support-history-report'))
                                <li>
                                    <a href="{{ url('support-history-report') }}" class="child-menu match_bold">
                                        @lang ('index.support_history')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('customer-feedback-report'))
                                <li>
                                    <a href="{{ url('customer-feedback-report') }}" class="child-menu match_bold">
                                        @lang ('index.customer_feedback')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('transaction-report'))
                                <li>
                                    <a href="{{ url('transaction-report') }}" class="child-menu match_bold">
                                        @lang ('index.transaction_report')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('attendance-report'))
                                <li>
                                    <a href="{{ route('attendance-report') }}" class="child-menu match_bold">
                                        @lang ('index.attendance_report')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Recurring Payment'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:card-2-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.recurring_payment')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('recurring-payments.create'))
                                <li>
                                    <a href="{{ route('recurring-payments.create') }}" class="child-menu match_bold">
                                        @lang ('index.add_recurring_payment')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('recurring-payments.index'))
                                <li>
                                    <a href="{{ route('recurring-payments.index') }}" class="child-menu match_bold">
                                        @lang ('index.recurring_payment_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (authUserRole() == 1)
                    <li class="parent-menu">
                        <a href="{{ url('activity-log-list') }}" class="child-menu">
                            <iconify-icon icon="solar:course-up-line-duotone" width="18"></iconify-icon>
                            <span class="match_bold"> @lang ('index.activity_log')</span>
                        </a>
                    </li>
                @endif
                @if (menuPermission('Canned Message'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:chat-line-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.canned_msg')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('canned-message.create'))
                                <li>
                                    <a href="{{ url('canned-message/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_canned_msg')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('canned-message.index'))
                                <li>
                                    <a href="{{ url('canned-message') }}" class="child-menu match_bold">
                                        @lang ('index.canned_msg_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Media'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="uim:image-v" width="18"></iconify-icon>
                            <span>@lang ('index.media')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('media.create'))
                                <li>
                                    <a href="{{ url('media/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_media')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('media.index'))
                                <li>
                                    <a href="{{ url('media') }}" class="child-menu match_bold">
                                        @lang ('index.media_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (menuPermission('Product/Category'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:cart-5-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.product_category')</span></a>
                        <ul class="treeview-menu">
                            @if (appTheme() == 'multiple')
                                @if (routePermission('product-category.create'))
                                    <li>
                                        <a href="{{ url('product-category/create') }}" class="child-menu match_bold">
                                            @lang ('index.add_product_category')
                                        </a>
                                    </li>
                                @endif
                            @endif

                            @if (routePermission('product-category.index'))
                                <li>
                                    <a href="{{ url('product-category') }}" class="child-menu match_bold">
                                        @if (appTheme() == 'multiple')
                                            @lang ('index.product_category_list')
                                        @else
                                            @lang ('index.product_category_settings')
                                        @endif
                                    </a>
                                </li>
                            @endif
                            @if (appTheme() == 'multiple')
                                @if (routePermission('product-category-sorting'))
                                    <li>
                                        <a href="{{ url('product-category-sorting') }}"
                                            class="child-menu match_bold">
                                            @lang ('index.product_category_sorting')
                                        </a>
                                    </li>
                                @endif
                            @endif
                        </ul>
                    </li>
                @endif

                @if (menuPermission('Tag'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:hashtag-square-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.tags')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('tag.create'))
                                <li>
                                    <a href="{{ url('tag/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_tag')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('tag.index'))
                                <li>
                                    <a href="{{ url('tag') }}" class="child-menu match_bold">
                                        @lang ('index.tag_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (menuPermission('Faq'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:info-circle-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.faq')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('faq.create'))
                                <li>
                                    <a href="{{ url('faq/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_faq')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('faq.index'))
                                <li>
                                    <a href="{{ url('faq') }}" class="child-menu match_bold">
                                        @lang ('index.faq_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Page'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:closet-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.page')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('pages.create'))
                                <li>
                                    <a href="{{ url('pages/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_page')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('pages.index'))
                                <li>
                                    <a href="{{ url('pages') }}" class="child-menu match_bold">
                                        @lang ('index.page_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (menuPermission('Role'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:dropper-minimalistic-2-bold-duotone"
                                width="18"></iconify-icon>
                            <span>@lang ('index.role')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('role.create'))
                                <li>
                                    <a href="{{ route('role.create') }}" class="child-menu match_bold">
                                        @lang ('index.add_role')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('role.index'))
                                <li>
                                    <a href="{{ route('role.index') }}" class="child-menu match_bold">
                                        @lang ('index.role_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Agents'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:user-speak-rounded-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.agents')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('agent.create'))
                                <li>
                                    <a href="{{ url('agent/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_agent')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('agent.index'))
                                <li>
                                    <a href="{{ url('agent') }}" class="child-menu match_bold">
                                        @lang ('index.agent_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Attendance'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:stopwatch-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.attendance')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('attendance.create'))
                                <li>
                                    <a href="{{ url('attendance/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_attendance')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('attendance.index'))
                                <li>
                                    <a href="{{ url('attendance') }}" class="child-menu match_bold">
                                        @lang ('index.attendance_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (menuPermission('Vacation'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:sun-fog-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.vacation')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('vacations.create'))
                                <li>
                                    <a href="{{ url('vacations/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_vacation')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('vacations.index'))
                                <li>
                                    <a href="{{ url('vacations') }}" class="child-menu match_bold">
                                        @lang ('index.vacation_list')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('holiday-setting.index'))
                                <li>
                                    <a href="{{ url('holiday-setting') }}" class="child-menu match_bold">
                                        @lang ('index.holiday_setting')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
                @if (menuPermission('Testimonials'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="material-symbols-light:reviews" width="18"></iconify-icon>
                            <span>@lang ('index.testimonial')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('testimonial.create'))
                                <li>
                                    <a href="{{ route('testimonial.create') }}" class="child-menu match_bold">
                                        @lang ('index.add_testimonial')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('testimonial.index'))
                                <li>
                                    <a href="{{ route('testimonial.index') }}" class="child-menu match_bold">
                                        @lang ('index.testimonial_list')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                @if (menuPermission('Setting'))
                    <li class="parent-menu treeview">
                        <a href="#">
                            <iconify-icon icon="solar:settings-bold-duotone" width="18"></iconify-icon>
                            <span>@lang ('index.setting')</span></a>
                        <ul class="treeview-menu">
                            @if (routePermission('site-setting'))
                                <li>
                                    <a href="{{ url('site-setting') }}" class="child-menu match_bold">
                                        @lang ('index.site_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('theme-setting'))
                                <li>
                                    <a href="{{ url('theme-setting') }}" class="child-menu match_bold">
                                        @lang ('index.theme_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('ai-setting'))
                                <li>
                                    <a href="{{ url('ai-setting') }}" class="child-menu match_bold">
                                        @lang ('index.ai_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('ai_replies.create'))
                                <li>
                                    <a href="{{ url('ai_replies/create') }}" class="child-menu match_bold">
                                        @lang ('index.add_auto_reply')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('ai_replies.index'))
                                <li>
                                    <a href="{{ url('ai_replies') }}" class="child-menu match_bold">
                                        @lang ('index.auto_reply_list')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('social-login-setting'))
                                <li>
                                    <a href="{{ url('social-login-setting') }}" class="child-menu match_bold">
                                        @lang ('index.social_login')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('custom-fields.index'))
                                <li>
                                    <a href="{{ url('custom-fields') }}" class="child-menu match_bold">
                                        @lang ('index.custom_fields')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('ticket-setting'))
                                <li>
                                    <a href="{{ url('ticket-setting') }}" class="child-menu match_bold">
                                        @lang ('index.ticket_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('chat-setting'))
                                <li>
                                    <a href="{{ url('chat-setting') }}" class="child-menu match_bold">
                                        @lang ('index.chat_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('chat-sequence-setting'))
                                <li>
                                    <a href="{{ url('chat-sequence-setting') }}" class="child-menu match_bold">
                                        @lang ('index.chat_sequence_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('departments.index'))
                                <li>
                                    <a href="{{ url('departments') }}" class="child-menu match_bold">
                                        @lang ('index.departments')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('integration-setting'))
                                <li>
                                    <a href="{{ url('integration-setting') }}" class="child-menu match_bold">
                                        @lang ('index.integrations')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('mail-setting'))
                                <li>
                                    <a href="{{ url('mail-setting') }}" class="child-menu match_bold">
                                        @lang ('index.mail_settings')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('mail-templates'))
                                <li>
                                    <a href="{{ url('mail-templates') }}" class="child-menu match_bold">
                                        @lang ('index.mail_template')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('notification-setting'))
                                <li>
                                    <a href="{{ url('notification-setting') }}" class="child-menu match_bold">
                                        @lang ('index.notification_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('payment-gateway-setting'))
                                <li>
                                    <a href="{{ url('payment-gateway-setting') }}" class="child-menu match_bold">
                                        @lang ('index.payment_gateway_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('gdpr-setting'))
                                <li>
                                    <a href="{{ url('gdpr-setting') }}" class="child-menu match_bold">
                                        @lang ('index.gdpr_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('about-us-setting'))
                                <li>
                                    <a href="{{ url('about-us-setting') }}" class="child-menu match_bold">
                                        @lang ('index.about_us_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('our-services-setting'))
                                <li>
                                    <a href="{{ url('our-services-setting') }}" class="child-menu match_bold">
                                        @lang ('index.our_services_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('feature-setting'))
                                <li>
                                    <a href="{{ url('feature-setting') }}" class="child-menu match_bold">
                                        @lang ('index.feature_setting')
                                    </a>
                                </li>
                            @endif
                            @if (routePermission('section-title'))
                                <li>
                                    <a href="{{ url('section-title') }}" class="child-menu match_bold">
                                        @lang ('index.section_title')
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif
            @endif

            @if (authUserRole() == 3)
                <li class="parent-menu">
                    <a href="{{ url('ticket') }}" class="child-menu">
                        <iconify-icon icon="solar:ticket-bold-duotone" width="18"></iconify-icon>
                        <span class="match_bold">@lang ('index.my_tickets')</span>
                    </a>
                </li>
                <li class="parent-menu">
                    <a href="{{ url('recurring-payment') }}" class="child-menu">
                        <iconify-icon icon="bx:money" width="18"></iconify-icon>
                        <span class="match_bold"> @lang ('index.recurring_payment')</span>
                    </a>
                </li>
                <li class="parent-menu">
                    <a href="{{ url('payment-history') }}" class="child-menu">
                        <iconify-icon icon="ion:logo-usd" width="18"></iconify-icon>
                        <span class="match_bold"> @lang ('index.payment_history')</span>
                    </a>
                </li>
        </ul>
        @endif
    </div>
</section>
