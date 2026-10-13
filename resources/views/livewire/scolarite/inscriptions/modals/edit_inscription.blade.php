{{-- EditModal Inscription --}}
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-inscription-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modifier Inscription</h4>
                <button wire:click="$emit('onModalClosed')" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="f1" wire:submit.prevent="editInscription">

                    {{-- Choix de classe --}}
                    <div>
                        <h4 class="font-weight-bold"><u>Choix de classe</u></h4>
                        <p>Procédez à l'inscription de ce candidat pour l'année scolaire <span
                                class="text-red">{{$annee_courante->nom}}</span>, dans la classe que vous
                            sélectionnerez ci-dessous.
                            Pour choisir la classe, vous devez commencer par sélectionner la section, puis l'option,
                            ensuite la filière et finalement la classe.</p>
                        <p>Il y a des sections sans options ni filières, dans ce cas choisir seulement la section,
                            puis
                            la classe.</p>
                        <p>Il y a des options sans filières, dans ce cas choisir seulement la section, puis
                            l'option, et
                            enfin la classe.</p>
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
                                <x-form::select wire:model="option_id" wire:change="changeOption" class="form-control">
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
                                <x-form::select wire:model="classe_id"
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
                                <label for="">Catégorie <i class="text-red">*</i></label>
                                <x-form::select wire:model="categorie"
                                                class="form-control  @error('categorie') is-invalid @enderror">
                                    <option value="" disabled>Choisir catégorie...</option>
                                    @foreach (InscriptionCategorie::cases() as $es )
                                        <option value="{{ $es->name}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('categorie')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="">Montant</label>
                                <input placeholder="Saisir frais d'inscription" type="number" wire:model="montant"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    {{-- ./Choix de classe --}}
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button wire:click="$emit('onModalClosed')" type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>
                <button form="f1" type="submit" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>

</div>


