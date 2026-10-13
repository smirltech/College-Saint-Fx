@php use Carbon\Carbon; @endphp
@php use App\Enums\PresenceStatus; @endphp
<x-adminlte-modal wire:ignore.self id="add-presence" icon="fa fa-people-group"
                  title="Présence {{Carbon::parse($current_date)->format('d-m-Y')}}">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div class="row">
        <div class="form-group col-md-12 col-sm-12">
            @if($presence_eleve?->avatar)
                <div>
                    <x-media::avatar :model="$presence_eleve" size="150" class="mr-2"/>
                </div>
            @endif
            <label for="">Élève </label>

            <x-form::select refresh wire:model="presence.inscription_id"
                            class="form-control">
                @foreach ($nonInscriptions as $es )
                    <option value="{{$es->id}}">{{$es->nomComplet}}</option>
                @endforeach
            </x-form::select>
        </div>
    </div>

    <x-slot name="footerSlot">
        <div style="width: 100%" class="d-flex btn-group">
            @foreach(PresenceStatus::cases() as $es)
                <button wire:click.debounce="addPresence('{{$es->name}}')" type="button"
                        class="btn btn-outline-{{$es->color()}} mr-3">{{$es->label()}}</button>
            @endforeach
        </div>
    </x-slot>
</x-adminlte-modal>

