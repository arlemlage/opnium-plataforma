@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/ticket.css') }}">
@endpush

@section('content')
    <input type="hidden" id="user_role_id" value="{{ auth()->user()->role_id }}">
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
        </section>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">{{ __('index.ticket_details') }}
                    </h3>
                </div>
                @include('layouts.breadcrumbs', [
                    'firstSection' => __('index.ticket'),
                    'secondSection' => __('index.ticket_details'),
                ])
            </div>
        </section>

        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card mb-3 ticket_details_card">
                    <div class="card-body flex-start p-0">

                        <div class="header-section mb-2">
                            <p class="ticket_id">
                                @lang('index.ticket_id') :
                                <span>{{ $obj->ticket_no ?? '' }}</span>
                                @if (needAction($obj->id))
                                    <span
                                        class="badge text-danger bg-light float-right text-capitalize me-2 fs-12">@lang('index.need_action')</span>
                                @endif
                            </p>
                            <p class="ticket_title">{{ $obj->title ?? '' }}</p>
                            <input type="hidden" name="category_id" id="category_id" class="get_this_category_id"
                                value="{{ $obj->getProductCategory->id }}">
                            <p class="ticket_category_title">
                                {{ !empty($obj->getProductCategory->title) ? $obj->getProductCategory->title : '' }}
                            </p>
                        </div>
                        <div class="mt-3">
                            <p class="ticket_content">
                                {!! !empty($obj->ticket_content) ? $obj->ticket_content : '' !!}
                            </p>

                            @if (count($obj->ticket_files))
                                <div class="file-section">
                                    <table class="table table-sm mt-2">
                                        <thead>
                                            <tr>
                                                <th class="w-10">@lang('index.sn')</th>
                                                <th class="w-50">@lang('index.title')</th>
                                                <th class="w-30">@lang('index.file_type')</th>
                                                <th class="ir_w_1_txt_center w-10">@lang('index.action')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($obj->ticket_files as $key => $file)
                                                @if (file_exists($file->file_path))
                                                    <?php $extension = pathinfo($file->file_path, PATHINFO_EXTENSION); ?>

                                                    <tr>
                                                        <td class="">{{ $key + 1 }}</td>
                                                        <td>{{ $file->file_title ?? '' }}</td>
                                                        <td> {{ $extension }} </td>
                                                        <td class="ir_txt_center">
                                                            <div class="d-inline-flex">
                                                                <a href="{{ url($file->file_path) }}" type="button"
                                                                    target="_blank"
                                                                    class="btn btn-sm bg-blue-btn float-right me-2"><iconify-icon
                                                                        icon="solar:eye-bold"
                                                                        width="14"></iconify-icon></a>
                                                                <a href="{{ url($file->file_path) }}" download
                                                                    type="button"
                                                                    class="btn btn-sm bg-blue-btn float-right"><iconify-icon
                                                                        icon="bytesize:download"
                                                                        width="14"></iconify-icon></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


                <!-- Show Ticket replies -->
                <input type="hidden" class="update_textarea_id_c" value="">
                <input type="hidden" class="update_textarea_id_a" value="">
                <div id="ticket_comment_box">
                    @foreach ($reply_comments as $r_comment)
                        @if ($r_comment->is_ai_replied == 1)
                            <div class="card mb-3 bg-admin">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-start">
                                        <div class="t_replier_img">
                                            <img src="{{ baseURL() }}/frequent_changing/images/ai_avatar.png"
                                                alt="AI">
                                        </div>
                                        <div class="t_reply_body ms-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="t_replier_name">
                                                    <h6>@lang('index.ai_generated_reply')</h6>
                                                    <p>{{ isset($r_comment->updated_at) ? $r_comment->updated_at->diffForHumans() . ' at ' . date('d F Y h:i A', strtotime($r_comment->updated_at)) : '' }}
                                                        </i></p>
                                                </div>
                                                <div class="text-right">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="user-type text-right w-128px">
                                                                @lang('index.auto_replied')
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t_reply_comment">
                                                <p>{!! $r_comment->ticket_comment ?? '' !!}</p>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($obj->is_menual_assist != 1)
                                <div class="card mb-3 bg-danger-not-found_ai">
                                    <div class="card-body p-0">
                                        <div class="t_reply_body">
                                            <div class="t_reply_comment m-0">
                                                <p class="mb-0">@lang('index.could_not_find_solution') <a href="#"
                                                            class="set_replay_btn_bg_danger set_replay_btn">@lang('index.click_here')</a>
                                                        @lang('index.to_ask_manual_assistance')</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-3 bg-info-ai-learn">
                                    <div class="card-body p-0">
                                            <div class="t_reply_body">
                                                <div class="t_reply_comment m-0">
                                                    <p class="mb-0">@lang('index.ai_learning_info')</p>
                                                </div>
                                            </div>
                                    </div>

                                </div>
                            @endif
                        @else
                            <div class="card margin_bottom_20 {{ $loop->last ? 'admin-last-comment' : '' }} {{ $r_comment->getCreatedBy->role_id == 3 ? 'bg-customer' : 'bg-admin' }}"
                                id="comment-id_{{ $r_comment->id }}">
                                <div class="card-body p-0">
                                    <div class="d-flex align-items-start">
                                        <div class="t_replier_img">
                                            <img src="{{ !empty($r_comment->getCreatedBy->image) ? asset($r_comment->getCreatedBy->image) : asset('frequent_changing/images/user-avatar.jpg') }}"
                                                alt="User">
                                        </div>
                                        <div class="t_reply_body ms-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="t_replier_name">
                                                    <h6>{{ $r_comment->getCreatedBy->first_name . ' ' . $r_comment->getCreatedBy->last_name }}
                                                    </h6>
                                                    <p>{{ isset($r_comment->updated_at) ? $r_comment->updated_at->diffForHumans() . ' at ' . date('d F Y h:i A', strtotime($r_comment->updated_at)) : '' }}
                                                        </i></p>
                                                </div>
                                                <div class="text-right">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6 class="user-type text-right">
                                                                <b>{{ $r_comment->getCreatedBy->type ?? '' }}</b>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="t_reply_comment">
                                                <p>{!! $r_comment->ticket_comment ?? '' !!}</p>
                                            </div>
                                            <div>
                                                @if (!empty($r_comment->ticket_attachment))
                                                    @foreach (explode(',', $r_comment->ticket_attachment) as $r_c_attachment)
                                                        @if (file_exists($r_c_attachment))
                                                            <?php $get_extension = pathinfo($r_c_attachment, PATHINFO_EXTENSION); ?>
                                                            @if ($get_extension == 'png' || $get_extension == 'jpeg' || $get_extension == 'jpg')
                                                                <a href="{{ url($r_c_attachment) }}" target="_blank"
                                                                    class="align-top reply_file"> <img
                                                                        src="{{ asset($r_c_attachment) }}" alt="Img"
                                                                        height="60"></a>
                                                            @else
                                                                <a href="{{ url($r_c_attachment) }}" download
                                                                    class="file_fs align-top"> <span><iconify-icon
                                                                            icon="octicon:file-directory-open-fill-16"
                                                                            width="22"></iconify-icon></span> </a>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @elseif(count($r_comment->comment_files))
                                                    <div class="file-section">
                                                        <table class="table table-sm mt-2">
                                                            <thead>
                                                                <tr>
                                                                    <th class="w-10">@lang('index.sn')</th>
                                                                    <th class="w-50">@lang('index.title')</th>
                                                                    <th class="w-30">@lang('index.file_type')</th>
                                                                    <th class="ir_w_1_txt_center w-10">@lang('index.action')
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($r_comment->comment_files as $key => $file)
                                                                    @if (file_exists($file->file_path))
                                                                        <?php $extension = pathinfo($file->file_path, PATHINFO_EXTENSION); ?>
                                                                        <tr>
                                                                            <td class="">{{ $key + 1 }}</td>
                                                                            <td>{{ $file->file_title ?? '' }}</td>
                                                                            <td> {{ $extension }} </td>
                                                                            <td class="ir_txt_center">
                                                                                <div class="d-inline-flex">
                                                                                    <a href="{{ url($file->file_path) }}"
                                                                                        type="button" target="_blank"
                                                                                        class="btn btn-sm bg-blue-btn float-right me-2"><iconify-icon
                                                                                            icon="solar:eye-bold"
                                                                                            width="14"></iconify-icon></a>
                                                                                    <a href="{{ url($file->file_path) }}"
                                                                                        download type="button"
                                                                                        class="btn btn-sm bg-blue-btn float-right"><iconify-icon
                                                                                            icon="bytesize:download"
                                                                                            width="14"></iconify-icon></a>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endif
                                            </div>



                                            <!-- Update Comment Form -->
                                            {!! Form::open([
                                                'method' => 'POST',
                                                'files' => true,
                                                'url' => ['update-reply-comment/' . $r_comment->id],
                                                'id' => 'comment-update-form',
                                                'class' => 'needs-validation ticket_comment_update_form ',
                                                'novalidate',
                                            ]) !!}
                                            <div class="row update_comment_text_area_div{{ $r_comment->id }} d-none">
                                                <div class="col-sm-12 mb-2 col-md-12">
                                                    <div class="form-group mb-2">
                                                        <div class="ticket_details_action_buttons d-flex justify-content-between">
                                                            <label>@lang('index.comment') {!! starSign() !!}</label>
                                                            <div>
                                                                <button type="button"
                                                                data-update_textarea_id="ticket_comment_update{{ $r_comment->id }}"
                                                                class="open_canned_modal">
                                                                @lang('index.canned_msg')</button>
                                                            <button type="button"
                                                                data-update_textarea_id="ticket_comment_update{{ $r_comment->id }}"
                                                                class="open_article_modal">
                                                                @lang('index.article')</button>
                                                            </div>
                                                        </div>
                                                        <textarea class="ticket_comment_update" id="ticket_comment_update{{ $r_comment->id }}" name="ticket_comment_update"
                                                            required>
                                                            {!! $r_comment->ticket_comment ?? '' !!}
                                                        </textarea>
                                                        <div class="invalid-feedback content-invalid">
                                                            @lang('index.comment_field_required')
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 mb-2 col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12 mt-2">
                                                            <label>@lang('index.attachment')</label>
                                                            <span class="alert alert-warning">
                                                                @lang('index.attachment_instruction')
                                                            </span>

                                                            @if (count($r_comment->comment_files))
                                                                <div class="file-section">
                                                                    <table class="table table-sm mt-2">
                                                                        <thead>
                                                                            <tr>
                                                                                <th class="w-1">@lang('index.sn')</th>
                                                                                <th class="ir_w_12">@lang('index.title')</th>
                                                                                <th class="ir_w_12">@lang('index.file_type')</th>
                                                                                <th class="ir_w_1_txt_center">
                                                                                    @lang('index.action')</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($r_comment->comment_files as $key => $file)
                                                                                @if (file_exists($file->file_path))
                                                                                    <?php $extension = pathinfo($file->file_path, PATHINFO_EXTENSION); ?>
                                                                                    <tr>
                                                                                        <td class="">
                                                                                            {{ $key + 1 }}</td>
                                                                                        <td>
                                                                                            <input type="hidden"
                                                                                                name="file_id[]"
                                                                                                value="{{ $file->id }}">
                                                                                            {{ $file->file_title ?? '' }}
                                                                                        </td>
                                                                                        <td> {{ $extension }} </td>
                                                                                        <td class="ir_txt_center">
                                                                                            <div class="d-inline-flex">
                                                                                                <a href="{{ url($file->file_path) }}"
                                                                                                    type="button"
                                                                                                    target="_blank"
                                                                                                    class="btn btn-sm bg-blue-btn float-right me-2"><iconify-icon
                                                                                                        icon="solar:eye-bold"
                                                                                                        width="14"></iconify-icon></a>
                                                                                                <a href="{{ url($file->file_path) }}"
                                                                                                    download type="button"
                                                                                                    class="btn btn-sm bg-blue-btn float-right"><iconify-icon
                                                                                                        icon="bytesize:download"
                                                                                                        width="14"></iconify-icon></a>
                                                                                            </div>
                                                                                        </td>
                                                                                        <td class="w-15">
                                                                                            <button type="button"
                                                                                                class="btn btn-md btn-danger text-right ds_remove_file "
                                                                                                id="">
                                                                                                <iconify-icon
                                                                                                    icon="solar:trash-bin-minimalistic-bold-duotone"
                                                                                                    width="22"></iconify-icon>
                                                                                            </button>
                                                                                        </td>
                                                                                    </tr>
                                                                                @endif
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            @endif

                                                            <table class="table displayNone w-100"
                                                                id="edit_doc_table_{{ $r_comment->id }}">
                                                                <thead>
                                                                    <tr>
                                                                        <th>@lang('index.file_title') {!! starSign() !!}</th>
                                                                        <th>@lang('index.file') {!! starSign() !!}</th>
                                                                        <th>@lang('index.action')</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                </tbody>
                                                            </table>

                                                            <div class="row mt-1">
                                                                <div class="form-group">
                                                                    <button type="button"
                                                                        class="btn bg-blue-btn ds_edit_add_file attachment_btn"
                                                                        data-id="{{ $r_comment->id }}">                                                                        
                                                                        <span class="ms-1">@lang('index.attachment')</span>
                                                                        @include('__optional.__attachment')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-12 mb-2">
                                                    <button type="submit" data-r_comment_id="{{ $r_comment->id }}"
                                                        class="btn btn-md bg-blue-btn float-right comment_btn_update"
                                                        id="post-update-{{ $r_comment->id }}">
                                                        <span class="me-2 reply-post-spin d-none"><iconify-icon
                                                                icon="la:spinner" width="22"></iconify-icon></span>
                                                        @lang('index.update')
                                                    </button>
                                                    <button type="button" data-r_comment_id="{{ $r_comment->id }}"
                                                        class="btn btn-md custom_header_btn float-right me-1 comment_edit_update_cancel_btn">
                                                        @lang('index.cancel')</button>
                                                </div>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @if ($loop->last && $r_comment->created_by == Auth::user()->id && $r_comment->get_ticket_info->status != 2)
                                <button type="button" data-r_comment_id="{{ $r_comment->id }}"
                                    class="btn btn-md bg-blue-btn float-left mb-3 comment_edit_update_btn r_edit_btn{{ $r_comment->id }} attachment_btn">
                                    @lang('index.edit')
                                </button>
                            @endif
                        @endif
                    @endforeach

                </div>

                <!-- Ticket post Reply Form-->
                <div class="card mb-3 {{ $obj->status == 1 || $obj->status == 3 ? '' : 'd-none' }}">
                    <div class="card-body">
                        <div id="row mt-2">
                            <div class="col-sm-12 col-md-3 mb-2">
                                <button class="btn btn-md bg-blue-btn replay_btn"><iconify-icon icon="fontisto:commenting"
                                        width="22"></iconify-icon> @lang('index.ticket_replay')</button>
                            </div>
                        </div>
                        <!-- ticket's replay form -->
                        {!! Form::open([
                            'method' => 'POST',
                            'files' => true,
                            'url' => ['posting-replay-in-ticket'],
                            'id' => 'ticket_post_reply_form',
                            'class' => 'needs-validation',
                            'novalidate',
                        ]) !!}
                        <input type="hidden" name="ticket_id" class="get_this_ticket_id" value="{{ $obj->id }}">
                        <input type="hidden" name="ticket_id" class="get_this_ticket_id_encrypt"
                            value="{{ encrypt_decrypt($obj->id, 'encrypt') }}">
                        <input type="hidden" name="is_menual_assist" id="is_menual_assist" value="0">
                        <div class="row d-none" id="post_replay_form">
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group row">
                                    <div class="d-flex justify-content-between small_flex_direction_column">
                                        <label>@lang('index.comment') {!! starSign() !!}</label>
                                        <div class="ticket_details_action_buttons">
                                            @if (authUserRole() != 3)
                                                <button type="button"
                                                    class="open_canned_modal">
                                                    @lang('index.canned_msg')</button>
                                                <button type="button"
                                                    class="open_article_modal">
                                                    @lang('index.article')</button>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="ticket_comment_ss">
                                        <textarea id="ticket_comment" name="ticket_comment" class="has-validation" required>
                                            @if (authUserRole() != 3)
@if (isset(App\Model\TicketSetting::first()->default_sign))
{!! '<br>' . '<br><!--supporthive_comment--->' . nl2br(App\Model\TicketSetting::first()->default_sign) !!}
@endif
@endif
                                        </textarea>
                                        <div class="invalid-feedback content-invalid">
                                            @lang('index.comment_field_required')
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="row">
                                    <div class="col-md-12 mt-2">
                                        <label>@lang('index.attachment')</label>
                                        <span class="alert alert-warning">
                                            @lang('index.attachment_instruction')
                                        </span>

                                        <table class="table displayNone w-100" id="doc_table">
                                            <thead>
                                                <tr>
                                                    <th>@lang('index.file_title') {!! starSign() !!}</th>
                                                    <th>@lang('index.file') {!! starSign() !!}</th>
                                                    <th>@lang('index.action')</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>

                                        <div class="row mt-1">
                                            <div class="form-group">
                                                <button type="button" id="ds_add_file"
                                                    class="btn bg-blue-btn attachment_btn">
                                                    <span>@lang('index.attachment')</span>
                                                    @include('__optional.__attachment')
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2 col-md-12 mt-4">
                                <div class="d-flex justify-content-between small_flex_direction_column gap25">
                                    <div class="d-flex gap10">
                                        <input class="form-check-input" type="checkbox" id="close_ticket" value="2"
                                        name="ticket_close">
                                    <label class="form-check-label" for="close_ticket">@lang('index.close_ticket')</label>
                                    </div>
                                    <div class="d-flex gap25">
                                        <button type="button"
                                        class="btn btn-md custom_header_btn float-right cancel_post_reply">
                                        @lang('index.cancel')</button>
                                        <button type="submit" data-val="post_replay"
                                            class="btn btn-md bg-blue-btn float-right post_replay" id="post-reply">
                                            <span class="me-2 reply-post-spin d-none"><iconify-icon icon="la:spinner"
                                                    width="22"></iconify-icon></span>
                                            @lang('index.replay')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- Right Sidebar-Ticket Details-->
            <div class="col-12 col-md-4">


                <div class="row">
                    <div class="top_button_group d-flex flex-wrap gap-2 margin_bottom_16">
                        @if (authUserRole() != 3)
                            @if ($obj->status != 2)
                                <button class="btn btn-md bg-blue-btn me-1 open_assign_modal " data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="@lang('index.assign')">
                                    <iconify-icon icon="ant-design:retweet-outlined" width="22"></iconify-icon>

                                </button>
                            @endif
                            @if ($obj->status == 1 || $obj->status == 3)
                                <button class="btn btn-sm bg-blue-btn me-1 ticket_status_set_close_reopen "
                                    data-ticket_status="2" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-title="@lang('index.close')">
                                    <iconify-icon icon="uil:times" width="22"></iconify-icon>
                                </button>
                            @endif

                        @endif
                        @if ($obj->status == 2)
                            <button class="btn btn-sm bg-blue-btn me-1 ticket_status_set_close_reopen "
                                data-ticket_status="3" data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="@lang('index.reopen')">
                                <iconify-icon icon="material-symbols:check" width="22"></iconify-icon>
                            </button>
                        @endif

                        @if (authUserRole() != 3)
                            <button class="btn btn-sm bg-blue-btn me-1 ticket_status_set_archived " data-ticket_status="2"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="@lang('index.archive')">

                                <iconify-icon icon="material-symbols:archive-outline" width="22"></iconify-icon>
                            </button>
                        @endif

                        <a href="{{ url('ticket') }}" class="go_back_btn">
                            <button class="btn btn-sm bg-blue-btn me-1 " data-bs-toggle="tooltip" data-bs-placement="top"
                                data-bs-title="@lang('index.go_back')">


                                <iconify-icon icon="mdi:arrow-left" width="22"></iconify-icon>
                            </button>
                        </a>
                        @if (authUserRole() != 3)
                            <a href="{{ url('flag-ticket/' . encrypt_decrypt($obj->id, 'encrypt')) }}"
                                class="go_back_btn">
                                <button class="btn btn-sm bg-blue-btn me-1 " data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-title="@lang('index.flag')">


                                    <iconify-icon icon="prime:flag" width="22"></iconify-icon>
                                </button>
                            </a>
                            @if (!App\Model\ChatGroup::where('ticket_id', $obj->id)->exists())
                                <a href="{{ url('open-new-chat/' . encrypt_decrypt($obj->id, 'encrypt')) }}"
                                    class="go_back_btn">
                                    <button class="btn btn-sm bg-blue-btn me-1 " data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="@lang('index.open_chat')">

                                        <iconify-icon icon="fa-regular:comment" width="22"></iconify-icon>
                                    </button>
                                </a>
                            @endif
                        @endif
                    </div>
                    <div class="col-sm-12 mb-4">
                        <div class="card ticket_details_right_side mt-3">
                            <div class="card-body">
                                <h4>
                                    @lang('index.ticket_details')
                                    @if ($obj->flag_status == 1)
                                        <span
                                            class="show_t_status badge text-dark border-red mt-1 me-2 fs-12 font-14 flagged">@lang('index.ticket_flgged')
                                        </span>
                                    @endif
                                </h4>
                                <hr>
                                @if (appTheme() == 'single')
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <span class="left_text">@lang('index.department') :</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            <span
                                                class="show_t_status badge text-dark border border-dark me-2 fs-12">{{ $obj->getDepartment->name ?? '' }}</span>
                                        </div>
                                    </div>
                                    <hr>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <span class="left_text">@lang('index.status')</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <span class="show_t_status badge text-dark border border-dark me-2 fs-12">
                                            {{ getTicketStatus($obj->status) }}
                                        </span>
                                        @if ($obj->archived_status == 1)
                                            <span
                                                class="show_t_status badge text-dark border border-dark mt-1 me-2 fs-12">@lang('index.archived')</span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <span class="left_text">@lang('index.priority')</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <span
                                            class="show_priority show_t_status text-dark badge border border-dark text-capitalize me-2 fs-12">
                                            {{ $obj->priority == 1 ? 'High' : '' }}
                                            {{ $obj->priority == 2 ? 'Medium' : '' }}
                                            {{ $obj->priority == 3 ? 'Low' : '' }}
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <span class="left_text">@lang('index.ticket_id') :</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <span class="text-bold">{{ $obj->ticket_no ?? '' }}</span>
                                    </div>
                                </div>
                                <hr>
                                @if (authUserRole() != 3)
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">
                                            @lang('index.customer')
                                            <button type="button"
                                                class="btn btn-md bg-blue-btn sidebar_btn mt-2 open_cus_note_list_modal me-2 mb-2">
                                                @lang('index.note_list')</button>
                                        </div>
                                        <div class="col-md-12 col-lg-6">
                                            <div class="d-flex">
                                                <a class="ds_anchor"
                                                    href="{{ url('ticket?customer_id=' . encrypt_decrypt($obj->getCustomer->id, 'encrypt')) }}">
                                                    {{ $obj->getCustomer->full_name ?? 'N/A' }}
                                                </a>

                                                <span
                                                    class="ms-auto float-right cursor-pointer ds_anchor_color open-customer-info-modal"><iconify-icon
                                                        icon="solar:eye-bold" width="22"></iconify-icon></span>
                                            </div>
                                            <button type="button"
                                                class="btn btn-md bg-blue-btn sidebar_btn mt-2 open_cus_note_modal mb-2">
                                                @lang('index.add_customer_note')</button>
                                        </div>
                                    </div>
                                    <hr>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <span class="left_text">@lang('index.customer_email')</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        {{ $obj->getCustomer->email ?? '' }}
                                    </div>
                                </div>
                                @if (authUserRole() != 3)
                                    <!-- if Envato Product -->
                                    @if ($obj->getProductCategory->verification == 1)
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <span class="left_text">@lang('index.envato_u_name')</span>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                {{ !empty($obj->envato_u_name) ? $obj->envato_u_name : '' }}
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <span class="left_text">@lang('index.envato_p_code')</span>
                                            </div>
                                            <div class="col-lg-6 col-md-12" id="en_p_code">
                                                {{ !empty($obj->envato_p_code) ? $obj->envato_p_code : '' }}
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <span class="left_text">@lang('index.product_category')</span>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        {{ !empty($obj->getProductCategory->title) ? $obj->getProductCategory->title : '' }}
                                    </div>
                                </div>
                                <hr>
                                @if (authUserRole() != 3)
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <span class="left_text">@lang('index.assigned_to')</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12 show_agents_names_this_ticket">
                                            @if (!empty($all_agents_this_ticket))
                                                @foreach ($all_agents_this_ticket as $assigned_agent)
                                                    {{ !empty($assigned_agent) ? $assigned_agent->full_name : 'N/A' }}
                                                    <br>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <span class="left_text">@lang('index.assigned_cc')</span>
                                            <div>
                                                <button type="button"
                                                    class="btn btn-md sidebar_btn bg-blue-btn mt-2 open_ticket_cc_modal">
                                                    @lang('index.add_cc')</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-12 ticket_cc_list">
                                            {{ $obj->ticket_cc ?? 'N/A' }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12 col-lg-6">
                                            <button type="button"
                                                class="btn btn-md bg-blue-btn sidebar_btn open_ticket_note_list_modal me-2 mb-2">
                                                @lang('index.ticket_note_list')</button>
                                        </div>
                                        <div class="col-md-12 col-lg-6">
                                            <button type="button"
                                                class="btn btn-md bg-blue-btn sidebar_btn open_ticket_note_modal mb-2">
                                                @lang('index.add_ticket_note')</button>
                                        </div>
                                    </div>
                                    <hr>

                                    @if ($obj->status != 2)
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                <span class="me-4">{{ __('index.this_is_paid_support') }}</span>
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                <label class="switch_ticketly">
                                                    <input type="checkbox" id="paid_support" name="paid_support"
                                                        {{ isset($obj) && $obj->paid_support == 'Yes' ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                    @endif


                                    <div class="row">
                                        <div class="col-md-12 {{ isset($obj) && $obj->paid_support == 'Yes' ? '' : 'displayNone' }}"
                                            id="payment-form">
                                            <form action="{{ route('send-payment-request') }}" method="POST"
                                                class="needs-validation" novalidate id="payment-request-form">
                                                @csrf
                                                <input type="hidden" name="ticket_id" value="{{ $obj->id }}"
                                                    required>
                                                <input type="hidden" name="is_paid" id="is_paid"
                                                    value="{{ $obj->paid_support ?? 'No' }}">
                                                <input type="hidden" id="current_amount"
                                                    value="{{ $obj->amount ?? '0' }}">

                                                <div class="row mt-3">
                                                    <div class="col-lg-6 col-md-12">
                                                        <label for="">@lang('index.amount')
                                                            {!! starSign() !!}</label>

                                                    </div>
                                                    <div class="col-lg-6 col-md-12">
                                                        <input type="number" required class="form-control"
                                                            name="amount" id="amount"
                                                            value="{{ $obj->amount ?? 0 }}"
                                                            placeholder="@lang('index.amount')">
                                                        <button type="submit"
                                                            class="btn btn-sm w-100 pull-right text-left bg-blue-btn mt-2"
                                                            id="send-payment-request">
                                                            <span class="me-2 paid-support-spinner d-none"><iconify-icon
                                                                    icon="la:spinner"
                                                                    width="22"></iconify-icon></span>
                                                            {{ $obj->paid_support == 'Yes' ? __('index.update') : __('index.send_payment_request') }}
                                                        </button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <hr>
                                @endif
                                <input type="hidden" id="is_paid_support" value="{{ $obj->paid_support }}">
                                @if ($obj->paid_support == 'Yes')
                                    <div class="row">
                                        <div class="col-md-8">
                                            <span class="text-nowrap me-4">{{ __('index.payment_status') }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <span
                                                class="show_priority text-dark badge border border-dark text-capitalize me-2 fs-12">
                                                {{ $obj->payment_status ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                    <hr>
                                @endif
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        @lang('index.created_at')
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        @isset($obj->created_at)
                                            {{ $obj->created_at->diffForHumans() }} <br>
                                            {{ $obj->created_at->format('M d, Y') . ' ' . $obj->created_at->format('h:i:s a') }}
                                        @endisset

                                    </div>
                                </div>
                                <hr>
                                @if (authUserRole() != 3)
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <span class="left_text">@lang('index.last_responded_by')</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            {{ !empty($last_response) ? $last_response->getCreatedBy->first_name . ' ' . $last_response->getCreatedBy->last_name . ' (' . $last_response->getCreatedBy->type . ')' : '' }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12">
                                            <span class="left_text">@lang('index.last_replied_at')</span>
                                        </div>
                                        <div class="col-lg-6 col-md-12">
                                            @isset($last_response->created_at)
                                                {{ $last_response->created_at->diffForHumans() }} <br>
                                                {{ $last_response->created_at->format('M d, Y') . ' ' . $last_response->created_at->format('h:i:s a') }}
                                            @endisset

                                        </div>
                                    </div>
                                    <hr>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (!empty($custom_field_label))
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4>@lang('index.other_details')</h4>
                                    <hr>
                                    @foreach ($custom_field_label as $k => $label)
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
                                                {{ $label }}
                                            </div>
                                            <div class="col-lg-6 col-md-12">
                                                @if ($custom_field_type[$k] == 3)
                                                    @if ($custom_field_option[$k])
                                                        @foreach (explode(',', $custom_field_option[$k]) as $opt_k => $opt_v)
                                                            {{ $custom_field_data[$k] == $opt_k ? $opt_v : '' }}
                                                        @endforeach
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Add Note Modal-->
    <div class="modal fade" id="add_customer_note">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_customer_note')</h4>
                    <button type="button" class="btn-close close_cus_note_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('index.note') {!! starSign() !!}</label>
                                            <textarea name="customer_note" class="form-control has-validation customer_note" rows="40" maxlength="1000"
                                                placeholder="@lang('index.note')" required></textarea>
                                            <input type="hidden" class="customer_id" name="customer_id"
                                                value="{{ $obj->customer_id }}">
                                            <span class="error_alert text-danger customer_note_error"
                                                role="alert"></span>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_customer_note"
                                            id="submit-customer-note">
                                            <span class="me-2 cus-note-form-spinner d-none"><iconify-icon
                                                    icon="la:spinner" width="22"></iconify-icon></span>

                                            @lang('index.submit')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Info Modal-->
    <div class="modal fade" id="customer_info">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.customer_details')</h4>
                    <button type="button" class="btn-close close-customer-info-modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="ml-ds-3">{{ $obj->getCustomer->full_name ?? '' }}</h5>
                                    <p class="ml-ds-3">{{ $obj->getCustomer->email ?? '' }}</p>
                                    <p class="ml-ds-3">{{ $obj->getCustomer->mobile ?? '' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{ asset($obj->getCustomer->image) }}" alt="" height="100"
                                        width="100" class="img-responsive text-right">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Note List Modal-->
    <div class="modal fade" id="customer_note_list">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.customer_note_list')</h4>
                    <button type="button" class="btn-close close_cus_note_list_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div class="col-md-12">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="text-align-left">@lang('index.sn')</th>
                                            <th class="text-nowrap">@lang('index.date')</th>
                                            <th>@lang('index.note')</th>
                                        </tr>
                                    </thead>
                                    <tbody id="append_new_added_note">
                                        @if (count($notes) > 0)
                                            @foreach ($notes as $k => $note)
                                                <tr>
                                                    <td>{{ ++$k }}</td>
                                                    <td class="text-nowrap">
                                                        {{ isset($note->created_at) ? date(orgDateFormat($obj->created_at), strtotime($note->created_at)) : '' }}
                                                        {{ isset($note->created_at) ? date('h:i A', strtotime($note->created_at)) : '' }}
                                                    </td>
                                                    <td>{!! $note->note !!}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="last_note">
                                                <td colspan="3">@lang('index.no_data_found')</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Add Note Modal-->
    <div class="modal fade" id="add_ticket_note">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_ticket_note')</h4>
                    <button type="button" class="btn-close close_ticket_note_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('index.note') {!! starSign() !!}</label>
                                            <textarea name="ticket_note" class="form-control has-validation ticket_note" rows="40" maxlength="1000"
                                                placeholder="@lang('index.note')" required></textarea>
                                        </div>
                                        <span class="error_alert text-danger ticket_note_error displayNone"
                                            role="alert"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_ticket_note"
                                            id="submit-ticket-note">

                                            <span class="me-2 ticket-note-form-spinner d-none"><iconify-icon
                                                    icon="la:spinner" width="22"></iconify-icon></span>
                                            @lang('index.submit')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ticket Note List Modal-->
    @if (authUserRole() != 3)
        <div class="modal fade" id="ticket_note_list">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">@lang('index.ticket_note_list')</h4>
                        <button type="button" class="btn-close close_ticket_note_list_modal" data-bs-dismiss="modal"
                            aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                    </div>
                    <div class="modal-body pt-0">
                        <div class="box-wrapper">
                            <!-- general form elements -->
                            <div class="table-box">
                                <div class="col-md-12">
                                    <table class="table mt-0 pt-0">
                                        <thead>
                                            <tr>
                                                <th class="text-align-left">@lang('index.sn')</th>
                                                <th class="text-nowrap">@lang('index.date')</th>
                                                <th>@lang('index.ticket_note')</th>
                                            </tr>
                                        </thead>
                                        <tbody id="append_new_added_ticket_note">
                                            @if (count($ticket_notes) > 0)
                                                @foreach ($ticket_notes as $k => $note)
                                                    <tr>
                                                        <td>{{ ++$k }}</td>
                                                        <td class="text-nowrap">
                                                            {{ isset($note->created_at) ? date(orgDateFormat($obj->created_at), strtotime($note->created_at)) : '' }}
                                                            {{ isset($note->created_at) ? date('h:i A', strtotime($note->created_at)) : '' }}
                                                        </td>
                                                        <td>{!! $note->ticket_note !!}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="last_note">
                                                    <td colspan="3">{{ 'No note found!' }}</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Ticket CC Add Modal-->
    <div class="modal fade" id="add_ticket_cc">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_cc')</h4>
                    <button type="button" class="btn-close close_ticket_cc_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <div class="d-flex">
                                                <label>@lang('index.email') </label>

                                                <button type="button"
                                                    class="btn btn-secondary btn-xs what-sign d-flex ms-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    data-bs-title="@lang('index.mail_temp_cc')">
                                                    <iconify-icon icon="ri:question-fill" width="22"></iconify-icon>
                                                </button>
                                            </div>

                                            <textarea class="form-control has-validation ticket_cc" rows="40" required
                                                placeholder="example1@mail.com,example2@mail.com,example3@mail.com">{{ $obj->ticket_cc }}</textarea>
                                        </div>
                                        <span class="error_alert text-danger ticket_cc_error" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button"
                                            class="btn bg-blue-btn w-100 add_new_ticket_cc">@lang('index.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Canned Message search Modal -->
    <div class="modal fade" id="canned_modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.canned_msg')</h4>
                    <button type="button" class="btn-close close_canned_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="col-12 mb-2 canned_msg_search_box">
                    <div class="form-group">
                        {!! Form::text('canned_msg_search', null, [
                            'id' => 'canned_input',
                            'class' => 'form-control canned_msg_search',
                            'placeholder' => __('index.search'),
                        ]) !!}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <ul class="canned_msg_ul">
                            @foreach ($canned_message as $c_k => $c_msg)
                                <li class="matched_canned_msg bg-article p-2 mb-2 me-2" data-id="{{ $c_msg->id }}"
                                    data-text='{!! $c_msg->canned_msg_content !!}'>{!! $c_msg->title !!}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article search Modal -->
    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.article')</h4>
                    <button type="button" class="btn-close close_article_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="row">
                    <div class="col-12 article_msg_search_box">
                        <div class="form-group">
                            {!! Form::text('article_search', null, [
                                'class' => 'form-control article_search',
                                'placeholder' => __('index.search'),
                                'autocomplete' => 'off',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <ul class="article_msg_ul"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign To Modal -->
    <div class="modal fade" id="assign_modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.assign')</h4>
                    <button type="button" class="btn-close close_assign_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('index.select_agent') {!! starSign() !!}</label>
                                            {!! Form::select(
                                                'assign_to_ids',
                                                $all_agents,
                                                !empty($obj->assign_to_ids) ? explode(',', $obj->assign_to_ids) : null,
                                                [
                                                    'class' => 'form-control select2 assign_to_val',
                                                    'id' => 'assign_to_ids',
                                                    'data-placeholder' => __('index.select_agent'),
                                                    'multiple',
                                                ],
                                            ) !!}
                                        </div>
                                        <span class="error_alert text-danger assign_to_id_error" role="alert"></span>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('index.priority')</label>
                                            {!! Form::select(
                                                'priority',
                                                ['1' => 'High', '2' => 'Medium', '3' => 'Low'],
                                                isset($obj->priority) ? $obj->priority : null,
                                                ['class' => 'form-control select2 priority_val'],
                                            ) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-4 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 set_new_ticket_assignee">
                                            <span class="me-2 assign-spin d-none"><iconify-icon icon="la:spinner"
                                                    width="18"></iconify-icon></span>
                                            @lang('index.submit')
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Keyboard shortcut Modal-->
    <div class="modal fade" id="keyboard_shortcut">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.keyboard_shortcut')</h4>
                    <button type="button" class="btn-close close_keyboard_shortcut_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="col-md-12">
                                    <div class="btn-group d-flex">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button
                                            class="bg-light border-0 me-1 ms-1">alt</button> + <button
                                            class="bg-light border-0 me-1 ms-1">m</button> = @lang('index.open_canned_msg_modal')
                                    </div>
                                    <div class="btn-group d-flex mt-2">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button
                                            class="bg-light border-0 me-1 ms-1">alt</button> + <button
                                            class="bg-light border-0 me-1 ms-1">a</button> = @lang('index.open_article_modal')
                                    </div>
                                    @if (authUserRole() != 3)
                                        <div class="btn-group d-flex mt-2">
                                            <button class="bg-light border-0 me-1">ctrl</button> + <button
                                                class="bg-light border-0 me-1 ms-1">alt</button> + <button
                                                class="bg-light border-0 me-1 ms-1">c</button> = @lang('index.close_reopen_ticket')
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agent Reply List Modal -->
    <div class="modal fade" id="helpful_modal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.helpful_answer')</h4>
                    <button type="button" class="btn-close close_canned_modal" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <div class="alert alert-info" role="alert">
                            <strong>@lang('index.helpful_info_msg')</strong>
                        </div>
                        <ul class="canned_msg_ul">
                            @foreach ($reply_comments as $r_comment)
                                @if ($r_comment->is_ai_replied != 1 && $r_comment->getCreatedBy->role_id != 3)
                                    <li class="ticket_comment_helpful bg-article p-2 mb-2"
                                        data-id="{{ $r_comment->id }}"">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="selected_comment"
                                            value="{{ $r_comment->id }}">
                                            <label class="form-check-label">
                                                {!! $r_comment->ticket_comment !!}
                                            </label>
                                        </div>
                                        
                                        
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary no_button">@lang('index.skip')</button>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script src="{{ asset('assets/ck-editor/ckeditor.js') }}"></script>
    <script src="{{ asset('frequent_changing/js/ticket-details.js') }}"></script>
@endpush
