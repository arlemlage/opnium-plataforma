@php
    app()->setLocale($lan);
@endphp

@if (isset($query_length) && $query_length >= 3)
    @php
        $max = max(count($articles), count($faqs), count($blogs), count($pages));
        $active = '';
        if ($max == count($articles)) {
            $active = 'article';
        } elseif ($max == count($faqs) && $active == '') {
            $active = 'faqs';
        } elseif ($max == count($blogs) && $active == '') {
            $active = 'blogs';
        } elseif ($max == count($pages) && $active == '') {
            $active = 'pages';
        }
    @endphp
    @if (count($articles) || count($faqs) || count($blogs) || count($pages))
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link {{ $active == 'article' ? 'active' : '' }}" id="search1-tab" data-bs-toggle="tab"
                    data-bs-target="#search1" type="button" role="tab" aria-controls="search1"
                    aria-selected="true">@lang('index.article')({{ count($articles) }})</button>

                <button class="nav-link {{ $active == 'faqs' ? 'active' : '' }}" id="search2-tab" data-bs-toggle="tab"
                    data-bs-target="#search2" type="button" role="tab" aria-controls="search2"
                    aria-selected="false">@lang('index.faq')({{ count($faqs) }})</button>

                <button class="nav-link {{ $active == 'blogs' ? 'active' : '' }}" id="search3-tab" data-bs-toggle="tab"
                    data-bs-target="#search3" type="button" role="tab" aria-controls="search3"
                    aria-selected="false">@lang('index.blog')({{ count($blogs) }})</button>

                <button class="nav-link {{ $active == 'pages' ? 'active' : '' }}" id="search4-tab" data-bs-toggle="tab"
                    data-bs-target="#search4" type="button" role="tab" aria-controls="search4"
                    aria-selected="false">@lang('index.page')({{ count($pages) }})</button>
                <button class="nav-link" id="search5-tab" data-bs-toggle="tab" data-bs-target="#search5" type="button"
                    role="tab" aria-controls="search5" aria-selected="false">AI(1)</button>
            </div>
        </nav>

        <div class="tab-content" id="nav-searchContent">
            <div class="tab-pane fade {{ $active == 'article' ? 'show active' : '' }}" id="search1" role="tabpanel"
                aria-labelledby="search1-tab">
                <div class="article-card">
                    <!-- List -->
                    <ul class="list-unstyled text-start">
                        @if (count($articles))
                            @foreach ($articles as $article)
                                @php($slug = App\Model\ProductCategory::find($article->product_category_id)->slug ?? '')
                                <li>
                                    <div class="d-flex">
                                        <a class="text-truncate search-result-title"
                                            href="{{ route('article-details', [$slug, $article->title_slug]) }}">
                                            @if (!isset($product_id))
                                                <span>
                                                    @php($slug = App\Model\ProductCategory::find($article->product_category_id)->slug)
                                                    <span class="search-result-title-content">{{ App\Model\ProductCategory::find($article->product_category_id)->title ?? '' }}</span>
                                                    <i class="bi bi-arrow-right-short"></i>
                                                </span>
                                            @endif
                                            <span class="search-result-title-content">{{ App\Model\ArticleGroup::find($article->article_group_id)->title ?? '' }}</span>
                                            <i class="bi bi-arrow-right-short"></i>
                                            <span class="search-result-title-content">{{ $article->title }}</span>
                                        </a>

                                        <button type="button" class="copy-btn-home copy_btn"
                                            data-link="{{ route('article-details', [$slug, $article->title_slug]) }}">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_128_284)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                                        d="M4 2C4 1.46957 4.21071 0.960859 4.58579 0.585786C4.96086 0.210714 5.46957 0 6 0L14 0C14.5304 0 15.0391 0.210714 15.4142 0.585786C15.7893 0.960859 16 1.46957 16 2V10C16 10.5304 15.7893 11.0391 15.4142 11.4142C15.0391 11.7893 14.5304 12 14 12H6C5.46957 12 4.96086 11.7893 4.58579 11.4142C4.21071 11.0391 4 10.5304 4 10V2ZM6 1C5.73478 1 5.48043 1.10536 5.29289 1.29289C5.10536 1.48043 5 1.73478 5 2V10C5 10.2652 5.10536 10.5196 5.29289 10.7071C5.48043 10.8946 5.73478 11 6 11H14C14.2652 11 14.5196 10.8946 14.7071 10.7071C14.8946 10.5196 15 10.2652 15 10V2C15 1.73478 14.8946 1.48043 14.7071 1.29289C14.5196 1.10536 14.2652 1 14 1H6ZM2 5C1.73478 5 1.48043 5.10536 1.29289 5.29289C1.10536 5.48043 1 5.73478 1 6V14C1 14.2652 1.10536 14.5196 1.29289 14.7071C1.48043 14.8946 1.73478 15 2 15H10C10.2652 15 10.5196 14.8946 10.7071 14.7071C10.8946 14.5196 11 14.2652 11 14V13H12V14C12 14.5304 11.7893 15.0391 11.4142 15.4142C11.0391 15.7893 10.5304 16 10 16H2C1.46957 16 0.960859 15.7893 0.585786 15.4142C0.210714 15.0391 0 14.5304 0 14V6C0 5.46957 0.210714 4.96086 0.585786 4.58579C0.960859 4.21071 1.46957 4 2 4H3V5H2Z"
                                                        fill="black" />
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_128_284">
                                                        <rect width="16" height="16" fill="white" />
                                                    </clipPath>
                                                </defs>
                                            </svg>

                                        </button>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <span>@lang('index.no_item_found')</span>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade {{ $active == 'faqs' ? 'show active' : '' }}" id="search2" role="tabpanel"
                aria-labelledby="search2-tab">

                <div class="article-card">

                    <!-- List -->
                    <ul class="list-unstyled text-start">
                        @if (count($faqs))
                            @foreach ($faqs as $faq)
                                <li>
                                    <h5>{{ $faq->question ?? '' }}</h5>
                                    {!! $faq->answer ?? '' !!}
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <span>@lang('index.no_item_found')</span>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade {{ $active == 'blogs' ? 'show active' : '' }}" id="search3" role="tabpanel"
                aria-labelledby="search3-tab">
                <div class="article-card">
                    <!-- List -->
                    <ul class="list-unstyled text-start">
                        @if (count($blogs))
                            @foreach ($blogs as $blog)
                                <li>
                                    <a class="text-truncate search-result-title"
                                        href="{{ route('blog-details', $blog->slug) }}">
                                        {{ $blog->title }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <span>@lang('index.no_item_found')</span>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade {{ $active == 'pages' ? 'show active' : '' }}" id="search4" role="tabpanel"
                aria-labelledby="search4-tab">
                <div class="article-card">
                    <!-- List -->
                    <ul class="list-unstyled text-start">
                        @if (count($pages))
                            @foreach ($pages as $page)
                                <li>
                                    <a class="text-truncate search-result-title"
                                        href="{{ route('page-details', $page->slug) }}">
                                        {{ $page->title ?? '' }}
                                    </a>
                                </li>
                            @endforeach
                        @else
                            <div class="alert alert-danger">
                                <span>@lang('index.no_item_found')</span>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade" id="search5" role="tabpanel" aria-labelledby="search5-tab">
                <div class="article-card">
                    <h4 class="text-primary">@lang('index.reply_from_ai')</h4>
                    <p class="aiData">
                        {{ $aiData }}
                    </p>
                </div>
            </div>
        </div>
    @elseif($aiData != null)
        <div class="article-card">
            <h4 class="text-primary">@lang('index.ai_found_reply')</h4>
            <p class="aiData">
                {{ $aiData }}
            </p>
        </div>
    @else
        <div class="alert alert-danger tc_m_4_px" role="alert">
            @lang('index.no_item_found')
        </div>
    @endif
@else
    <div class="alert alert-danger tc_m_4_px" role="alert">
        @lang('index.type_three_letter')
    </div>
@endif
