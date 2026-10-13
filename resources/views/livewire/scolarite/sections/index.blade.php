@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de sections</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Sections</li>
            </ol>
        </div>
    </div>
@stop
<div wire:ignore.self class="">
    @include('livewire.scolarite.sections.modals.crud')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-title">Liste des sections</h3>
            </div>
            <div class="card-tools d-flex my-auto">
                @can('sections.create')
                    <button type="button"
                            class="btn  ml-2" style="background-color: #0c84ff; color: white" data-toggle="modal"
                            data-target="#add-section-modal"><span
                            class="fa fa-plus"></span></button>
                @endcan
            </div>
        </div>

        <div class="card-body m-b-40 table-responsive">
            <table class="table  table-striped">
                <thead>
                <tr>
                    <th>CODE</th>
                    <th>SECTION</th>
                    <th class="text-center">ELEVES</th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sections as $section)
                    <tr>
                        <td>{{ $section->code }}</td>
                        <td>{{ $section->nom }}</td>
                        <td class="text-center">{{ $section->inscriptions->count() }}</td>
                        <td>
                            <div class="d-flex">
                                @can('sections.view', $section)
                                    <a href="/scolarite/sections/{{ $section->id }}" title="Voir"
                                       class="btn btn-warning">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endcan
                                @can('sectionsx.update', $section)
                                    <button wire:click="getSelectedSection({{$section}})" type="button"
                                            title="Modifier"
                                            class="btn btn-info  ml-2" data-toggle="modal"
                                            data-target="#edit-section-modal">
                                        <span class="fa fa-pen"></span>
                                    </button>
                                @endcan
                                @can('sectionsx.delete', $section)
                                    <button wire:click="getSelectedSection({{$section}})" type="button"
                                            title="supprimer"
                                            class="btn btn-danger  ml-2" data-toggle="modal"
                                            data-target="#delete-section-modal">
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

