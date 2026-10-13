{{--add category--}}
@php use App\Enums\MouvementStatus; @endphp
<x-adminlte-modal wire:ignore.self id="add-operation-modal" icon="fa fa-wrench"
                  title="Ajout de l'Opération">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="fmo1a" wire:submit.prevent="addOperation">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Bénéficiaire"
                    wire:model.defer="operation.beneficiaire"
                    :is-valid="$errors->has('operation.beneficiaire')?false:null"
                    :error="$errors->first('operation.beneficiaire')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Facilitateur </label>
                <x-form::select :select-placeholder='false' wire:model.defer="operation.facilitateur_id"
                                class="form-control">
                    @foreach ($users as $es )
                        <option value="{{$es->id}}">{{$es->name}}</option>
                    @endforeach
                </x-form::select>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date"
                    wire:model.defer="operation.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Direction </label>
                <x-form::select :select-placeholder='false' wire:model.defer="operation.direction"
                                class="form-control">
                    @foreach (MouvementStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="number"
                    label="Quantité"
                    wire:model.defer="operation.quantite">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="operation.observation">
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="fmo1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update category--}}
<x-adminlte-modal wire:ignore.self id="update-operation-modal" icon="fa fa-people-group"
                  title="Modification d'operation">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="fmo2a" wire:submit.prevent="updateOperation">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Bénéficiaire"
                    wire:model.defer="operation.beneficiaire"
                    :is-valid="$errors->has('operation.beneficiaire')?false:null"
                    :error="$errors->first('operation.beneficiaire')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Facilitateur </label>
                <x-form::select :select-placeholder='false' wire:model.defer="operation.facilitateur_id"
                                class="form-control">
                    @foreach ($users as $es )
                        <option value="{{$es->id}}">{{$es->name}}</option>
                    @endforeach
                </x-form::select>
            </div>

            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="date"
                    label="Date"
                    wire:model.defer="operation.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Direction </label>
                <x-form::select :select-placeholder='false' wire:model.defer="operation.direction"
                                class="form-control">
                    @foreach (MouvementStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <x-form::input
                    type="number"
                    label="Quantité"
                    wire:model.defer="operation.quantite">
                </x-form::input>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="operation.observation">
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="fmo2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete category--}}
<x-adminlte-modal wire:ignore.self id="delete-operation-modal" icon="fa fa-cubes"
                  title="Suppression d'Operation">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer cette operation</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteOperation" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
