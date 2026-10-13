@php
    use App\Enums\RolePermission;
    use App\Enums\UserRole;
@endphp
@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{$title}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{$user->name}}</li>
                </ol>
            </div>
        </div>
    </div>
@stop
<div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="d-flex align-items-center flex-column">
                            <div class="sw-13 position-relative mb-3">
                                <x-avatar :model="$user"/>
                            </div>
                            <div class="h5 mb-0">{{$user->name}}</div>
                            <div class="text-muted text-center">
                                <span class="badge badge-secondary">{{$user->role_name??'N/A'}}</span><br>
                            </div>
                            <div class="text-muted">
                                <i class="zmdi zmdi-email"></i>
                                <span class="align-middle">{{ $user->email }}@if ($user->hasVerifiedEmail())
                                        <i class="fa fa-check-circle"></i>
                                    @endif</span>

                            </div>
                            <div class="mt-3">
                                @if(Gate::allows('users.delete') AND auth()->user()->id != $user->id)
                                    <form method="post" class="center"
                                          action="{{route('users.destroy',$user)}}">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                @endcan
                            </div>
                            <div class="mt-3">
                                @can("view", $user->eleve)
                                    <a href="{{route('scolarite.eleves.show',$user->eleve)}}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Voir l'élève
                                    </a>
                                @endcan
                                @can("view", $user->responsable)
                                    <a href="{{route('scolarite.responsables.show',$user->responsable)}}"
                                       class="btn btn-primary btn-sm">
                                        <i class="fa fa-eye"></i> Voir le parent
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-body">
                        @if(Gate::allows('users.create') || auth()->user()->id == $user->id)
                            <form action="{{route('users.update',$user)}}" enctype="multipart/form-data"
                                  method="POST"
                                  class="form-horizontal">
                                @csrf @method('PUT')

                                <div class="form-group row">
                                    <label for="name"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input placeholder="" id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{$user->name}}" required autocomplete="name">
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address')
                                    }}</label>

                                    <div class="col-md-6">
                                        <input readonly placeholder="" id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{$user->email}}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                @can('users.create')
                                    <div class="form-group row">
                                        <label for="role_id" class="col-md-4 col-form-label text-md-right">{{ __('Role')
                                    }}</label>

                                        <div class="col-md-6">
                                            <x-form::select name="role_id" id="role_id"
                                                            class="form-control  form-select">
                                                <option>== Choisir rôle ==</option>
                                                @foreach ($roles as $role)
                                                    <option @if($user->role?->id == $role->id) selected
                                                            style="background-color: lightgray;"
                                                            @endif
                                                            value="{{$role->id}}">{{$role->display_name}}</option>
                                                @endforeach
                                            </x-form::select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password"
                                               class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <x-form::input.password name="password"/>
                                        </div>
                                    </div>
                                @endcan
                                <hr hidden>
                                <div class="card-footer">
                                    @if ($user->hasVerifiedEmail())
                                        <a href="{{ route('users.password.autoreset',$user) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fa fa-key"></i> {{ __('Reset Password') }}
                                        </a>
                                    @endif
                                    @can('users.create')
                                        <button type="submit" class="btn btn-primary btn-sm float-right">
                                            <i class="fa fa-save"></i> {{__('Save')}}
                                        </button>
                                    @endcan
                                </div>

                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
