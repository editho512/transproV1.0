@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Chauffeurs</title>
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
                        <h1>Chauffeurs</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">

                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" >
                                <h3 class="card-title">Liste des chauffeur</h3>
                                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-chauffeur" data-target="#modal-ajouter-chauffeur"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="chauffeurs" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>CIN</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($chauffeurs as $chauffeur)
                                            <tr style='{{$chauffeur->blocked == true ? "color:gray;" : ""}}'>
                                                <td>{{ ucwords($chauffeur->name) }} @if ($chauffeur->disponible() === false) - <span class="badge badge-info">En cours de travail</span> @endif</td>
                                                <td>{{$chauffeur->phone}}</td>
                                                <td>
                                                    {{$chauffeur->cin}}
                                                    @if ($chauffeur->nombreTrajetEnAttente() > 0)
                                                        <div class="badge badge-info">({{ $chauffeur->nombreTrajetEnAttente() }} - Trajet(s) en attente)</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="row" style="text-align: center;">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-xs btn-info"><span class="fa fa-eye"></span></button>
                                                            @can('update', $chauffeur)
                                                                <button class="btn btn-xs btn-primary modifier-chauffeur" data-show-url="{{route('chauffeur.modifier', ['chauffeur' => $chauffeur->id])}}"  data-url="{{route('chauffeur.update', ['chauffeur' => $chauffeur->id])}}" ><span class="fa fa-edit"></span></button>
                                                            @endcan

                                                            @can('delete', $chauffeur)
                                                                <button class="btn btn-xs btn-danger supprimer-chauffeur" data-url="{{route('chauffeur.delete', ['chauffeur' => $chauffeur->id])}}"><span class="fa fa-trash"></span></button>
                                                            @endcan
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="text-align: center" colspan="6">
                                                    Aucun chauffeur dans la liste
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Nom</th>
                                        <th>Téléphone</th>
                                        <th>CIN</th>
                                        <th>Actions</th>

                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!---- modal pour ajouter chauffeur --->
    <div class="modal fade" id="modal-ajouter-chauffeur">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <h4 class="modal-title">Ajouter un chauffeur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-ajouter-chauffeur">
                    <form action="{{route('chauffeur.ajouter')}}" method="post" role="form" id="form-ajouter-chauffeur" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="phone">Téléphone :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="phone" placeholder="Téléphone" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="cin">CIN :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="cin" placeholder="CIN" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <label for="permis">Permis</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                    </div>
                                    <div class="custom-file">
                                      <input type="file" name="permis" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                      <label class="custom-file-label" for="inputGroupFile01">Permis</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="button-ajouter-chauffeur" form="form-ajouter-chauffeur" class="float-right btn btn-success">Ajouter</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour ajouter chauffeur-->

    <!---- modal pour modification chauffeur --->
    <div class="modal fade" id="modal-modifier-chauffeur">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 class="modal-title">Modifier un chauffeur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-modifier-camion">
                    <form action="#" method="post" id="form-modifier-chauffeur" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="modifier_name" class="form-control" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="phone">Téléphone :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="phone" id="modifier_phone"placeholder="Téléphone" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="cin">CIN :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="cin" id="modifier_cin" placeholder="CIN" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <label for="permis">Permis</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text" id="inputGroupFileAddon01">Choisir</span>
                                    </div>
                                    <div class="custom-file">
                                      <input type="file" name="permis" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                      <label class="custom-file-label" for="inputGroupFile01">Permis</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" form="form-modifier-chauffeur" id="button-modifier-chauffeur" class="float-right btn btn-primary">Modifier</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour modification chauffeur-->
    <!---- modal pour suppression d'un chauffeur --->
    <div class="modal fade" id="modal-supprimer-chauffeur">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h4 class="modal-title">Supprimer un chauffeur</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-supprimer-chauffeur">
                    <form action="#" method="POST" id="form-supprimer-chauffeur">
                        @csrf
                        @method('delete')
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Nom :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="supprimer_name" class="form-control" placeholder="Nom" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="phone">Téléphone :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="phone" id="supprimer_phone"placeholder="Téléphone" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="cin">CIN :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="cin" id="supprimer_cin" placeholder="CIN" class="form-control" required>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer row">
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        </div>
                        <div class="col-sm-8" style="text-align: right;">
                            <a href="" style="text-align: right !important;">
                                <button type="button"  class=" btn btn-warning">Bloquer</button>
                            </a>
                            <a href="" style="text-align: right !important;" id="btn-supprimer-chauffeur">
                                <button type="button"  class=" btn btn-danger">Supprimer</button>
                            </a>
                        </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal pour suppression d'utilisateur -->

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

    <!-- page script -->
    <script>

    $("#chauffeurs").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                });

    $(document).on("click", ".modifier-chauffeur", function (e) {
        $("#modal-modifier-chauffeur").modal("show");
        let url = $(this).attr("data-show-url");
        let url_update= $(this).attr("data-url");
        $("#form-modifier-chauffeur").attr("action", url_update);
        $.get(url, {}, dataType="JSON").done(function (data) {
            console.log(data);
            $("#modal-modifier-chauffeur #modifier_name").val(data.name);
            $("#modal-modifier-chauffeur #modifier_phone").val(data.phone);
            $("#modal-modifier-chauffeur #modifier_cin").val(data.cin);

        })
    })

    $(document).on("click", ".supprimer-chauffeur", function (e) {
        $("#modal-supprimer-chauffeur").modal("show");

        let url = $(this).prev().attr("data-show-url");
        let url_delete = $(this).attr("data-url");

        $("#btn-supprimer-chauffeur").attr("href", url_delete).prev().attr("href", url_delete+"/2");

        $.get(url, {}, dataType="JSON").done(function (data) {
            console.log(data);

            if(data.blocked == 1){
                    $("#btn-supprimer-chauffeur").prev().attr("href", url_delete+"/3").find("button").html("Debloquer");
                }

            $("#modal-supprimer-chauffeur #supprimer_name").val(data.name).attr("disabled", true);
            $("#modal-supprimer-chauffeur #supprimer_phone").val(data.phone).attr("disabled", true);
            $("#modal-supprimer-chauffeur #supprimer_cin").val(data.cin).attr("disabled", true);

        })
    })



    </script>
@endsection
