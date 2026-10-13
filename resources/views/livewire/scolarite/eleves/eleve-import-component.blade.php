<x-modals::base title="Importer les élèves">
    <form wire:submit.prevent="submit" class="container">
        <div class="row">
            <div class="form-group col-md-12">
                <x-form::select label="Année"
                                required
                                placeholder="Choisir année scolaire"
                                wire:model="annee_id">
                    @foreach($annees as $annee)
                        <option value="{{$annee->id}}">{{$annee->nom}}
                        </option>
                    @endforeach
                </x-form::select>
            </div>

          {{--  <div class="form-group col-md-6">
                <x-form::select
                    label="Classe"
                    required
                    placeholder="Choisir classe"
                    wire:model="classe_id">
                    @foreach($classes as $classe)
                        <option value="{{$classe->id}}">{{$classe->nom}}
                        </option>
                    @endforeach
                </x-form::select>
            </div>--}}


            <div class="form-group col-md-12">

                <x-form::input.xlsx required label="Fiche d identification"
                                    wire:model="file"/>
                <div class="mt-2">
                    Veuillez télécharger le modèle <a
                </div>
            </div>
        </div>
        <x-form::button type="submit" class="btn btn-primary float-end">Soumettre
        </x-form::button>
    </form>
</x-modals::base>
