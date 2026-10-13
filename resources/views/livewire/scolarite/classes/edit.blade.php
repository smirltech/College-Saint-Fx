@php use App\Enums\ClasseNiveau;use App\Models\Enseignant;use App\Models\Option; @endphp
<x-modals::form>
    <x-form::select
        wire:model="section_id"
        label="Section"
        required>

        @foreach ($sections as $section )
            <option value="{{ $section->id }}">{{ $section->nom }}</option>
        @endforeach
    </x-form::select>

    @if($section_id == 3)
        <x-form::select
            required
            refresh
            wire:model="option_id"
            label="Option">
            @foreach (Option::all() as $option )
                <option value="{{ $option->id }}">{{ $option->nom }}</option>
            @endforeach
        </x-form::select>
    @endif
    <x-form::select
        label="Niveau"
        required
        wire:model="classe.niveau">
        @foreach (ClasseNiveau::cases() as $niveau )
            <option value="{{ $niveau->value}}">{{ $niveau->label() }}</option>
        @endforeach
    </x-form::select>

    @if($section_id == 1 || $section_id == 2 || $section_id == 3 )
        <x-form::select label="Type" refresh wire:model="type">
            @foreach (range('A', 'G') as $t)
                <option value="{{ $t }}">{{ $t }}</option>
            @endforeach
        </x-form::select>
    @endif



    <x-form::input
        required
        type="text"
        readonly
        label="Code"
        wire:model="classe.code"/>

    <x-form::select
        wire:model="enseignant_id"
        label="Titulaire">
        @foreach(Enseignant::all() as $c)
            <option value="{{ $c->id }}">{{ $c->nom }}</option>
        @endforeach
    </x-form::select>
</x-modals::form>
