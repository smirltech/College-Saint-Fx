@section('content_header')
@endsection
<div class="pb-3">
    <div class="content mt-3">
        <div class="mb-5">
            <div class="">
                <h3 class="container">Bienvenue {{auth()->user()->nom}}</h3>
                <p hidden class="container">Cette page est une page d'entrée pour tous les utilisateurs du système.
                    À partir d'ici, les utilisateurs peuvent naviguer selon le menu en leur disposition.</p>

            </div>
        </div>
        <div class="container">
            <div class="col-12">
                <div class="mb-5">
                    <div class="row g-2">
                        @foreach ($boxes as $box)
                            <div class="col-md-6 col-12">
                                <a href="{{ $box['url'] }}">
                                    <div class="info-box bg-{{ $box['theme'] }}">
                                        <span class="info-box-icon"><i
                                                class="{{ $box['icon'] }}{{--far fa-bookmark--}}"></i></span>
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
