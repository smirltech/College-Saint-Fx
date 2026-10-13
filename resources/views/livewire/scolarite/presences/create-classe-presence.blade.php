<x-modals::form title="Ajouter une presence">
    <div class="row">
        <div class="col-md-12">
            <x-form::select
                label="Classe"
                required
                :options="$classes"
                wire:model="presence.classe_id"/>
        </div>
        <div class="col-md-12">
            <x-form::input
                required
                label="Date"
                type="date"
                wire:model="presence.date"/>
        </div>
        <div class="col-md-6">
            <x-form::input.numeric
                label="Presence garçons"
                wire:model="presence.garcons"/>
        </div>
        <div class="col-md-6">
            <x-form::input.numeric
                label="Presence filles"
                wire:model="presence.filles"/>
        </div>

        <div class="col-md-12">
            <x-form::input.numeric
                required
                label="Total Presence"
                wire:model="presence.total"/>
        </div>
        <div class="col-md-12">
            <x-form::input.numeric
                label="Total Absences"
                wire:model="presence.absents"/>
        </div>
    </div>
</x-modals::form>
