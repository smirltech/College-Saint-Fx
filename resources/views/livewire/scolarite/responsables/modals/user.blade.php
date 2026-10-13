{{-- Add Responsable --}}
@php use App\Enums\Sexe; @endphp
@php use App\Enums\ResponsableRelation; @endphp
<div wire:ignore.self class="modal fade" tabindex="-1" id="edit-responsable-user-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Créer Compte Responsable</h4>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <x-form::validation-errors class="mb-4" :errors="$errors"/>
                <form id="fru1" wire:submit.prevent="addUserToResponsable">
                    <div>Le compte responsable sera créé et un email avec information d'accès lui sera envoyé</div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button form="fru1" type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </div>

    </div>

</div>


