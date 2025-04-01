<div class="modal fade" id="media_modal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">{{ __('index.add_media') }}</h4>
                <button type="button" class="btn-close close_media_modal" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="box-wrapper">
                    <!-- general form elements -->
                    <div class="table-box">
                        <div class="row">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link nav-color-normal active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">
                                        @lang('index.upload_file')
                                    </button>
                                    <button class="nav-link nav-color-normal" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">
                                        @lang('index.media_library')
                                    </button>
                                    <button class="nav-link nav-color-normal" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">
                                        @lang('index.insert_photo_url')
                                    </button>
                                    <button class="nav-link nav-color-normal" id="nav-video-tab" data-bs-toggle="tab" data-bs-target="#nav-video" type="button" role="tab" aria-controls="nav-video" aria-selected="false">
                                        @lang('index.insert_video_url')
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="box-wrapper">
                                        <!-- general form elements -->
                                        <div class="table-box">
                                            <form id="media-upload-form">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="">@lang('index.title'){!! starSign() !!} </label> 
                                                            <input type="text" id="media-title" class="form-control" placeholder="@lang('index.title')">
                                                        </div>
                                                        <span class="text-danger media-title-error displayNone">
                                                            @lang('index.title_required')
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>@lang('index.group') {!! starSign() !!}</label>
                                                            <select class="form-control select2" id="media-group" name="group">
                                                                <option value="">@lang('index.select')</option>
                                                                <option value="blog">@lang('index.blog')</option>
                                                                <option value="page">@lang('index.page')</option>
                                                                @foreach ($media_groups as $value)
                                                                    <option value="{{$value->id}}">
                                                                        {{$value->title}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <span class="text-danger media-group-error displayNone">
                                                            @lang('index.title_group_id')
                                                        </span>
                                                    </div>
                                                    <div class="col-md-4 txt-uh-50">
                                                        <div class="form-group">
                                                            <label for="">@lang('index.media_file') (@lang('index.max_file_size_2mb')){!! starSign() !!}</label>
                                                            
                                                            <input type="file" id="upload" class="form-control file_checker_global" data-this_file_size_limit="2">
                                                        </div>
                                                        <span class="text-danger media-file-error displayNone">
                                                            @lang('index.title_media_path')
                                                        </span>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row mt-2">
                                                <div class="img-container">
                                                    <img class="img-fluid displayNone"/>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-sm-12 col-md-2 mb-2">
                                                    <button type="button" class="btn bg-blue-btn w-100 upload-result" id="upload-media">
                                                        <span class="me-2 media-spinner d-none"><iconify-icon icon="la:spinner" width="22"></iconify-icon></span>
                                                        @lang('index.submit')
                                                    </button>
                                                </div>
                                                <div class="col-sm-12 col-md-2 mb-2">
                                                    <button type="button" class="btn bg-blue-btn w-100 cancle_media">@lang('index.cancel')</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="row">
                                        <div class="col-sm-12 mb-2 col-md-4">
                                            <div class="form-group">
                                                <select class="form-control select2" id="media_group" name="group">
                                                    <option value="All">@lang('index.all_group')</option>
                                                    <option value="blog">@lang('index.blog')</option>
                                                    <option value="page">@lang('index.page')</option>
                                                    @foreach (getAllProductCategory() as $value)
                                                        <option value="{{$value->id}}" {{ isset($obj) && $obj->group == $value->id ? 'selected' : '' }}>
                                                            {{$value->title}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if ($errors->has('group'))
                                                <span class="error_alert text-danger" role="alert">
                                                    {{ $errors->first('group') }}
                                                </span>
                                            @endif
                                        </div>
                                        <div class="col-sm-12 mb-2 col-md-4">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="media_title" placeholder="@lang('index.search_by_media_title')">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row justify-content-center media_body">
                                        <input type="hidden" id="selected_src" value="">
                                        <div class="media_files">

                                            @foreach (getAllMedia() as $key=>$media)
                                                <div class="file_media cursor-pointer col-xl-2 col-lg-2 col-md-3 col-sm-4" data-src="{{ asset($media->media_path) }}">
                                                    <figure>
                                                      <img src="{{asset($media->thumb_img)}}" class="img-fluid p-1" width="100%" >
                                                      <figcaption class="text-truncate">
                                                          <small class="media_title_text">
                                                            {{ $media->title ?? "" }}
                                                        </small>
                                                      </figcaption>
                                                    </figure>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group mt-0">
                                            <button id="insert_media" class="btn btn-md bg-blue-btn pull-right">@lang('index.select')</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">@lang('index.photo_url') {!! starSign() !!}</label>
                                                <input type="text" class="form-control" id="file_url" placeholder="@lang('index.paste_or_type')">
                                                <span class= "text-danger display-none" id="file_url_error">
                                                    @lang('index.photo_url_required')
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="" for="">&nbsp;</label>
                                                <button type="button" id="file_insert_btn" class="btn bg-blue-btn  ">@lang('index.submit')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="nav-video" role="tabpanel" aria-labelledby="nav-video-tab">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="">@lang('index.youtube_video_url'){!! starSign() !!}</label> 
                                                </a>
                                                <input type="text" class="form-control" id="video_url" placeholder="@lang('index.paste_or_type')">
                                                <span class= "text-danger display-none" id="video_error">
                                                    @lang('index.youtube_video_url_required')
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="" for="">&nbsp;</label>
                                                <button type="button" id="video_insert_btn" class="btn bg-blue-btn">@lang('index.submit')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
