@php use App\Enums\Sexe; @endphp
<x-modals::form>
    <div>
        <div class="row">
            <div class="form-group col-md-9 col-sm-12">
                <x-form::input
                    label="Nom"
                    wire:model="responsable.nom"
                    required/>
            </div>
            <div class="form-group col-md-3">
                <x-form::select
                    label="Sexe"
                    :options="Sexe::cases()"
                    wire:model="responsable.sexe">
                </x-form::select>
            </div>

            <div class="form-group col-md-6">
                <label for="">Téléphone</label>
                <input placeholder="Saisir le numéro de téléphone" type="tel"
                       wire:model="responsable_telephone"
                       class="form-control">
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">E-mail</label>
                <input placeholder="Saisir l'adresse e-mail" type="text"
                       wire:model="responsable_email"
                       class="form-control">
            </div>

        </div>
        <div class="form-group">
            <x-form::input
                required
                placeholder="Saisir l'adresse du domicile"
                wire:model="responsable.adresse"/>
        </div>
    </div>
</x-modals::form>
