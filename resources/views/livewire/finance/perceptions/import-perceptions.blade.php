@php use App\Enums\Devise ;use App\Enums\FraisType@endphp
<x-modals::form title="{{$this->title}}" size="modal-lg">
    <div class="form-group">
        <x-form::select wire:model="annee_id" label="{{ __('Annee') }}" :options="$annees"/>
    </div>
    <div class="form-group">
        <x-form::select wire:model="frais_id" label="{{ __('Frais') }}" :options="$frais"/>
    </div>
    {{-- @if($fee?->type?->properties())
         <div class="col-md-12">
             <x-form::select :change='true' label="{{ __('Mois') }}" class="form-select"
                             :options="$fee?->type?->properties()" wire:model="custom_property"/>
         </div>
     @endif--}}
    @if($fee?->type == FraisType::MINERVAL)
        <div class="col-md-12">
            <x-form::select required :change='true' label="{{ __('Devise') }}" class="form-select"
                            :options="Devise::cases()" wire:model="devise"/>
        </div>
    @endif

    <div class="form-group">
        <x-form::input.xlsx wire:model="file" label="{{ __('File') }}"/>
    </div>
</x-modals::form>
