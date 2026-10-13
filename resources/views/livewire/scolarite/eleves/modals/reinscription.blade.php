{{-- Attach Responsable --}}
@php use App\Enums\ResponsableRelation; @endphp
@php use App\Enums\InscriptionStatus; @endphp
@php use App\Enums\InscriptionCategorie; @endphp
@php use App\Enums\Sexe; @endphp

{{-- Add Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="reinscription-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Réinscription</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="reinsf2" wire:submit.prevent="addReinscription">

                    {{-- Choix de classe --}}
                    <div>
                        <div class="text-center mb-2">
                            <p>Réinscripiton de l'élève <b>{{$eleve?->fullName}}</b></p>
                        </div>
                        <div class="row">
                            <div class="form-group col-3">
                                <label for="">Section <i class="text-red">*</i></label>
                                <x-form::select wire:model="section_id" wire:change="changeSection"
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
                                <x-form::select wire:model="option_id" wire:change="changeOption"
                                                class="form-control">
                                    <option value="">Choisir option</option>
                                    @foreach ($options as $option )
                                        <option value="{{ $option->id }}">{{ $option->nom }}</option>
                                    @endforeach
                                </x-form::select>

                            </div>
                            <div class="form-group col-3">
                                <label for="">Filière</label>
                                <x-form::select wire:model="filiere_id"
                                                wire:change="changeFiliere" class="form-control">
                                    <option value="">Choisir filière</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                            <div class="form-group col-3">
                                <label for="">Classe <i class="text-red">*</i></label>
                                <x-form::select wire:model="classe_id" wire:change="changeClasse"
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
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Categorie <i class="text-red">*</i></label>
                                <x-form::select wire:model="categorie"
                                                class="form-control  @error('categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir categorie...</option>
                                    @foreach (InscriptionCategorie::cases() as $es )
                                        <option value="{{$es->value}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Montant</label>
                                <input readonly placeholder="Saisir frais d'inscription" type="number"
                                       wire:model="fee.montant"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Payé par</label>
                                <input placeholder="Qui vient payer" type="text"
                                       wire:model="paid_by"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                {{--                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>--}}
                <button form="reinsf2" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>

