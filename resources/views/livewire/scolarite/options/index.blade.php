@section('title')
    Liste d'options
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste d'options</h1>
        </div>
        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Options</li>
            </ol>
        </div>
    </div>
@stop
<div class="">
    @include('livewire.scolarite.options.modals.crud')
    <div class="content mt-3">
        <div class="container-fluid">
            <x-form::validation-errors class="mb-4" :errors="$errors"/>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools d-flex my-auto">
                                 @can('options.create')
                                    <button type="button"
                                            class="btn  ml-2" data-toggle="modal"
                                            style="background-color: #0c84ff; color: white"
                                            data-target="#add-option-modal"><span
                                            class="fa fa-plus"></span></button>
                                @endcan

                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th style="width: 200px">CODE</th>
                                    <th>OPTION</th>
                                    <th style="width: 100px"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($options as $option)
                                    <tr>
                                        <td>{{ $option->code }}</td>
                                        <td>{{ $option->nom }}</td>
                                        <td>
                                            <div class="d-flex float-right">
                                                @can('options.view', $option)
                                                    <a href="/scolarite/options/{{ $option->id }}" title="Voir"
                                                       class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('options.update', $option)
                                                    <button wire:click="getSelectedOption({{$option}})" type="button"
                                                            title="Modifier" class="btn btn-info  ml-2"
                                                            data-toggle="modal"
                                                            data-target="#edit-option-modal">
                                                        <span class="fa fa-pen"></span>
                                                    </button>
                                                @endcan
{{--                                                @can('options.delete', $option)--}}
{{--                                                    <button wire:click="getSelectedOption({{$option}})" type="button"--}}
{{--                                                            title="supprimer" class="btn btn-danger  ml-2"--}}
{{--                                                            data-toggle="modal"--}}
{{--                                                            data-target="#delete-option-modal">--}}
{{--                                                        <span class="fa fa-trash"></span>--}}
{{--                                                    </button>--}}
{{--                                                @endcan--}}

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

