<div class="card-header">
    <h3 class="card-title" style="color: gray;display:none;" >Liste des trajets</h3>
    <button class="float-right btn btn-success" id="btn-modal-trajet" data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-trajet"><span class="fa fa-plus"></span>&nbsp;Ajouter</button>
</div>
<!-- /.card-header -->
<div class="card-body">
    <table id="trajets" class="table table-bordered table-striped dataTable">
        <thead>
            <tr>
                <th>Numéro</th>
                <th>Chargement</th>
                <th>Itinéraire</th>
                <th>Date & heure départ</th>
                <th>Date & heure arrivée</th>
                <th>Chauffeur</th>
                <th>Statut</th>
                <th>Détail</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($camion->trajets()->orderBy('date_heure_depart', 'ASC')->get() as $trajet)
            <tr>
                <td @if ($trajet->ordreExecution() !== null) style="background-color:{{ $trajet->couleurs() }}" @endif>{{ $trajet->id }}</td>
                <td>{{$trajet->chargement}}</td>
                <td>{{ $trajet->nomItineraire() }}</td>
                <td>{{ formatDate($trajet->date_heure_depart) }}</td>
                <td>{{ formatDate($trajet->date_heure_arrivee) }}</td>
                <td>{{ $trajet->chauffeur === null ? "Pas encore de chauffeur assigné" : $trajet->chauffeur->name }}</td>
                <td>
                    @if ($trajet->enRetard())
                        <div class="badge badge-danger">En rétard</div>
                    @else
                        <div class="
                            @if ($trajet->etat === App\Models\Trajet::getEtat(1)) badge badge-info
                            @elseif ($trajet->etat === App\Models\Trajet::getEtat(0)) badge badge-warning
                            @else badge badge-success
                            @endif
                        ">
                            {{ $trajet->etat }}
                        </div>

                        @if ($trajet->ordreExecution() !== null AND $trajet->etat !== App\Models\Trajet::getEtat(2))
                            <b>&nbsp;-&nbsp;Ordre:&nbsp;<span>{{ $trajet->ordreExecution() }}</span></b>
                        @endif
                    @endif
                </td>
                <td >
                    <div class="row">

                        <div class="col-sm-12 text-center" >
                            <b> <span>{{$trajet->carburantUtilise() > 0 ? $trajet->carburantUtilise() . "L" : "--"}}</span>&nbsp;/&nbsp;<span>{{doubleval($trajet->poids) > 0 ? doubleval($trajet->poids) . "T" : "--"}}</span></b>
                        </div>
                        <div class="col-sm-12 text-center d-none" >
                            <b>{{doubleval($trajet->poids) > 0 ? doubleval($trajet->poids) . "T" : "--"}}</b>
                        </div>

                    </div>
                </td>
                <td>
                    <button class="btn btn-sm btn-info voir-trajet"><span class="fa fa-eye"></span></button>
                    <button @if ($trajet->IsLastFinished() === false ) disabled @endif  class="btn btn-sm btn-primary modifier-trajet"  data-update-url="{{route('trajet.update', ['trajet' => $trajet->id])}}" data-show-url="{{route('trajet.modifier', ['trajet' => $trajet->id])}}"><span class="fa fa-edit"></span></button>
                    <button {{ isset($trajet->reservation->id) === true ? "disabled": "" }} class="btn btn-sm btn-danger supprimer-trajet" data-url="{{route('trajet.supprimer', ['trajet' => $trajet->id])}}" data-delete-url="{{route('trajet.delete', ['trajet' => $trajet->id])}}"><span class="fa fa-trash"></span></button>
                </td>
            </tr>
            @empty
           
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th>Numéro</th>
                <th>Chargement</th>
                <th>Itinéraire</th>
                <th>Date & heure départ</th>
                <th>Date & heure arrivée</th>
                <th>Chauffeur</th>
                <th>Statut</th>
                <th>Détail</th>
                <th style="text-align:center;">Actions</th>
            </tr>
        </tfoot>
    </table>
</div>
<!-- /.card-body -->