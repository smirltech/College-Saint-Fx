<div class="content mt-3">
    <div class="row">
        <div class="col-12">
            <div class="mb-5">
                <div class="row g-2">
                    @foreach ($boxes as $box)
                        <div class="col-md-3 col-sm-6 col-12">
                            <a href="{{ $box['url'] }}">
                                <div class="info-box bg-{{ $box['theme'] }}">
                                        <span class="info-box-icon"><i
                                                class="{{ $box['icon'] }}{{--far fa-bookmark--}}"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ $box['text'] }}</span>
                                        <span class="info-box-number">{{ $box['title'] }}</span>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: {{$box['rate']}}"></div>
                                        </div>
                                        <span class="progress-description">
                                            {{$box['subtitle']}}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:scolarite.presences.charts.presences-line/>
        </div>
    </div>
</div>
