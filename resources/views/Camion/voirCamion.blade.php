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
                            <h5 class="info-box-number">Aucun</h5>
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
                            <h5 class="info-box-number">Aucun</h5>
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
                            <table id="example2" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th>Entrer en vigueur</th>
                                        <th>Montant</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Decembre 2021</td>

                                        <td>2 500 000,00 Ar</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-12" style="text-align: center;">
                                                    <a alt="Modifier le loyer" href="#" onclick="modifierLoyer('http://localhost/developpement/tsaravidy/public/depenses/loyer/modifier/3')" data-toggle="modal" data-target="#modal-loyer-modifier"><span class="fa fa-cog"></span></a>
                                                    <a alt="Supprimer le loyer" href="#" onclick="supprimerLoyer('http://localhost/developpement/tsaravidy/public/depenses/loyer/supprimer/3')" data-toggle="modal" data-target="#modal-supprimer-loyer"><span class="fa fa-trash"></span></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Entrer en vigueur</th>
                                        <th>Montant</th>
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

<!---- modal pour ajouter camions --->
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
                                <option value=1>Sortie</option>
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
                    <input type="hidden" name="camion_id" value={{$camion->id}}>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="date">Date & heure départ :</label>
                        </div>
                        <div class="col-sm-7">
                            <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_depart" name="date_heure_depart" required="">
                                <div class="input-group-append" data-target="#date_heure_depart" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="date">Date & heure arrivée :</label>
                        </div>
                        <div class="col-sm-7">
                            <div class="input-group date_heure_arrivee" id="date_heure_arrivee" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_arrivee" name="date_heure_arrivee" required="">
                                <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="numero">Numéro :</label>
                        </div>
                        <div class="col-sm-7">
                            <input type="number" class="form-control" name="numero" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="chauffeur" class="form-label">Chauffeur :</label>
                        </div>
                        <div class="col-sm-7">
                            <select name="chauffeur" class="form-control" id="chauffeur">
                                <option value="">RAKOTO</option>
                                <option value="">RABE</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="camion" class="form-label">Camion :</label>
                        </div>
                        <div class="col-sm-7">
                            <select name="camion" class="form-control" id="camion">
                                <option value="">MERCEDES Benz</option>
                                <option value="">NISSAN</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 3px; ">
                        <div class="col-sm-5">
                            <label for="camion" class="form-label">Itinéraire :</label>
                        </div>
                        <div class="col-sm-7">

                        </div>
                    </div>

                    {{-- Bloc pour gerer les itinéraires --}}
                    <div id="content-itineraire">
                        <input type="hidden" name="itineraire" class="itineraire_data" value="">
                        <div class="form-group">
                            <label for="nombre_itineraire">Itinéraires :</label>
                            <div id="itineraire_formulaire">
                                <div class="row">
                                    <div class="col-sm-12" style="padding-top:1%;">
                                        <input type="text" placeholder="Nom de l'itinéraire" name="nom_itinéraire" class='form-control' required>
                                    </div>
                                    <!--div class="col-sm-6" style="padding-top:1%;">
                                        <input type="text" placeholder="Montant salaire" name="montant_salaire" class='form-control salariale' required>
                                    </div-->
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
                <button type="submit" id="button-ajouter-trajet" onclick="save()" form="form-ajouter-trajet" class="float-right btn btn-success">Valider</button>
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

<div class="modal fade" id="modal-supprimer-trajet">
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

    $(document).on("blur", ".content-itineraire input" , function(e){
        alert('hello')
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
        console.log(nom_itineraire);
        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })


    const save = function () {
        let rows = $('#itineraire_formulaire .row');
        debugger
        rows.foreach((element, index) => {
            let nom_itineraire = $(element).find("input:first").val();

            if(nom_itineraire != ''){
                data_itineraire.push({
                    nom_itineraire : nom_itineraire
                });
            }
        })

        /*$('#itineraire_formulaire .row').each(function(){

            let nom_itineraire = $(this).find("input:first").val();

            if(nom_itineraire != ''){
                data_itineraire.push({
                    nom_itineraire : nom_itineraire
                });
            }
        })*/
        debugger
        alert(data_itineraire);
        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    }

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


</script>

@endsection
