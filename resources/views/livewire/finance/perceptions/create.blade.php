@php use App\Enums\FraisType; @endphp
@php use App\Enums\MinervalMonth; @endphp
@php use App\Enums\Devise; @endphp
<x-modals::form title="Perception de {{$inscription->eleve->nom}}">
   {{-- <x-form::validation-errors/>--}}
    <div class="row mb-3">
        <div class="col-md-12 mb-3">
            <x-form::select
                label="Frais"
                required wire:change="feeSelected" wire:model="perception.frais_id"
                class="form-control">
                @foreach ($frais as $f )
                    <option value="{{$f->id}}">{{ $f->label }}</option>
                @endforeach
            </x-form::select>
        </div>
        @if($fee?->type?->properties())
            <div class="col-md-12 mb-3">
                <x-form::select required :change='true' label="{{ __('Mois') }}" class="form-select"
                                :options="$fee?->type?->properties()" wire:model="perception.custom_property"/>
            </div>
        @endif
        <div class="col-md-12 mb-3">
            <x-form::input label="Montant à Payer - {{$fee?->devise}}" disabled type="number"
                           wire:model="perception.frais_montant"/>
        </div>
        <div class="col-md-12 mb-3">
            <x-form::select change label="Payé en devise" type="number" :options="Devise::cases()"
                            wire:model="perception.devise"/>
            @if($perception->devise == Devise::CDF)
                <div class="col-md-12 mb-3">
                    <x-form::input
                        required
                        label="Taux du $"
                        wire:model="perception.taux"
                        :value="$perception->taux ?? 2850"
                    />
                </div>
            @endif

        <div class="col-md-12 mb-3">
            <x-form::input label="Montant Payé" step=".01" required type="number" wire:model="perception.montant"/>
        </div>
       {{-- <div class="col-md-12 mb-3">
            <x-form::input label="Payé Par" wire:model="perception.paid_by"/>
        </div>--}}
    </div>
    </div>
</x-modals::form>


