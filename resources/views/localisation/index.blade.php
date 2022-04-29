@extends('main')

@section('title') <title>Localisation des camions</title> @endsection

@section('content')

<div class="content-wrapper teste" style="min-height: inherit!important;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Localisation des camions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Liste des Camions localisable</h3>
                                <a href="" class="btn btn-primary"><i class="fa fa-location-arrow mr-2"></i>Localiser tous les camions</a>
                            </div>
                        </div>

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
                                    @forelse($camions as $camion)
                                        <tr style='{{$camion->blocked == true ? "color:gray;" : ""}}' >
                                            <td>{{ ucwords($camion->name )}}</td>
                                            <td>{{ $camion->numero_chassis }}</td>
                                            <td>{{ $camion->model }}</td>
                                            <td>{{ $camion->marque }}</td>
                                            <td>{{ $camion->annee }}</td>
                                            <td class="d-flex justify-content-center">
                                                <a href="" class="btn btn-primary mr-2" data-toggle="tooltip" data-placement="top" title="Localiser le camion"><i class="fa fa-map-marker-alt"></i></a>
                                                <a href="" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Obtenir le lien de localisation du camion"><i class="fa fa-link"></i></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="6">
                                                Aucun camion dans la liste
                                            </td>
                                        </tr>
                                    @endforelse
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
</div>

@endsection
