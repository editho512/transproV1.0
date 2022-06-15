@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Remorques | {{ ucwords($remorque->name)}}</title>
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
                        <h1>{{ucwords($remorque->name)}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <a href="{{route('remorque.index')}}">

                                <button class="btn btn-default" style="color:gray"><span class="fa fa-arrow-left"></span>&nbsp;Retour</button>
                            </a>
                        </ol>
                    </div>
                </div>

                <div class="row mt-2 mb-2">
                    <div class="col-lg-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning" style="background-color: #ff9609 !important;"><img src="{{ asset('assets/images/icons/assurance.png') }}" style="width:55px;" alt=""></span>
                            <div class="info-box-content" >
                                <span class="info-box-text">Assurance</span>
                                <p class="info-box-number voir-camion-statistique" >
                                    {{ isset($assurance[0]->date_echeance) === true ? date("d/m/Y",strtotime($assurance[0]->date_echeance)) : "Aucune" }}
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
                    <div class="col-lg-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary"><i class="fas fa-info"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Carte grise</span>
                                <p class="info-box-number voir-camion-statistique">
                                    {{isset($carteGrise[0]->date_echeance) === true ? date("d/m/Y", strtotime($carteGrise[0]->date_echeance)) : "Aucune"}}
    
                                </p>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <div class="col-lg-6">
                        <div class="info-box"  >
                            <span class="info-box-icon " style="background-color:#3490c1;color: white;"><i class="fas fa-landmark"></i></span>
                            <div class="info-box-content" >
                                <span class="info-box-text">Patente transport</span>
                                <p class="info-box-number voir-camion-statistique">
                                    {{isset($patenteTransport[0]->date_echeance) === true ? date("d/m/Y", strtotime($patenteTransport[0]->date_echeance)) : "Aucune"}}
    
                                </p>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <a class="nav-item nav-link active" id="nav-list-tab" data-toggle="tab" href="#nav-list" role="tab" aria-controls="nav-list" aria-selected="true">Papiers</a>
                      <a class="nav-item nav-link" id="nav-historique-tab" data-toggle="tab" href="#nav-historique" role="tab" aria-controls="nav-historique" aria-selected="false">Historiques</a>
                      <!--<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Contact</a>-->
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab">
                        @include('Remorque.papiers')
                    </div>
                    <div class="tab-pane fade" id="nav-historique" role="tabpanel" aria-labelledby="nav-historique-tab">
                        @include('Remorque.historiques')
                    </div>

                    <!--
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus, mollitia.</div>
                    -->
                </div>
                
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('Remorque.voir_modal')

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
        $("#remorque-papier , #remorque-historique").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "searching": true,
                    "paging": false,
                    "ordering": true,
                    "info": false ,            
                    language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
                });

        $(document).on("click", ".papier-modifier", function(e){
            $("#modal-modifier-papier").modal("show");

            let url = $(this).attr("data-url");
            let url_update = $(this).attr("data-url_update");


            $.get(url, {}, dataType = "JSON").done(function(data){
                $("#modal-modifier-papier").find("input[name=designation]").val(data.designation);
                $("#modal-modifier-papier").find("input[name=date]").val(data.date);
                $("#modal-modifier-papier").find("input[name=date_echeance]").val(data.date_echeance);
                $("#modal-modifier-papier").find("select[name=type]").val(data.type).change();
                $("#modal-modifier-papier form").attr("action", url_update);
            });
        })

        $(document).on("click", ".papier-supprimer", function(e){
            $("#modal-supprimer-papier").modal("show");

            let url = $(this).prev().attr("data-url");
            let url_update = $(this).attr("data-url_delete");


            $.get(url, {}, dataType = "JSON").done(function(data){
                $("#modal-supprimer-papier").find("input[name=designation]").val(data.designation);
                $("#modal-supprimer-papier").find("input[name=date_obtention]").val(data.date);
                $("#modal-supprimer-papier").find("input[name=date_echeance]").val(data.date_echeance);
                $("#modal-supprimer-papier").find("select[name=type]").val(data.type).change();
                $("#modal-supprimer-papier #button-supprimer-papier").parent().attr("href", url_update);
            });
        });
    

    </script>
@endsection
