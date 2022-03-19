@extends('main')

@section('title') <title>Listes des dépenses</title> @endsection

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

                {{-- @foreach ($depensesGroups as $type => $depenseGrpup)
                    <div class="col-md-6">
                        <div class="card style-{{ $i }}">
                            <div class="card-body">
                                <h4 class="mb-3 font-weight-bold text-white">{{ formatMoney($depenseGrpup->sum('montant')) }}</h4>
                                <h6>{{ numberToLetter($depenseGrpup->sum('montant')) }}</h6>
                            </div>
                            <div class="card-footer">
                                <h5>{{ $type }}</h5>
                            </div>
                        </div>
                    </div>

                    @php
                        $i++
                    @endphp

                @endforeach --}}

                @foreach (typeDepense() as $type)
                    <div class="col-md-6">
                        <div class="card style-{{ $i }}">
                            <div class="card-body">
                                <h4 class="mb-3 font-weight-bold text-white">{{ $depensesGroups->has($type) === true ? formatMoney($depensesGroups[$type]->sum('montant')) : formatMoney(0) }}</h4>
                                <h6>{{ $depensesGroups->has($type) === true ? numberToLetter($depensesGroups[$type]->sum('montant')) : numberToLetter(0) }}</h6>
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
                            <h4 class="mb-3 font-weight-bold text-white">{{ formatMoney(totalDepense()) }}</h4>
                            <h6>{{ numberToLetter(totalDepense()) }}</h6>
                        </div>
                        <div class="card-footer" >
                            <h3 class="card-title">Total des dépenses</h3>
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
                            <h3 class="card-title">Historique des dépenses</h3>
                            <button class="btn btn-primary float-right" data-backdrop="static" data-keyboard="false" data-toggle="modal" id="ajouter-depense" data-target="#modal-ajouter-depense"><span class="fa fa-plus mr-2"></span>Ajouter</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="depenses" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Date & heure</th>
                                        <th>Montant (Ar)</th>
                                        <th>Camion</th>
                                        <th>Chauffeur</th>
                                        <th>Commentaire</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($depenses as $depense)
                                        <tr>
                                            <td>{{ $depense->type }}</td>
                                            <td>{{ formatDate($depense->date_heure) }}</td>
                                            <td>{{ formatMoney($depense->montant) }}</td>
                                            <td>{{ $depense->infosCamion() }}</td>
                                            <td>{{ $depense->infosChauffeur() }}</td>
                                            <td>{{ $depense->commentaire }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-xs-6">
                                                        <button class="btn btn-sm btn-primary mr-2" id="modifier-depense" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-modifier-depense" data-update-url="{{ route('depense.post.modifier', ['depense' => $depense->id]) }}" data-show-url="{{ route('depense.modifier', ['depense' => $depense->id]) }}"><i class="fa fa-edit"></i></button>

                                                    </div>
                                                    <div class="col-xs-6 ">
                                                        <button class="btn btn-sm btn-danger" id="supprimer-depense" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-supprimer-depense" data-update-url="{{ route('depense.post.supprimer', ['depense' => $depense->id]) }}" data-show-url="{{ route('depense.modifier', ['depense' => $depense->id]) }}"><i class="fa fa-trash"></i></button>

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
                                        <th>Date & heure</th>
                                        <th>Montant (Ar)</th>
                                        <th>Camion</th>
                                        <th>Chauffeur</th>
                                        <th>Commentaire</th>
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

<div class="modal fade" id="modal-ajouter-depense">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Enregistrer une dépense</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-ajouter-depense">

                <form action="{{ route('depense.post.nouvelle') }}" method="post" role="form" id="form-ajouter-depense">

                    @csrf

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="type" class="form-label">Type de dépense :</label>
                        </div>
                        <div class="col-sm-8">
                            <select onchange="resetStyle(this)" name="type" id="type" class="form-control">
                                <option value="">Selectionner le type</option>
                                @foreach (typeDepense() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="date_heure">Date et heure :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date_heure" id="date_heure" data-target-input="nearest">
                                <input onchange="resetStyle(this)" type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure" name="date_heure" required="">
                                <div class="input-group-append" data-target="#date_heure" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="camion">Camion :</label>
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
                        <div class="col-sm-4">
                            <label for="chauffeur">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <select onchange="resetStyle(this)" name="chauffeur_id" id="chauffeur" class="form-control">
                                <option value="">Selectionner un chauffeur</option>
                                @foreach ($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="montant">Montant :</label>
                        </div>
                        <div class="col-sm-8">
                            <input onchange="resetStyle(this)" type="number" name="montant" class="form-control" id="montant" placeholder="Montant de la dépense" />
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="commentaire">Commentaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea onchange="resetStyle(this)" name="commentaire" class="form-control" id="commentaire" cols="30" rows="5" placeholder="Commentaire"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
                <button type="submit" id="button-ajouter-depense" form="form-ajouter-depense" class="float-right btn btn-primary"><span class="fa fa-save mr-2"></span></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Modal pour modifier une dépense --}}

<div class="modal fade" id="modal-modifier-depense">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier une dépense</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-modifier-depense">

                <form action="#" method="post" role="form" id="form-modifier-depense">

                    @csrf

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="type" class="form-label">Type de dépense :</label>
                        </div>
                        <div class="col-sm-8">
                            <select onchange="resetStyle(this)" name="type" id="type" class="form-control">
                                <option value="">Selectionner le type</option>
                                @foreach (typeDepense() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="date_heure_edit">Date et heure :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date_heure_edit" id="date_heure_edit" data-target-input="nearest">
                                <input type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure_edit" name="date_heure">
                                <div class="input-group-append" data-target="#date_heure_edit" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="camion">Camion :</label>
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
                        <div class="col-sm-4">
                            <label for="chauffeur">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <select onchange="resetStyle(this)" name="chauffeur_id" id="chauffeur" class="form-control">
                                <option value="">Selectionner un chauffeur</option>
                                @foreach ($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="montant">Montant :</label>
                        </div>
                        <div class="col-sm-8">
                            <input onchange="resetStyle(this)" type="number" name="montant" class="form-control" id="montant" placeholder="Montant de la dépense" />
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="commentaire">Commentaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea onchange="resetStyle(this)" name="commentaire" class="form-control" id="commentaire" cols="30" rows="5" placeholder="Commentaire"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Fermer</button>
                <button type="submit" id="button-modifier-depense" form="form-modifier-depense" class="float-right btn btn-primary"><span class="fa fa-save mr-2"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Enregistrer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

{{-- Supprimer un depense --}}
<div class="modal fade" id="modal-supprimer-depense">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer une dépense</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body" id="modal-supprimer-depense">

                <form action="#" method="post" role="form" id="form-supprimer-depense">

                    @csrf

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="type" class="form-label">Type de dépense :</label>
                        </div>
                        <div class="col-sm-8">
                            <span class="form-control" for="" id="type"></span>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="date_heure">Date et heure :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date_heure_delete" id="date_heure_delete" data-target-input="nearest">
                                <input type="text" placeholder="Date & heure du dépense" class="form-control datetimepicker-input" data-target="#date_heure_delete" name="date_heure">
                                <div class="input-group-append" data-target="#date_heure_delete" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="camion">Camion :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="camion_id" id="camion" class="form-control bg-white">
                                <option value="">Selectionner un camion</option>
                                @foreach ($camions as $camion)
                                    <option value="{{ $camion->id }}">{{ $camion->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="chauffeur">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="chauffeur_id" id="chauffeur" class="form-control bg-white">
                                <option value="">Selectionner un chauffeur</option>
                                @foreach ($chauffeurs as $chauffeur)
                                    <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="montant">Montant :</label>
                        </div>
                        <div class="col-sm-8">
                            <span for="" id="montant" class="form-control"></span>
                        </div>
                    </div>

                    <div class="row mt-1 mb-3">
                        <div class="col-sm-4">
                            <label for="commentaire">Commentaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea disabled name="commentaire" class="form-control bg-white" id="commentaire" cols="30" rows="5" placeholder="Commentaire"></textarea>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i style="transform: rotate(45deg)" class="fa fa-plus mr-2"></i>Annuler</button>
                <button type="submit" id="button-supprimer-depense" form="form-supprimer-depense" class="float-right btn btn-danger"><i class="fa fa-trash mr-2"></i>Supprimer</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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

<script>

$("#depenses").DataTable({
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
    $(input).next().remove();
}

$(document).on("submit", "#form-ajouter-depense", function (e) {
    e.preventDefault()
    let button = $("#button-ajouter-depense");
    spinning(button);

    $.post($(e.target).attr("action"), $(e.target).serialize(), dataType="JSON").done(function (response) {
        spinning(button, 2);
        window.location.href = response.redirect
    }).fail(function (response) {
        spinning(button, 2);
        let errors = response.responseJSON.errors

        Object.entries(errors).forEach((error, key) => {
            let name = document.getElementsByName(error[0])[0]
            $(name).addClass(['border-danger', 'has-validation']);
            $(name).next().remove()
            $(name).after('<span class="text-danger">' + error[1][0] + '</span>')
        })
    })
})

$(document).on("submit", "#form-modifier-depense", function (e) {
    e.preventDefault()
    let button = $("#button-modifier-depense");
    spinning(button);

    $.post($(e.target).attr("action"), $(e.target).serialize(), dataType="JSON").done(function (response) {
        spinning(button, 2);
        window.location.href = response.redirect
    }).fail(function (response) {
        spinning(button, 2);
        let errors = response.responseJSON.errors

        Object.entries(errors).forEach((error, key) => {
            let name = document.getElementsByName(error[0])[1]
            $(name).addClass('border-danger');
            $(name).after('<span class="text-danger">' + error[1][0] + '</span>')
        })
    })
})

$(document).on("click", "#ajouter-depense", function (e) {
    resetForm("#form-ajouter-depense")
})

$(document).on("click", "#supprimer-depense", function (e) {
    url = $(this).attr("data-show-url");
    url_delete = $(this).attr("data-update-url");

    resetForm("#form-supprimer-depense")

    //$("#modal-modifier-depense").modal("show");
    $("#form-supprimer-depense").attr("action", url_delete);

    $.ajax(url, {}, dataType ="JSON").done(function (depense) {
        let date = formatAMPM(new Date(depense.date_heure)).toUpperCase()

        $("#modal-supprimer-depense #type").html(depense.type);
        $("#modal-supprimer-depense #date_heure_delete input").val(date);
        $("#modal-supprimer-depense #camion").val(depense.camion_id);
        $("#modal-supprimer-depense #chauffeur").val(depense.chauffeur_id);
        $("#modal-supprimer-depense #montant").html(depense.montant);
        $("#modal-supprimer-depense #commentaire").val(depense.commentaire);
    })
})

$(document).on("click", "#modifier-depense", function (e) {
    url = $(this).attr("data-show-url");
    url_update = $(this).attr("data-update-url");

    resetForm("#form-modifier-depense")

    //$("#modal-modifier-depense").modal("show");
    $("#form-modifier-depense").attr("action", url_update);

    $.ajax(url, {}, dataType ="HTML").done(function (depense) {
        let date = formatAMPM(new Date(depense.date_heure)).toUpperCase()

        $("#modal-modifier-depense #type").val(depense.type);
        $("#modal-modifier-depense #date_heure_edit input").val(date);
        $("#modal-modifier-depense #camion").val(depense.camion_id);
        $("#modal-modifier-depense #chauffeur").val(depense.chauffeur_id);
        $("#modal-modifier-depense #montant").val(depense.montant);
        $("#modal-modifier-depense #commentaire").val(depense.commentaire);
    })
})

function resetForm (formId) {
    let class_name = 'border-danger'
    let form = document.querySelector(formId)
    let elements = form.getElementsByClassName(class_name)

    for (let i = 0; i < elements.length; i++) {
        $(elements[i]).next().remove()
    }

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

</script>

@endsection
