<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}"/>

    <link rel="stylesheet" href="{{asset('assets/login/fonts/icomoon/style.css')}}">

    <link rel="stylesheet" href="{{asset('assets/login/css/owl.carousel.min.css')}}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/login/css/bootstrap.min.css')}}">

    <!-- Style -->
    <link rel="stylesheet" href="{{asset('assets/login/css/style.css')}}">

    <title>Inscription</title>
</head>
<body>



<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <!-- <div class="col-md-6 order-md-2">
              <img src="images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
            </div> -->
            <div class="col-md-6 contents">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="form-block">
                            <div class="mb-4">
                                <h3>Inscription sur <strong>{{ config('app.name') }}</strong></h3>
                            </div>
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="form-group first">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                                <div class="form-group first">
                                    <label for="username">Email</label>
                                    <input type="text" class="form-control" id="username" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group last mb-4">
                                    <label for="password">Confirmer mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password_confirmation">
                                </div>

                                <div class="d-flex mb-5 align-items-center">
                                    <label class="control control--checkbox mb-0"><span class="caption">Se souvenir de moi</span>
                                        <input type="checkbox" checked="checked"/>
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>

                                <input type="submit" value="S'inscrire" class="btn btn-pill text-white btn-block btn-dark">

                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<script src="{{asset('assets/login/js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('assets/login/js/popper.min.js')}}"></script>
<script src="{{asset('assets/login/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/login/js/main.js')}}"></script>
</body>
</html>
