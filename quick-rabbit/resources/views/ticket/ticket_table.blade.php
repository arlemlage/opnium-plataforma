<input type="hidden" id="key_hidden" value="{{ request()->get('key') }}">
<input type="hidden" id="email_hidden" value="{{ request()->get('email') }}">
<input type="hidden" id="customer_id_hidden" value="{{ request()->get('customer_id') }}">
<input type="hidden" id="product_category_id_hidden" value="{{ request()->get('product_category_id') }}">
<input type="hidden" id="department_id_hidden" value="{{ request()->get('department_id') }}">
<input type="hidden" id="agent_id_hidden" value="{{ request()->get('agent_id') }}">
<input type="hidden" id="purchase_code_hidden" value="{{ request()->get('purchase_code') }}">
<input type="hidden" id="ajax_datatable_url" value="{{ url('get-tickets') }}">

<section class="main-content-wrapper">
    <h2 class="display-none">&nbsp;</h2>
    <div class="alert-wrapper">
        {{ alertMessage() }}
        @if (Session::has('permission_message'))
            <div class="alert alert-danger alert-dismissible fade show">
                <div class="alert-body">
                    <p>

                        <iconify-icon icon="uil:times" width="22"></iconify-icon>
                        {{ Session::get('permission_message') }}
                    </p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <section class="content-header">
        <div class="row justify-content-between">
            <div class="col-6 p-0">
                <h3 dir="{{ isArabic() ? 'rtl' : 'ltr' }}" class="top-left-header mt-2">{{ __('index.ticket_list') }}
                </h3>
            </div>
            @include('layouts.breadcrumbs', ['firstSection' => __('index.ticket')])
        </div>
    </section>
    <input type="hidden" class="datatable_name" data-title="Users" data-id_name="datatable">
    <div class="box-wrapper pt-0">
        <!-- Search -->
        <form action="{{ url('/ticket') }}" method="GET">
            <div class="row" id="custom-button-group">
                <div class="col-xl-12 col-12 mt-2">
                    <?php
                    //active button checking variable
                    $purchase_code = isset($_GET['purchase_code']) && $_GET['purchase_code'] ? $_GET['purchase_code'] : '';
                    $is_active = isset($_GET['key']) && $_GET['key'] ? $_GET['key'] : $purchase_code;
                    
                    ?>
                    <div class="d-flex overflow-auto gap15 py-3" id="ticket_index_search_btn">
                        @isset($all_t)
                            <a data-key="all"
                                class="custom_header_btn redirect_url btn ticket-list-btn cus_css btn-md  {{ !isset($key) || (isset($key) && $key == 'all') ? (!$purchase_code ? 'ticket-btn-active' : '') : '' }}"
                                href="{{ url('ticket?key=all') }}"><span
                                    class="badge_c">{{ $all_t }}</span>@lang('index.all')</a>
                        @endisset
                        @isset($all_t_open)
                            <a data-key="open"
                                class="custom_header_btn redirect_url btn ticket-list-btn cus_css <?php echo $is_active == 'open' ? 'ticket-btn-active' : ''; ?>"
                                href="{{ url('ticket?key=open') }}"><span class="badge_c">{{ $all_t_open }}</span>
                                @lang('index.open')</a>
                        @endisset

                        @if (authUserRole() != 3)
                            <a data-key="n_action"
                                class="custom_header_btn redirect_url btn ticket-list-btn cus_css <?php echo $is_active == 'n_action' ? 'ticket-btn-active' : ''; ?>"
                                href="{{ url('ticket?key=n_action') }}"><span
                                    class="badge_c">{{ $all_t_need_action }}</span> @lang('index.need_action')
                            </a>
                        @endif

                        @if (App\Model\IntegrationSetting::first()->envato_set_up == 'on')
                            @if (authUserRole() != 3)
                                <a class="custom_header_btn btn ticket-list-btn cus_css open_p_code_modal <?php echo $purchase_code ? 'ticket-btn-active' : ''; ?>"
                                    href="#">
                                    @lang('index.purchase_code')
                                </a>
                            @endif
                        @endif

                        @if (authUserRole() != 3)
                            @isset($all_t_flag)
                                <a data-key="flagged"
                                    class="custom_header_btn redirect_url btn ticket-list-btn cus_css <?php echo $is_active == 'flagged' ? 'ticket-btn-active' : ''; ?>"
                                    href="{{ url('ticket?key=flagged') }}"><span
                                        class="badge_c">{{ $all_t_flag }}</span> @lang('index.flagged')</a>
                            @endisset
                        @endif
                        @isset($all_t_closed)
                            <a data-key="closed"
                                class="custom_header_btn redirect_url btn ticket-list-btn cus_css <?php echo $is_active == 'closed' ? 'ticket-btn-active' : ''; ?>"
                                href="{{ url('ticket?key=closed') }}"><span class="badge_c">{{ $all_t_closed }}</span>
                                @lang('index.closed')</a>
                        @endisset
                        @if (authUserRole() != 3)
                            @isset($all_t_archived)
                                <a data-key="archived"
                                    class="custom_header_btn redirect_url btn ticket-list-btn cus_css <?php echo $is_active == 'archived' ? 'ticket-btn-active' : ''; ?>"
                                    href="{{ url('ticket?key=archived') }}"><span
                                        class="badge_c">{{ $all_t_archived }}</span> @lang('index.archived')</a>
                            @endisset
                        @endif

                    </div>
                </div>
            </div>
            <hr class="m-0 mb-3">
            <div class="row my-3">
                <div class="col-12 col-md-{{ authUserRole() == 3 ? '10' : '4' }} mb-2 search_inp_focus">
                    <div class="form-group" id="search_wrap">
                        <input type="text" name="full_text_search" onfocus="select();"
                            value="{{ $fulltext_search ?? '' }}" id="full_text_search"
                            class="form-control full_text_search" placeholder="@lang('index.full_text_search')" autocomplete="off">
                        <ul class="results d-none"></ul>
                    </div>
                </div>
                @if (authUserRole() != 3)
                    <div class="col-12 col-md-4 col-lg-2 mb-2">
                        <div class="form-group">
                            <select name="customer_id" class="form-control select2" id="customer_id">
                                <option value="">@lang('index.customer')</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ encrypt_decrypt($customer->id, 'encrypt') }}"
                                        {{ isset($customer_id) && encrypt_decrypt($customer_id, 'decrypt') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->full_name }}({{ $customer->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @if (authUserRole() == 1)
                        <div class="col-12 col-md-4 col-lg-2 mb-2">
                            <div class="form-group">
                                <select name="agent_id" class="form-control select2" id="agent_id">
                                    <option value="">@lang('index.agent')</option>
                                    @foreach ($agents as $agent)
                                        <option value="{{ encrypt_decrypt($agent->id, 'encrypt') }}"
                                            {{ isset($agent_id) && encrypt_decrypt($agent_id, 'decrypt') == $agent->id ? 'selected' : '' }}>
                                            {{ $agent->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    @if (authUserRole() != 3)
                        <div class="col-12 col-md-4 col-lg-2 mb-2">
                            @if (appTheme() == 'multiple')
                                <div class="form-group">
                                    <select name="product_category_id" class="form-control select2"
                                        id="product_category_id">
                                        <option value="">@lang('index.product_category')</option>
                                        @foreach ($product_categories as $product)
                                            <option value="{{ encrypt_decrypt($product->id, 'encrypt') }}"
                                                {{ isset($product_category_id) && encrypt_decrypt($product_category_id, 'decrypt') == $product->id ? 'selected' : '' }}>
                                                {{ $product->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <select name="department_id" class="form-control select2" id="department_id">
                                        <option value="">@lang('index.department')</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ isset($department_id) && $department_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif

                        </div>
                    @endif

                @endif

                <div class="col-12 col-md-4 col-lg-2 mb-2">
                    <div class="form-group">
                        <button type="submit" class="btn bg-blue-btn w-100"
                            id="go">@lang('index.search')</button>
                    </div>
                </div>
            </div>
        </form>        
        <div class="table-box">
            <div class="table-responsive">
                <table id="datatable_ticket" class="table">
                    <thead>
                        <tr>
                            <th class="text-left w-10">@lang('index.ticket_id')</th>
                            <th class="w-20">@lang('index.title')</th>
                            @if (appTheme() == 'multiple')
                                <th class="w-10">@lang('index.product_category')</th>
                            @else
                                <th class="w-10">@lang('index.department')</th>
                            @endif
                            @if (authUserRole() != 3)
                                <th class="w-10">@lang('index.customer')</th>
                            @endif
                            <th class="w-10">@lang('index.created_at')</th>
                            <th class="w-10">@lang('index.updated_at')</th>
                            <th class="w-15">@lang('index.last_commented_by')</th>
                            @if (authUserRole() != 3)
                                <th class="w-1">@lang('index.flag')</th>
                            @endif
                            <th>@lang('index.status')</th>
                            <th class="text-nowrap">@lang('index.action')</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<!-- Purchase code Modal-->
<div class="modal fade" id="p_code_modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">@lang('index.p_code_search')</h4>
                <button type="button" class="btn-close close_p_code_modal" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span></button>
            </div>
            <div class="modal-body">
                <div class="box-wrapper">
                    <!-- general form elements -->
                    <form action="{{ url('ticket') }}" method="GET" class='needs-validation' novalidate>
                        <div class="table-box">
                            <div>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-group">
                                            <label>@lang('index.purchase_code') {!! starSign() !!}</label>
                                            <input type="text" name="purchase_code"
                                                class="form-control has-validation ticket_note" value=""
                                                placeholder="@lang('index.enter_purchase_code')" required>
                                            <div class="invalid-feedback">
                                                @lang('index.p_code_search_field_required')
                                            </div>
                                        </div>
                                        <span class="error_alert text-danger p_code_error" role="alert"></span>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-sm-12 col-md-2 mb-2">
                                        <button type="submit"
                                            class="btn btn-md bg-blue-btn">@lang('index.submit')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
