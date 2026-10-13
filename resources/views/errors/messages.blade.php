@if(count($errors)>0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
            <div class="alert-text">{!! $error !!}</div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <i class="zmdi zmdi-close-circle"></i>
            </button>
        </div>

    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-primary d-flex align-items-center justify-content-between" role="alert">
        <div class="alert-text">{!! session('success') !!}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="zmdi zmdi-close-circle"></i>
        </button>
    </div>
@endif



@if(session('error'))
    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
        <div class="alert-text">{!!session('error')!!}</div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="zmdi zmdi-close-circle"></i>
        </button>
    </div>
@endif



