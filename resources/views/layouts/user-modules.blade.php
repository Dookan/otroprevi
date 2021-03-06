<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Previseguros</title>

  <!-- Custom fonts for this template-->
  <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
  <link href="{{asset('Datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3">Previseguros</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Inicio</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Charts -->
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.index.policies') }}">
            <i class="fas fa-sticky-note"></i>
            <span>Pólizas</span></a>
          </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.index.vehicles') }}">
            <i class="fas fa-car"></i>
            <span>Vehiculos</span></a>
          </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.index.prices') }}">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Precios</span></a>
          </li>

        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.index.payments') }}">
            <i class="fas fa-money-check-alt"></i>
            <span>Consultas de pago</span></a>
          </li>
        
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
              <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

          </ul>
          <!-- End of Sidebar -->

          <!-- Content Wrapper -->
          <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

              <!-- Topbar -->
              <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                  <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                  <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                  <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-search fa-fw"></i>
                    </a>
                    <!-- Dropdown - Messages -->
                    <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                      <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                          <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                          <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                              <i class="fas fa-search fa-sm"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </li>

                  <div class="topbar-divider d-none d-sm-block"></div>

                  <!-- Nav Item - User Information -->
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                      <a class="dropdown-item" href="/user/activity-log/{{Auth::user()->id}}">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Registro de Actividad
                      </a>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#changePass">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cambiar Contraseña
                      </a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Cerrar Sesión
                      </a>
                    </div>
                  </li>

                </ul>

              </nav>
              <!-- End of Topbar -->

              <!-- Begin Page Content -->
              <div class="container-fluid">
                @include('partials.messages')
                @yield('module')
              </div>
              <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
          </div>
          <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
          <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seguro que desea salir?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">Seleccione "Cerrar Sesión" si desea continuar</div>
              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

        <!-- Core plugin JavaScript-->
        <script src="{{asset('js/jquery/jquery.easing.min.js')}}"></script>

        <!-- Custom scripts for all pages-->
        <script src="{{asset('js/sb-admin-2.min.js')}}"></script>


        <!-- Page level plugins -->
        <script src="{{asset('js/chart.js/Chart.min.js')}}"></script>

        <!-- Page level custom scripts -->
        <script type="text/javascript">
          $(document).ready(function () {
           $.ajaxSetup ({
            cache: false
          });
           $('#brand').change(function() {
            var brand = $('#brand option:selected').text();
            console.log(brand);
            $.ajax({
              url:"{{ route('policy.search.vehicle') }}",
              type:"GET",
              data:{brandId:brand},
              dataType:"Text",
              success:function (brand) {
                $('#model').html(brand);
              }
            })
          });

           $('#estado').change(function(){
            var estado = $(this).val();
            $.ajax({
              url:"{{ route('office.search.municipio.user')  }}",
              type:"GET",
              data:{estadoId:estado},
              dataType:"Text",
              success:function (estado) {
                $('#municipio').html(estado);
              }
            })
          });

           $('#municipio').change(function(){
            var municipio = $(this).val();
            $.ajax({
              url:"{{ route('office.search.parroquia.user')  }}",
              type:"GET",
              data:{municipioId:municipio},
              dataType:"Text",
              success:function (municipio) {
                $('#parroquia').html(municipio);
              }
            })
          });

           $('#price').change(function(){
            var data = $(this).val();
            console.log(data);
            $.ajax({
              url:"{{ route('policy.price.view')  }}",
              type:"GET",
              data:{priceId:data},
              dataType:"Text",
              success:function (data) {
                $('#quick_view').html(data);
              }
            })
          });

          $('#vehicle_class').change(function() {
            var vehicle_class = $(this).val();
            $.ajax({
              url: "{{route('policy.price.select')}}",
              type: "GET",
              data: {priceData:vehicle_class},
              dataType: "Text",
              success:function (vehicle_class) {
                $('#price').html(vehicle_class);
              }
            })
          });
         });
       </script>
       <script src="{{ asset('js/functions.js') }}"></script>
       <script type="text/javascript" charset="utf8" src="{{asset('Datatables/datatables.min.js')}}" defer></script>
       <script type="text/javascript" charset="utf8" src="{{asset('Datatables/dataTables.bootstrap4.js')}}" defer></script>
       <script type="text/javascript">
        $(document).ready(function() {
          $('#dataTable').DataTable({
            "aaSorting": [],
            "language": {
              "url": "{{asset('Datatables/spanish.json')}}"
            }
          } );
        } );
      </script>
      
      @yield('scripts')
      @include('partials.change-pass-modal-user')
    </body>

    </html>
