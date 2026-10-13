@php use App\Models\Enseignant; @endphp
<div class="modal-dialog">
    <form wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <x-form::select wire:model="cours_enseignant.enseignant_id"
                                        label="Enseignant : {{$cours_enseignant->enseignant->nom}}"
                                        :isValid="$errors->has('cours_enseignant.enseignant_id') ? false : null"
                                        error="{{$errors->first('cours_enseignant.enseignant_id')}}">
                            @foreach(Enseignant::classe($cours_enseignant->classe)->get() as $c)
                                <option value="{{ $c->id }}">{{ $c->nom }}</option>
                            @endforeach
                        </x-form::select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <x-form::button type="submit" class="btn btn-primary">Soumettre</x-button>
            </div>
        </div>
    </form>
</div>
