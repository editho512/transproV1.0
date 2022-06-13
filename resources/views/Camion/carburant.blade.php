<div class="card-header">
    <h3 class="card-title" style="color: gray;display:none;" >Flux des carburants</h3>
    <button class="float-right btn btn-success" id="btn-modal-carburant" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-carburant"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
</div>
<!-- /.card-header -->
<div class="card-body">
    <table id="flux-carburants" class="table table-bordered table-striped dataTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Montant total</th>
                <th>Flux</th>
                <th style="text-align: center;">Actions</th>

            </tr>
        </thead>
        <tbody>
            @if (isset($carburants) === true && $carburants->count() > 0)
            @foreach ($carburants as $carburant)

            <tr>
                <td>{{$carburant->date}}</td>
                <td class="text-left" >{{nombre_fr($carburant->quantite)."L"}}</td>
                <td class="text-left" >{{$carburant->prix == null ? "--" : prix_mg($carburant->prix)}}</td>
                <td class="text-left" >{{$carburant->prix == null ? "--" : prix_mg($carburant->prix * $carburant->quantite, 0, ",", ".")}}</td>
                <td>{{$carburant->flux == false ? "Entrée" : "Sortie"}}</td>
                <td >
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center">
                            <button @if ($carburant->flux == true) disabled @endif class="btn  btn-sm btn-primary modifier-carburant" data-url="{{route('carburant.update', ['carburant' => $carburant->id])}}" data-show-url="{{route('carburant.modifier', ['carburant' => $carburant->id])}}"><span class="fa fa-edit"></span></button>
                            <button @if ($carburant->flux == true) disabled @endif class="btn  btn-sm btn-danger  supprimer-carburant" data-url="{{route('carburant.delete', ['carburant' => $carburant->id])}}"><span class="fa fa-trash"></span></button>
                        </div>
                    </div>

                </td>
            </tr>

            @endforeach

            @else
           
            @endif

        </tbody>
        <tfoot>
            <tr>
                <th>Date</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Montant total</th>
                <th>Flux</th>
                <th style="text-align: center;">Actions</th>

            </tr>
        </tfoot>
    </table>
</div>
<!-- /.card-body -->