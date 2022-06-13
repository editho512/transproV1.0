
<div class="modal fade" id="modal-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Approvisionner en carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-carburant">
                <form action="{{route('carburant.ajouter')}}" method="post" role="form" id="form-ajouter-carburant" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                   
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date" data-target-input="nearest">
                                <input type="text" placeholder="Date" class="form-control datetimepicker-input" data-target="#date" name="date" required="">
                                <div class="input-group-append" data-target="#date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Quantité" class="form-control" name="quantite" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select readonly="readonly" name="flux" class="form-control" id="">
                                <option value=0 selected>Entrée</option>
                                <!--
                                <option value=1>Sortie</option>-->

                                {{-- <option value=1>Sortie</option> --}}
                            </select>
                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" id="button-ajouter-carburant" form="form-ajouter-carburant" class="float-right btn btn-success">Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter carburant-->

<!---- modal pour modification carburant --->
<div class="modal fade" id="modal-modifier-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un flux de carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-modifier-carburant" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date" class="form-control datetimepicker-input" data-target="#date_modifier" id="modifier_date" name="date" required="">
                                <div class="input-group-append" data-target="#date_modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" placeholder="Quantité" class="form-control" name="quantite" id="modifier_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="flux" class="form-control" id="modifier_flux">
                                <option value=0 selected>Entrée</option>
                                <option value=1>Sortie</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="submit" form="form-modifier-carburant" id="button-modifier-carburant" class="float-right btn btn-primary">Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modification camion-->

<!---- modal pour modification carburant --->
<div class="modal fade" id="modal-supprimer-carburant">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un flux de carburant</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-supprimer-carburant" >
                    @csrf
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="date">Date :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_modifier" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" data-target="#date_modifier" id="supprimer_date" name="date" required="">
                                <div class="input-group-append" data-target="#date_modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="quantite">Quantité :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="quantite" id="supprimer_quantite" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="prix">Prix unitaire :</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="number"  placeholder="Prix unitaire" class="form-control" name="prix" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px; ">
                        <div class="col-sm-4">
                            <label for="flux">Flux :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="flux" class="form-control" id="supprimer_flux">
                                <option value=0 selected>Entrée</option>
                                <option value=1>Sortie</option>
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" form="form-supprimer-carburant" id="button-supprimer-carburant" class="float-right btn btn-danger">Supprimer</button>
                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modification camion-->



{{-- -Tous ce qui concerne les trajets --}}

<div class="modal fade" id="modal-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Enregistrer un trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-trajet">
                <div class="row">
                    <form class="col-sm-12" action="{{route('trajet.ajouter')}}" method="post" role="form" id="form-ajouter-trajet" enctype="multipart/form-data">
    
                        @csrf
    
                        <input type="hidden" name="camion_id" value={{ $camion->id }}>

                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chargement" class="form-label">Chargement :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Chargement" type="text" class="form-control" name="chargement" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="bon" class="form-label">Bon N° :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Numéro de bon" type="text"  class="form-control" name="bon" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="row mb-3 bon_enlevement" style="margin-top: 3px;display:none; ">
                            <div class="col-sm-4">
                                <label for="bon_enlevement" class="form-label">Bon d'enlevement :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Bon d'enlevement" type="text"  class="form-control" name="bon_enlevement" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chauffeur" class="form-label">Chauffeur :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="chauffeur" class="form-control" id="chauffeur">
                                    <option value="">Selectionner un chauffeur</option>
                                    @forelse ($chauffeurs as $chauffeur)
                                        <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                    @empty
                                        <option value="">Aucun chauffeur disponible pour le moment</option>
                                    @endforelse
                                </select>
                                <div id="chauffeur-feedback"  class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Départ :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                    <div class="input-group-append" data-target="#date_heure_depart" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div  class="invalid-feedback"></div>

                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Arrivée :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date_heure_arrivee" id="date_heure_arrivee" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                    <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div  class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="etat">Statut :</label>
                            </div>
                            <div class="col-sm-8">
    
                                <select name="etat" class="form-control " id="etat" onchange="checkCarburant(this)" required>
                                    <option value="">Selectionner le statut</option>
                                    @foreach (App\Models\Trajet::getEtat() as $status)
                                    <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div  id="status-feedback" class="invalid-feedback"></div>

                            </div>
                        </div>
    
    
                        <div class="row mb-3 mt-3  carburant" id="carburant" style="display: none;">
                            <div class="col-sm-4">
                                <label for="carburant-restant">Carburant restant :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="carburantRestant" id="carburant-restant" placeholder="Quantité de carburant restant">
                                <div   class="invalid-feedback"></div>

                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  poids-content" style="display: none;" id="poids-content">
                            <div class="col-sm-4">
                                <label for="poids">Poids :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="poids" id="poids" placeholder="Poids">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
    
    
                        {{-- Bloc pour gerer les itinéraires --}}
                        <div id="content-itineraire" class="mb-3">
                            <input type="hidden" name="itineraire" class="itineraire_data" value="">
                            <div class="form-group">
                                <label for="nombre_itineraire">Itinéraires :</label>
                                <div id="itineraire_formulaire">
                                    <div class="row">
                                        <div class="col-sm-12" style="padding-top:1%;">
                                            <input type="text" placeholder="Nom de l'itinéraire" class='form-control' required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-1 row">
                                    <div class="col-sm-12" style="text-align:right;">
                                        <button  type="button" class="btn btn-sm btn-itineraire-moins" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);display:none;"><span class="fa fa-minus"></span></button>
    
                                        <button  type="button" class="btn btn-sm btn-itineraire-plus" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 5px" class="row">
                            <div class="col-sm-4">
                                <label for="remorque">Remorque :</label>
                            </div>
                            <div class="col-sm-8">
                                <select style="width: 100% !important;" placeholder="Remorque" name="remorque[]" id="ajout-trajet-remorque" class="form-control" multiple="multiple">
                                    @foreach ($remorques as $remorque)
                                        <option  value={{$remorque->id}}>{{$remorque->name . " - " . $remorque->id}}</option>
                                    @endforeach
                                </select>
                                <div id="ajouter-remorque-trajet" class="invalid-feedback"></div>

                            </div>
                        </div>
    
                    </form>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-sm-12">
                        <p class="alert alert-danger text-center"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-ajouter-trajet" form="form-ajouter-trajet" class="float-right btn btn-success"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-modifier-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un  trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <form action="#" class="col-sm-12" method="post" id="form-modifier-trajet" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
    
                        <input type="hidden" name="camion_id" value={{ $camion->id }}>

                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chargement" class="form-label">Chargement :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Chargement" type="text" class="form-control" name="chargement" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="bon" class="form-label">Bon N° :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Numéro de bon" type="text"  class="form-control" name="bon" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        
                        <div class="row mb-3 bon_enlevement" style="margin-top: 3px;display:none; ">
                            <div class="col-sm-4">
                                <label for="bon_enlevement" class="form-label">Bon d'enlevement :</label>
                            </div>
                            <div class="col-sm-8">
                                <input placeholder="Bon d'enlevement" type="text"  class="form-control" name="bon_enlevement" >
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="chauffeur" class="form-label">Chauffeur :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="chauffeur" class="form-control" id="modifier-chauffeur">
                                    <option value="">Selectionner un chauffeur</option>
                                    @forelse ($chauffeurs as $chauffeur)
                                        <option value="{{ $chauffeur->id }}">{{ $chauffeur->name }}</option>
                                    @empty
                                        <option value="">Aucun chauffeur disponible pour le moment</option>
                                    @endforelse
                                </select>
                                <div id="chauffeur-modifier-feedback"  class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Départ :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date" id="date_heure_depart_modifier" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_depart" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                    <div class="input-group-append" data-target="#date_heure_depart_modifier" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="date">Arrivée :</label>
                            </div>
                            <div class="col-sm-8">
                                <div class="input-group date_heure_arrivee" id="date_heure_arrivee_modifier" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" id="modifier_date_heure_arrivee" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                    <div class="input-group-append" data-target="#date_heure_arrivee_modifier" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
    
                       
    
                        <div class="row mb-3" style="margin-top: 3px; ">
                            <div class="col-sm-4">
                                <label for="etat">Statut :</label>
                            </div>
                            <div class="col-sm-8">
                                <select name="etat" class="form-control " id="modifier-etat" required onchange="checkCarburant(this, '#modal-modifier-trajet')">
                                    <option value="">Selectionner le statut</option>
                                    @foreach (App\Models\Trajet::getEtat() as $status)
                                        <option value="{{ $status }}">{{ $status }}</option>
                                    @endforeach
                                </select>
                                <div  id="status-modifier-feedback" class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  carburant" style="display: none;">
                            <div class="col-sm-4">
                                <label for="carburant-restant">Carburant restant :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="carburantRestant" id="carburant-restant" placeholder="Quantité de carburant restant">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
    
                        <div class="row mb-3 mt-3  poids-content" style="display: none;" id="poids-content">
                            <div class="col-sm-4">
                                <label for="poids">Poids :</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="poids" id="poids" placeholder="Poids">
                                <div class="invalid-feedback"></div>

                            </div>
                        </div>

                        <div style="margin-top: 5px" class="row">
                            <div class="col-sm-4">
                                <label for="remorque">Remorque :</label>
                            </div>
                            <div class="col-sm-8">
                                <select style="width: 100% !important;" placeholder="Remorque" name="remorque[]" id="modification-trajet-remorque" class="form-control" multiple="multiple">
                                    @foreach ($remorques as $remorque)
                                        <option  value={{$remorque->id}}>{{$remorque->name . " - " . $remorque->id}}</option>
                                    @endforeach
                                </select>
                                <div id="modifier-remorque-trajet" class="invalid-feedback"></div>

                            </div>
                        </div>
    
                        {{-- Bloc pour gerer les itinéraires --}}
                        <div id="content-itineraire" class="mb-3">
                            <input type="hidden" name="itineraire" id="data-itineraire" class="itineraire_data" value="">
                            <div class="form-group">
                                <label for="nombre_itineraire">Itinéraires :</label>
                                <div id="itineraire_formulaire">
                                    
                                </div>
                                <div class="mt-1 row">
                                    <div class="col-sm-12" style="text-align:right;">
                                        <button  type="button" class="btn btn-sm btn-itineraire-moins" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);display:none;"><span class="fa fa-minus"></span></button>
                                        <button  type="button" class="btn btn-sm btn-itineraire-plus" style="border:solid 1px rgba(147,155,162,0.8);color:rgba(147,155,162,0.8);"><span class="fa fa-plus"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </form>
                </div>
                <div class="row" style="display: none;">
                    <div class="col-sm-12">
                        <p class="alert alert-danger text-center"></p>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" form="form-modifier-trajet" id="button-modifier-trajet" class="float-right btn btn-primary"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Modifier</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-supprimer-trajet">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un trajet</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"  >
                <form action="#" method="post" id="form-supprimer-trajet" >
                    @csrf

                    <input type="hidden" name="camion_id" value={{ $camion->id }}>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="chargement" class="form-label">Chargement :</label>
                        </div>
                        <div class="col-sm-8">
                            <input placeholder="Chargement" type="text" disabled class="form-control" name="chargement" >
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="bon" class="form-label">Bon N° :</label>
                        </div>
                        <div class="col-sm-8">
                            <input placeholder="Numéro de bon" type="text" disabled class="form-control" name="bon" >
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3 " style="margin-top: 3px;">
                        <div class="col-sm-4">
                            <label for="bon_enlevement" class="form-label">Bon d'enlevement :</label>
                        </div>
                        <div class="col-sm-8">
                            <input placeholder="Bon d'enlevement" type="text" disabled class="form-control" name="bon_enlevement" >
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="chauffeur" class="form-label">Chauffeur :</label>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-control" id="supprimer-chauffeur"></label>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Départ :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date_heure_depart" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="supprimer_date_heure_depart" data-target="#date_heure_depart" name="date_heure_depart" required="false" placeholder="Date et heure départ">
                                <div class="input-group-append" data-target="#date_heure_depart" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="date">Arrivée :</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date_heure_arrivee" id="date_heure_arrivee" data-target-input="nearest">
                                <input type="text" class="form-control datetimepicker-input" id="supprimer_date_heure_arrivee" data-target="#date_heure_arrivee" name="date_heure_arrivee" placeholder="Date et heure arrivée">
                                <div class="input-group-append" data-target="#date_heure_arrivee" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="margin-top: 3px; ">
                        <div class="col-sm-4">
                            <label for="etat">Statut :</label>
                        </div>
                        <div class="col-sm-8">
                            <label class="form-control" id="supprimer-etat"></label>
                        </div>
                    </div>

                    {{-- Bloc pour gerer les itinéraires --}}
                    <div id="content-delete-itineraire" class="mb-3">
                        <div class="form-group">
                            <label for="nombre_itineraire">Itinéraires :</label>
                            <div id="itineraire_delete_formulaire">
                                <div class="row">
                                    <div class="col-sm-12" style="padding-top:1%;" id="list-delete-itineraire">
                                        <input type="text" placeholder="Nom de l'itinéraire" class='form-control' value="test"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <div class="d-flex justify-content-between">
                    <a href="" class="d-none btn btn-warning mr-2">Bloquer</a>
                    <a href="">
                        <button type="button" form="form-supprimer-trajet" id="button-supprimer-trajet" class="float-right btn btn-danger">Supprimer</button>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



{{-- Fin trajets --}}


{{-- Debut papier --}}
<!---- modal pour ajouter papier --->
<div class="modal fade" id="modal-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-success">
                <h4 class="modal-title">Ajouter un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="{{route('papier.ajouter')}}" method="post" role="form" id="form-ajouter-papier" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

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
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-ajouter-papier" form="form-ajouter-papier" class="float-right btn btn-success"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour ajouter papier-->


<!---- modal pour modifier papier --->
<div class="modal fade" id="modal-modifier-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-primary">
                <h4 class="modal-title">Modifier un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-ajouter-papier">
                <form action="#" method="post" role="form" id="form-modifier-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

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
                                  <input type="file" name="photo" class="custom-file-input form-control" id="inputGroupFile01"
                                    aria-describedby="inputGroupFileAddon01">
                                  <label class="custom-file-label" for="inputGroupFile01">Photo</label>
                                </div>
                            </div>
                            <div  class="invalid-feedback photo-feedback"></div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <button type="button" id="button-modifier-papier" form="form-modifier-papier" class="float-right btn btn-primary"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

<!---- modal pour supprimer papier --->
<div class="modal fade" id="modal-supprimer-papier">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h4 class="modal-title">Supprimer un papier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-supprimer-papier">
                <form action="#" method="post" role="form" id="form-supprimer-papier" enctype="multipart/form-data">
                    @csrf
                    @method("patch")
                    <input type="hidden" name="camion_id" value={{$camion->id}}>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="designation">Désignation:</label>
                        </div>
                        <div class="col-sm-8">
                            <input disabled type="text" class="form-control" name="designation" placeholder="Désignation">
                            <div  class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'obtention:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-obtention-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'obtention du papier" class="form-control datetimepicker-input" data-target="#date-obtention-modifier" name="date_obtention" required="">
                                <div class="input-group-append" data-target="#date-obtention-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>

                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="date">Date d'échéance:</label>
                        </div>
                        <div class="col-sm-8">
                            <div class="input-group date" id="date-echeance-modifier" data-target-input="nearest">
                                <input disabled type="text" placeholder="Date d'échéance du papier" class="form-control datetimepicker-input" data-target="#date-echeance-modifier" name="date_echeance" required="">
                                <div class="input-group-append" data-target="#date-echeance-modifier" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <div  class="invalid-feedback"></div>

                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" >
                        <div class="col-sm-4">
                            <label for="quantite">Type :</label>
                        </div>
                        <div class="col-sm-8">
                            <select disabled name="type" id="" class="form-control">
                                <option value="">Type</option>
                                @foreach (App\Models\Papier::TYPE as $item)
                                <option value="{{$item}}">{{ucwords($item)}}</option>
                                @endforeach
                            </select>
                            <div  class="invalid-feedback"></div>

                        </div>
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <a href="">
                    <button type="button" id="button-supprimer-papier" form="form-supprimer-papier" class="float-right btn btn-danger"><span class="fa fa-check"></span><span style="display: none;" class="spinner-border spinner-border-sm"></span>&nbsp;Valider</button>

                </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!---- / modal pour modifier papier-->

{{-- Fin papier --}}