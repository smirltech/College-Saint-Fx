@extends('adminlte::page')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-4">
                <div class="card mb-5">
                    <div class="card-body">
                        <div class="d-flex align-items-center flex-column mb-4">
                            <div class="d-flex align-items-center flex-column">
                                <div class="sw-13 position-relative mb-3">
                                    <img width="70" src="{{asset($audit->user->image())}}" class="img-fluid rounded-xl"
                                         alt="thumb">
                                </div>
                                <div class="text-muted">{{$audit->user->role->display_name??'N/A'}} | {{
                                $audit->user->faculte->name??'N/A' }}
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-mail"></i>
                                    <span class="align-middle">{{ $audit->user->email }}</span>
                                </div>
                                <div class="mt-3 d-flex align-items-center flex-column">
                                    <span
                                        class="badge bg-{{$audit->event->variant()}}"> {{$audit->event->label()}}</span>
                                    <strong>{{$audit->auditable->getTable()}}:{{$audit->auditable_id}}</strong>
                                    <span>
                                        {{$audit->display_date}}
                                    </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-5 tab-content">
                <div class="tab-pane fade show active" id="overviewTab" role="tabpanel">
                    <div class="card mb-5">
                        <div class="card-body">
                            <ul>
                                <li class="mb-3">
                                    <strong>Avant:</strong><br>
                                    <ul>
                                        @foreach($audit->old_values as $key => $value)
                                            <li class="border-bottom">
                                                <strong>{{$key}}:</strong>
                                                <span class="text-muted">{{$value}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li>
                                    <strong>Après:</strong><br>
                                    <ul>
                                        @foreach($audit->new_values as $key => $value)
                                            <li class="border-bottom">
                                                <strong>{{$key}}:</strong>
                                                <span class="text-muted">{{$value}}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div hidden class="card-footer">
                            <button type="submit" class="btn btn-success btn-sm float-right">
                                <i class="zmdi zmdi-time-restore"></i> {{__('Restore')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
