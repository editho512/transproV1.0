<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">Liste des historiques</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="remorque-historique" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Camion</th> 
                        <th>Trajet</th>                                                                              
                        <th>Date de départ</th>
                        <th>Date d'arrivée</th>

                    </tr>
                    </thead>
                    <tbody>

                      
                        @foreach ($remorque->trajets as $trajet)
                           
                            <tr>                                                    
                                <td class="text-center">{{$trajet->camion->name}}</td>
                                <td class="text-center">{{$trajet->nomItineraire()}}</td>
                                <td class="text-center">{{formatDate($trajet->date_heure_depart)}}</td>
                                <td class="text-center">{{formatDate($trajet->date_heure_arrivee)}}</td>

                                
                            </tr>
                        @endforeach
                          
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Camion</th> 
                            <th>Trajet</th>                                                                              
                            <th>Date de départ</th>
                            <th>Date d'arrivée</th>
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