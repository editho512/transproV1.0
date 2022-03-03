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
                            <h4 >{{$camion->marque}}</h4>
                            <h5>{{$camion->model ." - ". $camion->annee}} </h5>
                            <h6>{{$camion->numero_chassis}}</h6>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
            </div>

        </div>

        <div class="col-md-8 px-3">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-id-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chauffeur</span>
                            <h5 class="info-box-number">
                                @if ($camion->dernierTrajet() !== null)
                                    @if ($camion->dernierTrajet()->chauffeur !== null)
                                        {{ $camion->dernierTrajet()->chauffeur->name }}
                                    @else
                                        Pas encore de chauffeur
                                    @endif
                                @else
                                    Aucun chauffeur
                                @endif
                            </h5>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-battery-half"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Carburant restant</span>
                            <h5 class="info-box-number">{{$stock_carburant}}L</h5>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fa fa-road"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Trajet</span>
                            <h5 class="info-box-number">
                                @if ($camion->dernierTrajet(true) !== null)
                                {{ $camion->dernierTrajet(true)->nomItineraire() }}
                                @else
                                Aucun trajet en cours
                                @endif
                            </h5>
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
                        <a style="color:#023047 !important;" class="nav-item nav-link active" id="nav-carburant-tab" data-toggle="tab" href="#nav-carburant" role="tab" aria-controls="nav-carburant" aria-selected="true">Carburants</a>
                        <a style="color:#023047 !important;" class="nav-item nav-link " id="nav-trajet-tab" data-toggle="tab" href="#nav-trajet" role="tab" aria-controls="nav-trajet" aria-selected="false">Trajets</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-carburant" role="tabpanel" aria-labelledby="nav-carburant-tab">
                        <div class="card-header">
                            <h3 class="card-title" style="color: gray;display:none;" >Flux des carburants</h3>
                            <button class="float-right btn btn-success" id="btn-modal-carburant" data-toggle="modal" data-target="#modal-carburant"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="flux-carburants" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantité</th>
                                        <th>Flux</th>
                                        <th style="text-align: center;">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($carburants) === true && $carburants->count() > 0)
                                    @foreach ($carburants as $carburant)

                                    <tr>
                                        <td>{{$carburant->date}}</td>
                                        <td>{{$carburant->quantite}}</td>
                                        <td>{{$carburant->flux == false ? "Entrée" : "Sortie"}}</td>
                                        <td class="row">
                                            <div class="col-sm-12" style="text-align: center">
                                                <button class="btn btn-xs btn-primary modifier-carburant" data-url="{{route('carburant.update', ['carburant' => $carburant->id])}}" data-show-url="{{route('carburant.modifier', ['carburant' => $carburant->id])}}"><span class="fa fa-edit"></span></button>
                                                <button class="btn btn-xs btn-danger  supprimer-carburant" data-url="{{route('carburant.delete', ['carburant' => $carburant->id])}}"><span class="fa fa-trash"></span></button>
                                            </div>

                                        </td>

                                    </tr>

                                    @endforeach

                                    @else
                                    <tr>
                                        <td colspan="4" style="text-align: center;">Aucun flux de carburant</td>
                                    </tr>
                                    @endif

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Date</th>
                                        <th>Quantité</th>
                                        <th>Flux</th>
                                        <th style="text-align: center;">Actions</th>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    {{-- Pour les trajets --}}
                    <div class="tab-pane fade " id="nav-trajet" role="tabpanel" aria-labelledby="nav-trajet-tab">
                        <div class="card-header">
                            <h3 class="card-title" style="color: gray;display:none;" >Liste des trajets</h3>
                            <button class="float-right btn btn-success" id="btn-modal-trajet" data-toggle="modal" data-target="#modal-trajet"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
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
                                        <th>Status</th>
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
                                        <td>
                                            @if ($trajet->blocked == false)
                                            <a href="{{route('trajet.voir', ['trajet' => $trajet->id])}}">
                                                <button class="btn btn-sm btn-info" ><span class="fa fa-eye"></span></button>
                                            </a>
                                            @else
                                            <button class="btn btn-sm btn-info" disabled><span class="fa fa-eye"></span></button>
                                            @endif

                                            <button class="btn btn-sm btn-primary modifier-trajet" @if ($trajet->etat === App\Models\Trajet::getEtat(2)) disabled @endif  data-update-url="{{route('trajet.update', ['trajet' => $trajet->id])}}" data-show-url="{{route('trajet.modifier', ['trajet' => $trajet->id])}}"><span class="fa fa-edit"></span></button>
                                            <button class="btn btn-sm btn-danger supprimer-trajet" data-url="{{route('trajet.supprimer', ['trajet' => $trajet->id])}}" data-delete-url="{{route('trajet.delete', ['trajet' => $trajet->id])}}"><span class="fa fa-trash"></span></button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Aucune trajet pour ce camion</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Numéro du trajet</th>
                                        <th>Itinéraire</th>
                                        <th>Date & heure départ</th>
                                        <th>Date & heure arrivée</th>
                                        <th>Chauffeur</th>
                                        <th>Status</th>
                                        <th style="text-align:center;">Actions</th>
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
                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date" name="date" required="">
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantite" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="flux" class="form-control" id="">
                                <option value=0 selected>Entrée</option>
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
                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_modifier" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_modifier" id="modifier_date" name="date" required="">
                                <div class="input-group-append" data-target="#date_modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantite" id="modifier_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 3px; ">
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
                    <div class="row" style="margin-top: 3px; ">
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
                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantite" id="supprimer_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 3px; ">
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
                <form action="{{route('trajet.ajouter')}}" method="post" role="form" id="form-ajouter-trajet" enctype="multipart/form-data">

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
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="etat">Status :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="etat" class="form-control" id="etat" onchange="checkCarburant(this, '{{ App\Models\Trajet::getEtat(2) }}')" required>
                                <option value="">Selectionner le status</option>
                                @foreach (App\Models\Trajet::getEtat() as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3 mt-3 d-none" id="carburant">
                        <div class="col-sm-4">
                            <label for="carburant-restant">Carburant restant :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="carburantRestant" id="carburant-restant" placeholder="Quantité de carburant restant">
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
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-trajet" form="form-ajouter-trajet" class="float-right btn btn-success">Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-modifier-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Modifier un flux de carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="#" method="post" id="form-modifier-trajet" enctype="multipart/form-data">
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
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Départ :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_depart" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
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
                                <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_arrivee" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="etat">Status :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="etat" class="form-control" id="modifier-etat" required>
                                <option value="">Selectionner le status</option>
                                @foreach (App\Models\Trajet::getEtat() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Bloc pour gerer les itinéraires --}}
                    <div id="content-itineraire" class="mb-3">
                        <input type="hidden" name="itineraire" id="data-itineraire" class="itineraire_data" value="">
                        <div class="form-group">
                            <label for="nombre_itineraire">Itinéraires :</label>
                            <div id="itineraire_formulaire">
                                <div class="row">
                                    <div class="col-sm-12" style="padding-top:1%;" id="list-itineraire">
                                        {{-- <input type="text" placeholder="Nom de l'itinéraire" class='form-control' value="test"> --}}
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
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" form="form-modifier-trajet" id="button-modifier-trajet" class="float-right btn btn-success">Modifier</button>
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
                            <label for="etat">Status :</label>
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
                                        {{-- <input type="text" placeholder="Nom de l'itinéraire" class='form-control' value="test"> --}}
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
                    <a href="" class="btn btn-warning mr-2">Bloquer</a>
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
        nb_itineraire_formulaire+"' class='row'>"+itineraire_formulaire
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
    })

    $(document).on("blur", "#content-itineraire input" , function(e){
        //Récuperation des données relative au salarié avant de l'ajouter dans un input de type hidden(caché) pour pouvoir l'envoyer en post sous format json
        let data_itineraire = [];

        _this = $(this).parent().parent().parent().parent();
        _this.find('#itineraire_formulaire .row').each(function(){

            let nom_itineraire = $(this).find("input:first").val();

            if(nom_itineraire != ''){
                data_itineraire.push({
                    nom_itineraire : nom_itineraire
                });
            }
        })
        document.getElementById('content-itineraire').firstElementChild.value = JSON.stringify(data_itineraire)
        //_this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })

    $(document).ready(function () {

        $("#flux-carburants").DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching": true,
            "paging": false,
            "ordering": true,
            "info": false,
        });

        $(document).on("click", ".modifier-carburant", function(){
            let url = $(this).attr("data-show-url");
            let url_update = $(this).attr("data-url")

            $("#modal-modifier-carburant").modal("show");
            $("#form-modifier-carburant").attr("action", url_update);

            $.get(url, {}, dataType="JSON").done(function (data) {
                $("#modal-modifier-carburant #modifier_date").val(data.date);
                $("#modal-modifier-carburant #modifier_quantite").val(data.quantite);
                $("#modal-modifier-carburant #modifier_flux").val(data.flux).change();

            })
        })

        $(document).on("click", ".supprimer-carburant", function (e) {
            let url = $(this).prev().attr("data-show-url");
            let url_delete = $(this).attr("data-url");

            $("#button-supprimer-carburant").parent().attr("href", url_delete);

            $("#modal-supprimer-carburant").modal("show");

            $.get(url, {}, dataType="JSON").done(function (data) {
                $("#modal-supprimer-carburant #supprimer_date").val(data.date).attr("disabled", true);
                $("#modal-supprimer-carburant #supprimer_quantite").val(data.quantite).attr("disabled", true);
                $("#modal-supprimer-carburant #supprimer_flux").val(data.flux).change().attr("disabled", true);

            })

        })
    })


    $(document).ready(function () {

        $("#trajets").DataTable({
            "responsive": true,
            "autoWidth": false,
            "searching": true,
            "paging": false,
            "ordering": true,
            "info": false,
        });

        $(document).on("click", ".modifier-trajet", function(){
            let url = $(this).attr("data-show-url");
            let url_update = $(this).attr("data-update-url")

            $("#modal-modifier-trajet").modal("show");
            $("#form-modifier-trajet").attr("action", url_update);

            $.get(url, {}, dataType="JSON").done(function (data) {
                let lists = document.getElementById('list-itineraire')
                let itineraires = data.itineraires
                lists.innerHTML = ''

                itineraires.forEach(itineraire => {
                    input = document.createElement('input')
                    input.value = itineraire.nom
                    input.classList.add('form-control')
                    input.classList.add('mb-2')
                    input.setAttribute('placeholder', 'Nom de l\'itinéraire')
                    lists.appendChild(input)
                })

                $("#modal-modifier-trajet #data-itineraire").val(JSON.stringify(data.itineraires));
                $("#modal-modifier-trajet #modifier-chauffeur").val(data.trajet.chauffeur_id);
                $("#modal-modifier-trajet #modifier_date_heure_depart").val(data.trajet.date_heure_depart);
                $("#modal-modifier-trajet #modifier_date_heure_arrivee").val(data.trajet.date_heure_arrivee);
                $("#modal-modifier-trajet #modifier-etat").val(data.trajet.etat);

            })
        })

        $(document).on("click", ".supprimer-trajet", function (e) {
            let url = $(this).prev().attr("data-show-url");
            let url_delete = $(this).attr("data-url");

            $("#button-supprimer-trajet").parent().attr("href", url_delete);

            $("#modal-supprimer-trajet").modal("show");

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

    })


    const checkCarburant = function (select, wantStatus) {
        let etat = select.value
        let carburant = document.getElementById('carburant')

        if (etat == wantStatus) {
            carburant.classList.remove('d-none')
        } else {
            carburant.classList.add('d-none')
        }
    }

</script>

@endsection
