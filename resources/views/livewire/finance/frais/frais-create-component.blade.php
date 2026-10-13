@php use App\Enums\Devise;use App\Enums\FraisType;use App\Enums\Section;use App\Models\Frais; @endphp
<x-modals::form title="Ajouter un frais">
    <div class="row">
        <div class="col-md-12">
            <x-form::select required label="{{ __('Type') }}" class="form-select" :options="$types"
                            wire:model="fee.type"/>
        </div>
        <div class="col-md-12">
            <x-form::select :change='true' label="{{ __('Sub-type') }}" class="form-select"
                            :options="$fee->type?->subTypes()" wire:model="fee.sub_type"/>
        </div>
        <div class="col-md-12">
            <x-form::select label="{{ __('Section') }}" class="form-select" :options="$sections"
                            wire:model="fee.section"/>
        </div>

        @if($fee->section == Section::SECONDAIRE->value)
            <div class="col-md-12">
                <x-form::select label="{{ __('Option') }}" class="form-select" :options="$options"
                                wire:model="fee.option_id"/>
            </div>
        @endif
        <div class="col-md-12">
            @if(($fee?->type == FraisType::AUTRE))
                <x-form::input required label="{{ __('Name') }}"
                               wire:model.defer="fee.nom"/>
            @else
                <x-form::input readonly required label="{{ __('Name') }}"
                               wire:model.defer="fee.nom"/>
            @endif

        </div>
        <div class="col-md-6">
            <x-form::input required label="{{ __('Amount') }}" wire:model.defer="fee.montant"/>
        </div>
        <div class="col-md-6">
            <x-form::select required label="{{ __('Currency') }}" class="form-select" :options="Devise::cases()"
                            wire:model="fee.devise"/>
        </div>
    </div>
</x-modals::form>
