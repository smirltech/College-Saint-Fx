@php use App\Enums\ClasseNiveau;use App\Enums\DevoirStatus; @endphp
@section('title')
    - {{$devoir->titre}}
@endsection
@section('content_header')
    <div class="row">
        <div class="col-6">
            <h1 class="ms-3">{{$devoir->titre}}</h1>
        </div>

        <div class="col-6">
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="{{ route('scolarite') }}">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('scolarite.devoirs.index') }}">Devoirs</a></li>
                <li class="breadcrumb-item active">{{$devoir->titre}}</li>
            </ol>
        </div>
    </div>

@stop
<div class="">
    <div class="content mt-3">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-{{$devoir->status->variant()}}">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <span class="ms-3">Devoir</span>
                            </div>

                            <div class="col-6">
                                @can('devoirs.delete',$devoir)
                                    <x-form::button
                                            wire:click="deleteDevoir" class="btn btn-sm btn-danger float-right">
                                        <i class="fa fa-trash-alt"></i>
                                    </x-form::button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <x-form::select required
                                                    wire:model="devoir.classe_id"
                                                    label="Classe"
                                                    :isValid="$errors->has('devoir.classe_id') ? false : null"
                                                    error="{{$errors->first('devoir.classe_id')}}">
                                        @foreach($classes as $classe)
                                            <option
                                                    value="{{$classe->id}}">
                                                {{$classe->code}}
                                            </option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form::select required wire:model.defer="devoir.cours_id"
                                                    label="Cours"
                                                    :isValid="$errors->has('devoir.cours_id') ? false : null"
                                                    error="{{$errors->first('devoir.cours_id')}}">
                                        @foreach($cours as $c)
                                            <option value="{{$c->id}}">{{$c->nom}}</option>
                                        @endforeach
                                    </x-form::select>
                                </div>

                                <div class="form-group col-md-4">
                                    <x-form::input step="1" required min="{{date('Y-m-d')}} {{date('h:i')}}"
                                                   wire:model.defer="devoir.echeance"
                                                   label="Date limite de dépôt"
                                                   :isValid="$errors->has('devoir.echeance') ? false : null"
                                                   error="{{$errors->first('devoir.echeance')}}" type="datetime-local"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <x-form::input required placeholder="Saisir l'intitulé du devoir"
                                                   wire:model.defer="devoir.titre"
                                                   label="Intitulé du devoir"
                                                   :isValid="$errors->has('devoir.titre') ? false : null"
                                                   error="{{$errors->first('devoir.titre')}}"/>
                                </div>

                                <div class="form-group col-md-12">
                                    <x-form::textarea
                                            required
                                            placeholder="Saisir le contenu du devoir"
                                            wire:model.defer="devoir.contenu"
                                            label="Contenu du devoir"
                                            rows="10"
                                            :isValid="$errors->has('devoir.contenu') ? false : null"
                                            error="{{$errors->first('devoir.contenu')}}"/>
                                </div>
                                @if($devoir->status!=DevoirStatus::closed)
                                    <div class="form-group col-md-12">
                                        <x-form::select required wire:model.defer="devoir.status"
                                                        label="Statut"
                                                        :isValid="$errors->has('devoir.status') ? false : null"
                                                        error="{{$errors->first('devoir.status')}}">
                                            @foreach(DevoirStatus::cases() as $s)
                                                @if($s==DevoirStatus::closed)
                                                    @continue
                                                @endif
                                                <option value="{{$s}}">{{$s->label()}}</option>
                                            @endforeach
                                        </x-form::select>
                                    </div>
                                @endif

                                <div class="form-group col-md-12">
                                    <x-form::input.pdf wire:model="document"
                                                       label="Document du devoir"
                                                       target="document"
                                                       :isValid="$errors->has('document') ? false : null"
                                                       error="{{$errors->first('document')}}"/>
                                </div>

                            </div>
                            <x-form::button class="btn-primary float-end">Soumettre</x-form::button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Reponses
                            </div>
                            <div class="col-6">
                                @can('devoirs.view',$devoir)
                                    <a title="Repondre au devoir" href="{{ route('scolarite.devoirs.show',$devoir) }}"
                                       class="btn  btn-sm btn-info float-right">
                                        <i class="fa fa-add"></i>
                                    </a>
                                @endcan
                            </div>
                        </div>

                    </div>

                    <div class="card-body p-0 table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ELEVE</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reponses as $k=>$reponse)
                                <tr>
                                    <td>
                                        <x-media::avatar size="50" :model="$reponse->eleve"/>
                                    </td>
                                    <td>
                                        {{ $reponse->eleve->nom_complet }}
                                    </td>
                                    <td>{{ $reponse->created_at_display }}</td>
                                    <td>
                                        {{ $reponse->status?->label() }}
                                    </td>

                                    <td>
                                        <div class="d-flex float-right">
                                            @if($reponse->document)
                                                <a href="{{route('media.show', $reponse->document)}}"
                                                   title=" Document"
                                                   class="btn btn-outline-primary  ml-2">
                                                    <i class="fas fa-file"></i>
                                                </a>
                                            @endif
                                            {{-- <a href="{{route('scolarite.devoir.edit',$reponse )}}"
                                                title="modifier"
                                                class="btn btn-outline-info  ml-2">
                                                 <i class="fas fa-eye"></i>
                                             </a>--}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

