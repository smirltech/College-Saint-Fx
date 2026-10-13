@php use App\Enums\ResponsableRelation; @endphp
<div class="form-group">
    <div class="row mt-2 mb-2">
        <div class="form-group col-sm-12">
            <label for="" class="">Responsable :</label>
            <input type="text" class="form-control ml-2" wire:keydown.debounce="runSearchResponsables"
                   wire:model="searchResponsable" placeholder="Rechercher...">
        </div>
        <div class="form-group">
            <label for="">Choisir parmi {{ count($responsables) }} noms disponibles</label>
            <x-form::select wire:change.debounce="changeSelectedResponsable" wire:model="responsable_id"
                            class="form-control">
                @foreach ($responsables as $respo )
                    <option value="{{$respo->id}}">{{ $respo->detail }}</option>
                @endforeach
            </x-form::select>
        </div>
    </div>

    <div @if($responsable_id == null) hidden @endif class="form-group col-sm-12">
        <label for="">Relation</label>
        <x-form::select wire:model="responsable_relation2"
                        class="form-control">
            @foreach (ResponsableRelation::cases() as $es )
                <option value="{{$es->value}}">{{ $es->label() }}</option>
            @endforeach
        </x-form::select>
    </div>
</div>
