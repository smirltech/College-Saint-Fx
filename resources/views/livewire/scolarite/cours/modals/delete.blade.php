{{--delete classe--}}
<x-adminlte-modal wire:ignore.self id="delete-cours" icon="fa fa-wrench"
                  title="Suppression de Cours">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer ce cours</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteCours" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
