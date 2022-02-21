@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Camions</title>
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
                        <h1>Camions</h1>
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
                                <h3 class="card-title">Liste des Camions</h3>
                                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-camion" data-target="#modal-ajouter-camion"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="camions" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Numéro châssis</th>
                                        <th>Modèle</th>
                                        <th>Marque</th>
                                        <th>Année</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($camions) && $camions->count() > 0)
                                        @foreach($camions as $camion)
                                            <tr style='{{$camion->blocked == true ? "color:gray;" : ""}}' >
                                                <td>
                                                    {{ucwords($camion->name)}}
                                                    @if ($camion->aUnTrajetEncours()) -<span class="badge badge-info">A un trajet en cours</span> @endif
                                                    &nbsp; @if ($camion->nombreTrajetEnAttente() > 0)<div class="badge badge-info">({{ $camion->nombreTrajetEnAttente() }} Trajet(s) en attente)</div>@endif
                                                </td>
                                                <td>{{$camion->numero_chassis}}</td>
                                                <td>{{$camion->model}}</td>
                                                <td>{{$camion->marque}}</td>
                                                <td>{{$camion->annee}}</td>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12" style="text-align: center;">
                                                            @if ($camion->blocked == false)
                                                                <a href="{{route('camion.voir', ['camion' => $camion->id])}}">
                                                                    <button class="btn btn-sm btn-info" ><span class="fa fa-eye"></span></button>
                                                                </a>
                                                            @else
                                                                <button class="btn btn-sm btn-info" disabled><span class="fa fa-eye"></span></button>
                                                            @endif

                                                            @can('update', $camion)
                                                                <button class="btn btn-sm btn-primary modifier-camion" data-update-url="{{route('camion.update', ['camion' => $camion->id])}}" data-show-url="{{route('camion.modifier', ['camion' => $camion->id])}}" data-update-url=""><span class="fa fa-edit"></span></button>
                                                            @endcan

                                                            @can('delete', $camion)
                                                                <button class="btn btn-sm btn-danger supprimer-camion" data-url="{{route('camion.supprimer', ['camion' => $camion->id])}}" data-delete-url="{{route('camion.delete', ['camion' => $camion->id])}}"><span class="fa fa-trash"></span></button>
                                                            @endcan

                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                     <tr>
                                         <td style="text-align: center" colspan="6">
                                            Aucun camion dans la liste
                                        </td>
                                     </tr>
                                    @endif
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Numéro châssis</th>
                                        <th>Modèle</th>
                                        <th>Marque</th>
                                        <th>Année</th>
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

    <!---- modal pour ajouter camions --->
    <div class="modal fade" id="modal-ajouter-camion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-success">
                    <h4 class="modal-title">Ajouter un camion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-ajouter-camion">
                    <form action="{{route('camion.ajouter')}}" method="post" role="form" id="form-ajouter-camion" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Désignation :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" placeholder="Désignation" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="marque">Marque :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="marque" placeholder="Marque" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="model">Modèle :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="model" placeholder="Modèle" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="annee">Année :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="annee" placeholder="année" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="numero_chassis">Numéro châssis :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="numero_chassis" placeholder="Numéro châssis" class="form-control" required>
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
                                      <input type="file" name="photo" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                      <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" id="button-ajouter-camion" form="form-ajouter-camion" class="float-right btn btn-success">Ajouter</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour ajouter camions-->

    <!---- modal pour modification camion --->
    <div class="modal fade" id="modal-modifier-camion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-primary">
                    <h4 class="modal-title">Modifier un camion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-modifier-camion" >
                    <form action="#" method="post" id="form-modifier-camion" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Désignation :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Désignation" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="marque">Marque :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="marque" id="marque" placeholder="Marque" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="model">Modèle :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="model" id="model" placeholder="Modèle" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="annee">Année :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="annee" id="annee"  placeholder="année" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="numero_chassis">Numéro châssis :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="numero_chassis" id="numero_chassis" placeholder="Numéro châssis" class="form-control" required>
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
                                      <input type="file" name="photo" class="custom-file-input" id="inputGroupFile01"
                                        aria-describedby="inputGroupFileAddon01">
                                      <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    <button type="submit" form="form-modifier-camion" id="button-modifier-camion" class="float-right btn btn-primary">Modifier</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!---- / modal pour modification camion-->

    <!---- modal pour suppression d'camion --->
    <div class="modal fade" id="modal-supprimer-camion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-danger">
                    <h4 class="modal-title">Supprimer un camion</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-supprimer-camion">
                    <form action="#" method="POST" id="form-supprimer-camion">
                        @csrf
                        @method('delete')
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="name">Désignation :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="name" id="supprimer_name" class="form-control" placeholder="Désignation" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="marque">Marque :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="marque" id="supprimer_marque" placeholder="Marque" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="model">Modèle :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="model" id="supprimer_model" placeholder="Modèle" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="annee">Année :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="annee" id="supprimer_annee"  placeholder="année" class="form-control" required>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-sm-4">
                                <label for="numero_chassis">Numéro châssis :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="numero_chassis" id="supprimer_numero_chassis" placeholder="Numéro châssis" class="form-control" required>
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
                            <a href="" style="text-align: right !important;" id="btn-supprimer-camion">
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

    $("#camions").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false,
                });

        $(document).on("click", ".supprimer-camion", function (e) {
            $("#modal-supprimer-camion").modal("show");

            let url = $(this).attr("data-url");
            let url_delete = $(this).attr("data-delete-url");

            $("#btn-supprimer-camion").attr("href", url_delete).prev().attr("href", url_delete+"/2");

            $.get(url, {}, dataType="JSON").done(function (data) {
                console.log(data);

                if(data.blocked == 1){
                    $("#btn-supprimer-camion").prev().attr("href", url_delete+"/3").find("button").html("Debloquer");
                }

                $("#modal-supprimer-camion #supprimer_marque").val(data.marque).attr("disabled", true);
                $("#modal-supprimer-camion #supprimer_name").val(data.name).attr("disabled", true);
                $("#modal-supprimer-camion #supprimer_model").val(data.model).attr("disabled", true);
                $("#modal-supprimer-camion #supprimer_annee").val(data.annee).attr("disabled", true);
                $("#modal-supprimer-camion #supprimer_numero_chassis").val(data.numero_chassis).attr("disabled", true);
            })
        })

        $(document).on("click", ".modifier-camion", function (e) {
            url = $(this).attr("data-show-url");
            url_update = $(this).attr("data-update-url");
            $("#modal-modifier-camion").modal("show");
            $("#form-modifier-camion").attr("action", url_update);

            $.ajax(url, {}, dataType ="HTML").done(function (data) {
                console.log(data);

                $("#modal-modifier-camion #name").val(data.name);
                $("#modal-modifier-camion #marque").val(data.marque);
                $("#modal-modifier-camion #model").val(data.model);
                $("#modal-modifier-camion #annee").val(data.annee);
                $("#modal-modifier-camion #numero_chassis").val(data.numero_chassis);
            })
        })

    </script>
@endsection
