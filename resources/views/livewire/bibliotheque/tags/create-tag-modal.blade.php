<x-modals::form title="Create Tag">
    <div class="row">
        <div class="form-group col-md-12 col-sm-12">
            <x-form::input
                label="Nom"
                placeholder="Nom de l'étiquette"
                wire:model="etiquette_name">
            </x-form::input>
        </div>
    </div>
    <x-slot:footer>
        <div class="d-flex">
            <button type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot:footer>
</x-modals::form>

