
<style>
    .has-treeview > .active{
        background-color: #3490c1 !important;
    }
    @media screen and (min-width: 576px) {
          #tableau_bord {
            display: none !important;
          }
    }
</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #023047">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
        <img src="{{asset('assets/images/logo/logo-tsaravidy.jpg')}}" alt="Tsaravidy Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }} V1.0</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar" >
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('assets/images/avatars/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->name}}</a>
            </div>
        </div>
        <div class="user-panel  d-flex" id="tableau_bord" style="">
            <a style="@if(isset($active_dashboard_index))  color:white !important; @endif" href="" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard</a>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item has-treeview @if(isset($active_camion_index)) menu-open @endif">
                    <a href="{{route('camion.liste')}}" class="nav-link @if(isset($active_camion_index)) {{$active_camion_index}} @endif">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Camions
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview @if(isset($active_chauffeur_index)) menu-open @endif">
                    <a href="{{route('chauffeur.liste')}}" class="nav-link @if(isset($active_chauffeur_index)) {{$active_chauffeur_index}} @endif">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                            Chauffeurs
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                </li>


                <li class="nav-item has-treeview @if(isset($active_depense_index)) menu-open @endif">
                    <a href="" class="nav-link @if(isset($active_depense_index)) {{$active_depense_index}} @endif">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Depenses
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview @if(isset($active_maintenance_index)) menu-open @endif">
                    <a href="" class="nav-link @if(isset($active_maintenance_index)) {{$active_maintenance_index}} @endif">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Maintenances
                            {{--<i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                </li>

               @can("viewAny" ,auth()->user())
                <li class="nav-item has-treeview @if(isset($active_parametre_index) || isset($active_utilisateur) ) menu-open @endif">
                    <a href="#" class="nav-link @if(isset($active_parametre_index)|| isset($active_utilisateur) ) active @endif">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Paramètre
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('utilisateur.liste')}}" class="nav-link @if(isset($active_parametre_index)) {{$active_parametre_index}} @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Utilisateurs</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
