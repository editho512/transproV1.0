<div class="card-header">
    <h3 class="card-title" style="color: gray;display:none;" ></h3>
    <button class="float-right btn btn-success" id="btn-modal-papier" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-papier"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
</div>
<!-- /.card-header -->
<div class="card-body">
    <table id="papiers" class="table table-bordered table-striped dataTable">
        <thead>
            <tr>
                <th>Désignation</th>
                <th>Type</th>
                <th>Date d'obtention</th>
                <th>Date d'échéance</th>
                <th style="text-align: center;">Actions</th>

            </tr>
        </thead>
        <tbody>
            @if (isset($papiers) === true && $papiers->count() > 0)
            @foreach ($papiers as $papier)

            <tr>
                <td>{{$papier->designation}}</td>
                <td>{{$papier->type}}</td>
                <td>{{$papier->date}}</td>
                <td>{{$papier->date_echeance}}</td>
                <td >
                    <div class="row">
                        <div class="col-sm-12" style="text-align: center">
                            <a  href="{{$papier->photo == null ? "#" : asset('storage/'.$papier->photo)}}" target="_blank">
                                <button class="btn btn-sm btn-info"><span class="fa fa-eye"></span></button>
                            </a>
                            <button class="btn btn-sm btn-primary btn-papier-modifier" data-url="{{route('papier.update', ["papier" => $papier->id])}}"  data-show="{{route('papier.modifier', ["papier" => $papier->id])}}" ><span class="fa fa-edit"></span></button>
                            <button class="btn btn-sm btn-danger btn-papier-supprimer" data-url="{{route('papier.supprimer', ["papier" => $papier->id])}}" data-show="{{route('papier.modifier', ["papier" => $papier->id])}}"><span class="fa fa-trash"></span></button>
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
                <th>Désignation</th>
                <th>Type</th>
                <th>Date d'obtention</th>
                <th>Date d'échéance</th>
                <th style="text-align: center;">Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- /.card-body -->