@php use App\Enums\RolePermission; @endphp
@extends('adminlte::page')
@section('content')
    <div class="container mt-3">
        @can('users.create')
            <div class="row justify-content-center p-3">
                <div class="col-md-10">
                    <x-form::validation-errors/>
                    <div class="card">
                        <div class="card-header">
                            <strong>Informations personnelles</strong>
                        </div>
                        <div class="card-body card-block">
                            <form action="{{route('users.store')}}" enctype="multipart/form-data" method="POST"
                                  class="form-horizontal">
                                @csrf @method('POST')

                                <div class="form-group row">
                                    <label for="name"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input placeholder="" id="name" type="text"
                                               class="form-control @error('name') is-invalid @enderror" name="name"
                                               value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                                        <input placeholder="" id="email" type="email"
                                               class="form-control @error('email') is-invalid @enderror" name="email"
                                               value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="role_id"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>
                                    <div class="col-md-6">
                                        <x-form::select name="role_id" id="role_id" class="form-control  form-select">
                                            @foreach ($roles as $role)
                                                <option value="{{$role->id}}">{{$role->display_name}}</option>
                                            @endforeach
                                        </x-form::select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <x-form::input.password name="password" required/>
                                    </div>
                                </div>


                                <hr>
                                <div class="card-footer">

                                    <a href="{{url()->previous()}}" class="btn btn-outline-primary btn-sm">
                                        <i class="fa fa-chevron-left"></i>
                                    </a>
                                    <button type="submit" class="btn btn-primary btn-sm float-right">
                                        <i class="fa fa-save"></i> {{__('Save')}}
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @else
            <div class="alert alert-danger">
                <strong>{{__('You are not authorized to access this page.')}}</strong>
            </div>
        @endcan
    </div>
@endsection
