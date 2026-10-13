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
            <button wire:click="initPresence"
                    title="Prendre la présence"
                    class="btn rounded btn-outline-primary"
                    type="button"
                    data-toggle="modal"
                    data-target="#add-presence"
            >
                <i class="fas fa-bell"></i>
            </button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>ÉLÈVE</th>
                    @for($i = 7; $i >= 0; $i--)
                        <th class="bg-{{\Carbon\Carbon::now()->subDays($i)->format('Y-m-d') == $current_date?'secondary':''}}">{{\Carbon\Carbon::now()->subDays($i)->format('d-m')}}</th>
                    @endfor


                </tr>
                </thead>
                <tbody>


                @foreach($classe->inscriptions as $i=>$inscription)

                    <tr>
                        <td>{{$i+1}}</td>
                        <td>{{$inscription->nomComplet}}</td>
                        @for($i = 7; $i >= 0; $i--)
                            <td class="bg-gradient-{{\Carbon\Carbon::now()->subDays($i)->format('Y-m-d') == $current_date?'secondary':'light'}}">
                                @if($inscription->presence(\Carbon\Carbon::now()->subDays($i)->format('Y-m-d')))
                                    <button
                                        wire:click="selectPresence('{{$inscription->presence(\Carbon\Carbon::now()->subDays($i)->format('Y-m-d'))?->id }}')"
                                        title="modifier"
                                        class="btn btn-sm"
                                        data-toggle="modal"
                                        data-target="#update-presence">
                                        <span
                                            class="p2 badge badge-{{$inscription->presence(\Carbon\Carbon::now()->subDays($i)->format('Y-m-d'))?->status->color()}}">{{$inscription->presence(\Carbon\Carbon::now()->subDays($i)->format('Y-m-d'))?->status->label()}}</span>
                                    </button>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
