@extends('layouts.app')
@push('css')
    <link rel="stylesheet" href="{{ asset('frequent_changing/crop/cropper.min.css?var=2.2') }}">
    <link rel="stylesheet" href="{{ asset('frequent_changing/css/magnific-popup.css?var=2.2') }}">
@endpush

@section('content')
    <input type="hidden" id="page-name" value="media-list">
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}"
                        class="top-left-header mb-0">{{ __('index.media_list') }}</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.media'), 'secondSection' => __('index.media_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="row">
                    <div class="col-md-4">
                        <select id="group" class="form-control select2 w-300">
                            <option value="">@lang('index.group')</option>
                            <option value="{{ route('media.index',['group' => encrypt_decrypt('blog','encrypt')]) }}" {{ isset($group_id) && encrypt_decrypt($group_id,'decrypt') == "blog" ? 'selected' : '' }}>@lang('index.blog')</option>
                            <option value="{{ route('media.index',['group' => encrypt_decrypt('page','encrypt')]) }}" {{ isset($group_id) && encrypt_decrypt($group_id,'decrypt') == "page" ? 'selected' : '' }}>@lang('index.page')</option>
                            @foreach($product_category as $group)
                                <option value="{{ route('media.index',['group' => encrypt_decrypt($group->id,'encrypt')]) }}" {{ isset($group_id) && $group->id == encrypt_decrypt($group_id,'decrypt') ? 'selected' : '' }}>{{ $group->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="w-20">@lang('index.media_title')</th>
                            <th class="ir_w_12">@lang('index.thumbnail')</th>
                            <th class="ir_w_12">@lang('index.group')</th>
                            <th class="ir_w_12">@lang('index.created_at')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($obj as $value)
                            <tr>
                                <td class="">{{ $loop->index + 1 }}</td>
                                <td>
                                    <span class="text-short">{{ $value->title ?? "" }}</span>
                                </td>
                                <td>
                                    <a class="popup-with-move-anim c-btn btn-fill py-2 opacity-hover "
                                       href="#photo{{ $loop->index }}">
                                        <img src="{{ asset($value->thumb_img) }}" alt="" class="img-responsive"
                                             width="80" height="50">
                                    </a>
                                    <div id="photo{{ $loop->index }}"
                                         class="zoom-anim-dialog mfp-hide mfp-custom-modal">
                                        <img src="{{ asset($value->media_path) }}" alt="" class="w-100">
                                    </div>
                                </td>
                                <td>{{ productCatName($value->group) }}</td>
                                <td>
                                    {{ orgDateFormat($value->created_at) }}
                                </td>

                                <td class="">
                                    <div class="d-flex gap8">
                                        @if(routePermission('media.edit'))
                                            <a href="{{ route('media.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('media.destroy'))
                                            <form action="{{ route('media.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
                                                  class="edit alertDelete{{$value->id}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a class="deleteRow delete" data-form_class="alertDelete{{$value ->id}}"
                                                   href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                                   data-bs-original-title="@lang('index.delete')">
                                                    <i class="fa fa-trash"></i>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('js')
    <script src="{{ asset('frequent_changing/crop/cropper.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/jquery.magnific-popup.min.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/file_viewer.js?var=2.2') }}"></script>
    <script src="{{ asset('frequent_changing/js/media.js?var=2.2') }}"></script>
    @include('layouts.data_table_script')
@endpush
