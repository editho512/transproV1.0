@extends('main')

@section('title')
    <title>{{ config('app.name') }} | Tableau de bord</title>
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
                        <h1>Tableau de bord</h1>
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
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <div class="card card-outline card-info" >
                                    <div class="card-header">
                                        <h3 class="card-title">Consomation </h3>
                                        <div class="card-tools">
                                           
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <span class="badge badge-info" ></span>
                
                                        </div>
                
                                        <div class="card-tools">
                                           
                                          <!-- Buttons, labels, and many other things can be placed here! -->
                                          <!-- Here is a label for example -->
                
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <div class="card-body" >
                                        <div>
                                            <canvas id="carburantChart" width="200" height="200"></canvas>
                                        </div>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <button id="btn-mois-carburant-moins" class="btn" style="background-color:rgba(63,193,192,0.15);color: #0899ba;border-color:#0899ba;margin-right:2%" ><span class="fa fa-arrow-left"></span></button>
                                                <button disabled id="btn-mois-carburant-plus"  class="btn" style="background-color:rgba(63,193,192,0.15);color: #0899ba;border-color:#0899ba;margin-left:2%" ><span class="fa fa-arrow-right"></span></button>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-outline card-danger" >
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h3 class="card-title">Dépense </h3>
                                            </div>
                                            <div class="col-sm-8">
                                                <select name="typeDepenseCamion" id="typeDepenseCamion" class="form-control" autocomplete="off">
                                                    <option value="">Toute</option>
                                                    @foreach (typeDepense() as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-tools">
                                           
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <span class="badge badge-info" ></span>
                
                                        </div>
                
                                        <div class="card-tools">
                                           
                                          <!-- Buttons, labels, and many other things can be placed here! -->
                                          <!-- Here is a label for example -->
                
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <div class="card-body" >
                                        <div>
                                            <div id="container-depense-camion" style="width:100%; height:400px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                     <!-- Date dd/mm/yyyy -->
                                                         <div class="input-group">
                                                             <div class="input-group date" id="depenseCamionDebut" data-target-input="nearest">
                                                                 <input autocomplete="off" type="text" class="form-control datetimepicker-input" data-target="#depenseCamionDebut" placeholder="Début" name="depenseCamionDebut"  required/>
                                                                 <div class="input-group-append" data-target="#depenseCamionDebut" data-toggle="datetimepicker">
                                                                     <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     <!-- /Date dd/mm/yyyy -->
                    
                                                </div>
                                                <div class="col-md-6 ">
                                                 <!-- Date dd/mm/yyyy -->
                                                     <div class="input-group">
                                                         <div class="input-group date" id="depenseCamionFin" data-target-input="nearest">
                                                             <input autocomplete="off" type="text" class="form-control datetimepicker-input " data-target="#depenseCamionFin" placeholder="Fin" name="depenseCamionFin"  required/>
                                                             <div class="input-group-append" data-target="#depenseCamionFin" data-toggle="datetimepicker">
                                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 <!-- /Date dd/mm/yyyy -->
                                                 </div>
                                            </div>
                                         </div>
                                    </div>                            
                                </div>
        
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-7">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card card-outline card-success" >
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h3 class="card-title">Maintenance et reparation </h3>
                                            </div>
                                            <div class="col-sm-8">
                                                
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-tools">
                                           
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <span class="badge badge-success" ></span>
                
                                        </div>
                
                                        <div class="card-tools">
                                           
                                          <!-- Buttons, labels, and many other things can be placed here! -->
                                          <!-- Here is a label for example -->
                
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <div class="card-body" >
                                        <div>
                                            <div id="container-maintenance" style="width:100%; height:400px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                     <!-- Date dd/mm/yyyy -->
                                                         <div class="input-group">
                                                             <div class="input-group date" id="maintenanceDebut" data-target-input="nearest">
                                                                 <input autocomplete="off" type="text" class="form-control datetimepicker-input" data-target="#maintenanceDebut" placeholder="Début" name="maintenanceDebut"  required/>
                                                                 <div class="input-group-append" data-target="#maintenanceDebut" data-toggle="datetimepicker">
                                                                     <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     <!-- /Date dd/mm/yyyy -->
                    
                                                </div>
                                                <div class="col-md-6 ">
                                                 <!-- Date dd/mm/yyyy -->
                                                     <div class="input-group">
                                                         <div class="input-group date" id="maintenanceFin" data-target-input="nearest">
                                                             <input autocomplete="off" type="text" class="form-control datetimepicker-input " data-target="#maintenanceFin" placeholder="Fin" name="maintenanceFin"  required/>
                                                             <div class="input-group-append" data-target="#maintenanceFin" data-toggle="datetimepicker">
                                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 <!-- /Date dd/mm/yyyy -->
                                                 </div>
                                            </div>
                                         </div>
                                    </div>                            
                                </div>
        
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="row mt">
                            <div class="col-sm-12">
                                <div class="card card-outline card-danger" >
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h3 class="card-title">Dépense </h3>
                                            </div>
                                            <div class="col-sm-8">
                                                <select name="typeDepenseChauffeur" id="typeDepenseChauffeur" class="form-control" autocomplete="off">
                                                    <option value="">Toute</option>
                                                    @foreach (typeDepense() as $type)
                                                    <option value="{{ $type }}">{{ $type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-tools">
                                           
                                            <!-- Buttons, labels, and many other things can be placed here! -->
                                            <!-- Here is a label for example -->
                                            <span class="badge badge-info" ></span>
                
                                        </div>
                
                                        <div class="card-tools">
                                           
                                          <!-- Buttons, labels, and many other things can be placed here! -->
                                          <!-- Here is a label for example -->
                
                                        </div>
                                        <!-- /.card-tools -->
                                    </div>
                                    <div class="card-body" >
                                        <div>
                                            <div id="container" style="width:100%; height:400px;"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer" >
                                        <div class="card-footer">
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                     <!-- Date dd/mm/yyyy -->
                                                         <div class="input-group">
                                                             <div class="input-group date" id="depenseChauffeurDebut" data-target-input="nearest">
                                                                 <input autocomplete="off" type="text" class="form-control datetimepicker-input" data-target="#depenseChauffeurDebut" placeholder="Début" name="depenseChauffeurDebut"  required/>
                                                                 <div class="input-group-append" data-target="#depenseChauffeurDebut" data-toggle="datetimepicker">
                                                                     <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     <!-- /Date dd/mm/yyyy -->
                    
                                                </div>
                                                <div class="col-md-6 ">
                                                 <!-- Date dd/mm/yyyy -->
                                                     <div class="input-group">
                                                         <div class="input-group date" id="depenseChauffeurFin" data-target-input="nearest">
                                                             <input autocomplete="off" type="text" class="form-control datetimepicker-input " data-target="#depenseChauffeurFin" placeholder="Fin" name="depenseChauffeurFin"  required/>
                                                             <div class="input-group-append" data-target="#depenseChauffeurFin" data-toggle="datetimepicker">
                                                                 <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 <!-- /Date dd/mm/yyyy -->
                                                 </div>
                                            </div>
                                         </div>
                                    </div>                            
                                </div>
        
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="card card-outline card-info" style="border-color: #3a0ca3 !important;">
                            <div class="card-header">
                                <h3 class="card-title"></h3>
                                <div class="card-tools">
                                   
                                    <!-- Buttons, labels, and many other things can be placed here! -->
                                    <!-- Here is a label for example -->
                                    <span class="badge badge-info" style="background-color:#3a0ca3 !important;">Main d'oeuvre par mois</span>
        
                                </div>
        
                                <div class="card-tools">
                                   
                                  <!-- Buttons, labels, and many other things can be placed here! -->
                                  <!-- Here is a label for example -->
        
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <div class="card-body" >
                                <div>
                                    <canvas id="mainOeuvreChart" width="200" height="200"></canvas>
                                </div>
                            </div>
                            <div class="card-footer" >
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="btn-mois-mainOeuvre-moins" class="btn" style="background-color:rgba(53,12,163,0.15);color: #3a0ca3;border-color:#3a0ca3;margin-right:2%" ><span class="fa fa-arrow-left"></span></button>
                                        <button disabled id="btn-mois-mainOeuvre-plus"  class="btn" style="background-color:rgba(53,12,163,0.15);color: #3a0ca3;border-color:#3a0ca3;margin-left:2%" ><span class="fa fa-arrow-right"></span></button>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
                
                

                
                
          
            </div>
            <!-- /.container-fluid -->
        </section>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


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

     <!-- ChartJS -->
     <script type="text/javascript" src="{{asset('assets/adminlte/plugins/chart.js/Chart.min.js')}}"></script>
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/1.0.0/chartjs-plugin-datalabels.min.js" integrity="sha512-XulchVN83YTvsOaBGjLeApZuasKd8F4ZZ28/aMHevKjzrrjG0lor+T4VU248fWYMNki3Eimk+uwdlQS+uZmu8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>   
    
     <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
    
    <!-- Hightchars ---->
    <script src="https://code.highcharts.com/highcharts.js"></script> 
    <!-- Hightchars ---->

    <!-- page script -->
  
    <script>

        
        document.addEventListener('DOMContentLoaded', function () {

            // -------------- HIGHT CHART maintenance ----------------- //
                let maintenance = JSON.parse('{!! json_encode($maintenance)!!}')
                let maintenanceCategorie = [];
                let maintenanceMainData = [];
                let maintenanceRepData = [];
                for(var i in maintenance){
                    maintenanceCategorie.push(i);

                    if(maintenance[i].hasOwnProperty('Maintenance') === true){
                        maintenanceMainData.push(parseFloat(maintenance[i].Maintenance))
                    }else{
                        maintenanceMainData.push(0)
                    }

                    if(maintenance[i].hasOwnProperty('Reparation') === true){
                        maintenanceRepData.push(parseFloat(maintenance[i].Reparation))
                    }else{
                        maintenanceRepData.push(0)
                    }
                }

                

                const chartMaintenance = Highcharts.chart('container-maintenance', {
                        chart: {
                            type: 'column',
                            colors:['#dc3545']
                            
                        },
                        
                        title: {
                            text: 'Maintenance et reparation'
                        },
                        xAxis: {
                            title : {
                                text: 'Camions'
                            },
                            categories: maintenanceCategorie
                        },
                        yAxis: {
                            title: {
                                text: 'montant'
                            }
                        },
                       /* tooltip : {
                            formatter(){
                                return `x value  - $(this.x) :  $(this.y)`;
                            }
                        },*/
                        series: [
                            {
                                name: 'Maintenance',
                                data: maintenanceMainData,
                                color: 'rgba(40,167,69,0.6)'
                            },
                            {

                                name: 'Reparation',
                                data: maintenanceRepData,
                                color: 'rgba(191,210,0,0.6)'
                            }
                    ]
                    });

            // -------------- HIGH CHART depense camion --------------- //
                    let depenseCamion = JSON.parse('{!! json_encode($depenseCamion->toArray()) !!}')
                    
                    let depenseCamionLabel = []
                    let depenseCamionData = []

                    depenseCamion.forEach(function(dep){
                        depenseCamionLabel.push(dep.chauffeur)
                        depenseCamionData.push(parseFloat(dep.montant))
                    })

                    const chartDepenseCamion = Highcharts.chart('container-depense-camion', {
                        chart: {
                            type: 'bar',
                            colors:['#dc3545']
                            
                        },
                        
                        title: {
                            text: 'Dépense par camion'
                        },
                        xAxis: {
                            title : {
                                text: 'Camions'
                            },
                            categories: depenseCamionLabel
                        },
                        yAxis: {
                            title: {
                                text: 'montant'
                            }
                        },
                        series: [{
                            name: 'montant en Ar',
                            data: depenseCamionData,
                            color: 'rgba(220,53,69,0.6)'
                        }]
                    });

            // -------------- HIGH CHART depense chauffeur ------------ //
                    let depenseChauffeur = JSON.parse('{!! json_encode($depense->toArray()) !!}')
            
                    let depenseChauffeurLabel = []
                    let depenseChauffeurData = []

                    depenseChauffeur.forEach(function(dep){
                        depenseChauffeurLabel.push(dep.chauffeur)
                        depenseChauffeurData.push(parseFloat(dep.montant))
                    })

                    const chart = Highcharts.chart('container', {
                        chart: {
                            type: 'bar',
                            colors:['#dc3545']
                            
                        },
                        
                        title: {
                            text: 'Dépense par chauffeur'
                        },
                        xAxis: {
                            title : {
                                text: 'Chauffeurs'
                            },
                            categories: depenseChauffeurLabel
                        },
                        yAxis: {
                            title: {
                                text: 'montant'
                            }
                        },
                        series: [{
                            name: 'montant en Ar',
                            data: depenseChauffeurData,
                            color: 'rgba(220,53,69,0.6)'
                        }]
                    });

            //  --------- Hight chart events --------------------- //

            $(document).on("click, focusout" , "#maintenanceDebut , #maintenanceFin " , function(e){               
                getmaintenance();
            });

            function getmaintenance(){

                let maintenanceDebut = $("#maintenanceDebut input").val();
                let maintenanceFin = $("#maintenanceFin input").val();
                let post = {    _token: "{{ csrf_token() }}", 
                                debut: maintenanceDebut , 
                                fin : maintenanceFin
                            }

                let url = "{{route('tableaubord.maintenance')}}";

                $.post(url, post, dataType="JSON").done(function(data){
                    let maintenanceCategorie = [];
                    let maintenanceMainData = [];
                    let maintenanceRepData = [];
                    
                    for(var i in data){
                        maintenanceCategorie.push(i);

                        if(data[i].hasOwnProperty('Maintenance') === true){
                            maintenanceMainData.push(parseFloat(data[i].Maintenance))
                        }else{
                            maintenanceMainData.push(0)
                        }

                        if(data[i].hasOwnProperty('Reparation') === true){
                            maintenanceRepData.push(parseFloat(data[i].Reparation))
                        }else{
                            maintenanceRepData.push(0)
                        }
                    }


                    chartMaintenance.update({
                            xAxis: {
                                title : {
                                    text: 'Camions'
                                },
                                categories: maintenanceCategorie
                            },
                            series: [{
                                    name: 'Maintenance',
                                    data: maintenanceMainData,
                                    color: 'rgba(40,167,69,0.6)'
                                },
                                {

                                    name: 'Reparation',
                                    data: maintenanceRepData,
                                    color: 'rgba(191,210,0,0.6)'
                                }]
                        })

                    
                })
            }
            
            $(document).on("change", "#typeDepenseCamion", function(e){
                getDepenseCamion();
            })

            $(document).on("click, focusout" , "#depenseCamionDebut , #depenseCamionFin " , function(e){               
                getDepenseCamion();
            });


            function getDepenseCamion(){

                let depenseType = $("#typeDepenseCamion").find("option:selected").val();

                let depenseCamionDebut = $("#depenseCamionDebut input").val();
                let depenseCamionFin = $("#depenseCamionFin input").val();
                let post = {    _token: "{{ csrf_token() }}", 
                                debut: depenseCamionDebut , 
                                fin : depenseCamionFin,
                                type : depenseType 
                            }

                let url = "{{route('tableaubord.depense.camion')}}";

                $.post(url, post, dataType="JSON").done(function(data){
                    let depenseCamionLabel = [];
                    let depenseCamionData = [];

                    data.forEach(function(dep){
                        depenseCamionLabel.push(dep.chauffeur);
                        depenseCamionData.push(parseFloat(dep.montant));
                    })
                    
                    chartDepenseCamion.update({
                        xAxis: {
                            title : {
                                text: 'Camions'
                            },
                            categories: depenseCamionLabel
                        },
                        series: [{
                            name : "montant en Ar",
                            data : depenseCamionData
                        }]
                    })
                })
            }


            $(document).on("change", "#typeDepenseChauffeur", function(e){
                getDepenseChauffeur();
            })
            $(document).on("click, focusout" , "#depenseChauffeurDebut , #depenseChauffeurFin " , function(e){               
                getDepenseChauffeur();
            });

            function getDepenseChauffeur(){

                let depenseType = $("#typeDepenseChauffeur").find("option:selected").val();

                let depenseChauffeurDebut = $("#depenseChauffeurDebut input").val();
                let depenseChauffeurFin = $("#depenseChauffeurFin input").val();

                let post = {    _token: "{{ csrf_token() }}", 
                                debut: depenseChauffeurDebut , 
                                fin : depenseChauffeurFin,
                                type : depenseType 
                            }

                let url = "{{route('tableaubord.depense.chauffeur')}}";

                $.post(url, post, dataType="JSON").done(function(data){
                    let depenseChauffeurLabel = [];
                    let depenseChauffeurData = [];

                    data.forEach(function(dep){
                        depenseChauffeurLabel.push(dep.chauffeur);
                        depenseChauffeurData.push(parseFloat(dep.montant));
                    })
                    
                    chart.update({
                        xAxis: {
                            title : {
                                text: 'Chauffeurs'
                            },
                            categories: depenseChauffeurLabel
                        },
                        series: [{
                            name : "montant en Ar",
                            data : depenseChauffeurData
                        }]
                    })
                })
            }

        });

        var today = new Date();

        let carburants = JSON.parse('{!! json_encode($carburants->toArray()) !!}')
        
        let labelsCarburant = []
        let dataCarburant = []

        carburants.forEach(function(carburant){
            labelsCarburant.push(carburant.name);
            dataCarburant.push(carburant.quantite);
        });

     
        let data = {
            labels: labelsCarburant,
            datasets: [{
                label: 'Consommation de carburant en ' + mois(today.getMonth() + 1 ),
                data: dataCarburant ,
                fill: true,
                borderColor: '#0899ba',
                backgroundColor: 'rgba(63,193,192,0.15)',
                tension: 0.1
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {   
                responsive : true      
            }
        };
    
        var myChartCarburant = new Chart(
            document.getElementById('carburantChart'),
            config
        );


        // ------------------ Mains d'oeuvre ----------------
            let MainOeuvre = JSON.parse('{!! json_encode($mainOeuvre->toArray()) !!}')
            
            let labelsMainOeuvre = []
            let dataMainOeuvre = []
            MainOeuvre.forEach(function(mainOeuvre){
                labelsMainOeuvre.push(mois(mainOeuvre.month) + " - " + mainOeuvre.year);
                dataMainOeuvre.push(mainOeuvre.quantite);
            });

        
            let MainOeuvreData = {
                labels: labelsMainOeuvre,
                datasets: [{
                    label: 'Main d\' oeuvre par mois ',
                    data: dataMainOeuvre ,
                    fill: true,
                    borderColor: '#3a0ca3',
                    backgroundColor: 'rgba(58,12,163,0.15)',
                    tension: 0.1
                }]
            };
            const configMainOeuvre = {
                type: 'line',
                data: MainOeuvreData,
                options: {   
                    responsive : true   ,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                if (label) {
                                    label += ': ';
                                }
                                label += prix(tooltipItem.yLabel) + " Ar";
                                return label;
                            }
                        }
                    }   
                }
            };
        
            var myChartMainOeuvre = new Chart(
                document.getElementById('mainOeuvreChart'),
                configMainOeuvre
            );

        
        // -------------- EVENT ---------------------------- //
            // ----- CHART MAINOEUVRE ---------------- //
            let mainOeuvreBouton = 0;

            mainOeuvre(mainOeuvreBouton);

            $(document).on("click", "#btn-mois-mainOeuvre-moins", function(e){
                mainOeuvreBouton++;
                mainOeuvre(mainOeuvreBouton)

            });

            $(document).on("click", "#btn-mois-mainOeuvre-plus", function(e){
                mainOeuvreBouton--;
                mainOeuvre(mainOeuvreBouton)

            });

            function mainOeuvre(page){
                let url = "{{route('tableaubord.mainoeuvre')}}" + "/" + page

                $.get(url, {}, dataType = "JSON").done(function(data){
                    
                    myChartMainOeuvre.data.datasets[0].label =   "Main d'oeuvre par mois "
                
                    if(data != null && data.length > 0){
                        // vider les anciens données
                        myChartMainOeuvre.data.labels = [];
                        myChartMainOeuvre.data.datasets[0].data = [];
                        myChartMainOeuvre.update();

                        data.forEach(function(e , i){

                            myChartMainOeuvre.data.labels[i] = mois(e.month) + " - " + e.year;
                            myChartMainOeuvre.data.datasets[0].data[i] = e.quantite;
                            myChartMainOeuvre.update();
                        })
                        
                    }
                    else{
                        //--
                        removeData(myChartMainOeuvre);
                    }
                        
                    if(page > 0){
                        $("#btn-mois-mainOeuvre-plus").removeAttr("disabled");
                    }else{
                        $("#btn-mois-mainOeuvre-plus").attr("disabled", true);
                    }
                });
                }

            // ----- CHART CARBURANT ------------------ //

            let carburantBouton = 0;

            $(document).on("click", "#btn-mois-carburant-moins", function(e){
                carburantBouton++;

                let url = "{{route('tableaubord.carburant')}}" + "/" + carburantBouton
                carburantConsomation(url)
               
            })

            $(document).on("click", "#btn-mois-carburant-plus", function(e){
                carburantBouton--;

                let url = "{{route('tableaubord.carburant')}}" + "/" + carburantBouton
                carburantConsomation(url)
            })

            


            
            // ----- CHART CARBURANT ------------------ //
            carburantConsomation("{{route('tableaubord.carburant')}}" + "/" + carburantBouton)
            
            function carburantConsomation(url){

                $.get(url, {}, dataType = "JSON").done(function(data){
                    myChartCarburant.data.datasets[0].label =   "Consommation de carburant en "+ mois( (today.getMonth() + 1 ) - carburantBouton)
                
                    if(data != null && data.length > 0){
                        // vider les anciens données
                        myChartCarburant.data.labels = [];
                        myChartCarburant.data.datasets[0].data = [];
                        myChartCarburant.update();

                        data.forEach(function(e , i){

                            myChartCarburant.data.labels[i] = e.name;
                            myChartCarburant.data.datasets[0].data[i] = e.quantite;
                            myChartCarburant.update();
                        })
                        
                    }
                    else{
                        //--
                        removeData(myChartCarburant);
                    }
                        
                    if(carburantBouton > 0){
                        $("#btn-mois-carburant-plus").removeAttr("disabled");
                    }else{
                        $("#btn-mois-carburant-plus").attr("disabled", true);
                    }
                });
            }
        // -------------- EVENT ---------------------------- // 

        // functions
        function removeData(chart) {
            let data_remove_int = setInterval(() => {
                if(chart.data.labels.length > 0){
                    chart.data.labels.pop();
                    chart.data.datasets.forEach((dataset) => {
                    dataset.data.pop();
                });
                    chart.update();
                }else{
                    clearInterval(data_remove_int);
                }

            }, 200);
        }
            
    </script>
@endsection
