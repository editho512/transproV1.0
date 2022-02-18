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

    <title>Connexion</title>
</head>
<body>



    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <!-- <div class="col-md-6 order-md-2">
                    <img src="images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
                </div> -->
                <div class="col-md-6 contents">
                    {{-- Message d'erreurs --}}
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="form-block">
                                <div class="mb-4">
                                    <h3>Connexion sur <strong>{{ config('app.name') }}</strong></h3>
                                </div>
                                <form action="{{ route('login') }}" method="post">
                                    @csrf
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

                                    <div class="d-flex mb-5 align-items-center">
                                        <label class="control control--checkbox mb-0"><span class="caption">Se souvenir de moi</span>
                                            <input type="checkbox" checked="checked"/>
                                            <div class="control__indicator"></div>
                                        </label>
                                        <span class="ml-auto"><a href="#" class="forgot-pass d-none">Mot de passe publié ?</a></span>
                                    </div>

                                    <input type="submit" value="Connexion" class="btn btn-pill text-white btn-block btn-dark">

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
