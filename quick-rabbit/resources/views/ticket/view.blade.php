@extends('layouts.app')
@section('title','Edit Profile')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/ticket.css?var=2.2') }}">
@endpush

@section('content')
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
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">{{ __('index.ticket_details') }}</h3>
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket'), 'secondSection' => __('index.ticket_details')])
            </div>
        </section>
        <div class=" row content-header">
            <div class="col-md-7">
                <p class="fw-bold m-0 p-0 fs-5">@lang('index.ticket_id') {{ $obj->ticket_no ?? '' }}: {{ $obj->title ?? '' }}</p>
                <p class="fw-bold m-0 p-0 text-secondary ticket_no">{{ !empty($obj->getProductCategory->title)? $obj->getProductCategory->title:"" }}</p>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12 ms-2 justify-content-end top_button_group">
                        @if($obj->status !=2)
                            <button class="btn btn-sm bg-blue-btn me-2 open_assign_modal">
                            
                            <iconify-icon icon="ant-design:retweet-outlined" width="22"></iconify-icon>
                             @lang('index.assign')</button>
                        @endif
                        @if(($obj->status==1) || ($obj->status==3))
                            <button class="btn btn-sm bg-blue-btn me-2 ticket_status_set_close_reopen" data-ticket_status="2">
                            
                            <iconify-icon icon="uil:times" width="22"></iconify-icon>
                            @lang('index.close')</button>
                        @elseif($obj->status==2)
                            <button class="btn btn-sm bg-blue-btn me-2 ticket_status_set_close_reopen" data-ticket_status="3">
                            
                            <iconify-icon icon="material-symbols:check" width="22"></iconify-icon>
                            @lang('index.reopen')</button>
                        @endif
                        <button class="btn btn-sm bg-blue-btn me-2 ticket_status_set_archived" data-ticket_status="2">
                        
                        <iconify-icon icon="material-symbols:archive" width="22"></iconify-icon>
                        @lang('index.archive')</button>
                        <a href="{{ url('ticket') }}" class="go_back_btn"><button class="btn btn-sm bg-blue-btn me-2">
                        
                        <iconify-icon icon="material-symbols:undo" width="22"></iconify-icon>
                        @lang('index.go_back')</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="card mb-3">
                    <div class="card-body p-0">
                        <div>
                            <p class="mb-4 p-3 mt-0 pt-0">
                                <a href="{{ url('ticket/flag-ticket/'.encrypt_decrypt($obj->id, 'encrypt')) }}"><span class="badge {{ ($obj->flag_status==1)?'text-danger':'text-dark' }} float-right text-capitalize fs-12">
                                
                                
                                <iconify-icon icon="material-symbols-light:flag-outline" width="22"></iconify-icon>
                                </span></a>
                                @if($obj->need_action == 1)<span class="badge text-danger bg-light float-right text-capitalize me-2 fs-12">@lang('index.need_action')</span>@endif
                            </p>

                            {!! !empty($obj->ticket_content)? $obj->ticket_content:"" !!}

                            @if(count($obj->ticket_files))
                                <table class="table table-sm">
                                <thead>
                                <tr>
                                    <th class="ir_w_1_txt_center">@lang('index.sn')</th>
                                    <th class="ir_w_12">@lang('index.title')</th>
                                    <th class="ir_w_12">@lang('index.file_type')</th>
                                    <th class="ir_w_1_txt_center">@lang('index.action')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($obj->ticket_files as $key => $file)
                                        <?php $extension = pathinfo($file->file_path, PATHINFO_EXTENSION); ?>
                                    <tr>
                                        <td class="ir_txt_center">{{ $key + 1 }}</td>
                                        <td>{{ $file->file_title ?? "" }}</td>
                                        <td> {{ $extension }} </td>
                                        <td class="ir_txt_center">
                                            <div class="d-inline-flex">
                                                <a href="{{ url($file->file_path) }}" type="button" target="_blank" class="btn btn-sm bg-blue-btn float-right me-2"><iconify-icon icon="solar:eye-bold" width="22"></iconify-icon></a>
                                                <a href="{{ url($file->file_path) }}" download type="button" class="btn btn-sm bg-blue-btn float-right"><iconify-icon icon="material-symbols:download" width="22"></iconify-icon></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Show Ticket replies -->
                <input type="hidden" class="update_textarea_id_c" value=""> <!-- for canned msg -->
                <input type="hidden" class="update_textarea_id_a" value=""> <!-- for article msg -->
                <div id="ticket_comment_box">
                    @foreach($reply_comments as $r_comment)
                        <div class="card mb-3 {{ $loop->last ? 'admin-last-comment' : '' }}" id="comment-id_{{ $r_comment->id }}">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="t_replier_img">
                                        <img src="{{ !empty($r_comment->getCreatedBy->image)? asset($r_comment->getCreatedBy->image) : asset('frequent_changing/images/user-avatar.jpg') }}" alt="User">
                                    </div>
                                    <div class="t_reply_body ms-3">
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="t_replier_name">
                                                    <h6><b>{{ $r_comment->getCreatedBy->first_name.' '.$r_comment->getCreatedBy->last_name }}</b></h6>
                                                    <h6>{{ isset($r_comment->updated_at)? $r_comment->updated_at->diffForHumans().' on '. date('d F Y h:i A', strtotime($r_comment->updated_at)):'' }} </i></h6>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="text-right">
                                                    @if($loop->last && $r_comment->created_by == Auth::user()->id && $r_comment->get_ticket_info->status != 2)
                                                        <button type="button" data-r_comment_id="{{ $r_comment->id }}" class="btn btn-md bg-blue-btn float-right comment_edit_update_btn r_edit_btn{{ $r_comment->id }}"> @lang('index.edit')</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="t_reply_comment">
                                            <p>{!! $r_comment->ticket_comment ?? "" !!}</p>
                                        </div>
                                        <div>
                                            @if(!empty($r_comment->ticket_attachment))
                                                @foreach(explode(',', $r_comment->ticket_attachment) as $r_c_attachment)
                                                    <?php $get_extension = pathinfo($r_c_attachment, PATHINFO_EXTENSION); ?>
                                                    @if(($get_extension=='png') || ($get_extension=='jpeg') || ($get_extension=='jpg'))
                                                        <a href="{{ url($r_c_attachment) }}" class="align-top fancybox"> <img src="{{ asset($r_c_attachment) }}" alt="Img" height="50"></a>
                                                    @else
                                                        <a href="{{ url($r_c_attachment) }}" download class="file_fs align-top"> <span><iconify-icon icon="octicon:file-directory-open-fill-16" width="22"></iconify-icon></span> </a>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>

                                        <!-- Update Comment Form -->
                                        {!! Form::open(['method'=>'POST','files'=>true,'url'=>['admin/update-reply-comment/'.$r_comment->id],'id'=>'','class'=>'ticket_comment_update_form needs-validation','novalidate']) !!}
                                        <div class="row update_comment_text_area_div{{ $r_comment->id }} d-none">
                                            <div class="col-sm-12 mb-2 col-md-12">
                                                <div class="form-group mb-2">
                                                    <div class="mb-2">
                                                        <label>@lang('index.comment') {!! starSign() !!}</label>
                                                        <button type="button" data-update_textarea_id="ticket_comment_update{{ $r_comment->id }}" class="btn btn-md bg-blue-btn float-right open_canned_modal"> @lang('index.canned_msg')</button>
                                                        <button type="button" data-update_textarea_id="ticket_comment_update{{ $r_comment->id }}" class="btn btn-md bg-blue-btn float-right me-1 open_article_modal"> @lang('index.article')</button>
                                                    </div>
                                                    <textarea class="ticket_comment_update has-validation" id="ticket_comment_update{{ $r_comment->id }}" name="ticket_comment_update" required>{!! $r_comment->ticket_comment ?? "" !!}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 mb-2 col-md-12">
                                                <div class="form-group">
                                                    <label>@lang('index.attachment')</label>
                                                    <input tabindex="1" type="file" name="ticket_attachment[]" accept="image/*" class="form-control" value="" multiple>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-12 mb-2">
                                                <button type="submit" data-r_comment_id="{{ $r_comment->id }}" class="btn btn-md bg-blue-btn float-right comment_update_btn"> @lang('index.update')</button>
                                                <button type="button" data-r_comment_id="{{ $r_comment->id }}" class="btn btn-md bg-blue-btn float-right me-1 comment_edit_update_cancel_btn"> @lang('index.cancel')</button>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <!-- Ticket post Reply Form-->
                <div class="card mb-3 {{ (($obj->status==1) || ($obj->status==3)) ? '':'d-none' }}">
                    <div class="card-body">
                        <div id="row mt-2">
                            <div class="col-sm-12 col-md-2 mb-2">
                                <button class="btn btn-md bg-blue-btn replay_btn"><iconify-icon icon="fontisto:commenting" width="22"></iconify-icon> @lang('index.ticket_replay')</button>
                            </div>
                        </div>
                        <!-- ticket's replay form -->
                        {!! Form::open(['method' => 'POST', 'files'=>true, 'url' => ['posting-replay-in-ticket'],'id'=>'ticket_post_reply_form','class'=>'needs-validation','novalidate']) !!}
                        <input type="hidden" name="ticket_id" class="get_this_ticket_id" value="{{ $obj->id }}">
                        <input type="hidden" name="ticket_id" class="get_this_ticket_id_encrypt" value="{{ encrypt_decrypt($obj->id, 'encrypt') }}">
                        <div class="row d-none" id="post_replay_form">
                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <div class="mb-2">
                                        <label>@lang('index.comment') {!! starSign() !!}</label>
                                        <button type="button" class="btn btn-md bg-blue-btn float-right open_canned_modal"> @lang('index.canned_msg')</button>
                                        <button type="button" class="btn btn-md bg-blue-btn float-right me-1 open_article_modal"> @lang('index.article')</button>
                                    </div>
                                    <div class="ticket_comment_ss">
                                        <textarea id="ticket_comment" name="ticket_comment" class="has-validation" required>
                                            @if(authUserRole() == 1)
                                                {!! '<br><br>Regards,<br>'. SiteSetting()->company_name. ' Support' !!}
                                            @endif
                                        </textarea>
                                        <div class="invalid-feedback content-invalid">
                                            @lang('index.comment_field_required')
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2 col-md-12">
                                <div class="form-group">
                                    <label>@lang('index.attachment')</label>
                                    <input tabindex="1" type="file" name="ticket_attachment[]" accept="image/*" class="form-control" value="" multiple>
                                </div>
                            </div>

                            <div class="col-sm-12 mb-2 col-md-12 mt-3">
                                <div class="form-group">
                                    <input class="form-check-input" type="checkbox" id="close_ticket" value="2" name="ticket_close">
                                        <label class="form-check-label" for="close_ticket">Close Ticket</label>
                                    <button type="button" class="btn btn-md bg-blue-btn float-right cancel_post_reply"> @lang('index.cancel')</button>
                                    <button type="submit" data-val="post_replay" class="btn btn-md bg-blue-btn float-right me-2 post_replay">@lang('index.replay')</button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <!-- Right Sidebar-Ticket Details-->
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h4>@lang('index.ticket_details')</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.status')
                                    </div>
                                    <div class="col-md-6 d-flex">
                                        <span class="show_t_status badge text-dark border border-dark me-2 fs-12">
                                            {{ ($obj->status==1)? 'Open':'' }}
                                            {{ ($obj->status==2)? 'Closed':'' }}
                                            {{ ($obj->status==3)? 'Re-open':'' }}
                                            {{ ($obj->status==4)? 'Flagged':'' }}
                                        </span>
                                        @if($obj->archived_status==1)
                                            <span class="show_t_status badge text-dark border border-dark me-2 fs-12">@lang('index.archived')</span>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.priority')
                                    </div>
                                    <div class="col-md-6">
                                        <span class="show_priority text-dark badge border border-dark text-capitalize me-2 fs-12">
                                            {{ ($obj->priority==1)? 'High':'' }}
                                            {{ ($obj->priority==2)? 'Medium':'' }}
                                            {{ ($obj->priority==3)? 'Low':'' }}
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.ticket')
                                    </div>
                                    <div class="col-md-6">
                                        {{ $obj->ticket_no ?? '' }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.customer')
                                        <div>
                                            <button type="button" class="btn btn-md bg-blue-btn open_cus_note_list_modal"> @lang('index.note_list')</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        {{ !empty($obj->customer_id)? $obj->getCustomer->first_name.' '.$obj->getCustomer->last_name:"" }}
                                        <div>
                                            <button type="button" class="btn btn-md bg-blue-btn open_cus_note_modal"> @lang('index.add_note')</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.customer_email')
                                    </div>
                                    <div class="col-md-6">
                                        {{ !empty($obj->customer_id)? $obj->getCustomer->email:"" }}
                                    </div>
                                </div>
                                <!-- if Envato Product -->
                                @if($obj->getProductCategory->verification==1)
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @lang('index.envato_u_name')
                                        </div>
                                        <div class="col-md-6">
                                            {{ !empty($obj->envato_u_name)? $obj->envato_u_name:"" }}
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            @lang('index.envato_p_code')
                                        </div>
                                        <div class="col-md-6">
                                            {{ !empty($obj->envato_p_code)? $obj->envato_p_code:"" }}
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.product_category')
                                    </div>
                                    <div class="col-md-6">
                                        {{ !empty($obj->getProductCategory->title)? $obj->getProductCategory->title:"" }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.assigned_to')
                                    </div>
                                    <div class="col-md-6 show_agents_names_this_ticket">
                                        @if(!empty($all_agents_this_ticket))
                                            @foreach($all_agents_this_ticket as $assigned_agent)
                                                {{ !empty($assigned_agent)? $assigned_agent->full_name:"N/A" }}
                                                <br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.assigned_cc')
                                        <div>
                                            <button type="button" class="btn btn-md bg-blue-btn open_ticket_cc_modal"> @lang('index.add_cc')</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ticket_cc_list">
                                        {{ $obj->ticket_cc ?? "N/A" }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div>
                                            <button type="button" class="btn btn-md bg-blue-btn open_ticket_note_list_modal"> @lang('index.ticket_note_list')</button>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div>
                                            <button type="button" class="btn btn-md bg-blue-btn open_ticket_note_modal"> @lang('index.add_note')</button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.created_at')
                                    </div>
                                    <div class="col-md-6">
                                        {{ (isset($obj->created_at)? date(orgDateFormat($obj->created_at), strtotime($obj->created_at)):'') }}

                                        {{ (isset($obj->created_at)? date('h:i A', strtotime($obj->created_at)):'') }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.last_responded_by')
                                    </div>
                                    <div class="col-md-6">
                                        {{ !empty($last_response)? $last_response->getCreatedBy->first_name.' '.$last_response->getCreatedBy->last_name.' ('.$last_response->getCreatedBy->type.')':"" }}
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        @lang('index.last_replied_at')
                                    </div>
                                    <div class="col-md-6">
                                        {{ isset($last_response->created_at)? $last_response->created_at->diffForHumans():'' }}
                                        <br>
                                        {{ (isset($last_response->created_at)? date(orgDateFormat($obj->created_at), strtotime($last_response->created_at)):'') }}
                                        <br>
                                        {{ (isset($last_response->created_at)? date('h:i A', strtotime($last_response->created_at)):'') }}
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>@lang('index.other_details')</h4> <hr>
                                @if(!empty($custom_field_label))
                                    @foreach($custom_field_label as $k=>$label)
                                        <div class="row">
                                            <div class="col-md-6">
                                                {{ $label }}
                                            </div>
                                            <div class="col-md-6">
                                                @if($custom_field_type[$k] == 3)
                                                    @if($custom_field_option[$k])
                                                        @foreach(explode(',', $custom_field_option[$k]) as $opt_k=>$opt_v)
                                                            {{ ($custom_field_data[$k] == $opt_k)? $opt_v:'' }}
                                                        @endforeach
                                                    @endif
                                                @else
                                                    {{ $custom_field_data[$k] }}
                                                @endif

                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Add Note Modal-->
    <div class="modal fade" id="add_customer_note">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_customer_note')</h4>
                    <button type="button" class="btn-close close_cus_note_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>@lang('index.note') {!! starSign() !!}</label>
                                            <textarea name="customer_note" class="form-control has-validation mb-3 customer_note" rows="40" placeholder="@lang('index.note')" required></textarea>
                                            <input type="hidden" class="customer_id" name="customer_id" value="{{ $obj->customer_id }}">
                                        </div>
                                        <span class="error_alert text-danger customer_note_error" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-2 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_customer_note">@lang('index.submit')</button>
                                    </div>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.customer_note_list')</h4>
                    <button type="button" class="btn-close close_cus_note_list_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="col-md-12">
                                    <h5>{!! $customer->first_name.' '.$customer->last_name !!}</h5>
                                    <p>{!! $customer->email !!}</p>
                                    <hr>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <p class="fw-bold m-0 p-0 fs-6">@lang('index.customer_notes')</p>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>@lang('index.sn')</th>
                                            <th class="w-20">@lang('index.date')</th>
                                            <th>@lang('index.note')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="append_new_added_note">
                                        @if(count($notes) > 0)
                                            @foreach($notes as $k=>$note)
                                                <tr>
                                                    <td>{{ ++$k }}</td>
                                                    <td>
                                                        {{ isset($note->created_at)? date(orgDateFormat($obj->created_at), strtotime($note->created_at)):'' }}
                                                        {{ isset($note->created_at)? date('h:i A', strtotime($note->created_at)):'' }}
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
    </div>

    <!-- Ticket Add Note Modal-->
    <div class="modal fade" id="add_ticket_note">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_ticket_note')</h4>
                    <button type="button" class="btn-close close_ticket_note_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>@lang('index.note') {!! starSign() !!}</label>
                                            <textarea name="ticket_note" class="form-control has-validation mb-3 ticket_note" rows="40" placeholder="@lang('index.note')" required></textarea>
                                        </div>
                                        <span class="error_alert text-danger ticket_note_error" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-2 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_ticket_note">@lang('index.submit')</button>
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
    <div class="modal fade" id="ticket_note_list">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.ticket_note_list')</h4>
                    <button type="button" class="btn-close close_ticket_note_list_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="col-md-12">
                                    <p class="fw-bold m-0 p-0 fs-6">@lang('index.ticket_no'){{ $obj->ticket_no ?? '' }}: {{ $obj->title ?? '' }}</p>
                                    <hr>
                                </div>
                                <div class="col-md-12 mt-3">
                                    <p class="fw-bold m-0 p-0 fs-6">@lang('index.customer_notes')</p>
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>@lang('index.sn')</th>
                                            <th class="w-20">@lang('index.date')</th>
                                            <th>@lang('index.ticket_note')</th>
                                        </tr>
                                        </thead>
                                        <tbody id="append_new_added_ticket_note">
                                        @if(count($ticket_notes) > 0)
                                            @foreach($ticket_notes as $k=>$note)
                                                <tr>
                                                    <td>{{ ++$k }}</td>
                                                    <td >
                                                        {{ isset($note->created_at)? date(orgDateFormat($obj->created_at), strtotime($note->created_at)):'' }}
                                                        {{ isset($note->created_at)? date('h:i A', strtotime($note->created_at)):'' }}
                                                    </td>
                                                    <td>{!! $note->ticket_note !!}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="last_note">
                                                <td colspan="3">{{ 'No Note' }}</td>
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
    </div>

    <!-- Ticket CC Add Modal-->
    <div class="modal fade" id="add_ticket_cc">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.add_cc')</h4>
                    <button type="button" class="btn-close close_ticket_cc_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>@lang('index.email') {!! starSign() !!}</label>
                                            <span class="" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('index.mail_temp_cc') }}">
                                    <iconify-icon icon="ri:question-fill" width="22"></iconify-icon> 
                                </span>
                                            <textarea class="form-control has-validation mb-3 ticket_cc" rows="40" required placeholder="example1@mail.com,example2@mail.com,example3@mail.com">{{ $obj->ticket_cc }}</textarea>
                                        </div>
                                        <span class="error_alert text-danger ticket_cc_error" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-2 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 add_new_ticket_cc">@lang('index.submit')</button>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.canned_msg')</h4>
                    <button type="button" class="btn-close close_canned_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="col-12 mb-2 canned_msg_search_box">
                    <div class="form-group">
                        {!! Form::text('canned_msg_search', null, ['class' => 'form-control canned_msg_search','placeholder'=>__('index.search')]) !!}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <ul class="canned_msg_ul">
                            @foreach($canned_message as $c_k=>$c_msg)
                                <li class="matched_canned_msg bg-light p-2 mb-2 me-2" data-id="{{ $c_msg->id }}" data-text="{!! $c_msg->canned_msg_content !!}">{!! $c_msg->title !!}</li>
                            @endforeach
                        </ul>             
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Article search Modal -->
    <div class="modal fade" id="article_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">@lang('index.article')</h4>
                    <button type="button" class="btn-close close_article_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="col-12 article_msg_search_box">
                    <div class="form-group">
                        {!! Form::text('article_search', null, ['class' => 'form-control article_search','placeholder'=>__('index.search')]) !!}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
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
                    <button type="button" class="btn-close close_assign_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
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
                                            {!! Form::select('assign_to_ids', $all_agents, !empty($obj->assign_to_ids)? explode(',', $obj->assign_to_ids):null, ['class'=>'form-control select2 assign_to_val','multiple']) !!}
                                        </div>
                                        <span class="error_alert text-danger assign_to_id_error" role="alert"></span>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>@lang('index.priority')</label>
                                            {!! Form::select('priority', ['1'=>'High', '2'=>'Medium', '3'=>'Low'], isset($obj->priority)? $obj->priority:null, ['class'=>'form-control select2 priority_val']) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-3 mb-2">
                                        <button type="button" class="btn bg-blue-btn w-100 set_new_ticket_assignee">@lang('index.submit')</button>
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
                    <button type="button" class="btn-close close_keyboard_shortcut_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="box-wrapper">
                        <!-- general form elements -->
                        <div class="table-box">
                            <div>
                                <div class="col-md-12 mt-3">
                                    <div class="btn-group d-flex">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button class="bg-light border-0 me-1 ms-1">alt</button> + <button class="bg-light border-0 me-1 ms-1">r</button> = @lang('index.open_replay')
                                    </div>
                                    <div class="btn-group d-flex mt-2">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button class="bg-light border-0 me-1 ms-1">alt</button> + <button class="bg-light border-0 me-1 ms-1">m</button> = @lang('index.open_canned_msg_modal')
                                    </div>
                                    <div class="btn-group d-flex mt-2">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button class="bg-light border-0 me-1 ms-1">alt</button> + <button class="bg-light border-0 me-1 ms-1">a</button> = @lang('index.open_article_modal')
                                    </div>
                                    <div class="btn-group d-flex mt-2">
                                        <button class="bg-light border-0 me-1">ctrl</button> + <button class="bg-light border-0 me-1 ms-1">alt</button> + <button class="bg-light border-0 me-1 ms-1">c</button> = @lang('index.close_ticket')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@push('js')
    <script src="{{ asset('frequent_changing/js/ticket-view-details.js?var=2.2') }}"></script>
@endpush
