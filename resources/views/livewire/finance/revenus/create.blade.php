@php use App\Enums\Devise; @endphp
<x-modals::form title="Ajouter Revenu">
    <div class="row">
        <div class="form-group col-md-12">
            <x-form::select required label="Type" wire:model="revenu.type" :options="$types"/>
        </div>
        <div class="form-group col-md-12">
            <x-form::input required label="Libellé" wire:model="revenu.nom"/>
        </div>
        <div class="form-group col-md-6">
            <x-form::select required label="Devise" wire:model="revenu.devise" :options="Devise::cases()"/>
        </div>
        <div class="form-group col-md-6">
            <x-form::input.money currency="{{$revenu?->devise?->symbol()}}" required label="Montant"
                                 wire:model="revenu.montant"/>
        </div>
        <div class="form-group col-md-12">
            <x-form::textarea label="Description" wire:model="revenu.description"/>
        </div>
    </div>
</x-modals::form>
