<div class="content-wrapper">
    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h2 class="m-0">Modification de promotion - {{ $promotion->nom }}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form wire:submit.prevent="submit">
                        <div class="row">
                            <div class="form-group col-10">
                                <label for="">Niveau</label>
                                <input type="text" wire:model="promotion.niveau"
                                       class="form-control  @error('promotion.niveau') is-invalid @enderror">
                                @error('promotion.niveau')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-2">
                                <label for="">Code</label>
                                <input type="text" wire:model="promotion.code"
                                       class="form-control  @error('promotion.code') is-invalid @enderror">
                                @error('promotion.code')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Doyen</label>
                            <x-form::select wire:model="promotion.filiere_id"
                                            class="form-control  @error('promotion.filiere_id') is-invalid @enderror">
                                <option value="-1">Choisir filière</option>
                                @foreach ($filieres as $filiere )
                                    <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                                @endforeach
                                @error('promotion.filiere_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </x-form::select>
                        </div>


                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
