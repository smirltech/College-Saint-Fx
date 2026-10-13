<x-adminlte-modal wire:ignore.self id="paiement-facture" icon="fa fa-wallet"
                  title="Paiement facture">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="fpf1a" wire:submit.prevent="payFacture">
        <div class="row">

            <div class="form-group col-sm-12">
                <x-form::input
                    type="number"
                    label="Montant payé (max : {{$perception->montant??''}})"
                    max="{{$perception->montant??0}}"
                    wire:model.defer="perception.paid"
                    :is-valid="$errors->has('perception.paid')?false:null"
                    :error="$errors->first('perception.paid')">
                </x-form::input>
            </div>
            <div class="form-group col-sm-12">
                <label for="">Payé par</label>
                <input type="text" wire:model.defer="perception.paid_by"
                       class="form-control">
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="fpf1a" type="submit" class="btn btn-outline-primary mr-3">Valider et imprimer</button>
        </div>
    </x-slot>
</x-adminlte-modal>
