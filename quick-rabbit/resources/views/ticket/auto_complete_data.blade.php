@php
    app()->setLocale($lan);
@endphp
<div class="d-flex justify-content-end pe-4">
    <a href="javascript:void(0)" class="search-close">
        <iconify-icon icon="uil:times" width="18"></iconify-icon>
    </a>
</div>
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
        <ul class="nav nav-tabs me-2" id="myTab" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $active == 'article' ? 'active' : '' }}" id="article-tab"
                    data-bs-toggle="tab" data-bs-target="#article-tab-pane" type="button" role="tab"
                    aria-controls="article-tab-pane"
                    aria-selected="true">@lang('index.article')({{ count($articles) }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $active == 'faqs' ? 'active' : '' }}" id="faq-tab" data-bs-toggle="tab"
                    data-bs-target="#faq-tab-pane" type="button" role="tab" aria-controls="faq-tab-pane"
                    aria-selected="false">@lang('index.faq')({{ count($faqs) }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $active == 'blogs' ? 'active' : '' }}" id="blog-tab" data-bs-toggle="tab"
                    data-bs-target="#blog-tab-pane" type="button" role="tab" aria-controls="blog-tab-pane"
                    aria-selected="false">@lang('index.blog')({{ count($blogs) }})</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link {{ $active == 'pages' ? 'active' : '' }}" id="page-tab" data-bs-toggle="tab"
                    data-bs-target="#page-tab-pane" type="button" role="tab" aria-controls="page-tab-pane"
                    aria-selected="false">@lang('index.page')({{ count($pages) }})</button>
            </li>
             <li class="nav-item" role="presentation">
                <button class="nav-link" id="ai-tab" data-bs-toggle="tab"
                    data-bs-target="#ai-tab-pane" type="button" role="tab" aria-controls="ai-tab"
                    aria-selected="false">AI(1)</button>
            </li>
        </ul>
        <div class="tab-content me-2 search-result-scroll" id="myTabContent">
            <div class="tab-pane fade {{ $active == 'article' ? 'show active' : '' }}" id="article-tab-pane"
                role="tabpanel" aria-labelledby="article-tab" tabindex="0">
                <div class="search_result">
                    <ul class="pl_0">
                        @if (count($articles))
                            @foreach ($articles as $article)
                                <li class="search-result-item ml-5">
                                    <div class="d-flex align-items-stretch">
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            @php($slug = App\Model\ProductCategory::find($article->product_category_id)->slug ?? '')
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('article-details', ['product_slug' => $slug, 'slug' => $article->title_slug]) }}">
                                                <span>
                                                    {{ App\Model\ProductCategory::find($article->product_category_id)->title ?? '' }}
                                                    ->
                                                </span>
                                                {{ App\Model\ArticleGroup::find($article->article_group_id)->title ?? '' }}
                                                ->
                                                {{ $article->title }}
                                            </a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="search-result-item ml-5">
                                <div>
                                    <span class="alert alert-danger">@lang('index.no_item_found')</span>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="tab-pane fade {{ $active == 'faqs' ? 'show active' : '' }}" id="faq-tab-pane" role="tabpanel"
                aria-labelledby="faq-tab" tabindex="0">
                <div class="search_result">
                    <ul class="pl_0">
                        @if (count($faqs))
                            @foreach ($faqs as $faq)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('home') }}#faq-section">
                                                {{ $faq->question ?? '' }}
                                            </a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                            @foreach ($faqs as $faq)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('home') }}#faq-section">
                                                {{ $faq->question ?? '' }}
                                            </a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                            @foreach ($faqs as $faq)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('home') }}#faq-section">
                                                {{ $faq->question ?? '' }}
                                            </a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                            @foreach ($faqs as $faq)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('home') }}#faq-section">
                                                {{ $faq->question ?? '' }}
                                            </a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="search-result-item ml-5">
                                <div>
                                    <span class="alert alert-danger">@lang('index.no_item_found')</span>
                                </div>
                            </li>
                        @endif


                    </ul>
                </div>
            </div>
            <div class="tab-pane fade {{ $active == 'blogs' ? 'show active' : '' }}" id="blog-tab-pane"
                role="tabpanel" aria-labelledby="blog-tab" tabindex="0">
                <div class="search_result">
                    <ul class="pl_0">
                        @if (count($blogs))
                            @foreach ($blogs as $blog)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('blog-details', $blog->slug) }}">{{ $blog->title }}</a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="search-result-item ml-5">
                                <div>
                                    <span class="alert alert-danger">@lang('index.no_item_found')</span>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>


            <div class="tab-pane fade {{ $active == 'pages' ? 'show active' : '' }}" id="page-tab-pane"
                role="tabpanel" aria-labelledby="page-tab" tabindex="0">
                <div class="search_result">
                    <ul class="pl_0">
                        @if (count($pages))
                            @foreach ($pages as $page)
                                <li class="search-result-item ml-5">
                                    <div>
                                        <span>
                                            <iconify-icon icon="ph:link-light" width="18"></iconify-icon></span>
                                        <small>
                                            <a target="_blank" class="search_title_result text-decoration-none"
                                                href="{{ route('page-details', $page->slug) }}">{{ $page->title }}</a>
                                        </small>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="search-result-item ml-5">
                                <div>
                                    <span class="alert alert-danger">@lang('index.no_item_found')</span>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="tab-pane fade" id="ai-tab-pane"
                role="tabpanel" aria-labelledby="ai-tab" tabindex="0">
                <div class="search_result">
                    <h4 class="text-primary">@lang('index.reply_from_ai')</h4>
                    <p>
                        {{ $aiData }}
                    </p>
                </div>
            </div>
        </div>
    @elseif($aiData != null)
        <div class="search_result">
            <h4 class="text-primary">@lang('index.ai_found_reply')</h4>
            <p>
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
