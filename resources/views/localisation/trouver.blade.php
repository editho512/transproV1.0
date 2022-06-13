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
                                   <iframe src="https://tracking.dago-it.com/mod/share/index.php?su=5B3F001E289F4A9FE6563FF466A30D16&m=true" frameborder="0"     width="100%" height="400px" ></iframe>
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
@endsection
