@if(count($groups))
<div class="row g-4 masonary-wrapper">
    <!-- Card -->
    @foreach($groups as $key => $group)
    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
        <div class="card article-card">
            <div class="card-body">
                <h5>{{ $group->title }}</h5>

                <!-- List -->
                <ul class="mb-4 list-unstyled">
                    @if(count($group->articles))
                        @foreach($group->articles as $article)
                            @if($loop->index < 5)
                                <li>
                                    <a class="text-truncate" href="{{ route('article-details',$article->title_slug) }}">{{ $article->title }}</a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <li>
                            <span class="alert alert-danger">
                                @lang('index.no_article_found')
                            </span>
                        </li>
                    @endif
                </ul>
                @if(sizeof($group->articles) > 5)
                    <a href="{{ route('articlesssss',$group->slug) }}" class="btn btn-primary btn-sm">
                        {{ __('index.view_all') }} 
                        <i class="bi bi-arrow-right"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<div class="row g-4 masonary-wrapper">
    <div class="col-12">
        <div class="alert alert-primary" role="alert">
            @lang('index.no_item_found')
        </div>
    </div>
</div>
@endif