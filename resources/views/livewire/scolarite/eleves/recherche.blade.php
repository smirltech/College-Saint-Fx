<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <form wire:submit.prevent="search">
                                <div class="">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input class="form-control" wire:model="search"
                                                   placeholder="{{__('Search name or matricule')}}"/>
                                            <div class="input-group-append ml-1">
                                                <button class=" btn btn-primary" type="submit">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>

                    </div>

                    <div class="mb-3 card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>PHOTO</th>
                                    <th>MATRICULE</th>
                                    <th>NOM</th>
                                    <th>PROMOTION</th>
                                    <th style="width: 150px">ACTIONS</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($this->etudiants??[] as $etudiant)
                                    <tr>
                                        <td>
                                            <x-media::avatar :model="$etudiant" size="40" />
                                          </td>

                                        <td>{{ $etudiant->matricule }}</td>
                                        <td>{{$etudiant->fullname}}</td>
                                        <td>{{  $etudiant->classe?->code }}</td>
                                        <td>
                                            <a href="{{ route('scolarite.eleves.show', $etudiant) }}"
                                               class="btn btn-success btn-sm m-1" title="{{__('View')}}"><i
                                                    class="fa fa-eye"></i></a>

                                            <button onclick="showModal('scolarite.inscription.inscription-create-component', '{{$etudiant->inscription->id}}')"
                                               class="btn btn-info btn-sm m-1" title="{{__('Eidt')}}"><i
                                                    class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            <h3 class="text-danger">{{__("No student found, try searching matricule or
                                                name again !")}}</h3>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
