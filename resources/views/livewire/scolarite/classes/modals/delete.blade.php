{{--delete classe--}}
<x-adminlte-modal wire:ignore.self id="delete-classe" icon="fa fa-wrench"
                  title="Suppression de Classe">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette classe</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteClasse" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
