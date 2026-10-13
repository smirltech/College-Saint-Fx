@section('content_header')
    <h1>Elève : {{$eleve->fullName}}</h1>
@stop
<div class="card">
    <div class="card-body m-b-40 table-responsive">
        {!! $calendar_view !!}
    </div>
</div>
@push('js_top')
    {!! $calendar_script !!}
@endpush
