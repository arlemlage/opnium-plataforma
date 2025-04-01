@extends(layout())
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/magnific-popup.css') }}">
@endpush
@section('menu')
    @include('frontend.menu_others')
@endsection

@section('footer_menu')
    @include('frontend.others_footer')
@endsection
@section('content')
    <div class="breadcrumb-wrapper">
        <div class="container">
            <div class="row g-4 align-items-center">
                <h2 class="mb-0">@lang('index.forum')</h2>
                <ol class="breadcrumb mb-0 justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">@lang('index.home')</a></li>
                    <li class="breadcrumb-item active" aria-current="page">@lang('index.forum_details')</li>
                </ol>
            </div>
        </div>
    </div>
    </div>

    <div class="forum-page-wrapper">
        <div class="container">
            <div class="row forum-page-wrapper-row justify-content-between">
                <div class="col-12 col-md-7 col-xl-7 left_card_col">
                    <div class="forum-comment-card">
                        <div class="forum-card-wrapper forum-comment-card-wrapper">
                            <div class="forum-card">
                                <div class="d-flex align-items-center justify-content-between forum-card-row">
                                    <?php
                                    $check_login_class = 'login-alert';
                                    if (Auth::check()) {
                                        $check_login_class = '';
                                    }
                                    ?>
                                    <!-- Up Down Vote -->
                                    <div class="up-down-vote">
                                        @if (Auth::check())
                                            <a class="active like_unlike_btn vote_btn" data-status="1"
                                                data-id="{{ encrypt_decrypt($forum->id, 'encrypt') }}" href="#">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_162_1633)">
                                                        <path
                                                            d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM8.5 5C8.5 4.86739 8.44732 4.74021 8.35355 4.64645C8.25979 4.55268 8.13261 4.5 8 4.5C7.86739 4.5 7.74021 4.55268 7.64645 4.64645C7.55268 4.74021 7.5 4.86739 7.5 5V8H4.5C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H7.5V12C7.5 12.1326 7.55268 12.2598 7.64645 12.3536C7.74021 12.4473 7.86739 12.5 8 12.5C8.13261 12.5 8.25979 12.4473 8.35355 12.3536C8.44732 12.2598 8.5 12.1326 8.5 12V9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H8.5V5Z"
                                                            fill="white" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_162_1633">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="translate(0 0.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </a>
                                            <span>{{ $forum->total_like_counter }}</span>
                                            <a href="#" class="like_unlike_btn vote_btn" data-status="2"
                                                data-id="{{ encrypt_decrypt($forum->id, 'encrypt') }}">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM4.5 8C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H4.5Z"
                                                        fill="white" />
                                                </svg>

                                            </a>
                                        @endif
                                        @guest
                                            @php(session()->put('is_like_forum', 1))
                                            <a class="active like_unlike_btn" href="{{ route('customer.login') }}">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_162_1633)">
                                                        <path
                                                            d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM8.5 5C8.5 4.86739 8.44732 4.74021 8.35355 4.64645C8.25979 4.55268 8.13261 4.5 8 4.5C7.86739 4.5 7.74021 4.55268 7.64645 4.64645C7.55268 4.74021 7.5 4.86739 7.5 5V8H4.5C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H7.5V12C7.5 12.1326 7.55268 12.2598 7.64645 12.3536C7.74021 12.4473 7.86739 12.5 8 12.5C8.13261 12.5 8.25979 12.4473 8.35355 12.3536C8.44732 12.2598 8.5 12.1326 8.5 12V9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H8.5V5Z"
                                                            fill="white" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_162_1633">
                                                            <rect width="16" height="16" fill="white"
                                                                transform="translate(0 0.5)" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                            </a>
                                            <span>{{ $forum->total_like_counter }}</span>
                                            <a href="{{ route('customer.login') }}" class="like_unlike_btn">
                                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM4.5 8C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H4.5Z"
                                                        fill="white" />
                                                </svg>

                                            </a>
                                        @endguest
                                    </div>
                                    <div class="right_side">
                                        <div class="d-flex">
                                            <div class="content">
                                                <div class="top_content">
                                                    <div class="content-text">
                                                        <div class="thumbnail">
                                                            @if ($forum->user_id != null)
                                                                <img src="{{ asset($forum->user->image) }}" alt="">
                                                            @else
                                                                <img src="{{ asset('assets/images/avator.jpg') }}"
                                                                    alt="">
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <span class="name">{{ $forum->user->full_name ?? '' }}</span>
                                                            <span
                                                                class="role_span">{{ $forum->user->type_name ?? '' }}</span>
                                                            <span>asked
                                                                &nbsp;{{ $forum->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                    <a class="d-block title"
                                                        href="{{ route('forum-comment', $forum->slug) }}">{{ $forum->subject ?? '' }}</a>
                                                </div>
                                                <p>
                                                    {{ $forum->description ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="d-flex meta-data">
                                            <p class="mb-0"><i class="bi bi-chat"></i>
                                                {{ $forum->comments->count() ?? 0 }}&nbsp;@lang('index.replies')</p>
                                            <p class="mb-0"><i class="bi bi-eye"></i>
                                                {{ $forum->view_count ?? 0 }}&nbsp;@lang('index.views')
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                        </div>
                        <div class="reply-list">
                            <!-- Single Reply Item -->
                            @if (count($forum->comments))
                                @foreach ($forum->comments as $comment)
                                    <div class="forum-card">
                                        <div class="forum-card-row w-100">
                                            <?php
                                            $check_login_class = 'login-alert';
                                            if (Auth::check()) {
                                                $check_login_class = '';
                                            }
                                            ?>
                                            <div class="d-flex left_card_forum">
                                                <div class="up-down-vote">
                                                    @if (Auth::check())
                                                        <a class="active like_unlike_btn vote_btn" data-status="1"
                                                            data-id="{{ encrypt_decrypt($comment->id, 'encrypt') }}"
                                                            href="#">
                                                            <svg width="16" height="17" viewBox="0 0 16 17"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_162_1633)">
                                                                    <path
                                                                        d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM8.5 5C8.5 4.86739 8.44732 4.74021 8.35355 4.64645C8.25979 4.55268 8.13261 4.5 8 4.5C7.86739 4.5 7.74021 4.55268 7.64645 4.64645C7.55268 4.74021 7.5 4.86739 7.5 5V8H4.5C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H7.5V12C7.5 12.1326 7.55268 12.2598 7.64645 12.3536C7.74021 12.4473 7.86739 12.5 8 12.5C8.13261 12.5 8.25979 12.4473 8.35355 12.3536C8.44732 12.2598 8.5 12.1326 8.5 12V9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H8.5V5Z"
                                                                        fill="white" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_162_1633">
                                                                        <rect width="16" height="16"
                                                                            fill="white" transform="translate(0 0.5)" />
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>

                                                        </a>
                                                        <span>{{ $comment->total_like_counter ?? 0 }}</span>
                                                        <a href="#" class="like_unlike_btn vote_btn"
                                                            data-status="2"
                                                            data-id="{{ encrypt_decrypt($comment->id, 'encrypt') }}">
                                                            <svg width="16" height="17" viewBox="0 0 16 17"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM4.5 8C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H4.5Z"
                                                                    fill="white" />
                                                            </svg>

                                                        </a>
                                                    @endif
                                                    @guest
                                                        @php(session()->put('is_like_forum', 1))
                                                        <a class="active like_unlike_btn"
                                                            href="{{ route('customer.login') }}">
                                                            <svg width="16" height="17" viewBox="0 0 16 17"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_162_1633)">
                                                                    <path
                                                                        d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM8.5 5C8.5 4.86739 8.44732 4.74021 8.35355 4.64645C8.25979 4.55268 8.13261 4.5 8 4.5C7.86739 4.5 7.74021 4.55268 7.64645 4.64645C7.55268 4.74021 7.5 4.86739 7.5 5V8H4.5C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H7.5V12C7.5 12.1326 7.55268 12.2598 7.64645 12.3536C7.74021 12.4473 7.86739 12.5 8 12.5C8.13261 12.5 8.25979 12.4473 8.35355 12.3536C8.44732 12.2598 8.5 12.1326 8.5 12V9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H8.5V5Z"
                                                                        fill="white" />
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_162_1633">
                                                                        <rect width="16" height="16" fill="white"
                                                                            transform="translate(0 0.5)" />
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>

                                                        </a>
                                                        <span>{{ $comment->total_like_counter ?? 0 }}</span>
                                                        <a href="{{ route('customer.login') }}" class="like_unlike_btn">
                                                            <svg width="16" height="17" viewBox="0 0 16 17"
                                                                fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M16 8.5C16 10.6217 15.1571 12.6566 13.6569 14.1569C12.1566 15.6571 10.1217 16.5 8 16.5C5.87827 16.5 3.84344 15.6571 2.34315 14.1569C0.842855 12.6566 0 10.6217 0 8.5C0 6.37827 0.842855 4.34344 2.34315 2.84315C3.84344 1.34285 5.87827 0.5 8 0.5C10.1217 0.5 12.1566 1.34285 13.6569 2.84315C15.1571 4.34344 16 6.37827 16 8.5ZM4.5 8C4.36739 8 4.24021 8.05268 4.14645 8.14645C4.05268 8.24021 4 8.36739 4 8.5C4 8.63261 4.05268 8.75979 4.14645 8.85355C4.24021 8.94732 4.36739 9 4.5 9H11.5C11.6326 9 11.7598 8.94732 11.8536 8.85355C11.9473 8.75979 12 8.63261 12 8.5C12 8.36739 11.9473 8.24021 11.8536 8.14645C11.7598 8.05268 11.6326 8 11.5 8H4.5Z"
                                                                    fill="white" />
                                                            </svg>

                                                        </a>
                                                    @endguest
                                                </div>
                                                <div class="right_side">
                                                    <div class="">
                                                        <div class="content">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="content-text">
                                                                    <div class="thumbnail">
                                                                        @if ($comment->user_id != null)
                                                                            <img src="{{ asset($comment->user->image) }}"
                                                                                alt="">
                                                                        @else
                                                                            <img src="{{ asset('assets/images/avator.jpg') }}"
                                                                                alt="">
                                                                        @endif
                                                                    </div>
                                                                    <div>
                                                                        <span
                                                                            class="name name_forum_comment">{{ $comment->user->full_name ?? '' }}</span>
                                                                        <span
                                                                            class="role_span">{{ $comment->user->type_name ?? '' }}</span>
                                                                        <span>replied
                                                                            &nbsp;{{ $comment->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="content_section">
                                                                <div class="text_image_content_forum">
                                                                    <p>
                                                                        {!! $comment->comment ?? '' !!}
                                                                    </p>
                                                                    @if ($comment->attachment != null)
                                                                        @if (checkFileType($comment->attachment) == 'Image')
                                                                            <a href="#photo{{ $loop->index }}"
                                                                                class="popup-with-move-anim c-btn btn-fill py-2 opacity-hover attachment_img">
                                                                                <img src="{{ baseUrl() }}/{{ rootFilePath() }}forum/{{ $comment->attachment }}"
                                                                                    class="img-thumbnail" alt=""
                                                                                    width="150">
                                                                            </a>
                                                                            <div id="photo{{ $loop->index }}"
                                                                                class="zoom-anim-dialog mfp-hide mfp-custom-modal">
                                                                                <img src="{{ baseUrl() }}/{{ rootFilePath() }}forum/{{ $comment->attachment }}"
                                                                                    alt="" class="w-100">
                                                                            </div>
                                                                        @endif

                                                                        @if (checkFileType($comment->attachment) == 'PDF')
                                                                            <a href="{{ baseUrl() }}/{{ rootFilePath() }}forum/{{ $comment->attachment }}"
                                                                                class="attachment_img" target="_blank">
                                                                                <img src="{{ asset('assets/frontend/img/core-img/pdf_2.png') }}"
                                                                                    class="img-thumbnail" alt=""
                                                                                    width="150">
                                                                            </a>
                                                                        @endif

                                                                        @if (checkFileType($comment->attachment) == 'ZIP')
                                                                            <a href="{{ baseUrl() }}/{{ rootFilePath() }}forum/{{ $comment->attachment }}"
                                                                                class="attachment_img" target="_blank">
                                                                                <img src="{{ asset('assets/frontend/img/core-img/zip-folder.png') }}"
                                                                                    class="img-thumbnail" alt=""
                                                                                    width="150">
                                                                            </a>
                                                                        @endif
                                                                    @endif
                                                                </div>
                                                                <button class="reply_now" id="reply_btn"
                                                                    data-name="{{ $comment->user->full_name }}">
                                                                    <svg width="14" height="14"
                                                                        viewBox="0 0 14 14" fill="none"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <g clip-path="url(#clip0_235_910)">
                                                                            <path
                                                                                d="M7.01811 10.4125L3.02111 7.54252C2.92718 7.48672 2.84938 7.40745 2.79534 7.31249C2.7413 7.21753 2.71289 7.11015 2.71289 7.0009C2.71289 6.89164 2.7413 6.78426 2.79534 6.68931C2.84938 6.59435 2.92718 6.51508 3.02111 6.45927L7.01811 3.58752C7.11339 3.53148 7.2218 3.50165 7.33234 3.50105C7.44288 3.50045 7.55161 3.5291 7.64749 3.58411C7.74337 3.63912 7.823 3.71851 7.87827 3.81424C7.93355 3.90996 7.96252 4.01861 7.96224 4.12915V5.25002C9.27474 5.25002 13.2122 5.25002 14.0872 12.25C11.8997 8.31252 7.96224 8.75002 7.96224 8.75002V9.8709C7.96224 10.3609 7.43199 10.6566 7.01811 10.4134V10.4125Z"
                                                                                fill="#727272" />
                                                                            <path
                                                                                d="M4.57856 3.75639C4.61276 3.80268 4.63749 3.85525 4.65134 3.9111C4.66519 3.96696 4.66788 4.02499 4.65926 4.08189C4.65065 4.13878 4.63089 4.19342 4.60113 4.24267C4.57137 4.29192 4.53218 4.33481 4.48581 4.36889L0.975314 6.95189L0.938564 6.97639C0.919539 6.98783 0.903795 7.00399 0.892865 7.02331C0.881936 7.04263 0.876191 7.06445 0.876191 7.08664C0.876191 7.10884 0.881936 7.13066 0.892865 7.14998C0.903795 7.1693 0.919539 7.18546 0.938564 7.1969L0.975314 7.2214L4.48581 9.80614C4.53322 9.83976 4.57346 9.88249 4.60417 9.93183C4.63488 9.98117 4.65545 10.0361 4.66468 10.0935C4.67391 10.1509 4.67162 10.2095 4.65794 10.266C4.64425 10.3225 4.61945 10.3757 4.58498 10.4225C4.55051 10.4693 4.50706 10.5087 4.45718 10.5386C4.40729 10.5684 4.35196 10.588 4.29442 10.5961C4.23689 10.6043 4.17829 10.601 4.12207 10.5863C4.06584 10.5716 4.0131 10.5458 3.96694 10.5105L0.472189 7.93889C0.327709 7.84871 0.208557 7.72324 0.12595 7.5743C0.0433437 7.42535 0 7.25784 0 7.08752C0 6.9172 0.0433437 6.74969 0.12595 6.60074C0.208557 6.4518 0.327709 6.32633 0.472189 6.23614L3.96694 3.66364C4.06035 3.59486 4.17726 3.56598 4.29196 3.58338C4.40665 3.60077 4.50975 3.663 4.57856 3.75639Z"
                                                                                fill="#727272" />
                                                                        </g>
                                                                        <defs>
                                                                            <clipPath id="clip0_235_910">
                                                                                <rect width="14" height="14"
                                                                                    fill="white" />
                                                                            </clipPath>
                                                                        </defs>
                                                                    </svg>

                                                                    @lang('index.replay')
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="reply-form forum-reply-form">
                        <h3 class="comment-title">@lang('index.write_your_ans')</h3>
                        @if (Session::has('message'))
                            <div class="alert alert-{{ Session::get('type') ?? 'info' }} alert-dismissible fade show"
                                id="focused-div">
                                <div class="alert-body">
                                    <span><i class="m-right bi bi-check"></i>
                                        {{ Session::get('message') }}</span>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <form action="{{ route('post-comment') }}" method="POST" id="submit-comment"
                            enctype="multipart/form-data">
                            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        @error('comment')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        @error('attachment')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                        <p class="text-danger d-none comment-max-error">
                                            @lang('index.comment_max_1000')
                                        </p>
                                        <div class="position-relative">
                                            <textarea name="comment" class="form-control" placeholder="@lang('index.write_your_ans')" id="comment" cols="30"
                                                rows="10">{{ old('comment') ?? (Session::get('comment') ?? '') }}</textarea>
                                            <input type="file" id="imageInput" name="attachment" class="d-none">
                                            <input type="hidden" name="replying_to" id="replying_to" value="">
                                            <div class="forum_text_area_icon">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex left_icon">
                                                        <button type="button" class="attatch_ment_icon">
                                                            <img src="{{ asset('assets/frontend/img/core-img/paperclip.svg') }}"
                                                                class="" alt="">
                                                        </button>
                                                        <span id="image_name_show"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="isCaptchaEnable" value="{{ isCaptchaEnable() }}">
                                        @if (isCaptchaEnable())
                                            <div class="form-group mt-3 mb-3">
                                                <div class="captcha-box d-flex align-items-center mb-3">
                                                    <canvas id="canvas"></canvas>
                                                    <a href="javascript:void(0)" id="change-code" class="reset-btn">
                                                        <img src="{{ asset('assets/frontend/img/core-img/repeat.svg') }}"
                                                            alt="">
                                                    </a>
                                                </div>

                                                <input name="code" class="form-control col-md-3 code-input-control"
                                                    id="code" placeholder="@lang('index.captcha_code')">
                                                <span id="captcha-error"
                                                    class="text-danger d-none">@lang('index.invalid_captcha_code')</span>
                                            </div>
                                        @endif
                                        <button class="gt-btn send_message_btn comment-submit-button"
                                            type="submit">@lang('index.post_comment')<span class="icon">
                                                <svg width="14" height="15" viewBox="0 0 14 15" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12.545 1.40324L10.4939 12.695C10.4649 12.9031 10.3694 13.0963 10.2218 13.2457C10.0741 13.3952 9.88214 13.493 9.67442 13.5245C9.4667 13.5561 9.25435 13.5198 9.06896 13.4209C8.88357 13.322 8.73505 13.166 8.64551 12.9759L6.39267 8.24091C6.38365 8.22375 6.37131 8.20854 6.35638 8.19618C6.34145 8.18381 6.32421 8.17453 6.30567 8.16886L1.37227 6.92424C1.17401 6.87371 0.995994 6.76365 0.862173 6.60889C0.728352 6.45413 0.645151 6.26209 0.623768 6.05861L0.620648 6.03291C0.596232 5.82634 0.637613 5.61733 0.738897 5.43565C0.840183 5.25396 0.996208 5.10887 1.18476 5.02102L11.1587 0.297653C11.3186 0.22318 11.4957 0.193633 11.671 0.212179C11.8464 0.230725 12.0133 0.296667 12.1541 0.402927C12.3063 0.516355 12.4237 0.670247 12.4928 0.847091C12.5619 1.02393 12.58 1.21663 12.545 1.40324Z"
                                                        fill="#5065E2" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-5 col-xl-5 right_card_col">
                    <div>
                        @if (Auth::check())
                            <a class="gt-btn ask_question_btn" href="{{ route('ask-question') }}">
                                @lang('index.ask_a_question')<i class="bi bi-arrow-right"></i></a>
                        @else
                            <a class="gt-btn ask_question_btn" href="{{ route('customer.login') }}">
                                @lang('index.ask_a_question')<i class="bi bi-arrow-right"></i></a>
                        @endif
                    </div>
                    <div class="card_question_tag">
                        <div class="top-question-card">
                            <h5>@lang('index.top_discussed_topic')</h5>
                            <div class="card-wrapper">
                                @foreach ($questions as $question)
                                    <div class="card-question">
                                        <div class="question-section">
                                            @include('frontend.svg.topic')
                                            <a href="{{ route('forum-comment', $question->slug) }}"
                                                class="question">{{ $question->subject ?? '' }}</a>
                                        </div>
                                        <div class="content-text">
                                            <div class="d-flex left-text">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_269_633)">
                                                        <path
                                                            d="M11 6C11 6.79565 10.6839 7.55871 10.1213 8.12132C9.55871 8.68393 8.79565 9 8 9C7.20435 9 6.44129 8.68393 5.87868 8.12132C5.31607 7.55871 5 6.79565 5 6C5 5.20435 5.31607 4.44129 5.87868 3.87868C6.44129 3.31607 7.20435 3 8 3C8.79565 3 9.55871 3.31607 10.1213 3.87868C10.6839 4.44129 11 5.20435 11 6Z"
                                                            fill="black" />
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M0 8C0 5.87827 0.842855 3.84344 2.34315 2.34315C3.84344 0.842855 5.87827 0 8 0C10.1217 0 12.1566 0.842855 13.6569 2.34315C15.1571 3.84344 16 5.87827 16 8C16 10.1217 15.1571 12.1566 13.6569 13.6569C12.1566 15.1571 10.1217 16 8 16C5.87827 16 3.84344 15.1571 2.34315 13.6569C0.842855 12.1566 0 10.1217 0 8ZM8 1C6.68178 1.00007 5.39037 1.37236 4.2744 2.07403C3.15844 2.77569 2.26328 3.77821 1.69196 4.96619C1.12065 6.15418 0.896386 7.47934 1.045 8.78916C1.19361 10.099 1.70905 11.3402 2.532 12.37C3.242 11.226 4.805 10 8 10C11.195 10 12.757 11.225 13.468 12.37C14.2909 11.3402 14.8064 10.099 14.955 8.78916C15.1036 7.47934 14.8794 6.15418 14.308 4.96619C13.7367 3.77821 12.8416 2.77569 11.7256 2.07403C10.6096 1.37236 9.31822 1.00007 8 1Z"
                                                            fill="black" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_269_633">
                                                            <rect width="16" height="16" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <span class="name">{{ $question->user->full_name ?? '' }}</span>
                                            </div>
                                            <div class="d-flex left-text">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_162_1779)">
                                                        <path
                                                            d="M9.625 5.6875C9.625 5.57147 9.67109 5.46019 9.75314 5.37814C9.83519 5.29609 9.94647 5.25 10.0625 5.25H10.9375C11.0535 5.25 11.1648 5.29609 11.2469 5.37814C11.3289 5.46019 11.375 5.57147 11.375 5.6875V6.5625C11.375 6.67853 11.3289 6.78981 11.2469 6.87186C11.1648 6.95391 11.0535 7 10.9375 7H10.0625C9.94647 7 9.83519 6.95391 9.75314 6.87186C9.67109 6.78981 9.625 6.67853 9.625 6.5625V5.6875Z"
                                                            fill="#727272" />
                                                        <path
                                                            d="M3.0625 0C3.17853 0 3.28981 0.0460936 3.37186 0.128141C3.45391 0.210188 3.5 0.321468 3.5 0.4375V0.875H10.5V0.4375C10.5 0.321468 10.5461 0.210188 10.6281 0.128141C10.7102 0.0460936 10.8215 0 10.9375 0C11.0535 0 11.1648 0.0460936 11.2469 0.128141C11.3289 0.210188 11.375 0.321468 11.375 0.4375V0.875H12.25C12.7141 0.875 13.1592 1.05937 13.4874 1.38756C13.8156 1.71575 14 2.16087 14 2.625V12.25C14 12.7141 13.8156 13.1592 13.4874 13.4874C13.1592 13.8156 12.7141 14 12.25 14H1.75C1.28587 14 0.840752 13.8156 0.512563 13.4874C0.184374 13.1592 0 12.7141 0 12.25V2.625C0 2.16087 0.184374 1.71575 0.512563 1.38756C0.840752 1.05937 1.28587 0.875 1.75 0.875H2.625V0.4375C2.625 0.321468 2.67109 0.210188 2.75314 0.128141C2.83519 0.0460936 2.94647 0 3.0625 0ZM0.875 3.5V12.25C0.875 12.4821 0.967187 12.7046 1.13128 12.8687C1.29538 13.0328 1.51794 13.125 1.75 13.125H12.25C12.4821 13.125 12.7046 13.0328 12.8687 12.8687C13.0328 12.7046 13.125 12.4821 13.125 12.25V3.5H0.875Z"
                                                            fill="#727272" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="clip0_162_1779">
                                                            <rect width="14" height="14" fill="white" />
                                                        </clipPath>
                                                    </defs>
                                                </svg>

                                                <span class="date">{{ $question->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="d-flex left-text">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14 7C14 7 11.375 2.1875 7 2.1875C2.625 2.1875 0 7 0 7C0 7 2.625 11.8125 7 11.8125C11.375 11.8125 14 7 14 7ZM1.02637 7C1.44881 6.35651 1.93547 5.75757 2.47887 5.21237C3.605 4.0845 5.145 3.0625 7 3.0625C8.855 3.0625 10.3941 4.0845 11.522 5.21237C12.0654 5.75757 12.5521 6.35651 12.9745 7C12.9243 7.07583 12.8675 7.15983 12.8039 7.252C12.5108 7.672 12.0776 8.232 11.522 8.78763C10.3941 9.9155 8.85413 10.9375 7 10.9375C5.14587 10.9375 3.60588 9.9155 2.478 8.78763C1.9346 8.24243 1.44881 7.64349 1.02637 7Z"
                                                        fill="#727272" />
                                                    <path
                                                        d="M7 4.8125C6.41984 4.8125 5.86344 5.04297 5.4532 5.4532C5.04297 5.86344 4.8125 6.41984 4.8125 7C4.8125 7.58016 5.04297 8.13656 5.4532 8.5468C5.86344 8.95703 6.41984 9.1875 7 9.1875C7.58016 9.1875 8.13656 8.95703 8.5468 8.5468C8.95703 8.13656 9.1875 7.58016 9.1875 7C9.1875 6.41984 8.95703 5.86344 8.5468 5.4532C8.13656 5.04297 7.58016 4.8125 7 4.8125ZM3.9375 7C3.9375 6.18777 4.26016 5.40882 4.83449 4.83449C5.40882 4.26016 6.18777 3.9375 7 3.9375C7.81223 3.9375 8.59118 4.26016 9.16551 4.83449C9.73984 5.40882 10.0625 6.18777 10.0625 7C10.0625 7.81223 9.73984 8.59118 9.16551 9.16551C8.59118 9.73984 7.81223 10.0625 7 10.0625C6.18777 10.0625 5.40882 9.73984 4.83449 9.16551C4.26016 8.59118 3.9375 7.81223 3.9375 7Z"
                                                        fill="#727272" />
                                                </svg>

                                                <span
                                                    class="meta">{{ $question->view_count ?? 0 }}&nbsp;@lang('index.views')
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="top-catagory-card">
                            <h5>@lang('index.popular_tags')</h5>

                            <div class="d-flex align-items-center flex-wrap">
                                @foreach ($top_cateogries as $category)
                                    <a
                                        href="{{ baseURL() . '/forum?product-category=' . encrypt_decrypt($category->id, 'encrypt') }}">{{ $category->title ?? '' }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>




@endsection

@push('js')
    <script src="{{ asset('assets/jquery-captcha/jquery-captcha.min.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js') }}" defer></script>
    <script src="{{ asset('assets/frontend/js/forum-comment.js') }}"></script>
@endpush
