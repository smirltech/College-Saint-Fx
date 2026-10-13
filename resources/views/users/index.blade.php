@php use App\Enums\RolePermission; @endphp
@extends('adminlte::page')
@section('title')
    {{__($title)}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3"><span class="fas fa-fw fa-users"></span> Liste d'utilisateurs</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item active">Utilisateurs</li>
            </ol>
        </div>
    </div>
@stop
@section('content')
    <div class="p-0 container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-7">
                    <div class="card-header">
                        <div class="m-0 box_header">
                            <div class="main-title">
                                <h3 hidden class="m-0">{{config('app.name')}}{{__($title)}}</h3>
                            </div>
                            <div class="erning_btn d-flex float-right">
                                @can('users.create')
                                    <a href="{{route('users.create')}}" class="btn btn-outline-primary btn-sm"><i
                                            class="fa fa-plus"></i></a>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 card-body">
                        <!-- table-responsive -->
                        <div class="table-responsive-md">
                            <table class="table">
                                <thead class="table-heade bg-primary">
                                <tr>
                                    <td></td>
                                    <td>Nom</td>
                                    <td>Role</td>
                                    @can('users.create')
                                        <td>Actions</td>
                                    @endcan
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            <img width="40" class="img-cir" src="{{$user->image()}}">
                                        </td>
                                        <td>
                                            <div class="table-data__info">
                                                <h6>{{ $user->name }}@if ($user->hasVerifiedEmail())
                                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                    @endif</h6>
                                                <span>
                                                {{$user->email}}
                                            </span>
                                            </div>
                                        </td>

                                        <td>
                                            <span>{{$user->role->display_name??'N/A'}}</span><br>
                                        </td>
                                        @can('users.update', $user)
                                            <td>

                                                <a href="{{route('users.edit', $user->id)}}"
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                            </td>
                                        @endcan

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
@endsection
