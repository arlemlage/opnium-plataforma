<ul class="navbar-nav navbar-nav-scroll me-auto mb-3 mb-lg-0 menu-others" id="supportyNav">
    <li>
        <a class="set_active color-menu {{ empty(urlPrefix()) ? 'active' : '' }}" href="{{ baseurl() }}">@lang('index.home')</a>
    </li>
    <li>
        <a class="set_active color-menu" href="{{ baseurl() }}#article">@lang('index.articles')</a>
    </li>
    <li>
        <a class="set_active color-menu" href="{{ baseurl() }}#faq">@lang('index.faq')</a>
    </li>
    <li>
        <a class="set_active color-menu" href="{{ baseurl() }}">@lang('index.blog')</a>
    </li>
    <li class="dropdown-list">
        <a href="javascript:void(0)" class="color-menu">@lang('index.page')</a>
        <ul class="dropdown-body">
            <li>
                <a href="{{ url('about-us') }}">
                    @lang('index.about_us')
                </a>
            </li>
            <li>
                <a href="{{ url('our-services') }}">
                    @lang('index.our_services')
                </a>
            </li>
            <li>
                <a href="{{ url('support-policy') }}">
                    @lang('index.support_policy')
                </a>
            </li>
            @foreach(getAllPages() as $page)
            <li>
                <a href="{{ url('page-details') }}/{{ $page->slug }}">
                    {{ $page->title ?? "" }}
                </a>
            </li>
            @endforeach
        </ul>
    </li>
        <li>
            <a class="set_active color-menu" href="{{ url('forum') }}">@lang('index.forum')
            </a>
        </li>
        <li>
            <a class="set_active color-menu" href="{{ url("contact") }}">
            @lang('index.contact')
            </a>
    </li>
</ul>