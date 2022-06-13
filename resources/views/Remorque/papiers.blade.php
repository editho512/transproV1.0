<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header" >
                <h3 class="card-title">Liste des papiers</h3>
                <button class="btn  float-right" style="background: #007bff;color:white;" data-toggle="modal" id="nouveau-papier" data-target="#modal-papier"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="remorque-papier" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Désignation</th> 
                        <th>Type</th> 
                        <th>Date d'obtention</th> 
                        <th>Date d'échéance</th>                                     
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($papiers as $papier)
                            <tr>
                                <td class="text-center">{{$papier->designation}}</td>
                                <td class="text-center">{{$papier->type}}</td>
                                <td class="text-center">{{date('d-m-Y', strtotime($papier->date))}}</td>
                                <td class="text-center">{{date('d-m-Y', strtotime($papier->date_echeance))}}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <button class="btn papier-modifier btn-primary" data-url_update={{route('remorque.papier.update', ['papier' => $papier->id ])}} data-url="{{route('remorque.papier.modifier', ['papier' => $papier->id])}}"><span class="fa fa-edit"></span></button>
                                            <button class="btn btn-danger papier-supprimer" data-url_delete="{{route('remorque.papier.supprimer', ['papier' => $papier->id])}}"><span class="fa fa-trash"></span></button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                          
                    </tbody>
                    <tfoot>
                        <tr>                                                   
                            <th>Désignation</th> 
                            <th>Type</th> 
                            <th>Date d'obtention</th> 
                            <th>Date d'échéance</th>                                     
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