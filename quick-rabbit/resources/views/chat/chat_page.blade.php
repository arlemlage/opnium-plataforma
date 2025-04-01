@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/chat/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/chat/css/responsive.css') }}">
@endpush

@section('content')
    <input type="hidden" class="auth-user-id" value="{{ Auth::user()->id }}">
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <section class="alert-wrapper">
            {{ alertMessage() }}
        </section>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mb-0">{{ __('index.chat') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="{{ __('index.chat') }}"
                        data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.chat')])
            </div>
        </section>
        @if (App\Model\ChatSetting::first()->chat_widget_show == 'on')
            <div class="container-fluid chat_div_header">
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <div class="card chat-left-box">
                            <div class="chat-left-header">
                                <div class="search-category">

                                    <!-- Button trigger modal -->
                                    @if (authUserRole() == 3 && App\Model\ChatGroup::where('created_by', Auth::user()->id)->doesntExist())
                                        <button type="button" class="btn bg-blue-btn width-100-p pb-1"
                                            data-bs-toggle="modal"
                                            data-bs-target="#customer-create-group_{{ Auth::user()->id }}">
                                            @lang('index.open_new_chat')
                                        </button>
                                        <br>
                                    @endif
                                    @if (authUserRole() != 3)
                                        <ul class="nav-wrap-c nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active d-flex gap-1" id="pills-customer-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-customer" type="button"
                                                    role="tab" aria-controls="pills-customer" aria-selected="false">
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_721_1380)">
                                                            <path
                                                                d="M8.0019 8.3084C10.2876 8.3084 12.1561 6.43993 12.1561 4.1542C12.1561 1.86847 10.2876 0 8.0019 0C5.71617 0 3.84774 1.86847 3.84774 4.1542C3.84774 6.43993 5.71621 8.3084 8.0019 8.3084ZM15.1312 11.6281C15.0223 11.356 14.8772 11.102 14.714 10.8662C13.8795 9.63264 12.5915 8.81632 11.1403 8.61677C10.9589 8.59865 10.7593 8.6349 10.6142 8.74375C9.85228 9.30611 8.94527 9.59635 8.00194 9.59635C7.0586 9.59635 6.15159 9.30611 5.38968 8.74375C5.24454 8.6349 5.04499 8.58049 4.8636 8.61677C3.41235 8.81632 2.10624 9.63264 1.28992 10.8662C1.12666 11.102 0.98152 11.3742 0.872701 11.6281C0.818291 11.737 0.836416 11.864 0.890826 11.9728C1.03596 12.2268 1.21735 12.4808 1.38062 12.6984C1.63458 13.0431 1.90669 13.3515 2.2151 13.6417C2.46905 13.8957 2.7593 14.1315 3.04958 14.3674C4.48267 15.4377 6.20603 16 7.98381 16C9.76159 16 11.485 15.4376 12.918 14.3674C13.2083 14.1497 13.4985 13.8957 13.7525 13.6417C14.0428 13.3515 14.333 13.0431 14.587 12.6984C14.7684 12.4626 14.9317 12.2268 15.0768 11.9728C15.1675 11.864 15.1856 11.7369 15.1312 11.6281Z"
                                                                fill="black" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_721_1380">
                                                                <rect width="16" height="16" fill="black" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>

                                                    </i>@lang('index.customer')
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link d-flex gap-1" id="pills-agent-tab"
                                                    data-bs-toggle="pill" data-bs-target="#pills-agent" type="button"
                                                    role="tab" aria-controls="pills-agent" aria-selected="true"><svg
                                                        width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M16.418 5.31072H15.3133C14.3738 3.07992 12.305 1.45876 9.92338 1.14914C7.5632 0.83449 5.24422 1.74293 3.72709 3.57161C3.2811 4.10926 2.92732 4.69377 2.66829 5.31072H1.58203C0.709664 5.31072 0 6.02039 0 6.89276V9.00213C0 9.8745 0.709664 10.5842 1.58203 10.5842H3.74769L3.52111 9.89253C2.8614 7.8779 3.23272 5.81951 4.53923 4.24521C5.82311 2.69767 7.78363 1.93189 9.78641 2.19454C11.9045 2.47045 13.743 3.96835 14.4714 6.0116L14.4758 6.02345C14.593 6.33451 14.6759 6.65743 14.723 6.98648C14.8811 7.97269 14.791 8.97225 14.463 9.8771L14.4606 9.88339C13.6464 12.1952 11.4564 13.7482 9.0103 13.7482C8.13224 13.7482 7.41797 14.4579 7.41797 15.3303C7.41797 16.2026 8.12763 16.9123 9 16.9123C9.87237 16.9123 10.582 16.2026 10.582 15.3303V14.619C12.6877 14.1186 14.4563 12.6259 15.3064 10.5841H16.418C17.2903 10.5841 18 9.87446 18 9.0021V6.89272C18 6.02035 17.2903 5.31072 16.418 5.31072Z"
                                                            fill="black" />
                                                        <path
                                                            d="M4.25391 11.6388V12.6935H9C11.6171 12.6935 13.7461 10.5645 13.7461 7.94739C13.7461 5.33025 11.6171 3.20129 9 3.20129C6.38286 3.20129 4.25391 5.33025 4.25391 7.94739C4.25359 9.01063 4.61052 10.0431 5.26739 10.8792C5.1402 11.3236 4.73439 11.6388 4.25391 11.6388ZM10.582 7.42004H11.6367V8.47473H10.582V7.42004ZM8.47266 7.42004H9.52734V8.47473H8.47266V7.42004ZM6.36328 7.42004H7.41797V8.47473H6.36328V7.42004Z"
                                                            fill="black" />
                                                    </svg>
                                                    @lang('index.agent')</button>
                                            </li>
                                        </ul>
                                    @endif

                                    <div class="search-box-wrap">
                                        <div class="search-box">
                                            <input placeholder="Search..." class="border-0" type="search" name=""
                                                id="search-agent-group">
                                            <button class="border-0 bg-transparent d-flex align-items-center"
                                                type="submit"><iconify-icon icon="material-symbols:search"
                                                    width="22"></iconify-icon></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="chat-left-body">
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-customer" role="tabpanel"
                                        aria-labelledby="pills-customer-tab" tabindex="0">
                                        @include('chat.group_list')
                                    </div>
                                    <div class="tab-pane fade" id="pills-agent" role="tabpanel"
                                        aria-labelledby="pills-agent-tab" tabindex="0">
                                        @include('chat.user_list')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 px-0 message_box" id="message_box">

                    </div>
                </div>
            </div>
        @else
            <div class="container-fluid chat_div_header">
                <div class="row">
                    <h2>@lang('index.chat_disabled')</h2>
                </div>
            </div>
        @endif
    </section>


    <!-- Modal -->
    <div class="modal fade" id="customer-create-group_{{ Auth::user()->id }}" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('index.open_new_chat')</h1>
                    <button type="button" class="btn-close close_modal_customer" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <form action="{{ route('create-group') }}" method="POST" id="customer-group-create-form"
                    class="needs-validation" novalidate>
                    <div class="modal-body" id="customer-group-create-body_{{ Auth::id() }}">
                        @csrf
                        <div class="form-group">
                            <label for="product_id">{{ __('index.product_category') ?? 'Product' }}{!! starSign() !!}</label>
                            
                            <select name="product_id" id="product_id" class="form-control select2">
                                <option value="">{{ __('index.select_product') ?? 'Select Product' }}</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue-btn create-group" id="open-chat">
                            <span class="me-2 chat-add-edit-spin d-none"><iconify-icon icon="la:spinner"
                                    width="22"></iconify-icon></span>
                            @lang('index.submit')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="forward-chat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">@lang('index.forward_chat')</h1>
                    <button type="button " class="btn-close btn-danger" data-bs-dismiss="modal"
                        aria-label="Close"><iconify-icon icon="uil:times" width="22"></iconify-icon></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="agent_id">{{ __('index.admin_agent') ?? 'Agent' }}{!! starSign() !!}</label>
                        <select name="agent_id" id="agent_id" class="form-control select2">
                            <option value="">{{ __('index.select') }}</option>
                            @foreach (\App\Model\User::where('id', '!=', Auth::user()->id)->where('role_id', '!=', 3)->get() as $agent)
<option value="{{ $agent->id }}">{{ $agent->full_name }}</option>
@endforeach
              </select>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-blue-btn" id="forward-chat-button">
          <span class="me-2 forward-chat-add-edit-spin d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>
          @lang('index.submit')
        </button>
      </div>
    </div>
  </div>
</div>



@endsection

@push('js')
    <script src="{{ asset('frequent_changing/chat/js/chat_page.js') }}"></script>
@endpush