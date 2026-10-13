@php use App\Enums\EtudiantSexe; @endphp
@php use App\Enums\EtatCivil; @endphp
@php use App\Enums\InscriptionStatus; @endphp
<div class="">


    <div class="content mt-3">
        <div class="container-fluid">
            <div class="card">

                <div class="card-body">
                    <x-form::validation-errors class="mb-4" :errors="$errors"/>
                    <form wire:submit.prevent="submit">
                        <h4 class="font-weight-bold"><u>Information Personnelle
                                de {{$admission->etudiant->fullName}}</u></h4>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Nom <i class="text-red">*</i></label>
                                <input placeholder="Saisir le nom" type="text" wire:model="etudiant.nom"
                                       class="form-control  @error('etudiant.nom') is-invalid @enderror">
                                @error('etudiant.nom')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Lieu de naissance <i class="text-red">*</i></label>
                                <input placeholder="Saisir la ville / village de naissance" type="text"
                                       wire:model="etudiant.lieu_naissance"
                                       class="form-control  @error('etudiant.lieu_naissance') is-invalid @enderror">
                                @error('etudiant.lieu_naissance')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Date de naissance <i class="text-red">*</i></label>
                                <input type="date" wire:model="etudiant.date_naissance"
                                       class="form-control  @error('etudiant.date_naissance') is-invalid @enderror">
                                @error('etudiant.date_naissance')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Sexe <i class="text-red">*</i></label>
                                <x-form::select wire:model="etudiant.sexe"
                                                class="form-control  @error('etudiant.sexe') is-invalid @enderror">

                                    @foreach (EtudiantSexe::cases() as $es )
                                        <option value="{{ $es}}">{{ $es->label() }}</option>
                                    @endforeach
                                    @error('etudiant.sexe')
                                    <span class="text-red">{{ $message }}</span>
                                    @enderror
                                </x-form::select>
                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Etat civil</label>
                                <x-form::select wire:model="etudiant.etat_civil" class="form-control">

                                    @foreach (EtatCivil::cases() as $es )
                                        <option value="{{ $es->name}}">{{ $es->label() }}</option>
                                    @endforeach

                                </x-form::select>
                            </div>
                        </div>
                        <h6 class="font-weight-bold"><u>Vos informations de contacts</u></h6>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Téléphone</label>
                                <input placeholder="Saisir le numéro de téléphone" type="text"
                                       wire:model="etudiant.telephone"
                                       class="form-control">
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">E-mail <i class="text-red">*</i></label>
                                <input placeholder="Saisir l'adresse e-mail" type="email"
                                       wire:model="etudiant.email"
                                       class="form-control  @error('etudiant.email') is-invalid @enderror">
                                @error('etudiant.email')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Adresse </label>
                                <textarea placeholder="Saisir l'adresse du domicile"
                                          wire:model="etudiant.adresse" rows="1"
                                          class="form-control"></textarea>

                            </div>

                        </div>

                        <hr>
                        <h4 class="font-weight-bold"><u>Information sur les responsables / tuteurs</u></h4>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Père</label>
                                <input placeholder="Saisir le nom du père" type="text"
                                       wire:model="etudiant.pere"
                                       class="form-control">

                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Mère</label>
                                <input placeholder="Saisir le nom de la mère" type="text"
                                       wire:model="etudiant.mere"
                                       class="form-control">

                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Tuteur</label>
                                <input placeholder="Saisir le nom du tuteur" type="text"
                                       wire:model="etudiant.tuteur"
                                       class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Origine</label>
                                <input placeholder="Saisir la ville / village d'origine" type="text"
                                       wire:model="etudiant.origine" class="form-control">

                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Adresse d'urgence </label>
                                <textarea placeholder="Saisir l'adresse d'urgence"
                                          wire:model="etudiant.adresse_urgence" rows="1"
                                          class="form-control"></textarea>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="">Contact d'urgence</label>
                                <input placeholder="Saisir le numéro à appeler en cas d'urgence" type="tel"
                                       wire:model="etudiant.contact_urgence" class="form-control">

                            </div>
                        </div>
                        <hr>
                        <h4 class="font-weight-bold"><u>Information sur le dernier diplome obtenu</u></h4>
                        <p>Remplir les informations du dernier diplome obtenu
                            avec {{$diplome->pourcentage}}%.</p>
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Numéro diplome </label>
                                <input placeholder="Saisir le numéro du diplome" type="text"
                                       wire:model="diplome.numero"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Pourcentage obtenu</label>
                                <input placeholder="Saisir le pourcentage du diplome" type="number"
                                       wire:model="diplome.pourcentage"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Section</label>
                                <input placeholder="Saisir la section" type="text"
                                       wire:model="diplome.section"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Option</label>
                                <input placeholder="Saisir l'option" type="text"
                                       wire:model="diplome.option"
                                       class="form-control">

                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Date de delivrance</label>
                                <input placeholder="Saisir la date" type="date"
                                       wire:model="admission.etudiant.diplome.date_delivrance"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Ecole fréquantée</label>
                                <input placeholder="Saisir nom école" type="text"
                                       wire:model="diplome.ecole"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Code école fréquantée</label>
                                <input placeholder="Saisir nom école" type="text"
                                       wire:model="diplome.code_ecole"
                                       class="form-control">

                            </div>
                            <div class="form-group col-lg-3 col-md-6 col-sm-12">
                                <label for="">Province école fréquantée</label>
                                <input placeholder="Saisir le nom de la province" type="text"
                                       wire:model="diplome.province_ecole"
                                       class="form-control ">

                            </div>
                        </div>
                        <hr>
                        <h4 class="font-weight-bold"><u>Choix du programme</u></h4>
                        <p>Procédez à l'inscription de ce candidat pour l'année académique <span
                                class="text-red">{{$annee_courante->nom}}</span>
                            , dans la promotion que vous sélectionnerez ici-dessous.
                            Pour choisir la promotion, vous devez commencer par sélectionner la faculté, puis la filière
                            et finalement la promotion.</p>
                        <h5>1e Choix</h5>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                <label for="">Faculté <i class="text-red">*</i></label>
                                <x-form::select wire:model="faculte_id" wire:change="changeFaculte"
                                                class="form-control @error('faculte_id') is-invalid @enderror">
                                    <option value="-1" disabled>Choisir la faculté...</option>
                                    @foreach ($facultes as $faculte )
                                        <option value="{{ $faculte->id}}">{{ $faculte->DisplayName }}</option>
                                    @endforeach

                                </x-form::select>
                                @error('faculte_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                <label for="">Filière <i class="text-red">*</i></label>
                                <x-form::select wire:model="filiere_id" wire:change="changeFiliere"
                                                class="form-control @error('filiere_id') is-invalid @enderror">
                                    <option value="-1">Choisir la filière...</option>
                                    @foreach ($filieres as $filiere )
                                        <option value="{{ $filiere->id}}">{{ $filiere->nom }}</option>
                                    @endforeach

                                </x-form::select>
                                @error('filiere_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                <label for="">Promotion <i class="text-red">*</i></label>
                                <x-form::select wire:model="admission.promotion_id"
                                                class="form-control @error('admission.promotion_id') is-invalid @enderror">
                                    <option value="-1">Choisir la promotion...</option>
                                    @foreach ($promotions as $promotion )
                                        <option value="{{ $promotion->id}}">{{ $promotion->niveau->label() }}</option>
                                    @endforeach

                                </x-form::select>
                                @error('admission.promotion_id')
                                <span class="text-red">{{ $message }}</span>
                                @enderror
                            </div>

                        </div>
                        @if($admission->promotion_id > 0)
                            <h5>2e Choix</h5>
                            <div class="row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="">Faculté</label>
                                    <x-form::select wire:model="faculte2_id" wire:change="changeFaculte2"
                                                    class="form-control">
                                        <option value="-1" disabled>Choisir la faculté...</option>
                                        @foreach ($facultes2 as $faculte )
                                            <option value="{{ $faculte->id}}">{{ $faculte->DisplayName }}</option>
                                        @endforeach

                                    </x-form::select>

                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="">Filière</label>
                                    <x-form::select wire:model="filiere2_id" wire:change="changeFiliere2"
                                                    class="form-control">
                                        <option value="-1">Choisir la filière...</option>
                                        @foreach ($filieres2 as $filiere )
                                            <option value="{{ $filiere->id}}">{{ $filiere->nom }}</option>
                                        @endforeach
                                    </x-form::select>

                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-4">
                                    <label for="">Promotion</label>
                                    <x-form::select wire:model="admission.promotion2_id"
                                                    class="form-control">
                                        <option value="-1">Choisir la promotion...</option>
                                        @foreach ($promotions2 as $promotion )
                                            <option
                                                value="{{ $promotion->id}}">{{ $promotion->niveau->label() }}</option>
                                        @endforeach

                                    </x-form::select>

                                </div>

                            </div>
                        @endif
                        <hr>
                        <h4 class="font-weight-bold"><u>Documents nécessaires</u> (Facultatifs)</h4>
                        <div class="row">
                            <div class="form-group col-md-12 col-sm-12">
                                <table class="table border">
                                    <tbody>
                                    <tr>

                                        <td>
                                            <label for="">Bordereau (pdf, max: 3Mo) @if($hasBordereau)
                                                    <strong
                                                        class="fa fa-check-circle text-success"></strong>
                                                @endif</label>

                                            <input type="file" wire:model="bordereau" class="form-control"
                                                   accept="application/pdf"
                                                   placeholder="téléverser le bordereau">
                                            <div wire:loading.inline-flex wire:target="bordereau" class="text-green">
                                                Preview in process...
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label for="">Pièce scolaire (pdf, max: 3Mo) @if($hasPiece)
                                                    <strong
                                                        class="fa fa-check-circle text-success"></strong>
                                                @endif</label>
                                            <input type="file" wire:model="piece" class="form-control"
                                                   accept="application/pdf"
                                                   placeholder="téléverser la pièce">
                                            <div wire:loading.inline-flex wire:target="piece" class="text-green">
                                                Preview in process...
                                            </div>

                                        </td>
                                    </tr>
                                    <tr>

                                        <td>
                                            <label for="">Fiche d'inscription (pdf, max: 3Mo) @if($hasFiche)
                                                    <strong
                                                        class="fa fa-check-circle text-success"></strong>
                                                @endif</label>
                                            <input type="file" wire:model="fiche" class="form-control"
                                                   accept="application/pdf"
                                                   placeholder="téléverser la fiche">
                                            <div wire:loading.inline-flex wire:target="fiche" class="text-green">
                                                Preview in process...
                                            </div>

                                        </td>
                                    </tr>
                                    </tbody>

                                </table>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-6 col-lg-3">
                                <label for="">Status d'admission</label>
                                <x-form::select wire:model="admission.status" class="form-control">
                                    @foreach (InscriptionStatus::cases() as $es )
                                        <option value="{{ $es->value}}">{{ $es->label() }}</option>
                                    @endforeach
                                </x-form::select>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Soumettre</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
