<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">@lang('index.file_title') {!! starSign() !!}</label>
            <input type="text" name="file_title[]" class="form-control file_title_require_checker" required placeholder="@lang('index.file_title')">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="files">@lang('index.file') {!! starSign() !!}</label>
            <input type="file" name="files[]" class="form-control file_require_checker" required>
        </div>
    </div>
    <div class="col-sm-12 mb-2 col-md-2 ">
        <div class="form-group ">
            <label for=""></label>
            <button type="button" class="btn btn-md btn-danger ds_remove_file ds_mt_34" id="" >
                <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="22"></iconify-icon>
            </button>
        </div>
    </div>
</div>
