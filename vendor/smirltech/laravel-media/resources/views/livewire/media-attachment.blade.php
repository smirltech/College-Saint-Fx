<form wire:submit.prevent="save">
    <x-media::form-file wire:model="media"/>

    <x-media::list-files :media="$media"/>

    <x-media::form-button type="submit" class="btn-primary">
        {{__('Save')}}
    </x-media::form-button>
</form>
