<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="shortcut icon" href="{{asset('/logo.ico')}}">
  <!-- Custom fonts for this template-->
  <link  rel="stylesheet" href="{{asset('requisitos/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link  rel="stylesheet" href="{{asset('/css/sb-admin-3.min.css')}}">
  <link rel="stylesheet"  href="{{asset('/css/nuevo.css')}}">
  <script  src="{{asset('/js/funciones.min.js')}}"></script>

  <title>Coordinadora Académica @yield('title')</title>

</head>

<body id="page-top">
  <div id="wrapper" style="font-family: 'Century Gothic';" >
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark" style="background-color: #0B173B; font-size: 1.0em;" id="accordionSidebar" ><!-- Sidebar - Brand -->
          <!-- Nav Item - Dashboard -->

      <li class="nav-item active">
        <a class="nav-link" href={{ route('home_academica')}}>
           <img class="img-responsive center-block"   src="{{asset('/logo.ico')}}" width="47" height="47" alt=""><span style="font-size: 1.5em"> &nbsp;JAT WEB</span></a></li><!-- Divider -->
      <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">
        Gestión de Usuarios
      </div><!-- Nav Item - Pages Collapse Menu -->


      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#carga_de_datos" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa fa-plus-circle" aria-hidden="true"></i><span style="font-size: 0.8em;">&nbsp;Carga de Datos</span>
        </a>
        <div id="carga_de_datos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href={{ route('carga_de_datos')}}>Subir Archivo</a>
            <a class="collapse-item" href={{ route('registros_estudiantes_dia')}}>Registros del día</a>

          </div>
        </div>
      </li>

      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#estudiantes" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fa fa-user-circle" aria-hidden="true"></i></i><span style="font-size: 0.8em;">&nbsp;Estudiantes</span>
        </a>
        <div id="estudiantes" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href={{ route('registro_estudiante_aux')}}>Registrar Estudiante</a>
            <a class="collapse-item" href={{ route('busqueda_estudiante_aux')}}>Búsqueda de Estudiantes</a>
            <a class="collapse-item" href={{ route('estudiante_inactivo_aux')}}>Estudiantes Inactivos</a>
            <a class="collapse-item" href={{ route('futuros_egresados')}}>Estudiantes a Egresar</a>
            <a class="collapse-item" href={{ route('estudiantes_egresados')}}>Egresados</a>
          </div>
        </div>
      </li>


        <hr class="sidebar-divider" style=" background-color: #FFFFFF;">
<!-- Sidebar Toggler (Sidebar) -->
    <!-- Heading -->
    <div class="sidebar-heading" style="color: #FFFFFF">
      Utilidades
    </div>
	
	    <li class="nav-item" >
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#planeacionE" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fa fa-user-circle" aria-hidden="true"></i></i><span style="font-size: 0.8em;">&nbsp;Planeación </br> Modalidad Escolarizada</span>
      </a>
      <div id="planeacionE" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header" style="color: blue">Opciones:</h6>
          <a class="collapse-item" href={{ route('info_coord_academica_1E')}}>Información General</a>
          <a class="collapse-item" href={{ route('reporte9119E')}}>911.9</a>
          <a class="collapse-item" href={{ route('reporte911_9A0E')}}>911.9A</a>
        </div>
      </div>
    </li>

    <li class="nav-item" >
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#planeacionS" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fa fa-user-circle" aria-hidden="true"></i></i><span style="font-size: 0.8em;">&nbsp;Planeación </br> Modalidad Semiescolarizada</span>
      </a>
      <div id="planeacionS" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header" style="color: blue">Opciones:</h6>
          <a class="collapse-item" href={{ route('info_coord_academica_1S')}}>Información General</a>
          <a class="collapse-item" href={{ route('reporte9119S')}}>911.9</a>
          <a class="collapse-item" href={{ route('reporte911_9A0S')}}>911.9A</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link"  target="_blank"  href="{{asset('manuales_administrativos/MUCA.pdf')}}" aria-expanded="true">
        <i class="fas fa-fw fa-archive"></i>
        <span style="font-size: 0.9em;">Manual de Usuario</span>
      </a>
    </li>
	
	 <li class="nav-item">
      <a class="nav-link" href="download_carga/{{'formato_carga_estudiantes.xlsx'}}" aria-expanded="true">
        <i class="fas fa-fw fa-file-download"></i>
        <span style="font-size: 0.9em;">Descarga formato carga de estudiantes</span>
      </a>
    </li>
	
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>

      </div>

    </ul> <!-- End of Sidebar -->
    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column" style="background-image: url('/image/logos_idiomas/logo_fon.png'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF;">
          <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow " style="opacity: 0.7;filter:alpha(opacity=5);background-color: #819FF7;">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

			<li >
				 <a class="navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <!--<img class="img-responsive center-block" src="logo.ico" width="47" height="47" alt="">-->
           <h1 class="mr-2 d-none d-lg-inline" style="color: #0B173B;">&nbsp;Portal de Servicios Educativos "Jat Nijawe"</h1>
			              </a>
            </li>

<div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information
          -->

              <li class="nav-item">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php $usuario_actual=Auth::user()->id_user;
                  $id=$usuario_actual;
                  $users = DB::table('personas')
                  ->select('personas.nombre')
                  ->join('users', 'personas.id_persona', '=', 'users.id_persona')
                  ->where('users.id_persona',$id)
                  ->take(1)
                  ->first();  echo $users->nombre." ";  //url('image/logos_idiomas/logo_fon.png')echo $users->apellido_paterno." "; echo $users->apellido_materno;
                  ?></span>
                  <?php $imagen = DB::table('users')
                 ->select('users.imagenurl')
                 ->where('users.id_user',$id)
                 ->take(1)
                 ->first();
                 $im=$imagen->imagenurl;  ?>
                 <?php if($im==""){ $im="foto.png"; }  ?>
                  <img class="img-profile rounded-circle"  src="{{ asset("/image/$im")}}" >
             </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href={{ route('cuenta_academica')}}>
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-black-400"></i>
                    Configuración de cuenta
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-400"></i>
                    Cerrar Sesión
                  </a>
                </div>
              </li>
                      </ul>

        </nav>

        <!-- End of Topbar -->
@yield('seccion')
      </div>

      <!-- Footer -->
      <footer class="container-fluid text-center" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
  <p style="color: black">Av. Universidad S/N. Ex-Hacienda 5 Señores, Oaxaca, Méx. C.P. 68120 </br>Copyright &copy; <a style="color: white">Facultad de Idiomas</a> <?php $anio= date("Y"); echo $anio?>. Todos los derechos reservados.</p>
</footer>
    </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Desea cerrar Sesión?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Presione "Finalizar Sesión" para confirmar.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
          <a class="btn btn-primary" href="{{ route('logout_system') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Finalizar Sesión</a>

          <form id="logout-form" action="{{ route('logout_system') }}" method="POST" style="display: none;">
              @csrf
          </form>
        </div>
      </div>
    </div>
  </div>



  <script src="{{asset('requisitos/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('requisitos/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
   <!-- Core plugin JavaScript-->
  <script src="{{asset('requisitos/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>


  <!-- Page level plugins -->
<!--  <script src="requisitos/chart.js/Chart.min.js"></script>-->

  <!-- Page level custom scripts -->
  <!--<script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>-->


</body>

</html>
