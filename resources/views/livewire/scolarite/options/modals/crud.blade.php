{{-- Show Option --}}
{{--
<div wire:ignore.self class="modal fade" tabindex="-1" id="show-option-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Option : {{$option->nom??''}}</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="m-0">Détail sur l'option</h4>
                        </div>
                        <div class="card-tools">
                            @if($option != null)
                                --}}
{{-- <a href="/scolarite/sections/{{ $section->id }}/edit" title="modifier"
                                    class="btn btn-primary btn-sm ml-2">
                                     <i class="fas fa-pen"></i>
                                 </a>--}}{{--

                                <button type="button"
                                        title="Modifier" class="btn btn-info  ml-2" data-toggle="modal"
                                        data-target="#edit-option-modal">
                                    <span class="fa fa-pen"></span>
                                </button>
                            @endif
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <label>Nom : </label>
                                {{ $option->nom??'' }}
                            </div>
                            <div class="col">
                                <label>Code : </label>
                                {{ $option->code??'' }}
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4 class="m-0">Filières de l'option</h4>
                        </div>
                        <div class="card-tools d-flex my-auto">
                            @if($option != null)
                                <a href="{{ route('scolarite.filieres.create',["option_id"=>$option->id]) }}" title="ajouter"
                                   class="btn btn-primary mr-2"><span
                                        class="fa fa-plus"></span></a>

                            @endif
                        </div>
                    </div>

                    <div class="card-body p-0 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>OPTION</th>
                                <th style="width: 100px">CODE</th>

                                <th style="width: 100px"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if($option != null)
                                @foreach ($option->filieres as $filiere)
                                    <tr>
                                        <td><a href="/scolarite/options/{{ $filiere->id }}">{{ $filiere->nom }}</a></td>

                                        <td>{{ $filiere->code }}</td>

                                        <td>
                                            <div class="d-flex float-right">
                                                <a href="/scolarite/filieres/{{ $filiere->id }}" title="Voir"
                                                   class="btn btn-warning">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                --}}
{{--  <a href="/filiere-edit/{{ $filiere->id }}" title="modifier" class="btn btn-info  ml-2">
                                                     <i class="fas fa-pen"></i>
                                                 </a>

                                                 <button wire:click="deleteFiliere({{ $filiere->id }})" title="supprimer" class="btn btn-danger ml-2">
                                                     <i class="fas fa-trash"></i>
                                                 </button> --}}{{--

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

--}}

{{-- Add Option --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-option-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter Option</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="addOption">

                    <div class="row">
                        <div class="form-group col-5">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-2">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="code"
                                   class="form-control @error('code') is-invalid @enderror">
                            @error('code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-5">
                            <label for="">Section <i class="text-red">*</i></label>
                            <x-form::select
                                wire:model="section_id">
                                @foreach ($sections as $section )
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn" style="background-color: #000 ; color: white" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn " style="color: white; background-color: #0c84ff">Ajouter</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Section --}}
<div wire:ignore.self class="modal fade" tabindex="2" id="edit-option-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Option</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="updateOption">
                    <div class="row">
                        <div class="form-group col-5">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input type="text" wire:model="nom" class="form-control @error('nom') is-invalid @enderror">
                            @error('nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-2">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="code"
                                   class="form-control @error('code') is-invalid @enderror">

                        </div>
                        <div class="form-group col-5">
                            <label for="">Section <i class="text-red">*</i></label>
                            <x-form::select
                                wire:model="section_id">
                                @foreach ($sections as $section )
                                    <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn " style="background-color: #000 ; color: white" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f2" type="updateOption" class="btn " style="background-color: #0c84ff; color: white">Modifier</button>
            </div>
        </div>

    </div>

</div>

{{-- Delete Section --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="delete-option-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Suppression d'Option</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette option ?</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn " style="background-color: #000 ; color: white" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteOption" class="btn" style="background-color: #0c84ff; color: white">Supprimer</button>
            </div>
        </div>

    </div>

</div>


{{-- AUTRES --}}

{{-- Add Option --}}
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
                <form id="f4" wire:submit.prevent="addFiliere">

                    <div class="row">
                        <div class="form-group col-9">
                            <label for="">Nom <i class="text-red">*</i></label>
                            <input wire:keyup.debounce="genCode" type="text" wire:model="filiere_nom"
                                   class="form-control @error('filiere_nom') is-invalid @enderror">
                            @error('filiere_nom')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-3">
                            <label for="">Code <i class="text-red">*</i></label>
                            <input type="text" wire:model="filiere_code"
                                   class="form-control @error('filiere_code') is-invalid @enderror">
                            @error('filiere_code')
                            <span class="text-red">{{ $message }}</span>
                            @enderror
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

