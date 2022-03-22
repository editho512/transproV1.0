@extends('main')

@section('title')
<title>{{ config('app.name') }} | {{$camion->name }}</title>
@endsection

@section('styles')

@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper teste" style="min-height: inherit!important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$camion->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('camion.liste')}}">
                            <button class="btn btn-default" style="color:gray;"><span class="fa fa-arrow-left"></span>&nbsp;Retour</button>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <div class="row">
        <div class="col-md-4 px-3">
            <div class="card card-info card-outline" style="border-color:#3490c1 !important">
                <div class="card-body box-profile">
                    <div class="row">
                        <div class="col-sm-6" style="min-width:220px !important;">
                            <img class="rounded" style="max-width:200px !important;" alt="Photo de {{$camion->name}}" src="{{asset('storage/'.$camion->photo)}}">
                        </div>
                        <div class="col-sm-6" style="color: #023047">
                            <h4 class="mt-2">{{$camion->marque}}</h4>
                            <h5 class="mt-2">{{$camion->model ." - ". $camion->annee}} </h5>
                            <h6 class="mt-2">{{$camion->numero_chassis}}</h6>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
            </div>

        </div>

        <div class="col-md-8 px-3">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-id-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chauffeur</span>
                            <p class="info-box-number voir-camion-statistique">
                                @if ($camion->dernierTrajet() !== null)
                                    @if ($camion->dernierTrajet()->chauffeur !== null)
                                        {{ $camion->dernierTrajet()->chauffeur->name }}
                                    @else
                                        Pas encore de chauffeur
                                    @endif
                                @else
                                    Aucun chauffeur
                                @endif
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-lg-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-danger"><img src="{{asset("assets/images/icons/carburant.png")}}" style="width:35px;" alt=""></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Carburant restant</span>
                            <p class="info-box-number voir-camion-statistique ">{{nombre_fr($stock_carburant)}}L</p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-road"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Trajet en cours</span>
                            <p class="info-box-number voir-camion-statistique">
                                @if ($camion->dernierTrajet(true) !== null)
                                {{ $camion->dernierTrajet(true)->nomItineraire() }}
                                @else
                                Aucun
                                @endif
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning" style="background-color: #ff9609 !important;"><img src="{{asset('assets/images/icons/assurance.png')}}" style="width:55px;" alt=""></span>
                        <div class="info-box-content" >
                            <span class="info-box-text">Assurance</span>
                            <p class="info-box-number voir-camion-statistique" >
                                {{isset($assurance[0]->date_echeance) === true ? date("d/m/Y",strtotime($assurance[0]->date_echeance)) : "Aucune"}}
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><img  style="width:55px;" src="{{asset('assets/images/icons/visit.png')}}" alt=""></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Visite technique</span>
                            <p class="info-box-number voir-camion-statistique">
                                {{isset($visiteTechnique[0]->date_echeance) === true ? date("d/m/Y", strtotime($visiteTechnique[0]->date_echeance)) : "Aucune"}}
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
        </div>


    </div>

    <div class="row">
        <div class="col-sm-12 px-3">
            <div class="card">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === false || $tab == 1 ) ? 'active' : '' }} " id="nav-carburant-tab" data-toggle="tab" href="#nav-carburant" role="tab" aria-controls="nav-carburant" aria-selected="true">Carburants</a>
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === true && intval($tab) === 2 ) ? 'active' : ''}} " id="nav-trajet-tab" data-toggle="tab" href="#nav-trajet" role="tab" aria-controls="nav-trajet" aria-selected="false">Trajets</a>
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === true && intval($tab) === 3 ) ? 'active' : ''}} " id="nav-papier-tab" data-toggle="tab" href="#nav-papier" role="tab" aria-controls="nav-papier" aria-selected="false">Papier</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show {{( isset($tab) === false || $tab == 1 ) ? ' show active ' : '' }}" id="nav-carburant" role="tabpanel" aria-labelledby="nav-carburant-tab">
                        <div class="card-header">
                            <h3 class="card-title" style="color: gray;display:none;" >Flux des carburants</h3>
                            <button class="float-right btn btn-success" id="btn-modal-carburant" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-carburant"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="flux-carburants" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire</th>
                                        <th>Montant total</th>
                                        <th>Flux</th>
                                        <th style="text-align: center;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($carburants) === true && $carburants->count() > 0)
                                    @foreach ($carburants as $carburant)

                                    <tr>
                                        <td>{{$carburant->date}}</td>
                                        <td class="text-left" >{{nombre_fr($carburant->quantite)."L"}}</td>
                                        <td class="text-left" >{{$carburant->prix == null ? "--" : prix_mg($carburant->prix)}}</td>
                                        <td class="text-left" >{{$carburant->prix == null ? "--" : prix_mg($carburant->prix * $carburant->quantite, 0, ",", ".")}}</td>
                                        <td>{{$carburant->flux == false ? "Entrée" : "Sortie"}}</td>
                                        <td >
                                            <div class="row">
                                                <div class="col-sm-12" style="text-align: center">
                                                    <button @if ($carburant->flux == true) disabled @endif class="btn  btn-sm btn-primary modifier-carburant" data-url="{{route('carburant.update', ['carburant' => $carburant->id])}}" data-show-url="{{route('carburant.modifier', ['carburant' => $carburant->id])}}"><span class="fa fa-edit"></span></button>
                                                    <button @if ($carburant->flux == true) disabled @endif class="btn  btn-sm btn-danger  supprimer-carburant" data-url="{{route('carburant.delete', ['carburant' => $carburant->id])}}"><span class="fa fa-trash"></span></button>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach

                                    @else
                                   
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantité</th>
                                        <th>Prix unitaire</th>
                                        <th>Montant total</th>
                                        <th>Flux</th>
                                        <th style="text-align: center;">Actions</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    {{-- Pour les trajets --}}
                    <div class="tab-pane fade {{ ( isset($tab) === true && intval($tab) === 2 ) ? ' show active ' : ''}} " id="nav-trajet" role="tabpanel" aria-labelledby="nav-trajet-tab">
                        <div class="card-header">
                            <h3 class="card-title" style="color: gray;display:none;" >Liste des trajets</h3>
                            <button class="float-right btn btn-success" id="btn-modal-trajet" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-trajet"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="trajets" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Numéro du trajet</th>
                                        <th>Itinéraire</th>
                                        <th>Date & heure départ</th>
                                        <th>Date & heure arrivée</th>
                                        <th>Chauffeur</th>
                                        <th>Statut</th>
                                        <th>Détail</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($camion->trajets()->orderBy('date_heure_depart', 'ASC')->get() as $trajet)
                                    <tr>
                                        <td @if ($trajet->ordreExecution() !== null) style="background-color:{{ $trajet->couleurs() }}" @endif>{{ $trajet->id }}</td>
                                        <td>{{ $trajet->nomItineraire() }}</td>
                                        <td>{{ formatDate($trajet->date_heure_depart) }}</td>
                                        <td>{{ formatDate($trajet->date_heure_arrivee) }}</td>
                                        <td>{{ $trajet->chauffeur === null ? "Pas encore de chauffeur assigné" : $trajet->chauffeur->name }}</td>
                                        <td>
                                            @if ($trajet->enRetard())
                                                <div class="badge badge-danger">En rétard</div>
                                            @else
                                                <div class="
                                                    @if ($trajet->etat === App\Models\Trajet::getEtat(1)) badge badge-info
                                                    @elseif ($trajet->etat === App\Models\Trajet::getEtat(0)) badge badge-warning
                                                    @else badge badge-success
                                                    @endif
                                                ">
                                                    {{ $trajet->etat }}
                                                </div>

                                                @if ($trajet->ordreExecution() !== null AND $trajet->etat !== App\Models\Trajet::getEtat(2))
                                                    <b>&nbsp;-&nbsp;Ordre:&nbsp;<span>{{ $trajet->ordreExecution() }}</span></b>
                                                @endif
                                            @endif
                                        </td>
                                        <td >
                                            <div class="row">

                                                <div class="col-sm-12 text-center" >
                                                    <b> <span>{{$trajet->carburantUtilise() > 0 ? $trajet->carburantUtilise() . "L" : "--"}}</span>&nbsp;/&nbsp;<span>{{doubleval($trajet->poids) > 0 ? doubleval($trajet->poids) . "T" : "--"}}</span></b>
                                                </div>
                                                <div class="col-sm-12 text-center d-none" >
                                                    <b>{{doubleval($trajet->poids) > 0 ? doubleval($trajet->poids) . "T" : "--"}}</b>
                                                </div>

                                            </div>
                                        </td>
                                        <td>
                                            @if ($trajet->blocked == false)
                                            <!--
                                            <a href="{{route('trajet.voir', ['trajet' => $trajet->id])}}">
                                                <button class="btn btn-sm btn-info" ><span class="fa fa-eye"></span></button>
                                            </a>-->
                                            @else
                                            <button class="btn btn-sm btn-info" disabled ><span class="fa fa-eye"></span></button>
                                            @endif

                                            <button @if ($trajet->IsLastFinished() === false ) disabled @endif  class="btn btn-sm btn-primary modifier-trajet"  data-update-url="{{route('trajet.update', ['trajet' => $trajet->id])}}" data-show-url="{{route('trajet.modifier', ['trajet' => $trajet->id])}}"><span class="fa fa-edit"></span></button>
                                            <button {{ isset($trajet->reservation->id) === true ? "disabled": "" }} class="btn btn-sm btn-danger supprimer-trajet" data-url="{{route('trajet.supprimer', ['trajet' => $trajet->id])}}" data-delete-url="{{route('trajet.delete', ['trajet' => $trajet->id])}}"><span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                    @empty
                                   
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Numéro du trajet</th>
                                        <th>Itinéraire</th>
                                        <th>Date & heure départ</th>
                                        <th>Date & heure arrivée</th>
                                        <th>Chauffeur</th>
                                        <th>Statut</th>
                                        <th>Détail</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="tab-pane fade {{( isset($tab) === true && $tab == 3 ) ? ' show active ' : '' }}" id="nav-papier" role="tabpanel" aria-labelledby="nav-papier-tab">
                        <div class="card-header">
                            <h3 class="card-title" style="color: gray;display:none;" ></h3>
                            <button class="float-right btn btn-success" id="btn-modal-papier" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-papier"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="papiers" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Type</th>
                                        <th>Date d'obtention</th>
                                        <th>Date d'échéance</th>
                                        <th style="text-align: center;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($papiers) === true && $papiers->count() > 0)
                                    @foreach ($papiers as $papier)

                                    <tr>
                                        <td>{{$papier->designation}}</td>
                                        <td>{{$papier->type}}</td>
                                        <td>{{$papier->date}}</td>
                                        <td>{{$papier->date_echeance}}</td>
                                        <td >
                                            <div class="row">
                                                <div class="col-sm-12" style="text-align: center">
                                                    <a  href="{{$papier->photo == null ? "#" : asset('storage/'.$papier->photo)}}" >
                                                        <button class="btn btn-sm btn-info"><span class="fa fa-eye"></span></button>
                                                    </a>
                                                    <button class="btn btn-sm btn-primary btn-papier-modifier" data-url="{{route('papier.update', ["papier" => $papier->id])}}"  data-show="{{route('papier.modifier', ["papier" => $papier->id])}}" ><span class="fa fa-edit"></span></button>
                                                    <button class="btn btn-sm btn-danger btn-papier-supprimer" data-url="{{route('papier.supprimer', ["papier" => $papier->id])}}" data-show="{{route('papier.modifier', ["papier" => $papier->id])}}"><span class="fa fa-trash"></span></button>
                                                </div>
                                               
                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach

                                    @else
                                   
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Type</th>
                                        <th>Date d'obtention</th>
                                        <th>Date d'échéance</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<!---- modal pour ajouter carburants --->
<div class="modal fade" id="modal-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Approvisionner en carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-carburant">
                <form action="{{route('carburant.ajouter')}}" method="post" role="form" id="form-ajouter-carburant" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" placeholder="Date" class="form-control datetimepicker-input" data-target="#date" name="date" required="">
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Quantité" class="form-control" name="quantite" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select readonly="readonly" name="flux" class="form-control" id="">
                                <option value=0 selected>Entrée</option>
                                <!--
                                <option value=1>Sortie</option>-->

                                {{-- <option value=1>Sortie</option> --}}
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-carburant" form="form-ajouter-carburant" class="float-right btn btn-success">Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter carburant-->

<!---- modal pour modification carburant --->
<div class="modal fade" id="modal-modifier-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un flux de carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-modifier-carburant" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date" class="form-control datetimepicker-input" data-target="#date_modifier" id="modifier_date" name="date" required="">
                                <div class="input-group-append" data-target="#date_modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" placeholder="Quantité" class="form-control" name="quantite" id="modifier_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="flux" class="form-control" id="modifier_flux">
                                <option value=0 selected>Entrée</option>
                                <option value=1>Sortie</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" form="form-modifier-carburant" id="button-modifier-carburant" class="float-right btn btn-primary">Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modification camion-->

<!---- modal pour modification carburant --->
<div class="modal fade" id="modal-supprimer-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un flux de carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-supprimer-carburant" >
                    @csrf
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_modifier" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_modifier" id="supprimer_date" name="date" required="">
                                <div class="input-group-append" data-target="#date_modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantite" id="supprimer_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="flux" class="form-control" id="supprimer_flux">
                                <option value=0 selected>Entrée</option>
                                <option value=1>Sortie</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" form="form-supprimer-carburant" id="button-supprimer-carburant" class="float-right btn btn-danger">Supprimer</button>
                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modification camion-->

@if ($errors->any())
    <div class="row">
        <div class="col-xl-12">
            @dump($errors->all())
        </div>
    </div>
@endif

{{-- -Tous ce qui concerne les trajets --}}

<div class="modal fade" id="modal-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Enregistrer un trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-trajet">
                <div class="row">
                    <form class="col-sm-12" action="{{route('trajet.ajouter')}}" method="post" role="form" id="form-ajouter-trajet" enctype="multipart/form-data">
    
                        @csrf
    
                        <input type="hidden" name="camion_id" value={{ $camion->id }}>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chauffeur" class="form-label">Chauffeur :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="chauffeur" class="form-control" id="chauffeur">
                                    <option value="">Selectionner un chauffeur</option>
                                    @forelse ($chauffeurs as $chauffeur)
                                        <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                    @empty
                                        <option value="">Aucun chauffeur disponible pour le moment</option>
                                    @endforelse
                                </select>
                                <div id="chauffeur-feedback"  class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Départ :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                    <div class="input-group-append" data-target="#date_heure_depart" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div  class="invalid-feedback"></div>

                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Arrivée :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date_heure_arrivee" id="date_heure_arrivee" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                    <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div  class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="etat">Statut :</label>
                            </div>
                            <div class="col-sm-8">
    
                                <select name="etat" class="form-control " id="etat" onchange="checkCarburant(this)" required>
                                    <option value="">Selectionner le statut</option>
                                    @foreach (App\Models\Trajet::getEtat() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div  id="status-feedback" class="invalid-feedback"></div>

                            </div>
                        </div>
    
    
                        <div class="row mb-3 mt-3  carburant" id="carburant" style="display: none;">
                            <div class="col-sm-4">
                                <label for="carburant-restant">Carburant restant :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="carburantRestant" id="carburant-restant" placeholder="Quantité de carburant restant">
                                <div   class="invalid-feedback"></div>

                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  poids-content" style="display: none;" id="poids-content">
                            <div class="col-sm-4">
                                <label for="poids">Poids :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="poids" id="poids" placeholder="Poids">
                                <div class="invalid-feedback"></div>

                            </div>
                        </div>
    
    
                        {{-- Bloc pour gerer les itinéraires --}}
                        <div id="content-itineraire" class="mb-3">
                            <input type="hidden" name="itineraire" class="itineraire_data" value="">
                            <div class="form-group">
                                <label for="nombre_itineraire">Itinéraires :</label>
                                <div id="itineraire_formulaire">
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-top:1%;">
                                            <input type="text" placeholder="Nom de l'itinéraire" class='form-control' required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1 row">
                                    <div class="col-sm-12" style="text-align:right;">
                                        <button  type="button" class="btn btn-sm btn-itineraire-moins" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);display:none;"><span class="fa fa-minus"></span></button>
    
                                        <button  type="button" class="btn btn-sm btn-itineraire-plus" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-sm-12">
                        <p class="alert alert-danger text-center"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-ajouter-trajet" form="form-ajouter-trajet" class="float-right btn btn-success"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-modifier-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un un trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <form action="#" class="col-sm-12" method="post" id="form-modifier-trajet" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
    
                        <input type="hidden" name="camion_id" value={{ $camion->id }}>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chauffeur" class="form-label">Chauffeur :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="chauffeur" class="form-control" id="modifier-chauffeur">
                                    <option value="">Selectionner un chauffeur</option>
                                    @forelse ($chauffeurs as $chauffeur)
                                        <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                    @empty
                                        <option value="">Aucun chauffeur disponible pour le moment</option>
                                    @endforelse
                                </select>
                                <div id="chauffeur-modifier-feedback"  class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Départ :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date" id="date_heure_depart_modifier" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_depart" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                    <div class="input-group-append" data-target="#date_heure_depart_modifier" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Arrivée :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date_heure_arrivee" id="date_heure_arrivee_modifier" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_arrivee" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                    <div class="input-group-append" data-target="#date_heure_arrivee_modifier" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                       
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="etat">Statut :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="etat" class="form-control " id="modifier-etat" required onchange="checkCarburant(this, '#modal-modifier-trajet')">
                                    <option value="">Selectionner le statut</option>
                                    @foreach (App\Models\Trajet::getEtat() as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div  id="status-modifier-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  carburant" style="display: none;">
                            <div class="col-sm-4">
                                <label for="carburant-restant">Carburant restant :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="carburantRestant" id="carburant-restant" placeholder="Quantité de carburant restant">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  poids-content" style="display: none;" id="poids-content">
                            <div class="col-sm-4">
                                <label for="poids">Poids :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="poids" id="poids" placeholder="Poids">
                                <div class="invalid-feedback"></div>

                            </div>
                        </div>
    
                        {{-- Bloc pour gerer les itinéraires --}}
                        <div id="content-itineraire" class="mb-3">
                            <input type="hidden" name="itineraire" id="data-itineraire" class="itineraire_data" value="">
                            <div class="form-group">
                                <label for="nombre_itineraire">Itinéraires :</label>
                                <div id="itineraire_formulaire">
                                    
                                </div>
                                <div class="mt-1 row">
                                    <div class="col-sm-12" style="text-align:right;">
                                        <button  type="button" class="btn btn-sm btn-itineraire-moins" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);display:none;"><span class="fa fa-minus"></span></button>
                                        <button  type="button" class="btn btn-sm btn-itineraire-plus" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-sm-12">
                        <p class="alert alert-danger text-center"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" form="form-modifier-trajet" id="button-modifier-trajet" class="float-right btn btn-primary"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-supprimer-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-supprimer-trajet" >
                    @csrf

                    <input type="hidden" name="camion_id" value={{ $camion->id }}>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="chauffeur" class="form-label">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-control" id="supprimer-chauffeur"></label>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Départ :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="supprimer_date_heure_depart" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                <div class="input-group-append" data-target="#date_heure_depart" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Arrivée :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date_heure_arrivee" id="date_heure_arrivee" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="supprimer_date_heure_arrivee" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="etat">Statut :</label>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-control" id="supprimer-etat"></label>
                        </div>
                    </div>

                    {{-- Bloc pour gerer les itinéraires --}}
                    <div id="content-delete-itineraire" class="mb-3">
                        <div class="form-group">
                            <label for="nombre_itineraire">Itinéraires :</label>
                            <div id="itineraire_delete_formulaire">
                                <div class="row">
                                    <div class="col-sm-12" style="padding-top:1%;" id="list-delete-itineraire">
                                        <input type="text" placeholder="Nom de l'itinéraire" class='form-control' value="test"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <div class="d-flex justify-content-between">
                    <a href="" class="d-none btn btn-warning mr-2">Bloquer</a>
                    <a href="">
                        <button type="button" form="form-supprimer-trajet" id="button-supprimer-trajet" class="float-right btn btn-danger">Supprimer</button>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Fin trajets --}}


{{-- Debut papier --}}
<!---- modal pour ajouter papier --->
<div class="modal fade" id="modal-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Ajouter un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="{{route('papier.ajouter')}}" method="post" role="form" id="form-ajouter-papier" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label for="photo">Photo</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                </div>
                                <div class="custom-file">
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-ajouter-papier" form="form-ajouter-papier" class="float-right btn btn-success"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter papier-->


<!---- modal pour modifier papier --->
<div class="modal fade" id="modal-modifier-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="#" method="post" role="form" id="form-modifier-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-4">
                            <label for="photo">Photo</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                </div>
                                <div class="custom-file">
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-modifier-papier" form="form-modifier-papier" class="float-right btn btn-primary"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

<!---- modal pour supprimer papier --->
<div class="modal fade" id="modal-supprimer-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-supprimer-papier">
                <form action="#" method="post" role="form" id="form-supprimer-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input disabled type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" id="button-supprimer-papier" form="form-supprimer-papier" class="float-right btn btn-danger"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>

                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

{{-- Fin papier --}}

<!-- page script -->
@endsection

@section('scripts')
<!-- DataTables -->
<script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>
<script>
    // Limitation de nombre de lettre sur les statistique

    $(".voir-camion-statistique").each(function(value){
        let text = $(this).html().trim();
        $(this).html(etc(text, 25))
    })

    // Limitation de nombre de lettre sur les statistique

    var nb_itineraire_formulaire = 0;

    // Pour multiplier le nombre de champ pour ajouter un itinéraire
    $(document).on("click", ".btn-itineraire-plus" , function(e){
        _this = $(this).parent().parent().parent();
        nb_itineraire_formulaire = _this.find("#itineraire_formulaire .row").length + 1;
        console.log($('#itineraire_formulaire_added-'+nb_itineraire_formulaire));

        if(nb_itineraire_formulaire > 1){
            $(".btn-itineraire-moins").show(100);
        }
        let itineraire_formulaire = _this.find("#itineraire_formulaire").find(".row:first").html();

        _this.find("#itineraire_formulaire")
        .append("<div id='itineraire_formulaire_added-"+
        nb_itineraire_formulaire+"' class='row added'>"+itineraire_formulaire
        +"</div>").find(".row:last input").val("");

        
    })


    // Pour enlever le nombre de champ pour ajouter un itinéraire
    $(document).on("click", ".btn-itineraire-moins" , function(e){
        _this = $(this).parent().parent().parent();
        nb_itineraire_formulaire = _this.find("#itineraire_formulaire .row").length;
        console.log($('#itineraire_formulaire_added-'+nb_itineraire_formulaire));
        _this.find('#itineraire_formulaire_added-'+nb_itineraire_formulaire).remove();

        if(nb_itineraire_formulaire < 3){
            $(".btn-itineraire-moins").hide(100);
        }

        let data_itineraire = [];
        _this.find("#itineraire_formulaire .row").each(function(){

                let nom_itineraire = $(this).find("input:first").val();
                
                if(nom_itineraire != ''){
                    data_itineraire.push({
                        nom : nom_itineraire
                    });
                }

            })

        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })

    $(document).on("blur", "#content-itineraire input" , function(e){
        //Récuperation des données relative au salarié avant de l'ajouter dans un input de type hidden(caché) pour pouvoir l'envoyer en post sous format json
        let data_itineraire = [];

        _this = $(this).parent().parent().parent().parent();
        _this.find('#itineraire_formulaire .row').each(function(){

            let nom_itineraire = $(this).find("input:first").val();
             
            if(nom_itineraire != ''){
                data_itineraire.push({
                    nom : nom_itineraire
                });
            }
        })
        //document.getElementById('content-itineraire').firstElementChild.value = JSON.stringify(data_itineraire)
        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })

    $("#flux-carburants , #trajets , #papiers ").DataTable({
        "responsive": true,
        "autoWidth": false,
        "searching": true,
        "paging": false,
        "ordering": true,
        "info": false ,            
        language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
    });

    $(document).on("click", ".modifier-carburant", function(){

        let url = $(this).attr("data-show-url");
        let url_update = $(this).attr("data-url")

        $("#modal-modifier-carburant").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#form-modifier-carburant").attr("action", url_update);

        $.get(url, {}, dataType="JSON").done(function (data) {
            $("#modal-modifier-carburant #modifier_date").val(data.date);
            $("#modal-modifier-carburant #modifier_quantite").val(data.quantite);
            $("#modal-modifier-carburant input[name=prix]").val(data.prix);
            $("#modal-modifier-carburant #modifier_flux").val(data.flux).attr("readonly", "readonly").change();

        })
    })

    $(document).on("click", ".supprimer-carburant", function (e) {
        let url = $(this).prev().attr("data-show-url");
        let url_delete = $(this).attr("data-url");

        $("#button-supprimer-carburant").parent().attr("href", url_delete);

        $("#modal-supprimer-carburant").modal({
            backdrop: 'static',
            keyboard: false
        });

        $.get(url, {}, dataType="JSON").done(function (data) {
            $("#modal-supprimer-carburant #supprimer_date").val(data.date).attr("disabled", true);
            $("#modal-supprimer-carburant #supprimer_quantite").val(data.quantite).attr("disabled", true);
            $("#modal-supprimer-carburant input[name=prix]").val(data.prix).attr("disabled", true);
            $("#modal-supprimer-carburant #supprimer_flux").val(data.flux).change().attr("disabled", true);

        })

    })
   

    $(document).on("click","#nav-trajet-tab", function(){

            resizeDataTable($("#trajets"), $("#nav-trajet")) ;
    })

    $(document).on("click","#nav-carburant-tab", function(){

            resizeDataTable($("#flux-carburants"), $("#nav-carburant")) ;
    })

    $(document).on("click","#nav-papier-tab", function(){

            resizeDataTable($("#papiers"), $("#nav-papier")) ;

    })

    $(document).on("click", ".modifier-trajet", function(){
        let url = $(this).attr("data-show-url");
        let url_update = $(this).attr("data-update-url")
        viderFormulaireAjoutTrajet($("#form-modifier-trajet"));
        $("#modal-modifier-trajet").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#form-modifier-trajet").attr("action", url_update);

        $.get(url, {}, dataType="JSON").done(function (data) {
            let lists = document.getElementById('list-itineraire')
            let itineraires =  data.itineraires.sort( (teamA, teamB) => teamA.id - teamB.id  );

            $("#form-modifier-trajet").find("input[name=poids]").val(data.trajet.poids);
            $("#form-modifier-trajet").find(".added").remove();
            
            itineraires.forEach((itineraire, index) => {
                let element = "";
                if(index === 0){
                    element = '<div class="row added"><div class="col-sm-12" style="padding-top:1%;"><input type="text" placeholder="Nom de l\'itinéraire" class="form-control" value="' + itineraire.nom + '" required></div></div>'

                }else{
                    element = '<div id="itineraire_formulaire_added-'+(index + 1 )+'" class="row added" >';
                    element += '    <div class="col-sm-12" style="padding-top:1%;">';
                    element +=      '   <input type="text" placeholder="Nom de l\'itinéraire" class="form-control" value="' + itineraire.nom + '" required="">';
                    element +=  '   </div>';
                    element += '</div>';


                }
                $("#form-modifier-trajet").find("#itineraire_formulaire").append(element);

            })

            if(itineraires.length >  1){
                $("#form-modifier-trajet .btn-itineraire-moins").show(100);
            }

            $("#modal-modifier-trajet #data-itineraire").val(JSON.stringify(data.itineraires));
            $("#modal-modifier-trajet #modifier-chauffeur").val(data.trajet.chauffeur_id);
            $("#modal-modifier-trajet #modifier_date_heure_depart").val(data.trajet.date_heure_depart);
            $("#modal-modifier-trajet #modifier_date_heure_arrivee").val(data.trajet.date_heure_arrivee);
            $("#modal-modifier-trajet #modifier-etat").val(data.trajet.etat);
            $("#modifier-etat").change();


            if(data.reservation != null){
                $("#modal-modifier-trajet #modifier_date_heure_depart").attr("readonly", "readonly");
                $("#modal-modifier-trajet #content-itineraire input").attr("readonly", "readonly");
                $("#modal-modifier-trajet .btn-itineraire-plus , #modal-modifier-trajet .btn-itineraire-moins").attr("disabled", true);
            }else{
                $("#modal-modifier-trajet #modifier_date_heure_depart").removeAttr("readonly");
                $("#modal-modifier-trajet #content-itineraire input").removeAttr("readonly");
                $("#modal-modifier-trajet .btn-itineraire-plus , #modal-modifier-trajet .btn-itineraire-moins").removeAttr("disabled");
            }

            if($("#modifier-etat option:selected").val() == '{{ App\Models\Trajet::getEtat(1) }}'){
                $("#modal-modifier-trajet #carburant-restant").val(data.trajet.carburant_depart);

            }else if ($("#modifier-etat option:selected").val() == '{{ App\Models\Trajet::getEtat(2) }}'){
                $("#modal-modifier-trajet #carburant-restant").val(data.trajet.carburant_depart - data.trajet.carburant_total);
            }


        })
    })

    $(document).on("click", ".supprimer-trajet", function (e) {

        let url = $(this).prev().attr("data-show-url");
        let url_delete = $(this).attr("data-url");

        $("#button-supprimer-trajet").parent().attr("href", url_delete);

        $("#modal-supprimer-trajet").modal({
            backdrop: 'static',
            keyboard: false
        });

        $.get(url, {}, dataType="JSON").done(function (data) {
            let lists = document.getElementById('list-delete-itineraire')
            let itineraires = data.itineraires
            lists.innerHTML = ''

            itineraires.forEach(itineraire => {
                input = document.createElement('input')
                input.value = itineraire.nom
                input.classList.add('form-control')
                input.classList.add('mb-2')
                input.setAttribute('placeholder', 'Nom de l\'itinéraire')
                input.setAttribute('disabled', true)
                lists.appendChild(input)
            })

            $("#modal-supprimer-trajet #supprimer-chauffeur").html(data.chauffeur.name);
            $("#modal-supprimer-trajet #supprimer_date_heure_depart").val(data.trajet.date_heure_depart);
            $("#modal-supprimer-trajet #supprimer_date_heure_arrivee").val(data.trajet.date_heure_arrivee);
            $("#modal-supprimer-trajet #supprimer-etat").html(data.trajet.etat);
        })

    })
    
    $(document).on("click", "#button-ajouter-trajet", function(e){
        let me = $(this);
        spinning(me);

        let data = $("#form-ajouter-trajet").serialize();
        let url = $("#form-ajouter-trajet").attr("action");

        $.ajax({
                url: url,
                type : "post",
                dataType : "JSON",
                data : data ,
                success : function(data){

                    if(data.status == "success"){
                        window.location.href = data.value;
                    }

                    if(data.status == "error"){

                        // reeffacer les alert apres un cas de non success
                        $("#status-feedback").prev().removeClass("is-invalid");
                        $("#status-feedback").html("").hide(300);
                        $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        $("#form-ajouter-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)

                        if
                        (   data.value == "Camion non disponible entre les dates que vous avez selectionnées" ||
                            date.value == "Le camion a encore un trajet en cours" ||
                            data.value == "Vous devez choisir au moins deux itinéraires" ||
                            data.value == "echec d'ajout"  )
                        {
                            $("#form-ajouter-trajet").parent().next().find(".alert").html(data.value);
                            $("#form-ajouter-trajet").parent().next().show(300);
                        }else{
                            $("#form-ajouter-trajet").parent().next().find(".alert").html("");
                            $("#form-ajouter-trajet").parent().next().hide(300);
        
                        }

                        if(data.value == "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" || data.value == "Chauffeur non disponible entre les dates que vous avez selectionné"){
                            $("#chauffeur-feedback").prev().addClass("is-invalid");
                            $("#chauffeur-feedback").html(data.value).show(300);
                        }else{
                            $("#chauffeur-feedback").prev().removeClass("is-invalid");
                            $("#chauffeur-feedback").html("").hide(300);
                        }

                        if
                        (   data.value == "La date de depart doit être supérieur a ce moment précis si le statut est à prévoir" || 
                            data.value == "La date de depart doit être inférieur a la date d'arrivée")
                        {
                            
                            $("#form-ajouter-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html(data.value).show(300)
                        }else{
                            $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        }

                        if
                        (   data.value == "Veuillez remplir la quantité de carburant restant" || 
                            data.value == "Le carburant du véhicule est encore insuffisant" ||
                            data.value == "La quantité de carburant que vous avez saisi est superieur au stock")
                        {
                            $("#form-ajouter-trajet input[name=carburantRestant]").addClass("is-invalid").next().html(data.value).show(300);
                        }else{
                            $("#form-ajouter-trajet input[name=carburantRestant]").removeClass("is-invalid").next().html("").hide(300);

                        }

                    }

                    


                    spinning(me, 2);
                },
                error: function (data) {
                        donnee = $.parseJSON(data.responseText);
                      

                        if(donnee.message == "The given data was invalid."){
                           
                            console.log(donnee.errors.etat );

                            if(donnee.errors.hasOwnProperty("etat") === true){
                                $("#status-feedback").prev().addClass("is-invalid");
                                $("#status-feedback").html("la date de départ est obligatoire").show(300);
                            }else{
                                $("#status-feedback").prev().removeClass("is-invalid");
                                $("#status-feedback").html("").hide(300);
                            }

                            if(donnee.errors.hasOwnProperty("date_heure_depart") === true ){
                                $("#form-ajouter-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html("La date de départ est obligatoire").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                            }

                            if(donnee.errors.hasOwnProperty("date_heure_arrivee") === true ){
                                $("#form-ajouter-trajet input[name=date_heure_arrivee]").addClass("is-invalid").next().next().html("La date d'arrivée approximative est obligatoire").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)
                            }

                            if(donnee.errors.hasOwnProperty("poids") === true ){
                                
                                $("#form-ajouter-trajet input[name=poids]").addClass("is-invalid").next().html("Le poids doit être supérieur à zéro").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=poids]").removeClass("is-invalid").next().html("").hide(300)
                            }
                        }
                        spinning(me, 2);
                    }
                }
            )
        
    });

    $(document).on("click", "#button-modifier-trajet", function(e){
        let me = $(this);
        spinning(me);

        let data = $("#form-modifier-trajet").serialize();
        let url = $("#form-modifier-trajet").attr("action");

        $.ajax({
            url : url,
            type : "POST",
            dataType : "JSON",
            data : data,
            success : function (data) {

                if(data.status == "success"){
                        window.location.href = data.value;
                }

                if(data.status == "error"){
                    if
                    (   data.value == "Camion non disponible entre les dates que vous avez selectionnées" ||
                        date.value == "Le camion a encore un trajet en cours" ||
                        data.value == "Vous devez choisir au moins deux itinéraires" ||
                        data.value == "Erreur de mise a jour" ||
                        data.value == "Le camion a encore un trajet en cours" )
                    {
                        $("#form-modifier-trajet").parent().next().find(".alert").html(data.value);
                        $("#form-modifier-trajet").parent().next().show(300);
                    }else{
                        $("#form-modifier-trajet").parent().next().find(".alert").html("");
                        $("#form-modifier-trajet").parent().next().hide(300);
        
                    }

                    if(
                        data.value == "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" || 
                        data.value == "Chauffeur non disponible entre les dates que vous avez selectionné"
                    ){
                            $("#chauffeur-modifier-feedback").prev().addClass("is-invalid");
                            $("#chauffeur-modifier-feedback").html(data.value).show(300);
                    }else{
                            $("#chauffeur-modifier-feedback").prev().removeClass("is-invalid");
                            $("#chauffeur-modifier-feedback").html("").hide(300);
                    }

                    if( data.value == "On ne peut pas terminer un trajet a prévoir sans être en cours" ){

                        $("#status-modifier-feedback").prev().addClass("is-invalid");
                        $("#status-modifier-feedback").html(data.value).show(300);
                    }else{

                        $("#status-modifier-feedback").prev().removeClass("is-invalid");
                        $("#status-modifier-feedback").html("").hide(300);
                    }

                    if
                        (   data.value == "La date depart ne doit pas depasser la date et heure actuel" ||
                            data.value == "Vous devez specifier une date d'arrivée." ||
                            data.value == "La date de depart doit être inférieur a la date d'arrivée"
                            )
                        {
                            
                            $("#form-modifier-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html(data.value).show(300)
                        }else{
                            $("#form-modifier-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        }


                    if
                    (   data.value == "Veuillez remplir la quantité de carburant restant" || 
                        data.value == "Le carburant du véhicule est encore insuffisant" ||
                        data.value == "La quantité de carburant que vous avez saisi est superieur au stock")
                    {
                        $("#form-modifier-trajet input[name=carburantRestant]").addClass("is-invalid").next().html(data.value).show(300);
                    }else{
                        $("#form-modifier-trajet input[name=carburantRestant]").removeClass("is-invalid").next().html("").hide(300);

                    }

                }

                spinning(me, 2);
            },
            error : function (data){

                donnee = $.parseJSON(data.responseText);


                if(donnee.errors.hasOwnProperty("date_heure_depart") === true ){
                    $("#form-ajouter-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html("La date de départ est obligatoire").show(300)
                                
                }else{
                    $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                }

                if(donnee.errors.hasOwnProperty("date_heure_arrivee") === true ){
                    $("#form-modifier-trajet input[name=date_heure_arrivee]").addClass("is-invalid").next().next().html("La date d'arrivée approximative est obligatoire").show(300)
                                
                }else{
                    $("#form-modifier-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)
                }

                if(donnee.errors.hasOwnProperty("etat") === true){
                    $("#status-modifier-feedback").prev().addClass("is-invalid");
                    $("#status-modifier-feedback").html("la date de départ est obligatoire").show(300);
                }else{
                    $("#status-modifier-feedback").prev().removeClass("is-invalid");
                    $("#status-modifier-feedback").html("").hide(300);
                }

                if(donnee.errors.hasOwnProperty("poids") === true ){
                    $("#form-modifier-trajet input[name=poids]").addClass("is-invalid").next().html("Le poids doit être supérieur à zéro").show(300)
                                
                }else{
                        $("#form-modifier-trajet input[name=poids]").removeClass("is-invalid").next().html("").hide(300)
                }

                spinning(me, 2);
            }

        })
    })

    $(document).on("click", "#btn-modal-trajet", function(e){
        viderFormulaireAjoutTrajet($("#form-ajouter-trajet"));
    })


    const checkCarburant = function (select, action) {

        action = action === undefined ? "#modal-trajet" : action ;

        let etat = select.value
        let carburant = $(action + " .carburant") 
        let poids = $(action + " .poids-content")

        if (etat == '{{ App\Models\Trajet::getEtat(2) }}'|| etat == '{{ App\Models\Trajet::getEtat(1) }}' ) {
            carburant.show(200).find("input").val("");
            poids.show(200);

        } else {

            carburant.hide(200).find("input").val("");
            poids.hide(200);

        }
    }

   


    // -------------------- EVENEMENT LIEE AU PAPIER ------------------------ //
  
    $(document).on("click", ".btn-papier-supprimer", function(e){
        let url = $(this).attr("data-show");
        let url_delete = $(this).attr("data-url");

        //$("#modal-supprimer-papier").find("form").attr("action", url_update);
        $("#button-supprimer-papier").parent().attr("href", url_delete);
        $.get(url, {}, dataType = "JSON").done(function (data) {

            $("#modal-supprimer-papier").modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#modal-supprimer-papier").find("input[name=designation]").val(data.designation);
            $("#modal-supprimer-papier").find("input[name=date_obtention]").val(data.date);
            $("#modal-supprimer-papier").find("input[name=date_echeance]").val(data.date_echeance);
            $("#modal-supprimer-papier").find("select[name=type]").val(data.type).change();
           
            
        });
    })

    $(document).on("click", ".btn-papier-modifier", function(e){
        let url = $(this).attr("data-show");
        let url_update = $(this).attr("data-url");

        $("#modal-modifier-papier").find("form").attr("action", url_update);
        viderFormulaireAjouterPapier($("#modal-modifier-papier"));
        $.get(url, {}, dataType = "JSON").done(function (data) {

            $("#modal-modifier-papier").modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#modal-modifier-papier").find("input[name=designation]").val(data.designation);
            $("#modal-modifier-papier").find("input[name=date_obtention]").val(data.date);
            $("#modal-modifier-papier").find("input[name=date_echeance]").val(data.date_echeance);
            $("#modal-modifier-papier").find("select[name=type]").val(data.type).change();
           
            
        });
    });

    $(document).on("click", "#btn-modal-papier", function(e){
        viderFormulaireAjouterPapier($("#modal-ajouter-papier"));
    });

    $(document).on("click", "#button-ajouter-papier , #button-modifier-papier", function(e){
        let button = $(this);
        spinning(button);

        let me = button.parent().parent().find("form")

        let url = me.attr("action");
        let id_form =  me.attr("id");
        let data = new FormData(document.getElementById(id_form));

        $.ajax({
            url : url,
            type : "POST",
            dataType : "JSON",
            data : data,
            contentType: false,
            processData: false,
            error : function (data) {
                let donnees = $.parseJSON(data.responseText);
                name_list = Object.keys(donnees.errors);
                

                me.find(".form-control").each(function (value, index) {
                    let name = $(this).attr("name");
                    if(donnees.errors.hasOwnProperty(name)){                        
                        me.find("input[name="+name+"] , select[name="+name+"]").addClass("is-invalid")
                        .parent().find(".invalid-feedback").html(donnees.errors[name][0]).show(300);
                        
                        if(name == "photo"){
                            me.find(".photo-feedback").html(donnees.errors[name][0]).show(300);
                        }
                    }else if(name_list.indexOf(name) == -1){
                        $(this).removeClass("is-invalid").parent().find(".invalid-feedback").html("").hide();

                        if(name == "photo"){
                            me.find(".photo-feedback").html("").hide();
                        }
                    }
                })

                spinning(button, 2);
            },
            success : function (data) {
                spinning(button, 2);
                if(data.status == "success"){
                    window.location.href = data.value;
                }
            }
        });
    });

    // -------------------- EVENEMENT LIEE AU PAPIER ------------------------ //

    function resizeDataTable(element , content) {

            setTimeout(function(){
               let classes = content.attr("class").split(" ");
               console.log(classes, jQuery.inArray("active", classes), jQuery.inArray("show", classes) !== -1);
               if(jQuery.inArray("active", classes) !== -1 && jQuery.inArray("show", classes) !== -1 ){
                   let  table = element.DataTable();
                   table.columns.adjust().draw();
               }else{
                    resizeDataTable(element, content)
               }
           }, 200);
    }

    function viderFormulaireAjoutTrajet(me){
        me.find(" .mb-3 input").val("").removeClass("is-invalid");
        me.find(" select").val("").removeClass("is-invalid").change();
        me.find(" .invalid-feedback").html("").hide();
        me.parent().next().find(".alert").html("");
        me.parent().next().hide(200);
    }

    function viderFormulaireAjouterPapier(me){
        me.find(" input[type!='hidden'] , #form-ajouter-papier select").val("").removeClass("is-invalid");
        me.find(".invalid-feedback").html("").hide();
    }




    


</script>

@endsection
