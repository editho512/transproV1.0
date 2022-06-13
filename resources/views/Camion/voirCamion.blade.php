@extends('main')

@section('title')
<title>{{ config('app.name') }} | {{$camion->name }}</title>
@endsection

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{background-color:#3490c1;}
</style>
@endsection

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper teste" style="min-height: inherit!important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$camion->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <a href="{{route('camion.liste')}}">
                            <button class="btn btn-default" style="color:gray;"><span class="fa fa-arrow-left"></span>&nbsp;Retour</button>
                        </a>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content-header -->
    <div class="row">
        <div class="col-md-4 px-3">
            <div class="card card-info card-outline" style="border-color:#3490c1 !important">
                <div class="card-body box-profile">
                    <div class="row">
                        <div class="col-sm-6" style="min-width:220px !important;">
                            <img class="rounded" style="max-width:200px !important;" alt="Photo de {{$camion->name}}" src="{{asset('storage/'.$camion->photo)}}">
                        </div>
                        <div class="col-sm-6" style="color: #023047">
                            <h4 class="mt-2">{{$camion->marque}}</h4>
                            <h5 class="mt-2">{{$camion->model ." - ". $camion->annee}} </h5>
                            <h6 class="mt-2">{{$camion->numero_chassis}}</h6>
                        </div>

                    </div>

                </div>
                <!-- /.card-body -->
            </div>

        </div>

        <div class="col-md-8 px-3">
            <div class="row">
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary"><i class="fa fa-id-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Chauffeur</span>
                            <p class="info-box-number voir-camion-statistique">
                                @if ($camion->dernierTrajet() !== null)
                                    @if ($camion->dernierTrajet()->chauffeur !== null)
                                        {{ $camion->dernierTrajet()->chauffeur->name }}
                                    @else
                                        Pas encore de chauffeur
                                    @endif
                                @else
                                    Aucun chauffeur
                                @endif
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-lg-6">
                    <div class="info-box">

                        <span class="info-box-icon bg-danger"><img src="{{asset("assets/images/icons/carburant.png")}}" style="width:35px;" alt=""></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Carburant restant</span>
                            <p class="info-box-number voir-camion-statistique ">{{nombre_fr($stock_carburant)}}L</p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->

                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fa fa-road"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Trajet en cours</span>
                            <p class="info-box-number voir-camion-statistique">
                                @if ($camion->dernierTrajet(true) !== null)
                                {{ $camion->dernierTrajet(true)->nomItineraire() }}
                                @else
                                Aucun
                                @endif
                            </p>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-lg-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning" style="background-color: #ff9609 !important;"><img src="{{asset('assets/images/icons/assurance.png')}}" style="width:55px;" alt=""></span>
                        <div class="info-box-content" >
                            <span class="info-box-text">Assurance</span>
                            <p class="info-box-number voir-camion-statistique" >
                                {{isset($assurance[0]->date_echeance) === true ? date("d/m/Y",strtotime($assurance[0]->date_echeance)) : "Aucune"}}
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
        </div>


    </div>

    <div class="row">
        <div class="col-sm-12 px-3">
            <div class="card">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === false || $tab == 1 ) ? 'active' : '' }} " id="nav-carburant-tab" data-toggle="tab" href="#nav-carburant" role="tab" aria-controls="nav-carburant" aria-selected="true">Carburants</a>
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === true && intval($tab) === 2 ) ? 'active' : ''}} " id="nav-trajet-tab" data-toggle="tab" href="#nav-trajet" role="tab" aria-controls="nav-trajet" aria-selected="false">Trajets</a>
                        <a style="color:#023047 !important;" class="nav-item nav-link {{ ( isset($tab) === true && intval($tab) === 3 ) ? 'active' : ''}} " id="nav-papier-tab" data-toggle="tab" href="#nav-papier" role="tab" aria-controls="nav-papier" aria-selected="false">Papier</a>

                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show {{( isset($tab) === false || $tab == 1 ) ? ' show active ' : '' }}" id="nav-carburant" role="tabpanel" aria-labelledby="nav-carburant-tab">
                        @include('Camion.carburant')
                    </div>

                    {{-- Pour les trajets --}}
                    <div class="tab-pane fade {{ ( isset($tab) === true && intval($tab) === 2 ) ? ' show active ' : ''}} " id="nav-trajet" role="tabpanel" aria-labelledby="nav-trajet-tab">
                        @include('Camion.trajet')
                    </div>
                    <div class="tab-pane fade {{( isset($tab) === true && $tab == 3 ) ? ' show active ' : '' }}" id="nav-papier" role="tabpanel" aria-labelledby="nav-papier-tab">
                        @include('Camion.papier')
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


@include('Camion.modal')

<!-- page script -->
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

    // Remorques

    $("#ajout-trajet-remorque , #modification-trajet-remorque").select2({
        placeholder: "Remorque",
        allowClear: true
    })

 
    
    $(document).on("click", "#btn-modal-trajet", function(e){
        setTimeout(function(){

            $.get("{{route('remorque.dernier', ['camion' => $camion->id])}}", {}, dataType = "JSON").done(function(data){

                $("#ajout-trajet-remorque").val(data);
                $("#ajout-trajet-remorque").change();
            })
        }, 900)
    })

    // Limitation de nombre de lettre sur les statistique

    $(".voir-camion-statistique").each(function(value){
        let text = $(this).html().trim();
        $(this).html(etc(text, 25))
    })

    // Limitation de nombre de lettre sur les statistique

    var nb_itineraire_formulaire = 0;

    // Pour multiplier le nombre de champ pour ajouter un itinéraire
    $(document).on("click", ".btn-itineraire-plus" , function(e){
        _this = $(this).parent().parent().parent();
        nb_itineraire_formulaire = _this.find("#itineraire_formulaire .row").length + 1;
        console.log($('#itineraire_formulaire_added-'+nb_itineraire_formulaire));

        if(nb_itineraire_formulaire > 1){
            $(".btn-itineraire-moins").show(100);
        }
        let itineraire_formulaire = _this.find("#itineraire_formulaire").find(".row:first").html();

        _this.find("#itineraire_formulaire")
        .append("<div id='itineraire_formulaire_added-"+
        nb_itineraire_formulaire+"' class='row added'>"+itineraire_formulaire
        +"</div>").find(".row:last input").val("");

        
    })


    // Pour enlever le nombre de champ pour ajouter un itinéraire
    $(document).on("click", ".btn-itineraire-moins" , function(e){
        _this = $(this).parent().parent().parent();
        nb_itineraire_formulaire = _this.find("#itineraire_formulaire .row").length;
        console.log($('#itineraire_formulaire_added-'+nb_itineraire_formulaire));
        _this.find('#itineraire_formulaire_added-'+nb_itineraire_formulaire).remove();

        if(nb_itineraire_formulaire < 3){
            $(".btn-itineraire-moins").hide(100);
        }

        let data_itineraire = [];
        _this.find("#itineraire_formulaire .row").each(function(){

                let nom_itineraire = $(this).find("input:first").val();
                
                if(nom_itineraire != ''){
                    data_itineraire.push({
                        nom : nom_itineraire
                    });
                }

            })

        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })

    $(document).on("blur", "#content-itineraire input" , function(e){
        //Récuperation des données relative au salarié avant de l'ajouter dans un input de type hidden(caché) pour pouvoir l'envoyer en post sous format json
        let data_itineraire = [];

        _this = $(this).parent().parent().parent().parent();
        _this.find('#itineraire_formulaire .row').each(function(){

            let nom_itineraire = $(this).find("input:first").val();
             
            if(nom_itineraire != ''){
                data_itineraire.push({
                    nom : nom_itineraire
                });
            }
        })
        //document.getElementById('content-itineraire').firstElementChild.value = JSON.stringify(data_itineraire)
        _this.parent().parent().parent().find(".itineraire_data").val(JSON.stringify(data_itineraire));
    })

    $("#flux-carburants , #trajets , #papiers ").DataTable({
        "responsive": true,
        "autoWidth": false,
        "searching": true,
        "paging": false,
        "ordering": true,
        "info": false ,            
        language: { url: "{{asset('assets/json/json_fr_fr.json')}}" }
    });

    $(document).on("click", ".modifier-carburant", function(){

        let url = $(this).attr("data-show-url");
        let url_update = $(this).attr("data-url")

        $("#modal-modifier-carburant").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#form-modifier-carburant").attr("action", url_update);

        $.get(url, {}, dataType="JSON").done(function (data) {
            $("#modal-modifier-carburant #modifier_date").val(data.date);
            $("#modal-modifier-carburant #modifier_quantite").val(data.quantite);
            $("#modal-modifier-carburant input[name=prix]").val(data.prix);
            $("#modal-modifier-carburant #modifier_flux").val(data.flux).attr("readonly", "readonly").change();

        })
    })

    $(document).on("click", ".supprimer-carburant", function (e) {
        let url = $(this).prev().attr("data-show-url");
        let url_delete = $(this).attr("data-url");

        $("#button-supprimer-carburant").parent().attr("href", url_delete);

        $("#modal-supprimer-carburant").modal({
            backdrop: 'static',
            keyboard: false
        });

        $.get(url, {}, dataType="JSON").done(function (data) {

            $("#modal-supprimer-carburant #supprimer_date").val(data.date).attr("disabled", true);
            $("#modal-supprimer-carburant #supprimer_quantite").val(data.quantite).attr("disabled", true);
            $("#modal-supprimer-carburant input[name=prix]").val(data.prix).attr("disabled", true);
            $("#modal-supprimer-carburant #supprimer_flux").val(data.flux).change().attr("disabled", true);

        })

    })
   

    $(document).on("click","#nav-trajet-tab", function(){

            resizeDataTable($("#trajets"), $("#nav-trajet")) ;
    })

    $(document).on("click","#nav-carburant-tab", function(){

            resizeDataTable($("#flux-carburants"), $("#nav-carburant")) ;
    })

    $(document).on("click","#nav-papier-tab", function(){

            resizeDataTable($("#papiers"), $("#nav-papier")) ;

    })

    $(document).on("click", ".modifier-trajet", function(){
        let url = $(this).attr("data-show-url");
        let url_update = $(this).attr("data-update-url")
        viderFormulaireAjoutTrajet($("#form-modifier-trajet"));
        $("#modal-modifier-trajet").modal({
            backdrop: 'static',
            keyboard: false
        });

        $("#form-modifier-trajet").attr("action", url_update);

        $.get(url, {}, dataType="JSON").done(function (data) {

            let lists = document.getElementById('list-itineraire')
            let itineraires =  data.itineraires.sort( (teamA, teamB) => teamA.id - teamB.id  );

            $("#form-modifier-trajet").find("input[name=poids]").val(data.trajet.poids);
            $("#form-modifier-trajet").find(".added").remove();

            let remorques = [];

            data.remorque.forEach(function(value){
                remorques.push(value.remorque_id)
            })


            $("#modification-trajet-remorque").val(remorques);
            $("#modification-trajet-remorque").change();
            
            itineraires.forEach((itineraire, index) => {
                let element = "";
                if(index === 0){
                    element = '<div class="row added"><div class="col-sm-12" style="padding-top:1%;"><input type="text" placeholder="Nom de l\'itinéraire" class="form-control" value="' + itineraire.nom + '" required></div></div>'

                }else{
                    element = '<div id="itineraire_formulaire_added-'+(index + 1 )+'" class="row added" >';
                    element += '    <div class="col-sm-12" style="padding-top:1%;">';
                    element +=      '   <input type="text" placeholder="Nom de l\'itinéraire" class="form-control" value="' + itineraire.nom + '" required="">';
                    element +=  '   </div>';
                    element += '</div>';

                }
                $("#form-modifier-trajet").find("#itineraire_formulaire").append(element);

            })

            if(itineraires.length >  1){
                $("#form-modifier-trajet .btn-itineraire-moins").show(100);
            }

            $("#modal-modifier-trajet #data-itineraire").val(JSON.stringify(data.itineraires));
            $("#modal-modifier-trajet #modifier-chauffeur").val(data.trajet.chauffeur_id);
            $("#modal-modifier-trajet #modifier_date_heure_depart").val(data.trajet.date_heure_depart);
            $("#modal-modifier-trajet #modifier_date_heure_arrivee").val(data.trajet.date_heure_arrivee);
            $("#modal-modifier-trajet #modifier-etat").val(data.trajet.etat);
            $("#modal-modifier-trajet input[name=chargement]").val(data.trajet.chargement);
            $("#modal-modifier-trajet input[name=bon]").val(data.trajet.bon);
            $("#modal-modifier-trajet input[name=bon_enlevement]").val(data.trajet.bon_enlevement);
            $("#modifier-etat").change();

            if(data.reservation != null){
                $("#modal-modifier-trajet #modifier_date_heure_depart").attr("readonly", "readonly");
                $("#modal-modifier-trajet #content-itineraire input").attr("readonly", "readonly");
                $("#modal-modifier-trajet .btn-itineraire-plus , #modal-modifier-trajet .btn-itineraire-moins").attr("disabled", true);
            }else{
                $("#modal-modifier-trajet #modifier_date_heure_depart").removeAttr("readonly");
                $("#modal-modifier-trajet #content-itineraire input").removeAttr("readonly");
                $("#modal-modifier-trajet .btn-itineraire-plus , #modal-modifier-trajet .btn-itineraire-moins").removeAttr("disabled");
            }

            if($("#modifier-etat option:selected").val() == '{{ App\Models\Trajet::getEtat(1) }}'){
                $("#modal-modifier-trajet #carburant-restant").val(data.trajet.carburant_depart);

            }else if ($("#modifier-etat option:selected").val() == '{{ App\Models\Trajet::getEtat(2) }}'){
                $("#modal-modifier-trajet #carburant-restant").val(data.trajet.carburant_depart - data.trajet.carburant_total);
            }

        })
    })

    $(document).on("click", ".voir-trajet", function (e) {
        
        $(this).next().next().trigger("click");
        $("#modal-supprimer-trajet").find(".modal-header").removeClass("modal-header-danger").find("h4").html("Voir un trajet");
        $("#button-supprimer-trajet").parent().hide();
    })

    $(document).on("click", ".supprimer-trajet", function (e) {
        $("#modal-supprimer-trajet").find(".modal-header").addClass("modal-header-danger").find("h4").html("Supprimer un trajet");
        $("#button-supprimer-trajet").parent().show();

        let url = $(this).prev().attr("data-show-url");
        let url_delete = $(this).attr("data-url");

        $("#button-supprimer-trajet").parent().attr("href", url_delete);

        $("#modal-supprimer-trajet").modal({
            backdrop: 'static',
            keyboard: false
        });

        $.get(url, {}, dataType="JSON").done(function (data) {
            let lists = document.getElementById('list-delete-itineraire')
            let itineraires = data.itineraires
            lists.innerHTML = ''

            itineraires.forEach(itineraire => {
                input = document.createElement('input')
                input.value = itineraire.nom
                input.classList.add('form-control')
                input.classList.add('mb-2')
                input.setAttribute('placeholder', 'Nom de l\'itinéraire')
                input.setAttribute('disabled', true)
                lists.appendChild(input)
            })

            $("#modal-supprimer-trajet #supprimer-chauffeur").html(data.chauffeur.name);
            $("#modal-supprimer-trajet #supprimer_date_heure_depart").val(data.trajet.date_heure_depart);
            $("#modal-supprimer-trajet #supprimer_date_heure_arrivee").val(data.trajet.date_heure_arrivee);
            $("#modal-supprimer-trajet #supprimer-etat").html(data.trajet.etat);
            $("#modal-supprimer-trajet input[name=chargement]").val(data.trajet.chargement);
            $("#modal-supprimer-trajet input[name=bon]").val(data.trajet.bon);
            $("#modal-supprimer-trajet input[name=bon_enlevement]").val(data.trajet.bon_enlevement);

        })

    })

    

    
    $(document).on("click", "#button-ajouter-trajet", function(e){
        let me = $(this);
        spinning(me);

        let data = $("#form-ajouter-trajet").serialize();
        let url = $("#form-ajouter-trajet").attr("action");

        $.ajax({
                url: url,
                type : "post",
                dataType : "JSON",
                data : data ,
                success : function(data){

                    if(data.status == "success"){
                        window.location.href = data.value;
                    }

                    if(data.status == "error"){

                        // reeffacer les alert apres un cas de non success
                        $("#status-feedback").prev().removeClass("is-invalid");
                        $("#status-feedback").html("").hide(300);
                        $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        $("#form-ajouter-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)

                        
                        if
                        (   data.value == "Camion non disponible entre les dates que vous avez selectionnées" ||
                            date.value == "Le camion a encore un trajet en cours" ||
                            data.value == "Vous devez choisir au moins deux itinéraires" ||
                            data.value == "echec d'ajout"  )
                        {
                            $("#form-ajouter-trajet").parent().next().find(".alert").html(data.value);
                            $("#form-ajouter-trajet").parent().next().show(300);
                        }else{
                            $("#form-ajouter-trajet").parent().next().find(".alert").html("");
                            $("#form-ajouter-trajet").parent().next().hide(300);
        
                        }

                        if(data.value == "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" || data.value == "Chauffeur non disponible entre les dates que vous avez selectionné"){
                            $("#chauffeur-feedback").prev().addClass("is-invalid");
                            $("#chauffeur-feedback").html(data.value).show(300);
                        }else{
                            $("#chauffeur-feedback").prev().removeClass("is-invalid");
                            $("#chauffeur-feedback").html("").hide(300);
                        }

                        if
                        (   data.value == "La date de depart doit être supérieur a ce moment précis si le statut est à prévoir" || 
                            data.value == "La date de depart doit être inférieur a la date d'arrivée")
                        {
                            
                            $("#form-ajouter-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html(data.value).show(300)
                        }else{
                            $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        }

                        if
                        (   data.value == "Veuillez remplir la quantité de carburant restant" || 
                            data.value == "Le carburant du véhicule est encore insuffisant" ||
                            data.value == "La quantité de carburant que vous avez saisi est superieur au stock" ||
                            data.value == "La quantité de carburant que vous avez saisi est superieur au stock actuel")
                        {
                            $("#form-ajouter-trajet input[name=carburantRestant]").addClass("is-invalid").next().html(data.value).show(300);
                        }else{
                            $("#form-ajouter-trajet input[name=carburantRestant]").removeClass("is-invalid").next().html("").hide(300);

                        }

                        if(data.value == "Remorque non disponible entre les dates que vous avez selectionnées"){
                            $("#ajouter-remorque-trajet").prev().addClass("is-invalid");
                            $("#ajouter-remorque-trajet").html(data.value).show(300);
                        }else{
                            $("#ajouter-remorque-trajet").prev().removeClass("is-invalid");
                            $("#ajouter-remorque-trajet").html("").hide(300);
                        }

                        

                        

                    }

                    


                    spinning(me, 2);
                },
                error: function (data) {
                        donnee = $.parseJSON(data.responseText);
                      

                        if(donnee.message == "The given data was invalid."){
                           
                            console.log(donnee.errors.etat );

                            if(donnee.errors.hasOwnProperty("bon") === true){
                                $("#form-ajouter-trajet input[name=bon]").addClass("is-invalid");
                                $("#form-ajouter-trajet input[name=bon]").next().html("Le bon est obligatoire pour ce statut et doit contenir au moins un caractère").show(200);
                            }else{
                                $("#form-ajouter-trajet input[name=bon]").removeClass("is-invalid");
                                $("#form-ajouter-trajet input[name=bon]").next().html("").hide();
                            }

                            if(donnee.errors.hasOwnProperty("bon_enlevement") === true){
                                $("#form-ajouter-trajet input[name=bon_enlevement]").addClass("is-invalid");
                                $("#form-ajouter-trajet input[name=bon_enlevement]").next().html("Le bon d'enlevement est obligatoire pour ce statut et doit contenir au moins un caractère").show(200);
                            }else{
                                $("#form-ajouter-trajet input[name=bon_enlevement]").removeClass("is-invalid");
                                $("#form-ajouter-trajet input[name=bon_enlevement]").next().html("").hide();
                            }

                            if(donnee.errors.hasOwnProperty("chargement") === true){
                                $("#form-ajouter-trajet input[name=chargement]").addClass("is-invalid");
                                $("#form-ajouter-trajet input[name=chargement]").next().html("Le chargement doit contenir au moins 3 caractères").show(200);
                            }else{
                                $("#form-ajouter-trajet input[name=chargement]").removeClass("is-invalid");
                                $("#form-ajouter-trajet input[name=chargement]").next().html("").hide();
                            }


                            if(donnee.errors.hasOwnProperty("etat") === true){
                                $("#status-feedback").prev().addClass("is-invalid");
                                $("#status-feedback").html("La date de départ est obligatoire").show(300);
                            }else{
                                $("#status-feedback").prev().removeClass("is-invalid");
                                $("#status-feedback").html("").hide(300);
                            }

                            if(donnee.errors.hasOwnProperty("date_heure_depart") === true ){
                                $("#form-ajouter-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html("La date de départ est obligatoire").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                            }

                            if(donnee.errors.hasOwnProperty("date_heure_arrivee") === true ){
                                $("#form-ajouter-trajet input[name=date_heure_arrivee]").addClass("is-invalid").next().next().html("La date d'arrivée approximative est obligatoire").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)
                            }

                            if(donnee.errors.hasOwnProperty("poids") === true ){
                                
                                $("#form-ajouter-trajet input[name=poids]").addClass("is-invalid").next().html("Le poids doit être supérieur à zéro").show(300)
                                
                            }else{
                                    $("#form-ajouter-trajet input[name=poids]").removeClass("is-invalid").next().html("").hide(300)
                            }

                            if(donnee.errors.hasOwnProperty("remorque") === true){
                                $("#ajouter-remorque-trajet").prev().addClass("is-invalid");
                                $("#ajouter-remorque-trajet").html("Le remorque est obligatoire").show(300);
                            }else{
                                $("#ajouter-remorque-trajet").prev().removeClass("is-invalid");
                                $("#ajouter-remorque-trajet").html("").hide(300);
                            }
                        }
                        spinning(me, 2);
                    }
                }
            )
        
    });

    $(document).on("click", "#button-modifier-trajet", function(e){
        let me = $(this);
        spinning(me);

        let data = $("#form-modifier-trajet").serialize();
        let url = $("#form-modifier-trajet").attr("action");

        $.ajax({
            url : url,
            type : "POST",
            dataType : "JSON",
            data : data,
            success : function (data) {

                if(data.status == "success"){
                        window.location.href = data.value;
                }

                if(data.status == "error"){
                    if
                    (   data.value == "Camion non disponible entre les dates que vous avez selectionnées" ||
                        date.value == "Le camion a encore un trajet en cours" ||
                        data.value == "Vous devez choisir au moins deux itinéraires" ||
                        data.value == "Erreur de mise a jour" ||
                        data.value == "Le camion a encore un trajet en cours" )
                    {
                        $("#form-modifier-trajet").parent().next().find(".alert").html(data.value);
                        $("#form-modifier-trajet").parent().next().show(300);
                    }else{
                        $("#form-modifier-trajet").parent().next().find(".alert").html("");
                        $("#form-modifier-trajet").parent().next().hide(300);
        
                    }

                    if(
                        data.value == "Vous devez selectionner au moins un chauffeur pour un trajet a prévoir" || 
                        data.value == "Chauffeur non disponible entre les dates que vous avez selectionné"
                    ){
                            $("#chauffeur-modifier-feedback").prev().addClass("is-invalid");
                            $("#chauffeur-modifier-feedback").html(data.value).show(300);
                    }else{
                            $("#chauffeur-modifier-feedback").prev().removeClass("is-invalid");
                            $("#chauffeur-modifier-feedback").html("").hide(300);
                    }

                    if( data.value == "On ne peut pas terminer un trajet a prévoir sans être en cours" ){

                        $("#status-modifier-feedback").prev().addClass("is-invalid");
                        $("#status-modifier-feedback").html(data.value).show(300);
                    }else{

                        $("#status-modifier-feedback").prev().removeClass("is-invalid");
                        $("#status-modifier-feedback").html("").hide(300);
                    }

                    if
                        (   data.value == "La date depart ne doit pas depasser la date et heure actuel" ||
                            data.value == "Vous devez specifier une date d'arrivée." ||
                            data.value == "La date de depart doit être inférieur a la date d'arrivée"
                            )
                        {
                            
                            $("#form-modifier-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html(data.value).show(300)
                        }else{
                            $("#form-modifier-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                        }


                    if
                    (   data.value == "Veuillez remplir la quantité de carburant restant" || 
                        data.value == "Le carburant du véhicule est encore insuffisant" ||
                        data.value == "La quantité de carburant que vous avez saisi est superieur au stock")
                    {
                        $("#form-modifier-trajet input[name=carburantRestant]").addClass("is-invalid").next().html(data.value).show(300);
                    }else{
                        $("#form-modifier-trajet input[name=carburantRestant]").removeClass("is-invalid").next().html("").hide(300);

                    }

                    if(data.value == "Remorque non disponible entre les dates que vous avez selectionnées"){
                            $("#modifier-remorque-trajet").prev().addClass("is-invalid");
                            $("#modifier-remorque-trajet").html(data.value).show(300);
                    }else{
                            $("#modifier-remorque-trajet").prev().removeClass("is-invalid");
                            $("#modifier-remorque-trajet").html("").hide(300);
                    }

                }

                spinning(me, 2);
            },
            error : function (data){

                donnee = $.parseJSON(data.responseText);

                if(donnee.errors.hasOwnProperty("bon") === true){
                    $("#form-modifier-trajet input[name=bon]").addClass("is-invalid");
                    $("#form-modifier-trajet input[name=bon]").next().html("Le bon est obligatoire pour ce statut et doit contenir au moins un caractère").show(200);
                }else{
                    $("#form-modifier-trajet input[name=bon]").removeClass("is-invalid");
                    $("#form-modifier-trajet input[name=bon]").next().html("").hide();
                }

                if(donnee.errors.hasOwnProperty("bon_enlevement") === true){
                    $("#form-modifier-trajet input[name=bon_enlevement]").addClass("is-invalid");
                    $("#form-modifier-trajet input[name=bon_enlevement]").next().html("Le bon d'enlevement est obligatoire pour ce statut et doit contenir au moin un caractère").show(200);
                }else{
                    $("#form-modifier-trajet input[name=bon_enlevement]").removeClass("is-invalid");
                    $("#form-modifier-trajet input[name=bon_enlevement]").next().html("").hide();
                }


                if(donnee.errors.hasOwnProperty("chargement") === true){
                    $("#form-modifier-trajet input[name=chargement]").addClass("is-invalid");
                    $("#form-modifier-trajet input[name=chargement]").next().html("Le chargement doit contenir au moins 3 caractères").show(200);
                }else{
                    $("#form-modifier-trajet input[name=chargement]").removeClass("is-invalid");
                    $("#form-modifier-trajet input[name=chargement]").next().html("").hide();
                }

                if(donnee.errors.hasOwnProperty("date_heure_depart") === true ){
                    $("#form-modifier-trajet input[name=date_heure_depart]").addClass("is-invalid").next().next().html("La date de départ est obligatoire").show(300)
                                
                }else{
                    $("#form-modifier-trajet input[name=date_heure_depart]").removeClass("is-invalid").next().next().html("").hide(300)
                }

                if(donnee.errors.hasOwnProperty("date_heure_arrivee") === true ){
                    $("#form-modifier-trajet input[name=date_heure_arrivee]").addClass("is-invalid").next().next().html("La date d'arrivée approximative est obligatoire").show(300)
                                
                }else{
                    $("#form-modifier-trajet input[name=date_heure_arrivee]").removeClass("is-invalid").next().next().html("").hide(300)
                }

                if(donnee.errors.hasOwnProperty("etat") === true){
                    $("#status-modifier-feedback").prev().addClass("is-invalid");
                    $("#status-modifier-feedback").html("la date de départ est obligatoire").show(300);
                }else{
                    $("#status-modifier-feedback").prev().removeClass("is-invalid");
                    $("#status-modifier-feedback").html("").hide(300);
                }

                if(donnee.errors.hasOwnProperty("poids") === true ){
                    $("#form-modifier-trajet input[name=poids]").addClass("is-invalid").next().html("Le poids doit être supérieur à zéro").show(300)
                                
                }else{
                        $("#form-modifier-trajet input[name=poids]").removeClass("is-invalid").next().html("").hide(300)
                }

                if(donnee.errors.hasOwnProperty("remorque") === true){
                                $("#modifier-remorque-trajet").prev().addClass("is-invalid");
                                $("#modifier-remorque-trajet").html("Le remorque est obligatoire").show(300);
                            }else{
                                $("#modifier-remorque-trajet").prev().removeClass("is-invalid");
                                $("#modifier-remorque-trajet").html("").hide(300);
                            }

                spinning(me, 2);
            }

        })
    })

    $(document).on("click", "#btn-modal-trajet", function(e){
        viderFormulaireAjoutTrajet($("#form-ajouter-trajet"));
    })


    const checkCarburant = function (select, action) {

        action = action === undefined ? "#modal-trajet" : action ;

        let etat = select.value
        let carburant = $(action + " .carburant") 
        let poids = $(action + " .poids-content")
        let bon_enlevement = $(action + " .bon_enlevement");


        if (etat == '{{ App\Models\Trajet::getEtat(2) }}'|| etat == '{{ App\Models\Trajet::getEtat(1) }}' ) {
            carburant.show(200).find("input").val("");
            poids.show(200);

            if(etat == '{{ App\Models\Trajet::getEtat(2) }}' ){
                bon_enlevement.show(200)
            }else{
                bon_enlevement.hide(200);
            }

        } else {

            carburant.hide(200).find("input").val("");
            poids.hide(200);
            bon_enlevement.hide(200);
        }
    }

   


    // -------------------- EVENEMENT LIEE AU PAPIER ------------------------ //
  
    $(document).on("click", ".btn-papier-supprimer", function(e){
        let url = $(this).attr("data-show");
        let url_delete = $(this).attr("data-url");

        //$("#modal-supprimer-papier").find("form").attr("action", url_update);
        $("#button-supprimer-papier").parent().attr("href", url_delete);
        $.get(url, {}, dataType = "JSON").done(function (data) {

            $("#modal-supprimer-papier").modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#modal-supprimer-papier").find("input[name=designation]").val(data.designation);
            $("#modal-supprimer-papier").find("input[name=date_obtention]").val(data.date);
            $("#modal-supprimer-papier").find("input[name=date_echeance]").val(data.date_echeance);
            $("#modal-supprimer-papier").find("select[name=type]").val(data.type).change();
           
            
        });
    })

    $(document).on("click", ".btn-papier-modifier", function(e){
        let url = $(this).attr("data-show");
        let url_update = $(this).attr("data-url");

        $("#modal-modifier-papier").find("form").attr("action", url_update);
        viderFormulaireAjouterPapier($("#modal-modifier-papier"));
        $.get(url, {}, dataType = "JSON").done(function (data) {

            $("#modal-modifier-papier").modal({
                backdrop: 'static',
                keyboard: false
            });

            $("#modal-modifier-papier").find("input[name=designation]").val(data.designation);
            $("#modal-modifier-papier").find("input[name=date_obtention]").val(data.date);
            $("#modal-modifier-papier").find("input[name=date_echeance]").val(data.date_echeance);
            $("#modal-modifier-papier").find("select[name=type]").val(data.type).change();
           
            
        });
    });

    $(document).on("click", "#btn-modal-papier", function(e){
        viderFormulaireAjouterPapier($("#modal-ajouter-papier"));
    });

    $(document).on("click", "#button-ajouter-papier , #button-modifier-papier", function(e){
        let button = $(this);
        spinning(button);

        let me = button.parent().parent().find("form")

        let url = me.attr("action");
        let id_form =  me.attr("id");
        let data = new FormData(document.getElementById(id_form));

        $.ajax({
            url : url,
            type : "POST",
            dataType : "JSON",
            data : data,
            contentType: false,
            processData: false,
            error : function (data) {
                let donnees = $.parseJSON(data.responseText);
                name_list = Object.keys(donnees.errors);
                

                me.find(".form-control").each(function (value, index) {
                    let name = $(this).attr("name");
                    if(donnees.errors.hasOwnProperty(name)){                        
                        me.find("input[name="+name+"] , select[name="+name+"]").addClass("is-invalid")
                        .parent().find(".invalid-feedback").html(donnees.errors[name][0]).show(300);
                        
                        if(name == "photo"){
                            me.find(".photo-feedback").html(donnees.errors[name][0]).show(300);
                        }
                    }else if(name_list.indexOf(name) == -1){
                        $(this).removeClass("is-invalid").parent().find(".invalid-feedback").html("").hide();

                        if(name == "photo"){
                            me.find(".photo-feedback").html("").hide();
                        }
                    }
                })

                spinning(button, 2);
            },
            success : function (data) {
                spinning(button, 2);
                if(data.status == "success"){
                    window.location.href = data.value;
                }
            }
        });
    });

    // -------------------- EVENEMENT LIEE AU PAPIER ------------------------ //

    function resizeDataTable(element , content) {

            setTimeout(function(){
               let classes = content.attr("class").split(" ");
               console.log(classes, jQuery.inArray("active", classes), jQuery.inArray("show", classes) !== -1);
               if(jQuery.inArray("active", classes) !== -1 && jQuery.inArray("show", classes) !== -1 ){
                   let  table = element.DataTable();
                   table.columns.adjust().draw();
               }else{
                    resizeDataTable(element, content)
               }
           }, 200);
    }

    function viderFormulaireAjoutTrajet(me){
        me.find(" .mb-3 input").val("").removeClass("is-invalid");
        me.find(" select").val("").removeClass("is-invalid").change();
        me.find(" .invalid-feedback").html("").hide();
        me.parent().next().find(".alert").html("");
        me.parent().next().hide(200);
    }

    function viderFormulaireAjouterPapier(me){
        me.find(" input[type!='hidden'] , #form-ajouter-papier select").val("").removeClass("is-invalid");
        me.find(".invalid-feedback").html("").hide();
    }




    


</script>

@endsection
