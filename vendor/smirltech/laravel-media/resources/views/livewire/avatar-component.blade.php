<div class="modal-dialog">
    <form wire:submit.prevent="submit">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <x-form::input.image :height="200" required :avatar="$avatar" wire:model="avatar"
                                             label="Avatar"/>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <x-form::button type="submit" class="btn btn-primary">Soumettre</x-form::button>
            </div>
        </div>
    </form>
</div>
