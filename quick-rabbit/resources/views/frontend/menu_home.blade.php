<ul class="navbar-nav navbar-nav-scroll mb-3 mb-lg-0" id="supportyNav">
    <li>
        <a class="set_active {{ empty(urlPrefix()) ? 'active' : '' }}" href="{{ route('home') }}">@lang('index.home')</a>
    </li>
    <li>
        <a class="set_active" href="#knowledge-article" id="menu_knowledge-article">@lang('index.articles')</a>
    </li>
    <li>
        <a class="set_active" href="#faq" id="menu_faq">@lang('index.faq')</a>
    </li>
    <li>
        <a class="set_active" href="{{ route('blogs') }}">@lang('index.blog')</a>
    </li>
    <li class="dropdown-list">
        <a href="javascript:void(0)" class="set_active">@lang('index.page')</a>
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
            @foreach (getAllPages() as $page)
                <li>
                    <a href="{{ route('page-details', $page->slug) }}">
                        {{ $page->title ?? '' }}
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
    <li>
        <a class="set_active {{ urlPrefix() == 'forum' ? 'active' : '' }}" href="{{ route('forum') }}">@lang('index.forum')
        </a>
    </li>
    <li>
        <a class="set_active {{ urlPrefix() == 'contact' ? 'active' : '' }}" href="{{ route('contact') }}">
            @lang('index.contact')
        </a>
    </li>
</ul>

