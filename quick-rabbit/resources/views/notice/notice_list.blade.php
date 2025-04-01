@extends('layouts.app')
@push('css')
@endpush

@section('content')
    <section class="main-content-wrapper">
        <h2 class="display-none">&nbsp;</h2>
        <div class="alert-wrapper">
            {{ alertMessage() }}
        </div>
        <section class="content-header">
            <div class="row justify-content-between">
                <div class="col-6 p-0">
                    <h3 dir="{{isArabic() ? 'rtl' : 'ltr'}}" class="top-left-header mt-2">@lang('index.notice_list')</h3>
                    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
                </div>
                @include('layouts.breadcrumbs', ['firstSection' => __('index.notice'), 'secondSection' => __('index.notice_list')])
            </div>
        </section>
        <div class="box-wrapper">
            <div class="table-box">
                <div class="table-responsive">
                    <table id="datatable" class="table">
                        <thead>
                        <tr>
                            <th class="ir_w_1">@lang('index.sn')</th>
                            <th class="ir_w_12">@lang('index.title')</th>
                            <th class="ir_w_12">@lang('index.notice')</th>
                            <th class="ir_w_12">@lang('index.start_date')</th>
                            <th class="ir_w_12">@lang('index.end_date')</th>
                            <th class="ir_w_1_txt_center">@lang('index.action')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($results as $value)
                            <tr>
                                <td class="">{{ $loop->index + 1 }}</td>
                                <td>{{ Str::limit($value->title, 60, '...') ?? "" }}</td>
                                <td>
                                    <span class="text-short">{!! Str::limit($value->notice, 100, '...') ?? '' !!} <i class="fa fa-eye ms-2 readMore" data-desc="{{ $value->notice }}" role="button"></i></span>
                                </td>
                                <td>{{ $value->start_date ?? "" }}</td>
                                <td>{{ $value->end_date ?? "" }}</td>

                                <td class="">
                                    <div class="d-flex gap8">
                                        @if(routePermission('notices.edit'))
                                            <a href="{{ route('notices.edit', encrypt_decrypt($value->id, 'encrypt')) }}"
                                               class="edit success-color" data-bs-toggle="tooltip" data-bs-placement="top"
                                               data-bs-original-title="@lang('index.edit')">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(routePermission('notices.destroy'))
                                            <form action="{{ route('notices.destroy', encrypt_decrypt($value->id, 'encrypt')) }}"
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
       <!-- ReadMore Modal-->
 @include('helper.__read_more_modal')
@endsection

@push('js')
    @include('layouts.data_table_script')
@endpush
