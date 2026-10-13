@php use App\Models\Option; @endphp
@php use App\Models\Section; @endphp
@section('title')
    - Liste des devoirs
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de devoirs</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Devoirs</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('devoirs.create')
                                    <a href="{{ route('scolarite.devoirs.create') }}" title="ajouter"
                                       class="btn btn-primary mr-2"><span
                                                class="fa fa-plus"></span></a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>NO.</th>
                                    <th>TITRE</th>
                                    <th>COURS</th>
                                    <th>DEPOTS</th>
                                    <th>CLASSE</th>
                                    <th>ECHEANCE</th>
                                    <th>STATUS</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($devoirs as $k=>$devoir)
                                    <tr>
                                        <td>{{ $k+1 }}</td>
                                        <td>{{ $devoir->titre }}</td>
                                        <td>
                                            {{ $devoir->cours->nom }}
                                        </td>
                                        <td>
                                            {{ $devoir->reponses->count() }}
                                            / {{ $devoir->classe->eleves->count() }}
                                        </td>
                                        <td>
                                            {{ $devoir->classe->code }}
                                        </td>
                                        <td>
                                            {{ $devoir->echeance_display }}
                                        </td>
                                        <td>
                                            <span class="badge bg-{{$devoir->status?->variant()}}">
                                                 {{ $devoir->status?->label() }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="d-flex float-right">
                                                @can('devoirs.view',$devoir)
                                                    <a href="{{route('scolarite.devoirs.show',$devoir )}}"
                                                       title="modifier"
                                                       class="btn btn-sm btn-primary ml-2">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('devoirs.update',$devoir)
                                                    <a href="{{route('scolarite.devoirs.edit',$devoir )}}"
                                                       title="modifier"
                                                       class="btn btn-sm btn-warning  ml-2">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
