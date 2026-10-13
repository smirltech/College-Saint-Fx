@php use App\Models\Annee; @endphp
<div class="card">
    <div class="card-header">
        Depenses récentes
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
            <tr>
                <th>Depense</th>
                <th>Montant</th>
                <th>Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($depenses as $depense)
                <tr>
                    <td>
                        <b>{{ $depense->type->nom }}</b>
                    </td>
                    <td>{{ $depense->montant }}{{ $depense->devise }}</td>
                    <td>{{ $depense->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
