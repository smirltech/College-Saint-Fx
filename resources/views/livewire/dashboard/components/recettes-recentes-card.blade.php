@php use App\Models\Annee; @endphp
<div class="card">
    <div class="card-header">
        Recettes récentes
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>Recette</th>
                <th>Montant</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($recettes as $recette)
                <tr>
                    <td>
                        <b>{{ $recette->frais->nom }}</b>
                    </td>
                    <td>{{ $recette->montant }}{{ $recette->devise }}</td>
                    <td>{{ $recette->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
