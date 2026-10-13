@php
    use Pharaonic\Laravel\Readable\Readable;
@endphp
<div>
    <div class="row">
        <div class="col-sm-3 col-6">
            <div class="description-block border-right">
                <span class="description-percentage text-{{$changeSignRevenus['text']}}"><i
                        class="fas fa-caret-{{$changeSignRevenus['caret']}}"></i> @if($changeRevenus < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($changeRevenus),showDecimal: true, decimals: 2)}}%</span>
                <h5 class="description-header">
                    <small>Fc</small> @if($totalRevenus < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($totalRevenus),showDecimal: true, decimals: 2)}}
                </h5>
                <span class="description-text">TOTAL REVENUS</span>
            </div>

        </div>

        <div class="col-sm-3 col-6">
            <div class="description-block border-right">
                <span class="description-percentage text-{{$changeSignDepenses['text']}}"><i
                        class="fas fa-caret-{{$changeSignDepenses['caret']}}"></i> @if($changeDepenses < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($changeDepenses),showDecimal: true, decimals: 2)}}%</span>
                <h5 class="description-header">
                    <small>Fc</small> @if($totalDepenses < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($totalDepenses),showDecimal: true, decimals: 2)}}
                </h5>
                <span class="description-text">TOTAL DEPENSES</span>
            </div>

        </div>

        <div class="col-sm-3 col-6">
            <div class="description-block border-right">
                <span class="description-percentage text-{{$changeSignSolde['text']}}"><i
                        class="fas fa-caret-{{$changeSignSolde['caret']}}"></i>@if($changeSolde < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($changeSolde),showDecimal: true, decimals: 2)}}%</span>
                <h5 class="description-header">
                    <small>Fc</small> @if($totalSolde < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($totalSolde),showDecimal: true, decimals: 2)}}
                </h5>
                <span class="description-text">TOTAL SOLDE</span>
            </div>

        </div>

        <div class="col-sm-3 col-6">
            <div class="description-block">
                <span class="description-percentage text-{{$changeSignPerceptions['text']}}"><i
                        class="fas fa-caret-{{$changeSignPerceptions['caret']}}"></i> @if($changePerceptions < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($changePerceptions),showDecimal: true, decimals: 2)}}%</span>
                <h5 class="description-header">
                    <small>Fc</small> @if($totalPerceptions < 0)
                        -
                    @endif{{Readable::getHumanNumber(abs($totalPerceptions),showDecimal: true, decimals: 2)}}
                </h5>
                <span class="description-text">TOTAL FRAIS IMPAYES</span>
            </div>

        </div>
    </div>
</div>
