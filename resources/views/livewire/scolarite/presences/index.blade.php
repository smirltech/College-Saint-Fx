<div>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-9">
                    <form wire:submit.prevent="search" class="mt-1">
                        <div class="row">
                            <div class="col-md-4">
                                <x-form::select
                                    placeholder="Section"
                                    :options="$sections"
                                    wire:model="section_id"/>
                            </div>
                            <div class="col-md-4">
                                <x-form::select
                                    placeholder="Classe"
                                    :options="$classes"
                                    wire:model="classe_id"/>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                    @can('inscriptions.create')
                        <x-form::button.primary
                            class="float-right"
                            icon="plus"
                            onclick="showModal('scolarite.presences.presence-classe-component')"
                            title="ajouter"/>
                    @endcan

                </div>
            </div>

        </div>
    </div>
  <livewire:scolarite.presences.charts.presences-line :classeId="$classe_id"/>
</div>
