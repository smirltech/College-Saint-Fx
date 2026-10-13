@php use App\Enums\Conduite; @endphp
<x-adminlte-modal wire:ignore.self id="update-resultat" icon="fa fa-cubes"
                  title="Mettre à jour résultat">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="f1a" wire:submit.prevent="updateResultat">
        <div class="row">
            <div class="form-group col-md-5 col-sm-12">
                <x-form::input
                    type="number"
                    label="Pourcentage"
                    step="0.01"
                    wire:model="resultat.pourcentage"
                    :is-valid="$errors->has('resultat.pourcentage')?false:null"
                    :error="$errors->first('resultat.pourcentage')">
                </x-form::input>
            </div>
            <div class="form-group col-md-3 col-sm-12">
                <x-form::input
                    type="number"
                    label="Place"
                    wire:model="resultat.place"
                    :is-valid="$errors->has('resultat.place')?false:null"
                    :error="$errors->first('resultat.place')">
                </x-form::input>
            </div>
            <div class="form-group col-md-4 col-sm-12">
                <label for="">Conduite</label>
                <x-form::select wire:model="resultat.conduite"
                                class="form-control">

                    @foreach (Conduite::cases() as $es )
                        <option value="{{$es->name}}">{{strtoupper($es->name)}}</option>
                    @endforeach
                </x-form::select>

            </div>

        </div>

    </form>
    <x-slot name="footerSlot">
        <button form="f1a" type="submit" class="btn btn-primary">Mettre à jour</button>
    </x-slot>
</x-adminlte-modal>

