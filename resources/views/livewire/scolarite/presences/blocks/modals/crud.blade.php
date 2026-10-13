@php use App\Enums\PresenceStatus; @endphp
<x-adminlte-modal wire:ignore.self id="update-presence" icon="fa fa-cubes"
                  title="Modifier État de Présence">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div class="row">

        <div class="form-group col-md-12 col-sm-12">
            <div>
                <x-media::avatar :model="$presence?->inscription?->eleve" size="150" class="mr-2"/>
            </div>
            <h3 style="text-align: center;">{{$presence->inscription?->nomComplet}}</h3>
        </div>
        <div class="form-group col-md-12 col-sm-12">
            <div style="text-align: center;"><h4
                    class="p-2 badge badge-{{$presence->status?->color()}} text-lg">{{$presence->status?->label()}}</h4>
            </div>
        </div>
    </div>
    <x-slot name="footerSlot">
        <div style="width: 100%" class="d-flex btn-group">
            @foreach(PresenceStatus::cases() as $es)
                @if($es != $presence->status)
                    <button wire:click.debounce="updatePresence('{{$es->name}}')" type="button"
                            class="btn btn-outline-{{$es->color()}} mr-3">{{$es->label()}}</button>
                @endif
            @endforeach
        </div>
    </x-slot>
</x-adminlte-modal>

<x-adminlte-modal wire:ignore.self id="delete-presence" icon="fa fa-cubes"
                  title="Supprimer la Présence">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette présence ?</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deletePresence" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
