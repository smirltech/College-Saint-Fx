{{--add category--}}
@php use App\Enums\MouvementStatus; @endphp
@php use App\Enums\MaterialStatus; @endphp
<x-adminlte-modal wire:ignore.self id="add-mouvement-modal" icon="fa fa-wrench"
                  title="Ajout de Mouvement du Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="fmm1a" wire:submit.prevent="addMouvement">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Bénéficiaire"
                    wire:model.defer="mouvement.beneficiaire"
                    :is-valid="$errors->has('mouvement.beneficiaire')?false:null"
                    :error="$errors->first('mouvement.beneficiaire')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Facilitateur </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.facilitateur_id"
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
                    wire:model.defer="mouvement.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Direction </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.direction"
                                class="form-control">
                    @foreach (MouvementStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">État du matériel </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.materiel_status"
                                class="form-control">
                    @foreach (MaterialStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="mouvement.observation">
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="fmm1a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--update category--}}
<x-adminlte-modal wire:ignore.self id="update-mouvement-modal" icon="fa fa-people-group"
                  title="Modification de Matériel">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <form id="fmm2a" wire:submit.prevent="updateMouvement">
        <div class="row">
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Bénéficiaire"
                    wire:model.defer="mouvement.beneficiaire"
                    :is-valid="$errors->has('mouvement.beneficiaire')?false:null"
                    :error="$errors->first('mouvement.beneficiaire')">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Facilitateur </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.facilitateur_id"
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
                    wire:model.defer="mouvement.date">
                </x-form::input>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">Direction </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.direction"
                                class="form-control">
                    @foreach (MouvementStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-6 col-sm-12">
                <label for="">État du matériel </label>
                <x-form::select :select-placeholder='false' wire:model.defer="mouvement.materiel_status"
                                class="form-control">
                    @foreach (MaterialStatus::cases() as $es )
                        <option value="{{$es->name}}">{{$es->label()}}</option>
                    @endforeach
                </x-form::select>
            </div>
            <div class="form-group col-md-12 col-sm-12">
                <x-form::input
                    type="text"
                    label="Description"
                    wire:model.defer="mouvement.observation">
                </x-form::input>
            </div>
        </div>
    </form>
    <x-slot name="footerSlot">
        <div class="d-flex">
            <button form="fmm2a" type="submit" class="btn btn-outline-primary mr-3">Soumettre</button>
        </div>
    </x-slot>
</x-adminlte-modal>

{{--delete category--}}
<x-adminlte-modal wire:ignore.self id="delete-mouvement-modal" icon="fa fa-cubes"
                  title="Suppression de Mouvement">
    <x-form::validation-errors class="mb-4" :errors="$errors"/>
    <div>Êtes-vous sûr de vouloir supprimer ce mouvement</div>
    <x-slot name="footerSlot">
        <x-adminlte-button wire:click="deleteMouvement" type="button" theme="primary"
                           label="Supprimer"></x-adminlte-button>
    </x-slot>
</x-adminlte-modal>
