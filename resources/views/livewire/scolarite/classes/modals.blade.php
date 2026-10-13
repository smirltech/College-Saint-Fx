@php use App\Models\Cours;use App\Models\Enseignant; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="add-cours-modal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ajouter un cours</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{--   <x-form::validation-errors class="mb-4" :errors="$errors"/>--}}
                <form id="modal1" wire:submit.prevent="addCours">
                    <div class="row">
                        <div class="form-group @if(!$classe->primaire()) col-md-6 @else col-md-12 @endif">
                            <x-form::select wire:model.lazy="cours_enseignant.cours_id"
                                            label="Cours"
                                            :isValid="$errors->has('cours_enseignant.cours_id') ? false : null"
                                            error="{{$errors->first('cours_enseignant.cours_id')}}">
                                @foreach(Cours::all() as $c)
                                    <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                @endforeach
                            </x-form::select>
                        </div>
                        @if(!$classe->primaire())
                            <div class="form-group col-md-6">
                                <x-form::select wire:model="cours_enseignant.enseignant_id"
                                                label="Enseignant"
                                                :isValid="$errors->has('cours_enseignant.enseignant_id') ? false : null"
                                                error="{{$errors->first('cours_enseignant.enseignant_id')}}">

                                    @foreach(Enseignant::all() as $c)
                                        <option value="{{ $c->id }}">{{ $c->nom }}</option>
                                    @endforeach
                                </x-form::select>
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Fermer
                </button>

                <button form="modal1" class="btn btn-warning">Soumettre</button>
            </div>
        </div>

    </div>
</div>
