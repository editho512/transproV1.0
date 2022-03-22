@extends('main')

@section('title') <title>Historique des maintenances</title> @endsection

@section('styles')

<style>

.style-1 {
    background: linear-gradient(190deg, #3392c5, #0c6edf);
    color: white;
}

.style-2 {
    background: linear-gradient(146deg, #3064d1, #30d1ca);
    color: white;
}

.style-3 {
    background: linear-gradient(45deg, #007497, #30b0d1);
    color: white;
}

.style-4 {
    background: linear-gradient(146deg, #51b9ff, #306fd1);
    color: white;
}

.style-5 {
    background: linear-gradient(146deg, #834400, #c6eeff);
    color: white;
}

.style-6 {
    background: linear-gradient(146deg, #834400, #c6eeff);
    color: white;
}

.style-7 {
    background: linear-gradient(146deg, #834400, #c6eeff);
    color: white;
}

.total {
    background: linear-gradient(135deg, #084766, #00a3f2);
    color: white;
}

</style>

@endsection

@section('content')

<div class="content-wrapper teste" style="min-height: inherit!important;">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @php
                    $i = 1
                @endphp

                @foreach (typeMaintenance() as $type)
                    <div class="col-md-6">
                        <div class="card style-{{ $i }}">
                            <div class="card-body">
                                <h4 class="mb-3 font-weight-bold text-white">{{ $maintenancesGroups->has($type) === true ? formatMoney($maintenancesGroups[$type]->sum('main_oeuvre') + montantPieces($maintenancesGroups[$type])) : formatMoney(0) }}</h4>
                                <h6>{{ $maintenancesGroups->has($type) === true ? numberToLetter($maintenancesGroups[$type]->sum('main_oeuvre') + montantPieces($maintenancesGroups[$type])) : numberToLetter(0) }}</h6>
                            </div>
                            <div class="card-footer">
                                <h5>{{ $type }}</h5>
                            </div>
                        </div>
                    </div>

                    @php
                        $i++
                    @endphp

                @endforeach
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->

    <!-- Main content -->

    <section class="content mb-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card total">
                        <div class="card-body">
                            <h4 class="mb-3 font-weight-bold text-white">{{ formatMoney(totalMaintenance()) }}</h4>
                            <h6>{{ numberToLetter(totalMaintenance()) }}</h6>
                        </div>
                        <div class="card-footer" >
                            <h5>Total des dépenses pour maintenance</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header" >
                            <h3 class="card-title">Historique des dépenses (Maintenances et reparations)</h3>
                            <button class="btn btn-primary float-right" data-backdrop="static" data-keyboard="false" data-toggle="modal" id="ajouter-maintenance" data-target="#modal-ajouter-maintenance"><span class="fa fa-plus mr-2"></span>Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="maintenances" class="table table-bordered table-striped" >
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Titre</th>
                                        <th>Date & heure</th>
                                        <th>Montant (Ar)</th>
                                        <th>Camion</th>
                                        <th>Agent</th>
                                        <th>Commentaire</th>
                                        <th>Pièces</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($maintenances as $maintenance)
                                        <tr>
                                            <td>{{ $maintenance->type }}</td>
                                            <td>{{ $maintenance->titre }}</td>
                                            <td>{{ formatDate($maintenance->date_heure) }}</td>
                                            <td>
                                                <span class="d-block mb-2"><b>TOTAL: </b>{{ formatMoney($maintenance->montantTotal()) }}</span>
                                                <span class="d-block"><b>Main d'&oelig;uvre: </b> {{ formatMoney($maintenance->main_oeuvre) }}</span>
                                                @if ($maintenance->pieces !== null AND json_decode($maintenance->pieces, true) !== [])
                                                    <span class="d-block"><b>Pièces: </b></span>
                                                    <ul>
                                                        @foreach (json_decode($maintenance->pieces, true) as $nom => $piece)
                                                            <li><b>{{ $nom }}: </b>{{ formatMoney($piece['pu'] * $piece['quantite']) }}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>{{ $maintenance->infosCamion() }}</td>
                                            <td>{{ $maintenance->nom_reparateur }}</td>
                                            <td>{{ $maintenance->commentaire }}</td>
                                            <td>
                                                @if ($maintenance->pieces !== null AND json_decode($maintenance->pieces, true) !== [])
                                                    <ul>
                                                        @foreach (json_decode($maintenance->pieces, true) as $nom => $piece)
                                                            <li>{{ $nom }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    Aucune pieces necessaires
                                                @endif
                                            </td>
                                            <td >
                                                <div class="row">
                                                    <div class="col-sm-4 text-left">
                                                          <button class="btn btn-xs btn-info mr-2" id="voir-maintenance" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-voir-maintenance" data-show-url="{{ route('maintenance.voir', ['maintenance' => $maintenance->id]) }}"><i class="fa fa-eye"></i></button>

                                                    </div>
                                                    <div class="col-sm-4 text-center">
                                                        <button class="btn btn-xs btn-primary mr-2" id="modifier-maintenance" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-modifier-maintenance" data-update-url="{{ route('maintenance.post.modifier', ['maintenance' => $maintenance->id]) }}" data-show-url="{{ route('maintenance.modifier', ['maintenance' => $maintenance->id]) }}"><i class="fa fa-edit"></i></button>

                                                    </div>
                                                    <div class="col-sm-4 text-right">
                                                        <button class="btn btn-xs btn-danger" id="supprimer-maintenance" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-supprimer-maintenance" data-update-url="{{ route('maintenance.post.supprimer', ['maintenance' => $maintenance->id]) }}" data-show-url="{{ route('maintenance.modifier', ['maintenance' => $maintenance->id]) }}"><i class="fa fa-trash"></i></button>

                                                    </div>
                                                </div>

                                            </td>
                                        </tr>
                                    @empty

                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Type</th>
                                        <th>Titre</th>
                                        <th>Date & heure</th>
                                        <th>Montant total (Ar)</th>
                                        <th>Camion</th>
                                        <th>Agent</th>
                                        <th>Commentaire</th>
                                        <th>Pièces</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>


{{-- Modal pour ajouter une dépense --}}

<div class="modal fade" id="modal-ajouter-maintenance">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Enregistrer une mainténance / reparation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-ajouter-maintenance">

                <form action="{{ route('maintenance.post.nouvelle') }}" method="post" role="form" id="form-ajouter-maintenance">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-primary font-weight-bold">Information de la maintenance</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="type" class="form-label">Type de dépense</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select onchange="resetStyle(this)" name="type" id="type" class="form-control">
                                        <option value="">Selectionner le type</option>
                                        @foreach (typeMaintenance() as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="titre">Intitulé / Titre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" name="titre" class="form-control" id="titre" placeholder="Titre ou intitulé" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="date_heure">Date et heure</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group date_heure" id="date_heure" data-target-input="nearest">
                                        <input onchange="resetStyle(this)" type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure" name="date_heure">
                                        <div class="input-group-append" data-target="#date_heure" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="camion">Camion</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select onchange="resetStyle(this)" name="camion_id" id="camion" class="form-control">
                                        <option value="">Selectionner un camion</option>
                                        @foreach ($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="main_oeuvre">Main d'&oelig;uvre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="number" name="main_oeuvre" class="form-control" id="main_oeuvre" placeholder="Montant de la main d'oeuvre" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex d-flex justify-content-between align-items-center">
                                    <label for="commentaire">Commentaire</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea onchange="resetStyle(this)" name="commentaire" class="form-control" id="commentaire" cols="30" rows="2" placeholder="Commentaire"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-primary font-weight-bold">Information de l'agent</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="nom_reparateur" class="form-label">Nom de l'agent</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="nom_reparateur" id="nom_reparateur" placeholder="Nom et prénoms de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="tel_reparateur" class="form-label">Téléphone</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="tel_reparateur" id="tel_reparateur" placeholder="Téléphone de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="adresse_reparateur" class="form-label">Adresse</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="adresse_reparateur" id="adresse_reparateur" placeholder="Adresse de l'agent">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-4">
                            <h5 class="text-uppercase mb-4 text-center text-primary font-weight-bold">Détails des matérielles</h5>

                            <table class="table" style="width:100%">
                                <thead>
                                    <th>Nom du matériel</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Montant total</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="result">
                                    <tr>
                                        <td><input class="form-control" value="" type="text" id="nom" placeholder="Nom de la pièce"></td>
                                        <td><input class="form-control" value="" type="number" id="pu" placeholder="Prix unitaire"></td>
                                        <td><input class="form-control" value="" type="number" id="quantite" placeholder="Quantité "></td>
                                        <td><input class="form-control" value="" readonly type="number" id="total" placeholder="Montant total"></td>
                                        <td>
                                            <button id="addMateriel" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <input type="hidden" name="pieces" id="pieces" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
                <button type="submit" id="button-ajouter-maintenance" form="form-ajouter-maintenance" class="float-right btn btn-primary"><i class="fa fa-save mr-2"></i>Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Modal pour modifier une dépense --}}

<div class="modal fade" id="modal-modifier-maintenance">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier une mainténance / reparation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-modifier-maintenance">

                <form action="{{ route('maintenance.post.nouvelle') }}" method="post" role="form" id="form-modifier-maintenance">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-primary font-weight-bold">Information de la maintenance</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="type" class="form-label">Type de dépense</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select onchange="resetStyle(this)" name="type" id="type" class="form-control">
                                        <option value="">Selectionner le type</option>
                                        @foreach (typeMaintenance() as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="titre">Intitulé / Titre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" name="titre" class="form-control" id="titre" placeholder="Titre ou intitulé" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="date_heure_edit">Date et heure</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group date_heure_edit" id="date_heure_edit" data-target-input="nearest">
                                        <input onchange="resetStyle(this)" type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure_edit" name="date_heure">
                                        <div class="input-group-append" data-target="#date_heure_edit" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="camion">Camion</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select onchange="resetStyle(this)" name="camion_id" id="camion" class="form-control">
                                        <option value="">Selectionner un camion</option>
                                        @foreach ($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="main_oeuvre">Main d'&oelig;uvre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="number" name="main_oeuvre" class="form-control" id="main_oeuvre" placeholder="Montant de la main d'oeuvre" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex d-flex justify-content-between align-items-center">
                                    <label for="commentaire">Commentaire</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea onchange="resetStyle(this)" name="commentaire" class="form-control" id="commentaire" cols="30" rows="2" placeholder="Commentaire"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-primary font-weight-bold">Information de l'agent</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="nom_reparateur" class="form-label">Nom de l'agent</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="nom_reparateur" id="nom_reparateur" placeholder="Nom et prénoms de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="tel_reparateur" class="form-label">Téléphone</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="tel_reparateur" id="tel_reparateur" placeholder="Téléphone de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="adresse_reparateur" class="form-label">Adresse</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input onchange="resetStyle(this)" type="text" class="form-control" name="adresse_reparateur" id="adresse_reparateur" placeholder="Adresse de l'agent">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-4">
                            <h5 class="text-uppercase mb-4 text-center text-primary font-weight-bold">Détails des matérielles</h5>

                            <table class="table" style="width:100%">
                                <thead>
                                    <th>Nom du matériel</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Montant total</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="result-edit">
                                    <tr id="inputs">
                                        <td><input class="form-control" value="" type="text" id="nom-edit" placeholder="Nom de la pièce"></td>
                                        <td><input class="form-control" value="" type="number" id="pu-edit" placeholder="Prix unitaire"></td>
                                        <td><input class="form-control" value="" type="number" id="quantite-edit" placeholder="Quantité "></td>
                                        <td><input class="form-control" value="" readonly type="number" id="total-edit" placeholder="Montant total"></td>
                                        <td>
                                            <button id="addMaterielEdit" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <input type="hidden" name="pieces" id="pieces-edit" value="">
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
                <button type="submit" id="button-modifier-maintenance" form="form-modifier-maintenance" class="float-right btn btn-primary"><i class="fa fa-save mr-2"></i>Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Supprimer un maintenance --}}

<div class="modal fade" id="modal-supprimer-maintenance">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer une maintenance / reparation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-supprimer-maintenance">

                <form action="#" method="post" role="form" id="form-supprimer-maintenance">

                    @csrf

                    <div class="row">

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-danger font-weight-bold">Information de la maintenance</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="type" class="form-label">Type de dépense</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select disabled onchange="resetStyle(this)" name="type" id="type" class="form-control">
                                        <option value="">Selectionner le type</option>
                                        @foreach (typeMaintenance() as $type)
                                            <option value="{{ $type }}">{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="titre">Intitulé / Titre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled onchange="resetStyle(this)" type="text" name="titre" class="form-control" id="titre" placeholder="Titre ou intitulé" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="date_heure_edit">Date et heure</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group date_heure_edit" id="date_heure_edit" data-target-input="nearest">
                                        <input disabled onchange="resetStyle(this)" type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure_edit" name="date_heure" required="">
                                        <div class="input-group-append" data-target="#date_heure_edit" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="camion">Camion</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select disabled onchange="resetStyle(this)" name="camion_id" id="camion" class="form-control">
                                        <option value="">Selectionner un camion</option>
                                        @foreach ($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="main_oeuvre">Main d'&oelig;uvre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled onchange="resetStyle(this)" type="number" name="main_oeuvre" class="form-control" id="main_oeuvre" placeholder="Montant de la main d'oeuvre" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex d-flex justify-content-between align-items-center">
                                    <label for="commentaire">Commentaire</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea disabled onchange="resetStyle(this)" name="commentaire" class="form-control" id="commentaire" cols="30" rows="2" placeholder="Commentaire"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-danger font-weight-bold">Information de l'agent</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="nom_reparateur" class="form-label">Nom de l'agent</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="nom_reparateur" id="nom_reparateur" placeholder="Nom et prénoms de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="tel_reparateur" class="form-label">Téléphone</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="tel_reparateur" id="tel_reparateur" placeholder="Téléphone de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="adresse_reparateur" class="form-label">Adresse</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="adresse_reparateur" id="adresse_reparateur" placeholder="Adresse de l'agent">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-4">
                            <h5 class="text-uppercase mb-4 text-center text-danger font-weight-bold">Détails des matérielles</h5>

                            <table class="table" style="width:100%">
                                <thead>
                                    <th>Nom du matériel</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Montant total</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="result-delete">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
                <button type="submit" id="button-supprimer-maintenance" form="form-supprimer-maintenance" class="float-right btn btn-danger"><i class="fa fa-trash mr-2"></i>Supprimer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Voir une maintenance --}}

<div class="modal fade" id="modal-voir-maintenance">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Details maintenance / reparation</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-voir-maintenance">
                    <div class="row">
                        <div class="col-md-6 p-3">
                            <h5 class="text-uppercase mb-4 text-info font-weight-bold">Information de la maintenance</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="type" class="form-label">Type de dépense</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="type" disabled>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="titre">Intitulé / Titre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" name="titre" class="form-control" id="titre" placeholder="Titre ou intitulé" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="date_heure_edit">Date et heure</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group date_heure_edit" id="date_heure_edit" data-target-input="nearest">
                                        <input disabled onchange="resetStyle(this)" type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure_edit" name="date_heure" required="">
                                        <div class="input-group-append" data-target="#date_heure_edit" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="camion">Camion</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <select disabled onchange="resetStyle(this)" name="camion_id" id="camion" class="form-control">
                                        <option value="">Selectionner un camion</option>
                                        @foreach ($camions as $camion)
                                            <option value="{{ $camion->id }}">{{ $camion->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="main_oeuvre">Main d'&oelig;uvre</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="number" name="main_oeuvre" class="form-control" id="main_oeuvre" placeholder="Montant de la main d'oeuvre" />
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex d-flex justify-content-between align-items-center">
                                    <label for="commentaire">Commentaire</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <textarea disabled name="commentaire" class="form-control" id="commentaire" cols="30" rows="2" placeholder="Commentaire"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 p-3">

                            <h5 class="text-uppercase mb-4 text-info font-weight-bold">Information de l'agent</h5>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="nom_reparateur" class="form-label">Nom de l'agent</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="nom_reparateur" id="nom_reparateur" placeholder="Nom et prénoms de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="tel_reparateur" class="form-label">Téléphone</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="tel_reparateur" id="tel_reparateur" placeholder="Téléphone de l'agent">
                                </div>
                            </div>

                            <div class="row mt-1 mb-3">
                                <div class="col-sm-4 d-flex justify-content-between align-items-center">
                                    <label for="adresse_reparateur" class="form-label">Adresse</label>
                                    <label for="">:</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" class="form-control" name="adresse_reparateur" id="adresse_reparateur" placeholder="Adresse de l'agent">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-4 mb-4">
                            <h5 class="text-uppercase mb-4 text-center text-info font-weight-bold">Détails des matérielles</h5>

                            <table class="table" style="width:100%">
                                <thead>
                                    <th>Nom de la matérielle</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    <th>Montant total</th>
                                    <th>Action</th>
                                </thead>
                                <tbody id="result-voir">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="error">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h6 class="modal-title">Une erreur s'est produite</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="message">Vous devez remplir le nom</p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-danger"><i class="fa fa-plus mr-2" style="transform: rotate(45deg)"></i>Ok</button>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

<script src="{{asset('assets/adminlte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<!-- InputMask -->
<script src="{{asset('assets/adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('assets/adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>

<script src="{{ asset('js/gerer-materiels.js') }}"></script>
<script src="{{ asset('js/modifier-maintenance.js') }}"></script>

<script>

$("#maintenances").DataTable({
        "responsive": true,
        "autoWidth": false,
        "searching": true,
        "paging": false,
        "ordering": true,
        "info": false ,
        language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
    });

const resetStyle = (input) => {
    if ($(input).hasClass('border-danger')) $(input).removeClass('border-danger');
    let next = input.nextElementSibling
    if (next !== undefined && next.tagName === "DIV") $(next.parentElement.nextElementSibling).remove()
    else $(input).next().remove()
}

$(document).on("submit", "#form-ajouter-maintenance", function (e) {
    e.preventDefault()

    $("#pieces").val(JSON.stringify(pieces));

    $.post($(e.target).attr("action"), $(e.target).serialize(), dataType="JSON").done(function (response) {
        window.location.href = response.redirect
    }).fail(function (response) {
        let errors = response.responseJSON.errors

        Object.entries(errors).forEach((error, key) => {
            let name = document.getElementsByName(error[0])[0]
            $(name).addClass(['border-danger']);
            let next = $(name).next()[0]

            if (next !== undefined && next.tagName === "DIV") {
                $(next.parentElement.nextElementSibling).remove()
                $(next.parentElement).after('<span class="text-danger">' + error[1][0] + '</span>')
            } else {
                $(name).next().remove()
                $(name).after('<span class="text-danger">' + error[1][0] + '</span>')
            }
        })
    })
})


$(document).on("submit", "#form-modifier-maintenance", function (e) {
    e.preventDefault()

    $("#pieces-edit").val(JSON.stringify(pieces));

    $.post($(e.target).attr("action"), $(e.target).serialize(), dataType="JSON").done(function (response) {
        window.location.href = response.redirect
    }).fail(function (response) {
        let errors = response.responseJSON.errors

        Object.entries(errors).forEach((error, key) => {
            let name = document.getElementsByName(error[0])[1]
            $(name).addClass(['border-danger']);
            let next = $(name).next()[0]

            if (next !== undefined && next.tagName === "DIV") {
                $(next.parentElement.nextElementSibling).remove()
                $(next.parentElement).after('<span class="text-danger">' + error[1][0] + '</span>')
            } else {
                $(name).next().remove()
                $(name).after('<span class="text-danger">' + error[1][0] + '</span>')
            }
        })
    })
})

$(document).on("click", "#ajouter-maintenance", function (e) {
    resetForm("#form-ajouter-maintenance")
})

$(document).on("click", "#supprimer-maintenance", function (e) {
    url = $(this).attr("data-show-url");
    url_update = $(this).attr("data-update-url");

    document.getElementById('form-supprimer-maintenance').getElementsByTagName('tbody')[0].innerHTML = null
    resetForm("#form-supprimer-maintenance")

    //$("#modal-supprimer-maintenance").modal("show");
    $("#form-supprimer-maintenance").attr("action", url_update);

    $.ajax(url, {}, dataType ="HTML").done(function (maintenance) {
        let date = formatAMPM(new Date(maintenance.date_heure)).toUpperCase()

        $("#modal-supprimer-maintenance #type").val(maintenance.type);
        $("#modal-supprimer-maintenance #titre").val(maintenance.titre);
        $("#modal-supprimer-maintenance #main_oeuvre").val(maintenance.main_oeuvre);
        $("#modal-supprimer-maintenance #date_heure_edit input").val(date);
        $("#modal-supprimer-maintenance #camion").val(maintenance.camion_id);
        $("#modal-supprimer-maintenance #montant").val(maintenance.montant);
        $("#modal-supprimer-maintenance #commentaire").val(maintenance.commentaire);

        $("#modal-supprimer-maintenance #nom_reparateur").val(maintenance.nom_reparateur);
        $("#modal-supprimer-maintenance #tel_reparateur").val(maintenance.tel_reparateur);
        $("#modal-supprimer-maintenance #adresse_reparateur").val(maintenance.adresse_reparateur);

        pieces = populatePieceList(maintenance.pieces, '#result-delete', false)
    })
})

$(document).on("click", "#voir-maintenance", function (e) {
    url = $(this).attr("data-show-url");

    document.getElementById('modal-voir-maintenance').getElementsByTagName('tbody')[0].innerHTML = null

    //$("#modal-supprimer-maintenance").modal("show");

    $.ajax(url, {}, dataType ="HTML").done(function (maintenance) {
        let date = formatAMPM(new Date(maintenance.date_heure)).toUpperCase()

        $("#modal-voir-maintenance #type").val(maintenance.type);
        $("#modal-voir-maintenance #titre").val(maintenance.titre);
        $("#modal-voir-maintenance #main_oeuvre").val(maintenance.main_oeuvre);
        $("#modal-voir-maintenance #date_heure_edit input").val(date);
        $("#modal-voir-maintenance #camion").val(maintenance.camion_id);
        $("#modal-voir-maintenance #montant").val(maintenance.montant);
        $("#modal-voir-maintenance #commentaire").val(maintenance.commentaire);

        $("#modal-voir-maintenance #nom_reparateur").val(maintenance.nom_reparateur);
        $("#modal-voir-maintenance #tel_reparateur").val(maintenance.tel_reparateur);
        $("#modal-voir-maintenance #adresse_reparateur").val(maintenance.adresse_reparateur);

        pieces = populatePieceList(maintenance.pieces, '#result-voir', false)

    })
})

$(document).on("click", "#modifier-maintenance", function (e) {
    url = $(this).attr("data-show-url");
    url_update = $(this).attr("data-update-url");

    let inputs = document.getElementById('inputs')
    document.getElementById('form-modifier-maintenance').getElementsByTagName('tbody')[0].innerHTML = null
    document.getElementById('form-modifier-maintenance').getElementsByTagName('tbody')[0].appendChild(inputs)
    resetForm("#form-modifier-maintenance")

    //$("#modal-modifier-maintenance").modal("show");
    $("#form-modifier-maintenance").attr("action", url_update);

    $.ajax(url, {}, dataType ="HTML").done(function (maintenance) {
        let date = formatAMPM(new Date(maintenance.date_heure)).toUpperCase()

        $("#modal-modifier-maintenance #type").val(maintenance.type);
        $("#modal-modifier-maintenance #titre").val(maintenance.titre);
        $("#modal-modifier-maintenance #main_oeuvre").val(maintenance.main_oeuvre);
        $("#modal-modifier-maintenance #date_heure_edit input").val(date);
        $("#modal-modifier-maintenance #camion").val(maintenance.camion_id);
        $("#modal-modifier-maintenance #montant").val(maintenance.montant);
        $("#modal-modifier-maintenance #commentaire").val(maintenance.commentaire);

        $("#modal-modifier-maintenance #nom_reparateur").val(maintenance.nom_reparateur);
        $("#modal-modifier-maintenance #tel_reparateur").val(maintenance.tel_reparateur);
        $("#modal-modifier-maintenance #adresse_reparateur").val(maintenance.adresse_reparateur);

        pieces = populatePieceList(maintenance.pieces, '#result-edit')
    })
})



function resetForm (formId) {
    let class_name = 'border-danger'
    let form = document.querySelector(formId)
    let elements = form.getElementsByClassName(class_name)

    for (let i = 0; i < elements.length; i++) {
        $(elements[i]).next().remove()
    }

    pieces = new Object()
    form.reset()
    $(elements).removeClass(class_name);
}

function formatAMPM(date)
{
    let year = date.getFullYear()
    let month = date.getMonth() + 1
    let day = date.getDate()
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime =  month.toString().padStart(2, 0) + '/' + day.toString().padStart(2, 0) + '/' + year + ' ' + hours + ':' + minutes + ' ' + ampm;
    return strTime;
}


function editPiece (button) {
    window.event.preventDefault()
    let tr = button.parentElement.parentElement
    let LIB = tr.firstElementChild
    let PU = LIB.nextElementSibling
    let Q = PU.nextElementSibling
    let TOTAL = Q.nextElementSibling

    PU.innerHTML = "<input type='number' class='form-control' value='" + PU.innerHTML.replace('Ar', '').trim().replace(",", "").replace(" ", "") + "'/>"
    Q.innerHTML = "<input type='number' class='form-control' value='" + Q.innerHTML.replace('Ar', '').trim().replace(",", "").replace(" ", "") + "'/>"

    button.innerHTML = "<i class='fa fa-save'></i>"
    button.setAttribute("onclick", "savePiece(this)")

    editing = LIB.innerHTML
}

function savePiece (button) {
    window.event.preventDefault()
    let tr = button.parentElement.parentElement
    let LIB = tr.firstElementChild
    let PU = LIB.nextElementSibling
    let Q = PU.nextElementSibling
    let TOTAL = Q.nextElementSibling

    if (isNaN(parseFloat(PU.firstElementChild.value)) || parseFloat(PU.firstElementChild.value) < 0) { $('#error p').html("Prix unitaire vide ou invalide"); $('#error').modal('show'); return; }
    if (isNaN(parseInt(Q.firstElementChild.value)) || parseInt(Q.firstElementChild.value) < 0) { $('#error p').html("Quantité vide ou invalide"); $('#error').modal('show'); return; }

    pieces[LIB.innerHTML] = {
        nom: LIB.innerHTML,
        pu: PU.firstElementChild.value,
        quantite: Q.firstElementChild.value,
        total: PU.firstElementChild.value * Q.firstElementChild.value,
    }

    TOTAL.innerHTML = (PU.firstElementChild.value * Q.firstElementChild.value).toString() + " Ar"
    PU.innerHTML = PU.firstElementChild.value.toString() + " Ar"
    Q.innerHTML = Q.firstElementChild.value.toString()

    button.innerHTML = "<i class='fa fa-edit'></i>"
    button.setAttribute("onclick", "editPiece(this)")

    editing = false
}

</script>

@endsection
