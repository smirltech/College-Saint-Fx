<div class="content-wrapper">

    <div class="content mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2 class="m-0">Liste de Promotions</h2>
                            </div>
                            <div class="card-tools d-flex my-auto">

                                <a href="{{ route('promotion.ajout') }}" title="ajouter" class="btn btn-success mr-2"><span
                                        class="fa fa-plus"></span></a>


                            </div>
                        </div>

                        <div class="card-body p-0 table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>PROMOTION</th>

                                        <th style="width: 300px">FILIERE</th>
                                        <th style="width: 100px">CODE</th>
                                        <th style="width: 100px"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotions as $promotion)
                                        <tr>
                                            <td>{{ $promotion->niveau }}</td>
                                            <td><a href="/promotion/{{ $promotion->filiere->id }}">{{ $promotion->filiere->nom }}</a></td>

                                            <td>{{ $promotion->code }}</td>
                                            <td>
                                                <div class="d-flex float-right">
                                                    <a href="/promotion/{{ $promotion->id }}" title="Voir" class="btn btn-warning">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/promotion-edit/{{ $promotion->id }}" title="modifier" class="btn btn-info  ml-2">
                                                        <i class="fas fa-pen"></i>
                                                    </a>

                                                    <button wire:click="deletePromotion({{ $promotion->id }})" title="supprimer" class="btn btn-danger ml-2">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
</div>
