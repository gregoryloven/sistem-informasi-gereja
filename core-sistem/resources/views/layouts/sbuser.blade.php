<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
    @yield('title')
    </title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Custom fonts for this template-->
    <link href="{{ asset('layout/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('layout/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    @yield('javascript')
    @yield('customstyle')
    @stack('css')
    <style>
        body {
            font-family: "Nunito" !important;
        }

        .container {
            max-width: 1020px;
        }

        .bg-primary {
            background-color: #4a70dc !important;
            color: #FFF;
        }

        .carousel-item img {
            height: 500px;
            object-fit: cover;
        }

        nav {
            border-bottom: 2px solid #E0E0E0;
        }
    </style>
    @stack('css2')
    
</head>

<body id="page-top">

    <!-- Page Container -->
    <div class="container shadow-sm p-0">
        <!-- Page Wrapper -->
        <div class="shadow-lg" id="wrapper">

            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg">
                <!-- <a href="#">
                    <img src="https://i.ibb.co/BC1YQDt/cropped-katedral-logo.png" alt="cropped-katedral-logo" width="100" border="0">
                </a>     -->
                @if(\Spatie\Multitenancy\Models\Tenant::checkCurrent())
                <h3>{{app('currentTenant')->name}}</h3>
                @endif
            
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                    </ul>
                    <span class="navbar-text">
                        <ul class="navbar-nav mr-auto">
                            @if (Route::has('login'))
                                @auth
                                    <li class="nav-item">
                                        <div class="dropdown dropleft">
                                            <a class="nav-link"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                {{ucwords(Auth::user()->name)}}
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ url('/dashboard') }}">Dashboard</a>
                                                <a class="dropdown-item" href="{{ url('/user/profile')}}">Profile</a>
                                                <hr>
                                                <form method="POST" action="{{ route('logout') }}" x-data>
                                                    @csrf
                                                    <x-jet-responsive-nav-link class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"><i class="fa-solid fa-arrow-right-from-bracket"></i> {{ __(' Log Out') }}</x-jet-responsive-nav-link>
                                                </form>
                                            </div>
                                        </div>
                                    </li> 
                                @else
                                    <li class="nav-item">
                                        <a href="{{ route('login') }}" class="nav-link">Log in</a>
                                    </li> 
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a href="{{ route('register') }}" class="nav-link">Register</a>
                                    </li> 
                                @endif
                                @endauth
                            @endif
                        </ul>
                    </span>
                    <!-- <span class="navbar-text">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Log in</a>
                            </li> 
                        </ul>
                    </span> -->
                </div>
            </nav>
            <!-- End of Navbar -->

            <!-- Header Image -->

            @yield('carousel')

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                    @yield('content')
                        
                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>
    <!-- End Page Container -->

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('layout/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('layout/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('layout/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('layout/vendor/chart.js/Chart.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('layout/vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('layout/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    

    <!-- Page level custom scripts -->
    <script src="{{ asset('layout/js/demo/chart-area-demo.js')}}"></script>
    <script src="{{ asset('layout/js/demo/chart-pie-demo.js')}}"></script>

    <script>
        jQuery(document).ready(function() {    
            $('#myTable').DataTable();
        });
    </script>
    <script>
        jQuery(document).ready(function() {    
            $('#myTable2').DataTable();
        });
    </script>
    <script>
        jQuery(document).ready(function() {    
            $('#myTable3').DataTable();
        });
    </script>
</body>

</html>