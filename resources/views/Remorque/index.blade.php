@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Remorques</title>
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
                        <h1>Remorques</h1>
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
                                <h3 class="card-title">Liste des remorques</h3>
                                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-chauffeur" data-target="#modal-ajouter-remorque"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="remorques" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Désignation</th>                                        
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($remorques as $remorque)
                                            <tr >
                                                <td>{{$remorque->name}}</td>
                                                
                                                <td>
                                                    <div class="row">
                                                        <div class="col-sm-12 text-center">
                                                            <a href="{{route('remorque.voir', ['remorque' => $remorque->id])}}"><button class="remorque-voir btn btn-info"><span class="fa fa-eye"></span></button></a>
                                                                <button class="remorque-modifier btn btn-primary" data-url_update="{{route('remorque.update', ['remorque' => $remorque->id])}}" data-url="{{route('remorque.edit', ['remorque' => $remorque->id])}}" ><span class="fa fa-edit"></span></button>
                                                            <button class="remorque-supprimer btn btn-danger" data-url_delete="{{route('remorque.delete', ['remorque' => $remorque->id])}}"><span class="fa fa-trash"></span></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                          
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Désignation</th>                                        
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

    @include('Remorque.modal')

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

    $("#remorques").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false ,            
                    language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
                });

    $(document).on("click", ".remorque-modifier", function(){

        $("#modal-modification-remorque").modal("show");

        let url = $(this).attr("data-url");
        let url_update = $(this).attr("data-url_update");

        $.get(url, {}, dataType = "JSON").done(function(data){

            if(data.name != undefined){
                $("#modal-modification-remorque input[name='name']").val(data.name);
                $("#modal-modification-remorque form").attr("action", url_update);
            }
        })
    })

    $(document).on("click", ".remorque-supprimer", function(e){

        $("#modal-suppression-remorque").modal("show");

        let url = $(this).prev().attr("data-url");
        let url_delete = $(this).attr("data-url_delete")

        $.get(url, {}, dataType = "JSON").done(function(data){

            if(data.name != undefined){
                $("#modal-suppression-remorque input[name='name']").val(data.name);
                $("#button-suppression-remorque").parent().attr("href", url_delete);
            }

        })


    })

    

    </script>
@endsection
