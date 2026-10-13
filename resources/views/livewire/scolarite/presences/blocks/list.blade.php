@php
    use App\Enums\ResultatType;
@endphp

<div>
    {{-- @include('livewire.scolarite.resultats.blocks.modals.result')--}}
    @include('livewire.scolarite.presences.blocks.modals.crud')
    @include('livewire.scolarite.presences.blocks.modals.add')
    <div class="input-group  mb-3">
        <div class="input-group-prepend mr-2">
            <span class="input-group-text">{{$presences->count()}} / {{$classe->inscriptions->count()}} </span>
        </div>
        <div class="input-group-prepend mr-1">
            <button wire:click="previousDate"
                    title="Date précédente"
                    class="btn btn-secondary"
                    type="button"
            >
                <i class="fas fa-angle-left"></i>
            </button>
        </div>
        <div class="input-group-prepend">
            <span class="input-group-text">Date : </span>
        </div>

        <input type="date" wire:model="current_date" max="{{Carbon\Carbon::now()->format('Y-m-d')}}"
               class="form-control">

        <div class="input-group-append ml-1" id="button-addon4">
            <button @disabled(!$hasNextDay) wire:click="nextDate"
                    title="Date suivante"
                    class="btn btn-secondary mr-1"
                    type="button"
            >
                <i class="fas fa-angle-right"></i>
            </button>
        </div>
        <div class="input-group-append ml-1" id="button-addon4">
            @can('presences.create')
                <button wire:click="initPresence"
                        title="Prendre la présence"
                        class="btn rounded btn-outline-primary"
                        type="button"
                        data-toggle="modal"
                        data-target="#add-presence"
                >
                    <i class="fas fa-bell"></i>
                </button>
            @endcan
        </div>
        {{--<div class="input-group-append ml-3" id="button-addon4">
            <button wire:click="printIt" title="Imprimer liste de présence" class="btn btn-outline-secondary" type="button"><i
                    class="fas fa-print"></i></button>
        </div>--}}
    </div>
    <div class="card">
        <div class="card-body p-0 table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>ÉLÈVE</th>
                    <th>ÉTAT DE PRÉSENCE</th>
                    <th style="width: 50px;"></th>

                </tr>
                </thead>
                <tbody>

                @foreach($presences as $i=>$presence)

                    <tr>
                        <td>{{$i+1}}</td>
                        <td>
                            <a href="{{route('scolarite.eleves.show', [$presence->inscription?->eleve])}}">{{$presence->inscription->eleve?->fullName}}</a>
                        </td>
                        <td><span
                                class=" pl-2 pr-2 badge badge-{{$presence->status->color()}}">{{$presence->status->label()}}</span>
                        </td>
                        <td>
                            <div class="d-flex float-right">
                                <a href="{{route('scolarite.eleves.presence',$presence->inscription?->eleve)}}"
                                   title="Voir les présences"
                                   class="btn btn-default btn-sm m-1">
                                    <i class="fas fa-calendar-alt"></i>
                                </a>
                                <button wire:click="selectPresence('{{$presence->id }}')"
                                        title="modifier"
                                        class="btn btn-sm btn-outline-warning m-1"
                                        data-toggle="modal"
                                        data-target="#update-presence">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button wire:click="selectPresence('{{$presence->id }}')"
                                        title="supprimer"
                                        class="btn btn-sm btn-outline-danger m-1"
                                        data-toggle="modal"
                                        data-target="#delete-presence">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
