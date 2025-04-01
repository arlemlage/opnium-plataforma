
@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show">
        <div class="alert-body">
            <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}" width="22"></iconify-icon>{{ Session::get('message') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-warning alert-dismissible fade show">
        <div class="alert-body">
            <p><iconify-icon icon="{{ Session::get('sign') ?? 'material-symbols:check' }}" width="22"></iconify-icon>{{ Session::get('success') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <div class="alert-body">
            <p><iconify-icon icon="{{ Session::get('sign') ?? 'uil:times' }}" width="22"></iconify-icon>{{ Session::get('error') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('warning'))
    <div class="alert alert-warning alert-dismissible fade show">
        <div class="alert-body">
            <p><iconify-icon icon="{{ Session::get('sign') ?? 'uil:times' }}" width="22"></iconify-icon>{{ Session::get('error') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(Session::has('warning_demo'))
    <div class="alert alert-warning alert-dismissible fade show">
        <div class="alert-body">
            <p><iconify-icon icon="{{ Session::get('sign') ?? 'uil:times' }}" width="22"></iconify-icon>{{ Session::get('warning_demo') }}</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
