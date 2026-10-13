@php use App\Helpers\Helpers;use Carbon\Carbon; @endphp
<div id="factPrint" class="text-center" style="text-align:center">
    <div style="text-align:center">
        <img width="80px" src="{{ url('/images/logo.png') }}" alt="cenk logo">
    </div>
    <strong>COLLÈGE ST FRANÇOIS XAVIER</strong>
    <div style="margin-bottom:10px">AV. Kilenge coin Wamba, Q/Bel-Air C/Kampembe, Lubumbashi – RDC</div>
{{--    <div style="margin-bottom:10px"><span>Telephone:000</span> <span>Email:email</span></div>--}}

    <div>REÇU N°{{$perception?->reference}}</div>
    <div>Date: {{ Carbon::now()->format("d-m-Y à H:i:s") }}</div>
    <br>
    <div>Élève : <strong>{{$inscription?->eleve->fullName}}</strong></div>
    @if($inscription?->eleve?->matricule)
        <div>
            Matricule : <strong>{{ $inscription->eleve->matricule }}</strong>
        </div>
    @endif
    <br>
    <div style="width: 100%">
        <span style="float:left; margin-right:10px">{{$inscription?->classe?->niveau?->label()}}</span>
        <span style="text-align:center; margin-right:10px">{{$inscription?->classe->parent->nom}}</span>
        <span style="float:right">{{$annee->nom}}</span>
    </div>
    <br>

    @if($perception->custom_property)
        <div>
            MOIS DE {{ [
            1=>'JANVIER',2=>'FÉVRIER',3=>'MARS',4=>'AVRIL',5=>'MAI',6=>'JUIN',
            7=>'JUILLET',8=>'AOÛT',9=>'SEPTEMBRE',10=>'OCTOBRE',11=>'NOVEMBRE',12=>'DÉCEMBRE'
        ][$perception->custom_property] ?? '' }}
        </div>
    @endif
    
    
    @isset($perception->frais->nom)
        @if($perception->frais->nom !== '')
            <div>
                <strong>{{ strtoupper($perception->frais->nom) }}</strong>
            </div>
        @endif
    @endisset



    <br>
    <div class="table-responsive">
        <table style="width:100%">
            <thead>
            <tr>
                <th>MONTANT DÛ</th>
                <th>MONTANT PAYÉ</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{ number_format($perception->frais_montant) }} {{ $perception->frais->devise }}</td>
                <td>{{ number_format($perception->montant) }} {{ $perception->frais->devise }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <hr>
    <div style="text-align:right">Total : <strong>{{ Helpers::currencyFormat($perception->montant) }}</strong></div>
    <div style="text-align:right">Cash : <strong>{{ Helpers::currencyFormat($perception->montant) }} {{ 
$perception->frais->devise }}</strong></div>
    <div style="text-align:right">Reste : <strong>{{ Helpers::currencyFormat($perception->reste) }} {{ 
$perception->frais->devise }}</strong></div>
    @if($perception?->paid_by)
        <div style="text-align:right">Payé par : <strong>{{$perception->paid_by}}</strong></div>
    @endif
    <br>
    <div class="w3-small text-center">COLLÈGE ST FRANÇOIS XAVIER - FINANCE</div>

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script>
        function redirectBack() {
            window.location.href = "{{ URL::previous() }}";
        }

        printJS({
            printable: 'factPrint',
            type: 'html',
            targetStyles: ['*'],
            maxWidth: 300,
            style: "text-align:center",
            onPrintDialogClose: redirectBack
        });

        if (window.matchMedia) {
            window.matchMedia('print').addEventListener('change', function(e) {
                if (!e.matches) {
                    redirectBack();
                }
            });
        } else {
            window.onafterprint = redirectBack;
        }

        setTimeout(() => {
            redirectBack();
        }, 10000);
    </script>

</div>

