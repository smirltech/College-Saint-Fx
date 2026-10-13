<div>
    <p class="text-center">
        <strong>Performance Recouvrement Frais</strong>
    </p>
    @foreach($frais as $fee)
        <div class="progress-group">
            {{$fee['name']}}
            <span class="float-right"><b>{{$fee['montant']}}</b>/{{$fee['total']}}</span>
            <div class="progress progress-sm">
                <div class="progress-bar bg-{{$fee['color']}}" style="width: {{$fee['rate']}}%"></div>
            </div>
        </div>
    @endforeach
</div>
