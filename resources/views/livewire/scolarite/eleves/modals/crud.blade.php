{{-- Attach Responsable --}}
@php use App\Enums\ResponsableRelation; @endphp
@php use App\Enums\InscriptionStatus; @endphp
@php use App\Enums\InscriptionCategorie; @endphp
@php use App\Enums\Sexe; @endphp


<div wire:ignore.self class="modal fade" tabindex="-1" id="attach-responsable-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Attacher un responsable</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1a" wire:submit.prevent="attachResponsable">

                    <div class="row">
                        @include('livewire.scolarite.eleves.blocks.responsables_search_block')
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1a" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Relation --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-relation-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Relation</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="editRelation">

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="">Relation</label>
                            <x-form::select wire:model="responsable_relation"
                                            class="form-control">
                                @foreach (ResponsableRelation::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button wire:click="deleteRelation" type="button" class="btn btn-danger" data-dismiss="modal">
                    Supprimer
                </button>
                <button form="f1" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- Add Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-inscription-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Reinscription</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f2" wire:submit.prevent="addInscription">

                    {{-- Choix de classe --}}
                    <div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="">Section <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_section_id" wire:change="changeSection"
                                                class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </x-form::select>
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="">Option</label>
                                <x-form::select wire:model="inscription2_option_id" wire:change="changeOption"
                                                class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </x-form::select>

                            </div>
                            <div class="form-group col-3">
                                <label for="">Filière</label>
                                <x-form::select wire:model="inscription2_filiere_id"
                                                wire:change="changeFiliere" class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Classe <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_classe_id"
                                                class="form-control">
                                    <option value="">Choisir classe</option>
                                    @foreach ($classes as $classe )
                                        <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                    @endforeach
                                </x-form::select>
                                @error('classe_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_categorie"
                                                class="form-control  @error('inscription2_categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (InscriptionCategorie::cases() as $es )
                                        <option value="{{$es->value}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('inscription2_categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Montant</label>
                                <input placeholder="Saisir frais d'inscription" type="number"
                                       wire:model="inscription2_montant"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                {{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button form="f2" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-inscription-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Le choix de classe</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f3" wire:submit.prevent="editInscription">

                    {{-- Choix de classe --}}
                    <div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="">Section <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_section_id" wire:change="changeSection"
                                                class="form-control  @error('section_id') is-invalid @enderror">
                                    <option value="">Choisir section</option>
                                    @foreach ($sections as $section )
                                        <option value="{{ $section->id }}">{{ $section->nom }}</option>
                                    @endforeach
                                </x-form::select>
                                @error('section_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-3">
                                <label for="">Option</label>
                                <x-form::select wire:model="inscription2_option_id" wire:change="changeOption"
                                                class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </x-form::select>

                            </div>
                            <div class="form-group col-3">
                                <label for="">Filière</label>
                                <x-form::select wire:model="inscription2_filiere_id"
                                                wire:change="changeFiliere" class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Classe <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_classe_id"
                                                class="form-control">
                                    <option value="">Choisir classe</option>
                                    @foreach ($classes as $classe )
                                        <option value="{{ $classe->id }}">{{ $classe->code }}</option>
                                    @endforeach
                                </x-form::select>
                                @error('classe_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <x-form::select wire:model="inscription2_categorie"
                                                class="form-control  @error('inscription2_categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (InscriptionCategorie::cases() as $es )
                                        <option value="{{ strtoupper($es->value)}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('inscription2_categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Montant</label>
                                <input placeholder="Saisir frais d'inscription" type="number"
                                       wire:model="inscription2_montant"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                {{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button wire:click="deleteInscription" type="button" class="btn btn-danger" data-dismiss="modal">
                    Supprimer
                </button>
                <button form="f3" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Inscription Status --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-inscription-status-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier état d'inscription</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f3a" wire:submit.prevent="editInscriptionStatus">

                    {{-- Choix de classe --}}
                    <div>

                        <div class="form-group">
                            <label for="">État <i class="text-red">*</i></label>
                            <x-form::select wire:model="inscription_status"
                                            class="form-control  @error('inscription_status') is-invalid @enderror">
                                <option value="" disabled>Choisir état...</option>
                                @foreach (InscriptionStatus::cases() as $es )
                                    <option value="{{ $es->value}}">{{ $es->label() }}</option>
                                @endforeach
                                @error('inscription_status')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </x-form::select>
                        </div>

                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button form="f3a" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Inscription Category --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-inscription-categorie-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier categirie d'inscription</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f3b" wire:submit.prevent="editInscriptionCategorie">

                    {{-- Choix de classe --}}
                    <div>

                        <div class="form-group">
                            <label for="">Categorie <i class="text-red">*</i></label>
                            <x-form::select wire:model="inscription2_categorie"
                                            class="form-control  @error('inscription2_categorie') is-invalid @enderror">
                                <option value="" disabled>Choisir categorie...</option>
                                @foreach (InscriptionCategorie::cases() as $es )
                                    <option value="{{$es->value}}">{{ $es->label() }}</option>
                                @endforeach
                                @error('inscription2_categorie')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </x-form::select>
                        </div>

                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button form="f3b" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

{{-- EditModal Élève --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-eleve-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Information Élève</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f4" wire:submit.prevent="editEleve">
                    {{-- Information Personnelle--}}
                    <div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input placeholder="Saisir le nom" type="text" wire:model="eleve_nom"
                                       class="form-control  @error('eleve_nom') is-invalid @enderror">
                                @error('eleve_nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <x-form::select
                                    wire:model="eleve_sexe"
                                    required
                                    label="Sexe">
                                    <option value="" disabled>Choisir sexe...</option>
                                    @foreach (Sexe::cases() as $es )
                                        <option value="{{ $es}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('eleve_sexe')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="">Lieu de naissance</label>
                                <input placeholder="Saisir la ville / village de naissance" type="text"
                                       wire:model="eleve_lieu_naissance"
                                       class="form-control">

                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Date de naissance</label>
                                <input type="date" wire:model="eleve_date_naissance"
                                       class="form-control">

                            </div>

                            <div class="form-group col-md-4">
                                <label for="">No. Permanent</label>
                                <input placeholder="Saisir le numero permanent" type="text"
                                       wire:model="numero_permanent"
                                       class="form-control">
                            </div>
                        </div>
                        <h6 class="font-weight-bold"><u>Information de contacts</u></h6>
                        <div class="row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Téléphone</label>
                                <input placeholder="Saisir le numéro de téléphone" type="tel"
                                       wire:model="eleve_telephone"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">E-mail</label>
                                <input placeholder="Saisir l'adresse e-mail" type="text" wire:model="eleve_email"
                                       class="form-control">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="">Adresse </label>
                            <textarea placeholder="Saisir l'adresse du domicile" wire:model="eleve_adresse" rows="2"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    {{-- ./Information Personnelle--}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                {{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button wire:click="deleteEleve" type="button" class="btn btn-danger" data-dismiss="modal">Supprimer
                </button>
                <button form="f4" type="submit" class="btn btn-warning">Modifier</button>
            </div>
        </div>

    </div>

</div>


