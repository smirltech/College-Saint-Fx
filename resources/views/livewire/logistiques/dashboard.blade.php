@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-book mr-1"></span>Logistique</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Logistique</li>
            </ol>
        </div>
    </div>

@stop
<div class="">

    <div class="content mt-3">
        <div class="container">
            <div class="col-12">
                <div class="mb-5">
                    <div class="row g-2">
                        @foreach ($boxes as $box)
                            <div class="col-md-6 col-12">
                                <a href="{{ $box['url'] }}">
                                <div class="info-box bg-{{ $box['theme'] }}">
                                    <span class="info-box-icon"><i class="{{ $box['icon'] }}{{--far fa-bookmark--}}"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $box['text'] }}</span>
                                        <span class="info-box-number">{{ $box['title'] }}</span>

                                    </div>
                                </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
