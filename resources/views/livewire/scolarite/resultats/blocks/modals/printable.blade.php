
<x-adminlte-modal wire:ignore.self id="resultatsPrint0" icon="fa fa-cubes"
                  title="Résultats">
    <div id="resultatsPrint">
        <h2 style="text-align: center;">COLLÈGE ÉXCELLENT NYEMBE KAZAMBI</h2>
        <h3 style="text-align: center;">ANNÉE SCOLAIRE : {{mb_strtoupper(\App\Models\Annee::encours()->nom)}}</h3>
        <h3 style="text-align: center;">{{mb_strtoupper($classe->fullReverseName)}}</h3>
        <h3 style="text-align: center;">RÉSULTATS DE {{mb_strtoupper($resultatType->longLabel())}}</h3>
    <hr>
        <div class="card-body p-0 table-responsive">
        <table style="width: 100%;" class="table">
            <thead>
            <tr>
                <th style="text-align: center;">PLACE</th>
                <th style="text-align: left;">ÉLÈVE</th>
                <th style="text-align: right;">POURCENT</th>
                <th style="text-align: right;">CONDUITE</th>
            </tr>
            </thead>
            <tbody>
            @if($resultatType != null)
                @foreach($inscriptions as $inscription)
                    @php
                        $resultat = $inscription->resultats()->where('custom_property', $resultatType)->first();
                    @endphp
                    <tr>
                        <td style="text-align: center;">{{$resultat?->place}}</td>
                        <td>{{$inscription->eleve->fullName}}</td>
                        <td style="text-align: right;">{{$resultat?->pourcentage}}%</td>
                        <td style="text-align: right;">{{strtoupper($resultat?->conduite?->value)}}</td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    </div>
</x-adminlte-modal>

