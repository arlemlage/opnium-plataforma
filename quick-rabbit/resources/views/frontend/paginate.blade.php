@if ($paginator->hasPages())
    <div class="row justify-content-center blog-page-footer-btn">
        <div class="col-12 col-sm-12 col-lg-6 mx-auto d-flex justify-content-center blog-page-footer-btn-wrap">
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
            @endphp
            <div class="paginate_wrapper d-flex">
                <!-- First Page -->
                <a href="{{ $paginator->url(1) }}" class="list-item {{ $currentPage == 1 ? 'active' : '' }}">
                    1
                </a>

                <!-- Show next pages dynamically if not the first 3 pages -->
                @if ($currentPage > 3)
                    <a href="#" class="list-item text">...</a>
                @endif

                <!-- Dynamic Pagination for 3 pages -->
                @for ($i = max(2, $currentPage - 1); $i <= min($currentPage + 1, $lastPage - 1); $i++)
                    <a href="{{ $paginator->url($i) }}" class="list-item {{ $currentPage == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>
                @endfor

                <!-- Ellipsis before the last page if needed -->
                @if ($currentPage < $lastPage - 2)
                    <a href="#" class="list-item text">...</a>
                @endif

                <!-- Last Page -->
                <a href="{{ $paginator->url($lastPage) }}"
                    class="list-item {{ $currentPage == $lastPage ? 'active' : '' }}">
                    {{ $lastPage }}
                </a>

                <!-- Next Page Button -->
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="list-item">
                        <svg width="17" height="17" viewBox="0 0 17 17" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M1.5 8.5C1.5 8.36739 1.55268 8.24021 1.64645 8.14645C1.74021 8.05268 1.86739 8 2 8H13.793L10.646 4.854C10.5521 4.76011 10.4994 4.63277 10.4994 4.5C10.4994 4.36722 10.5521 4.23988 10.646 4.146C10.7399 4.05211 10.8672 3.99937 11 3.99937C11.1328 3.99937 11.2601 4.05211 11.354 4.146L15.354 8.146C15.4006 8.19244 15.4375 8.24762 15.4627 8.30836C15.4879 8.36911 15.5009 8.43423 15.5009 8.5C15.5009 8.56577 15.4879 8.63089 15.4627 8.69163C15.4375 8.75238 15.4006 8.80755 15.354 8.854L11.354 12.854C11.2601 12.9479 11.1328 13.0006 11 13.0006C10.8672 13.0006 10.7399 12.9479 10.646 12.854C10.5521 12.7601 10.4994 12.6328 10.4994 12.5C10.4994 12.3672 10.5521 12.2399 10.646 12.146L13.793 9H2C1.86739 9 1.74021 8.94732 1.64645 8.85355C1.55268 8.75978 1.5 8.63261 1.5 8.5Z"
                                fill="#1E1D1D" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
