{{--delete enseignant--}}
<x-adminlte-modal wire:ignore.self id="delete-enseignant" icon="fa fa-wrench"
                  title="Suppression d'Enseignant">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cet enseignant</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteEnseignant" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
