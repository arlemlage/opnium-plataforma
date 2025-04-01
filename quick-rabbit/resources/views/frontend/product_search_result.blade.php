@if(count($products))
    <div class="article-card px-sm-3 ">
        <ul class="list-unstyled text-start">
            @foreach ($products as $product)
                <li>
                    <a class="text-truncate product-category-list search-result-title"
                        href="{{ route('product-wise-article-groups',$product->slug) }}" data-id="{{ $product->id }}">{{ $product->title }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <div class="alert alert-danger">@lang('index.no_item_found')</div>
@endif