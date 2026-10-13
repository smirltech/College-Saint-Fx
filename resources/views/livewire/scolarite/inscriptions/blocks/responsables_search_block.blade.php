@php use App\Enums\ResponsableRelation; @endphp
<div class="form-group">
    <div class="row mt-2 mb-2">
        <div class="form-group col-md-9">
            <x-form::select
                label="Responsable"
                wire:change.debounce="changeSelectedResponsable"
                wire:model="responsable_id">
                @foreach ($responsables as $respo)
                    <option value="{{$respo->id}}">{{ $respo->detail }}</option>
                @endforeach
            </x-form::select>
        </div>
        @if($responsable_id)
            <div class="form-group col-md-3">
                <x-form::select
                    label="Relation"
                    wire:model="responsable_relation">
                    @foreach (ResponsableRelation::cases() as $es )
                        <option value="{{$es->value}}">{{ $es->label() }}</option>
                    @endforeach
                </x-form::select>
            </div>
        @endif
    </div>
</div>
