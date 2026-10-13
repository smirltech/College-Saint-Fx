@section('title')
    {{$title}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-tags mr-1"></span>Liste d'étiquettes</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Étiquettes</li>
            </ol>
        </div>
    </div>

@stop
<div wire:ignore.self class="">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">

                            </div>
                            <div class="card-tools d-flex my-auto">
                                @can('tags.create')
                                    <button type="button"
                                            wire:click="$emit('showModal','bibliotheque.tags.create-tag-modal')"
                                            class="btn btn-primary  ml-2"><span
                                            class="fa fa-plus"></span></button>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body m-b-40">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-primary">
                                    <tr>
                                        <th style="width: 50px">#</th>
                                        <th>ÉTIQUETTE</th>
                                        <th style="width: 50px"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($etiquettes as $i=>$etiquette)
                                        <tr>
                                            <td>{{$i+1}}</td>
                                            <td>{{$etiquette->nom}}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    @can('tags.update',$etiquette)
                                                        <button
                                                            wire:click="$emit('showModal','bibliotheque.tags.create-tag-modal','{{$etiquette->id}}')"
                                                            title="Modifier"
                                                            class="btn btn-info  ml-2"
                                                        >
                                                            <span class="fa fa-pen"></span>
                                                        </button>
                                                    @endcan
                                                    @can('tags.delete',$etiquette)
                                                        <button wire:click="deleteEtiquette('{{$etiquette->id}}')"
                                                                title="supprimer"
                                                                class="btn btn-danger  ml-2">
                                                            <span class="fa fa-trash"></span>
                                                        </button>
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
</div>

