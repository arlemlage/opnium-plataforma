<ul class="navbar-nav navbar-nav-scroll me-auto mb-3 mb-lg-0 menu-others" id="supportyNav">
    <li>
        <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }} {{ empty(urlPrefix()) ? 'active' : '' }}" href="{{ route('home') }}">@lang('index.home')</a>
    </li>
    <li>
        <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }}" href="{{ route('home') }}#knowledge-article">@lang('index.articles')</a>
    </li>
    <li>
        <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }}" href="{{ route('home') }}#faq">@lang('index.faq')</a>
    </li>
    <li>
        <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }}" href="{{ route('blogs') }}">@lang('index.blog')</a>
    </li>
    <li class="dropdown-list">
        <a href="javascript:void(0)" class="{{ request()->url() == route('home') ? '' : 'color-menu' }}">@lang('index.page')</a>
        <ul class="dropdown-body">
            <li>
                <a href="{{ route('about-us') }}">
                    @lang('index.about_us')
                </a>
            </li>
            <li>
                <a href="{{ route('our-services') }}">
                    @lang('index.our_services')
                </a>
            </li>
            <li>
                <a href="{{ route('support-policy') }}">
                    @lang('index.support_policy')
                </a>
            </li>
            @foreach(getAllPages() as $page)
            <li>
                <a href="{{ route('page-details',$page->slug) }}">
                    {{ $page->title ?? "" }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
        <li>
            <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }} {{ urlPrefix() == "forum" ? 'active' : '' }}" href="{{ route('forum') }}">@lang('index.forum')
            </a>
        </li>
        <li>
            <a class="set_active {{ request()->url() == route('home') ? '' : 'color-menu' }} {{ urlPrefix() == "contact" ? 'active' : '' }}" href="{{ route("contact") }}">
            @lang('index.contact')
            </a>
    </li>
</ul>