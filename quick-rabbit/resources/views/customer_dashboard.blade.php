@extends('layouts.app')
@section('content')
<section class="main-content-wrapper">
    <h2 class="d-none">&nbsp;</h2>
    @if(authUserType() != 4)
    <div class="alert-wrapper">
        {{ alertMessage() }}
    </div>
    @endif
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 class="top-left-header mb-0 mt-2">
                    @lang('index.profile')/@lang('index.home')
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.home')])
        </div>
    </section>

    <div class="row">
        <div class="col-md-4 col-lg-3 mt-2">
            <div class="user-profile-card">
                <div class="d-flex align-items-center">
                    <div class="media-size-email">
                        @if((Auth::user()->image != null) AND (file_exists(Auth::user()->image)))
                        <img width="52" height="52" class="me-3 rounded-circle" src="{{ asset(Auth::user()->image) }}" alt="Image">
                        @else
                        <img width="52" height="52" class="me-3 rounded-circle" src="{{ asset('assets/images/avatar.png') }}" alt="Image">
                        @endif
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="m-0">{{ Auth::check() ? Auth::user()->full_name : "Admin" }}</h5>
                        <p class="text-muted my-1 font-weight-bolder text-lowercase text-email">
                            {{ Auth::check() ? Auth::user()->email : "Admin" }}
                        </p>
                    </div>
                </div>
                <!-- End User Profile Info -->

                <ul class="menu-list">
                    <li class="item">
                        <a href="{{ route('edit-profile') }}">
                            <span class="iconbg badge-light-primary">
                                <iconify-icon icon="solar:user-bold-duotone" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                @lang('index.change_profile')
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('change-password') }}">
                            <span class="iconbg badge-light-success">
                                <iconify-icon icon="solar:key-bold-duotone" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                @lang('index.change_password')
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('set-security-question') }}">
                            <span class="iconbg badge-light-danger">
                                <iconify-icon icon="solar:info-circle-bold-duotone" width="20"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                @lang('index.set_security_question')
                            </span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="{{ route('logout') }}">
                            <span class="iconbg badge-light-info">
                                <iconify-icon icon="solar:logout-2-bold-duotone" width="18"></iconify-icon>
                            </span>
                            <span class="user-profile-card-text">
                                @lang('index.logout')
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End User Profile -->
        <div class="col-md-8 col-lg-9 mt-2">
            <div class="table-card">
                <h2 class="top-left-header mb-0 mt-2 ms-3">@lang('index.open_tickets')</h2>
                <div class="card-body table-responsive profile_min_height">
                    <input type="hidden" class="datatable_name" data-title="@lang('index.ticket')" data-id_name="datatable">
                    <table id="datatable" class="table table-responsive">
                        <thead>
                            <tr>
                                <th class="w-5">@lang('index.sn')</th>
                                <th class="w-10">@lang('index.ticket_id')</th>
                                <th class="w-20">@lang('index.title')</th>
                                <th class="w-10">@lang('index.product_category')</th>
                                <th class="w-10">@lang('index.customer')</th>
                                <th class="w-10">@lang('index.last_commented_by')</th>
                                <th class="w-10">@lang('index.action')</th>
                            </tr>
                        </thead>
                        @php
                        $results = \App\Model\Ticket::with('getProductCategory', 'getCustomer')->ticketCondition()->where('del_status', 'Live')->where('status', 1)->get();
                        @endphp
                        <tbody>
                            @foreach($results as $data)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $data->ticket_no ?? "" }}</td>
                                <td title="{{  $data->title ?? '' }}">
                                    <a title="{{ $data->title }}" class="gray-color text-decoration-none {{ (needAction($data->id) ? "text-bold" :'') }}" href="{{ url('ticket/'.encrypt_decrypt($data->id, 'encrypt')) }}">
                                        {{ Str::limit($data->title,40,'...') ?? "" }}
                                    </a>

                                </td>
                                <td>
                                    {{ $data->getProductCategory->title ?? "" }}
                                </td>
                                <td>
                                    {{ $data->getCustomer->full_name ?? "" }}
                                </td>
                                <td>
                                    {{ $data->last_comment ?? "" }}
                                </td>
                                <td>
                                    <a href="{{ (url('ticket/'.encrypt_decrypt($data->id, 'encrypt'))) }}" class="btn bg-blue-btn mt-2 ms-md-0 mt-md-2 mt-sm-0 ms-sm-2 mt-lg-0 ms-lg-2">
                                        <iconify-icon icon="ic:baseline-reply" width="22"></iconify-icon>@lang('index.reply')
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Tickets Table -->
    </div>
</section>
@endsection
@push('js')
@include('layouts.data_table_script')
@endpush