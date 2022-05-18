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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Localisation</h3>
                                <a href="{{route('localisation.index')}}" class="btn btn-primary"><i class="fa fa-arrow-left mr-2"></i>Retour</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="row">
                               <div class="col-sm-12">
                                    <div id="map"></div>                               
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

<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAeKHX66emRCkc6dtuPSMkQnej6H2xiTeY&callback=initMap&v=weekly"
defer
></script>

<script>
    // Initialize and add the map
function initMap() {
  // The location of Uluru
  const uluru = { lat: -25.344, lng: 131.031 };
  // The map, centered at Uluru
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 4,
    center: uluru,
  });
  // The marker, positioned at Uluru
  const marker = new google.maps.Marker({
    position: uluru,
    map: map,
  });
}

window.initMap = initMap;

</script>

@endsection
