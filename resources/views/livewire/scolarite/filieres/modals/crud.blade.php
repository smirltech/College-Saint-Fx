{{-- Add Option --}}
@php use App\Enums\ClasseNiveau; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addFiliere">

                    <div class="row">
                        <div class="form-group col-md-9">
                            <x-form::input
                                    label="Nom"
                                    required
                                    type="text"
                                    wire:model="nom"/>
                        </div>
                        <div class="form-group col-md-3">
                            <x-form::input
                                    type="text"
                                    required
                                    wire:model="code"
                                    label="Code"/>
                        </div>

                        <div class="form-group col-6">
                            <x-form::select
                                    required
                                    wire:model="section_id"
                                    wire:change="changeSection"
                                    label="Section"
                                    :options="$sections"/>
                        </div>
                        <div class="form-group col-6">
                            <x-form::select
                                    wire:model="option_id"
                                    required
                                    refresh
                                    label="Option"
                                    :options="$options"/>
                        </div>
                        <div class="form-group col-md-12">
                            <x-form::ckeditor
                                    label="Description"
                                    wire:model="description"
                                    class="form-control"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Option --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateFiliere">
                    <div class="row">
                        <div class="form-group col-md-9">
                            <x-form::input
                                    label="Nom"
                                    required
                                    type="text"
                                    wire:model="nom"/>
                        </div>
                        <div class="form-group col-md-3">
                            <x-form::input
                                    type="text"
                                    required
                                    wire:model="code"
                                    label="Code"/>
                        </div>

                        <div class="form-group col-6">
                            <x-form::select
                                    required
                                    wire:model="section_id"
                                    wire:change="changeSection"
                                    label="Section"
                                    :options="$sections"/>
                        </div>
                        <div class="form-group col-6">
                            <x-form::select
                                    wire:model="option_id"
                                    required
                                    refresh
                                    label="Option"
                                    :options="$options"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="updateFiliere" class="btn btn-primary">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Option --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-filiere-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression de filière</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette filière ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteFiliere" class="btn btn-primary">Supprimer</button>
            </div>
        </div>

    </div>

</div>


{{-- AUTRES --}}

{{-- Add Classe --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-classe-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Classe</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f4" wire:submit.prevent="addClasse">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <x-form::select
                                    label="Niveau"
                                    required
                                    wire:change="setCode"
                                    wire:model="classe_niveau"
                                    :options="ClasseNiveau::cases()"/>
                        </div>
                        <div class="form-group col-md-6">
                            <x-form::input
                                    type="text"
                                    label="Code"
                                    readonly wire:model="classe_code"/>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f4" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </div>

    </div>

</div>

