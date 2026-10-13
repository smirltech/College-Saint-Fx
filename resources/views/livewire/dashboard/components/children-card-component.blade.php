<div class="card">
    <div class="card-header">
        Mes enfants
    </div>
    <div class="card-body row">
        @foreach($eleves as $eleve)
            <div class="col-md-3">
                <div class="card card-widget widget-user-2 shadow-sm">

                    <div class="widget-user-header bg-gray-light">
                        <a href="{{ route('scolarite.eleves.show',$eleve) }}" class="widget-user-image">
                            <img class="img-circle elevation-2" src="{{ $eleve->avatar }}"
                                 alt="User Avatar">
                        </a>

                        <h3 class="widget-user-username">{{ $eleve->nom }}</h3>
                        <h5 class="widget-user-desc">{{$eleve->id}}</h5>
                    </div>
                    <div class="card-footer p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link">
                                    Section <span
                                        class="float-right text-dark">{{$eleve?->section?->nom}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    Classe <span
                                        class="float-right text-dark">{{$eleve?->classe?->code}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    Admit le <span
                                        class="float-right text-dark">{{$eleve->inscription?->created_at->format('d-m-Y')}}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link">
                                    Genre <span class="float-right text-dark">{{$eleve?->sexe}}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
