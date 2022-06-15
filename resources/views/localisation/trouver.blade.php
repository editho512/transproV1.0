@extends('main')

@section('title') <title>Localisation des camions</title> @endsection

@section('content')

<div class="content-wrapper teste" style="min-height: inherit!important;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Trouver un camion</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row" >
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Localisation</h3>
                                <a href="{{route('localisation.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left mr-2"></i>Retour</a>
                            </div>
                        </div>

                        <div class="card-body" >
                            <div class="row">
                               <div class="col-sm-12">
                                    @if ($camion->gps != "" && $camion->gps != null)
                                        @switch($camion->gps)
                                            @case("Dago-it")  
                                                @php
                                                    $su = json_decode($camion->gps_content);
                                                   
                                                @endphp  
                                                @if (isset($su->su) === true)
                                                    <div class="row mb-4">
                                                        <div class="col-sm-2">
                                                            <label for="lien">Lien à partager : </label>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" id="input-lien-gps" style="height: 50px !important;" value="{{'https://tracking.dago-it.com/mod/share/index.php?su='.$su->su.'&m=true'}}">
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button class="btn btn-default" id="btn-copier-lien"  onclick="copier()" style="height: 50px !important;">Copiez</button>
                                                        </div>
                                                    </div>
                                                    <iframe src="{{'https://tracking.dago-it.com/mod/share/index.php?su='.$su->su.'&m=true'}}" frameborder="0"     width="100%" height="400px" ></iframe>
                                                @else
                                                    <p class="alert alert-danger text-center">
                                                        Problème de connexion au gps    
                                                    </p> 
                                                @endif                                            
                                                @break
                                           
                                            @default
                                                
                                        @endswitch
                                    @else
                                        <p class="alert alert-danger text-center">
                                            Ce camion n'a pas de gps
                                        </p>
                                    @endif
                                </div>

                            </div>

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
</div>

@endsection

@section('scripts')
<script>
    function copier() {
    /* Get the text field */
    var copyText = document.getElementById("input-lien-gps");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    navigator.clipboard.writeText(copyText.value);

    document.getElementById("btn-copier-lien").classList.remove("btn-default");
    document.getElementById("btn-copier-lien").classList.add("btn-outline-success");
   
}
</script>
@endsection
