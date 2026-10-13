{{--@section('title')
    - rôles et permissions
@endsection--}}
{{--@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">Liste de rôles et leurs permissions</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Rôles</li>
            </ol>
        </div>
    </div>

@stop--}}
<x-slot name="contentHeaderToolSlot">
    <ol class="breadcrumb float-right">
        <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
        <li class="breadcrumb-item active">{{$title}}</li>
    </ol>
</x-slot>
<div class="p-0 container-fluid ">
    <div class="row">
        <div class="col-12">
            <div class="card mb-7">
                <div class="card-header">
                    <div class="m-0 box_header">
                        <div class="main-title">
                            <h3 hidden class="m-0">{{__($title)}}</h3>
                        </div>
                        <div class="erning_btn d-flex float-right">
                            <button wire:click="refreshPermissions"
                                    title="mettre à jour les permissions"
                                    class="btn btn-outline-info btn-sm mr-2">
                                <i wire:loading.delay wire:target="refreshPermissions"
                                   class="spinner-border spinner-border-sm"></i>
                                <i wire:loading.remove wire:target="refreshPermissions"
                                   class="fa fa-refresh"></i></button>
                            <a href="{{route('roles.create')}}"
                               class="btn btn-outline-primary btn-sm"><i
                                    class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </div>
                <div class="mb-3 card-body">
                    <!-- table-responsive -->
                    <div class="table-responsive-md">
                        <table class="table table-striped table-hover">
                            <thead class="table-header bg-primary">
                            <tr>
                                <th>#</th>
                                <th>Rôle</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{$role->display_name}}
                                    </td>
                                    <td>
                                        {{$role->description}}
                                    </td>
                                    <td>
                                        @foreach($role->permissions as $perm)
                                            <span class="badge badge-secondary">{{$perm->displayName}}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.show',$role) }}"
                                           class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-eye"></i>
                                        </a>
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
