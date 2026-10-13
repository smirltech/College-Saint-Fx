@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$title}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
        </div>
    </div>
@endsection
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body card-block">
                    <form wire:submit.prevent="save">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <x-form::input
                                        required
                                        label="Nom"
                                        placeholder="Nom du rôle"
                                        wire:model="role.name"
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <x-form::input
                                        placeholder="Description du rôle"
                                        label="Description"
                                        wire:model="role.description"
                                    />
                                </div>
                                <div class="form-group col-md-12 p-3">
                                    <strong>Permissions</strong>
                                    <div class="row mb-3 p-3">
                                        @php
                                            $fw = '';
                                        @endphp
                                        @foreach($permissions as $permission)
                                            @php
                                                $vw = explode(' ', trim($permission->displayName))[0];
                                            @endphp
                                            @if($fw !== $vw)
                                                <div class="col-md-12 mt-2">
                                                    <h5 class="text-primary border-bottom">{{$vw}}</h5>
                                                </div>
                                                @php
                                                    $fw = $vw;
                                                @endphp
                                            @endif
                                            <div class="col-md-4">
                                                <label class="form-check-label">
                                                    <input class="form-check-input"
                                                           @if($role->hasPermissionTo($permission)) checked
                                                           @endif type="checkbox"
                                                           wire:model="new_permissions"
                                                           value="{{$permission->id}}">
                                                    {{$permission->displayName}}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>

                                    @if($role->id)
                                        <div class="text-black mt-1">
                                            Avant: {{ count($role->permissions) }} {{ Str::plural('permission', count($role->permissions))}}
                                            | @foreach($role->permissions as $perm)
                                                <span
                                                    class="badge badge-secondary">{{$perm->displayName}}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="text-green">
                                        Apres
                                        : {{ count($new_permissions) }} {{ Str::plural('permission', count($new_permissions))}}
                                        | @foreach($this?->getPermissionNames() as $perm)
                                            <span class="badge badge-success">{{$perm}}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            @if($role->id AND $role->users->isEmpty())
                                <button type="button" class="btn btn-danger" wire:click="delete">Supprimer
                                </button>
                            @endif
                            <x-form::button type="submit" class="btn btn-primary">Soumettre</x-form::button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
