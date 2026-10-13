@extends('adminlte::page')
@section('content')
    <div class="p-0 container-fluid ">
        <div class="row">
            <div class="col-12">
                <div class="card mb-7">
                    <div class="card-header">
                        <div class="m-0 box_header">
                            <div class="main-title">
                                <h3 hidden class="m-0">{{__($title)}}</h3>
                            </div>

                        </div>
                    </div>
                    <div class="mb-3 card-body">
                        <div class="table-responsive m-b-40">
                            <x-adminlte-datatable id="table7" :heads="$heads" head-theme="light"
                                                  :config="$config"
                                                  hoverable with-buttons/>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
