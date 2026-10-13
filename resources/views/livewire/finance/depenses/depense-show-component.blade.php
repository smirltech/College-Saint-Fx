@php use App\Enums\DepenseStatus;use App\Models\Status; @endphp
<div class="content mt-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <x-media::avatar :model="$depense->user"/>
                        </div>
                        <h3 class="profile-username text-center">{{$depense->user->name}}</h3>
                        <p class="text-muted text-center">{{$depense->user->role?->name}}</p>
                    </div>

                </div>


                <div class="card card-{{$depense->status()?->color}}">
                    <div class="card-header">
                        <h3 class="card-title">{{$depense->status()?->label}}</h3>
                    </div>

                    <div class="card-body">
                        <strong><i class="fas fa-money-check"></i> Montant</strong>
                        <p class="text-muted">
                            {{$depense->display_montant}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-calculator"></i> Type</strong>
                        <p class="text-muted">
                            {{$depense->type->nom}}
                        </p>
                        <hr>
                        <strong><i class="fas fa-calendar-times mr-1"></i>
                            Echeance</strong>
                        <p class="text-muted">{{$depense->date}}</p>
                        <hr>
                        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
                        <p class="text-muted">
                            {{$depense->note}}
                        </p>
                    </div>

                </div>
                <div class="card">
                    <div class="card-header">
                        Documents
                    </div>
                    <div class="card-body">
                        <x-media::list class="mt-0" :media="$depense->media"/>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card p-3">
                    <div class="timeline">
                        @php
                            $lastStatus = null;
                        @endphp
                        @foreach($depense_statuses as $status)
                            @continue($lastStatus?->name==$status?->name)
                            @php
                                $lastStatus = $status
                            @endphp
                            <div class="time-label">
                                <span class="bg-{{$status->color}}">{{$status->label}}</span>
                            </div>

                            @php
                                $statuses = $depense->statuses()->where('name',$lastStatus->name)->get();
                            @endphp
                            @foreach($statuses as $status)
                                <div>
                                    <i class="fas fa-user bg-green"></i>
                                    <div class="timeline-item">
                                        <span class="time"><i class="fas fa-clock"></i> {{$status->created_at->diffForHumans()}}</span>
                                        <h3 class="timeline-header"><a href="#">{{$status->user?->name}}</a></h3>
                                        <div class="timeline-body">
                                            {!! $status->reason !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3">
                    <form>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <x-form::ckeditor
                                    label="Note"
                                    rows="2"
                                    wire:model="status_note"/>
                            </div>
                        </div>
                        @if(!$depense->isApproved()  and $depense->canBeApprovedByUser())
                            <x-form::button.primary
                                type="button"
                                icon="check"
                                wire:click="approveDepense"
                                class="float-end m-1"
                                label="Approuver"/>

                            <x-form::button.warning
                                type="button"
                                icon="close"
                                wire:click="rejectDepense"
                                class="float-start m-1"
                                label="Rejetter"/>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
