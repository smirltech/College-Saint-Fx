@php
    use App\Enums\ResultatType;
@endphp

<div>
    @include('livewire.scolarite.resultats.blocks.modals.result')
    @include('livewire.scolarite.resultats.blocks.modals.printable')
    <div class="input-group  mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text">Résultats </span>
        </div>
        <select placeholder="----------" wire:change="selectResultatType"
                wire:model="resultatTypeValue"
                class="form-control">
            @if(!$classe->maternelle())
                <option value="{{ResultatType::p1->value}}">{{ResultatType::p1->longLabel()}}</option>
                <option value="{{ResultatType::p2->value}}">{{ResultatType::p2->longLabel()}}</option>
                <option value="{{ResultatType::ex1->value}}">{{ResultatType::ex1->longLabel()}}</option>
            @endif
            <option value="{{ResultatType::t1->value}}">{{ResultatType::t1->longLabel()}}</option>
            <option value="" disabled>----------</option>
            @if(!$classe->maternelle())
                <option value="{{ResultatType::p3->value}}">{{ResultatType::p3->longLabel()}}</option>
                <option value="{{ResultatType::p4->value}}">{{ResultatType::p4->longLabel()}}</option>
                <option value="{{ResultatType::ex2->value}}">{{ResultatType::ex2->longLabel()}}</option>
            @endif
            <option value="{{ResultatType::t2->value}}">{{ResultatType::t2->longLabel()}}</option>
            <option value="" disabled>----------</option>
            @if($classe->primaire())
                @if($classe->primaire(strict:true))
                    <option value="{{ResultatType::p5->value}}">{{ResultatType::p5->longLabel()}}</option>
                    <option value="{{ResultatType::p6->value}}">{{ResultatType::p6->longLabel()}}</option>
                    <option value="{{ResultatType::ex3->value}}">{{ResultatType::ex3->longLabel()}}</option>
                @endif
                <option value="{{ResultatType::t3->value}}">{{ResultatType::t3->longLabel()}}</option>
                <option value="" disabled>----------</option>
            @endif
            <option value="{{ResultatType::tg->value}}">{{ResultatType::tg->longLabel()}}</option>
        </select>
        <div class="input-group-append ml-1" id="button-addon4">
            <button wire:click="printIt" title="Imprimer résultats" class="btn btn-outline-secondary" type="button"><i
                    class="fas fa-print"></i></button>
        </div>
    </div>

    <div class="card-body p-0 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>PLACE</th>
                <th>ÉLÈVE</th>
                <th>%</th>
                <th>CONDUITE</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @if($resultatType != null)
                @foreach($inscriptions as $inscription)
                    @php
                        $resultat = $inscription->resultats()->where('custom_property', $resultatType)->first();
                    @endphp
                    <tr>
                        <td>{{$resultat?->place}}</td>
                        <td>
                            <a href="{{route('scolarite.eleves.show', [$inscription->eleve])}}">{{$inscription->eleve->fullName}}</a>
                        </td>
                        <td class="text-center">{{$resultat->pourcentage??'-'}}</td>
                        <td>{{strtoupper($resultat?->conduite?->value)}}</td>
                        <td>
                            <div class="d-flex float-right">
                                <button wire:click="selectInscription('{{$inscription->id }}')"
                                        title="supprimer"
                                        class="btn btn-sm btn-outline-warning ml-2"
                                        data-toggle="modal"
                                        data-target="#update-resultat">
                                    <i class="fas fa-edit"></i>
                                </button>
                                @if($resultat?->bulletin)
                                    <a target="_blank"
                                       href="{{ route('media.show',$resultat->bulletin) }}"
                                       title="Voir le bulletin"
                                       class="btn btn-outline-info btn-sm  ml-2">
                                        <i class="fa fa-file"></i>
                                    </a>
                                @endif
                            </div>
                        </td>

                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
