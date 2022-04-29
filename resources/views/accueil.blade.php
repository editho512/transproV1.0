<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Accueil</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/vendor/bootstrap/css/bootstrap.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/fonts/iconic/css/material-design-iconic-font.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/vendor/animate/animate.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/vendor/select2/select2.min.css')}}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/accueil/css/main.css')}}">
    <style>
        .wrappic1 img {
            max-width: 10%;
        }
    </style>
    <!--===============================================================================================-->
</head>
<body>



<div class="flex-w flex-str size1 overlay1">
    <div class="flex-w flex-col-sb wsize1 bg0 p-l-65 p-t-37 p-b-50 p-r-80 respon1">
        <div class="wrappic1">
            <a href="#">
                <img src="{{asset('assets/images/logo/logo-tsaravidy.jpg')}}" alt="IMG">
            </a>
        </div>

        <div class="w-full flex-c-m p-t-80 p-b-90">
            <div class="wsize2">
                <h3 class="l1-txt1 p-b-34 respon3">
                    {{ config('app.name') }}
                </h3>

                @if (Route::has('login'))
                    @auth

                        @if (isset($getRole) === true && $getRole === false)
                            <form class="contact100-form m-t-10 m-b-10" action="{{route('logout')}}" method="POST" id="deconnexion">
                                @csrf
                                <div class="wrap-input100 m-lr-auto-lg" >
                                    <button type="submit" form="deconnexion" class="s2-txt1 placeholder0 input100 trans-04" style="color: #40A8DF"><strong style="font-size: large">Deconnexion</strong></button>

                                    <button type="submit" form="deconnexion" class="flex-c-m ab-t-r size2 hov1">
                                        <i class="zmdi zmdi-long-arrow-right fs-30 cl1 trans-04"></i>
                                    </button>
                                </div>
                            </form>
                        @else

                            {{-- Masquer le texte d'acceder u dashboard si l'utilisateur n'a pas de type --}}
                            @can('acceder-dashboard')
                                <form class="contact100-form m-t-10 m-b-10" action="{{route('home')}}" method="GET" id="dashboard">
                                    <div class="wrap-input100 m-lr-auto-lg" >
                                        <button type="submit" form="dashboard" class="s2-txt1 placeholder0 input100 trans-04" style="color: #40A8DF"><strong style="font-size: large">Dashboard</strong></button>

                                        <button type="submit" form="dashboard" class="flex-c-m ab-t-r size2 hov1">
                                            <i class="zmdi zmdi-long-arrow-right fs-30 cl1 trans-04"></i>
                                        </button>
                                    </div>
                                </form>
                            @endcan

                            @cannot('acceder-dashboard')
                            <form class="contact100-form m-t-10 m-b-10" action="{{route('logout')}}" method="POST" id="deconnexion">
                                @csrf
                                <div class="wrap-input100 m-lr-auto-lg" >
                                    <button type="submit" form="deconnexion" class="s2-txt1 placeholder0 input100 trans-04" style="color: #40A8DF"><strong style="font-size: large">Deconnexion</strong></button>

                                    <button type="submit" form="deconnexion" class="flex-c-m ab-t-r size2 hov1">
                                        <i class="zmdi zmdi-long-arrow-right fs-30 cl1 trans-04"></i>
                                    </button>
                                </div>
                            </form>
                            @endcannot

                        @endif

                    @else

                        <form class="contact100-form m-t-10 m-b-10" action="{{route('login')}}" method="GET" id="login">
                            <div class="wrap-input100 m-lr-auto-lg" >
                                <button type="submit" form="login" class="s2-txt1 placeholder0 input100 trans-04" style="color: #40A8DF"><strong style="font-size: large">Connexion</strong></button>

                                <button type="submit" form="login" class="flex-c-m ab-t-r size2 hov1">
                                    <i class="zmdi zmdi-long-arrow-right fs-30 cl1 trans-04"></i>
                                </button>
                            </div>
                        </form>


                    @endauth
                 @endif

            </div>
        </div>
    </div>

</div>





<!--===============================================================================================-->
<script src="{{asset('assets/accueil/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/accueil/vendor/bootstrap/js/popper.js')}}"></script>
<script src="{{asset('assets/accueil/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/accueil/vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/accueil/vendor/tilt/tilt.jquery.min.js')}}"></script>
<!--===============================================================================================-->
<script src="{{asset('assets/accueil/js/main.js')}}"></script>

</body>
</html>
