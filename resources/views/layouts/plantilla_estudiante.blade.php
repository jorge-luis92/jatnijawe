<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
 
  <link rel="shortcut icon" href="{{asset('/storage/logo.ico')}}">
  <!-- Custom fonts for this template-->
  <link  rel="stylesheet" href="{{asset('requisitos/fontawesome-free/css/all.min.css')}}" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link  rel="stylesheet" href="{{asset('css/sb-admin-3.min.css')}}">
  <link rel="stylesheet"  href="{{asset('css/nuevo.css')}}">
  <title>Estudiante @yield('title')</title>

</head>
<body id="page-top" >
  <div id="wrapper" style="font-family: 'Century Gothic';"><!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-dark " style="background-color: #0A122A; font-size: 1.0em;" id="accordionSidebar" ><!-- Sidebar - Brand -->
          <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href={{ route('home_estudiante')}}>
          <img class="img-responsive center-block" src="{{asset('/storage/logo.ico')}}" width="47" height="47" alt="">
          <span style="font-size: 1.5em">&nbsp;JAT WEB</span></a></li><!-- Divider -->
      <hr class="sidebar-divider" style=" background-color: #FFFFFF;"><!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">
        Servicios
      </div><!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#datos_estudiante" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-upload"></i><span style="font-size: 0.8em;">&nbsp;Actualización de Datos</span>
        </a>
        <div id="datos_estudiante" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href={{ route('datos_general')}}>Datos Generales</a>
            <a class="collapse-item" href={{ route('datos_personal')}}>Datos Personales</a>
            <a class="collapse-item" href={{ route('datos_medico')}}>Datos Médicos</a>
            <a class="collapse-item" href={{ route('otras_actividades')}}>Otras Actividades</a>
            <a class="collapse-item"  href="pdfs" target="_blank">Descargar Hoja de Datos </br> Personales</a>

          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#activid_extra" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fa fa-list"></i><span style="font-size: 0.8em;">&nbsp;Formación Integral</span>
        </a>
        <div id="activid_extra" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a  class="collapse-item" href={{ route('catalogo')}}>Catálogo de Actividades</a>
            <a  class="collapse-item" href={{ route('mis_actividades')}}>Mis Actividades </br> Extraescolares</a>
            <a  class="collapse-item" href={{ route('avance')}}>Avance de Horas</a>
          <a  class="collapse-item" href={{ route('solicitud_taller')}}>Solicitud Actividades </br> Extracurriculares</a>
          <a  class="collapse-item" href="descargar_solicitud_taller" target="_blank"}>Descargar Solicitud de <br />Taller</a>
		    <a class="collapse-item" href={{ route('registro_anterior')}}>Registro de horas </br>anteriores a 2019</a>
          <!--  <a  class="collapse-item" href="">Constancia Actividades Extracurriculares </br>Parcial</a>-->
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#prac_prof" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa fa-book fa-1x fa-fw"></i><span style="font-size: 0.8em;">&nbsp;Prácticas Profesionales</span>
        </a>
        <div id="prac_prof" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
        <!--  <a  class="collapse-item" href="#">Requisitos Previos</a>-->
              <a  class="collapse-item" href={{ route('solicitud_practicasP')}}>Solicitud de Prácticas</br>Profesionales</a>
            <a class="collapse-item"  href="pdf_solicitud_practicas" target="_blank">Descargar Solicitud</a>
            </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#serv_social" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa fa-blind fa-1x fa-fw"></i><span style="font-size: 0.8em;">&nbsp;Servicio Social</span>
        </a>
        <div id="serv_social" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
          <!--  <a  class="collapse-item" href="#">Requisitos Previos</a>-->
            <a  class="collapse-item" href={{ route('solicitud_servicioSocial')}}>Datos de Servicio Social</a>
           </div>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#mis_talleres_menu" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa fa-heart fa-1x fa-fw"></i><span style="font-size: 0.8em;">&nbsp;Mis Talleres</span>
        </a>
        <div id="mis_talleres_menu" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a  class="collapse-item"  href={{ route('mi_taller')}}>Taller Activo</a>
           <a  class="collapse-item" href={{ route('talleres_finalizados_estudiante')}}>Talleres Finalizados</a>
          </div>
        </div>
      </li>

      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#egresado" aria-expanded="true" aria-controls="collapseTwo">
           <i class="fa fa-graduation-cap" aria-hidden="true"></i><span style="font-size: 0.9em;">&nbsp;Egresado</span>
        </a>
        <div id="egresado" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href={{ route('generales_egresado')}}>Datos Generales</a>
            <a class="collapse-item" href={{ route('cuestionario_egresado')}}>Cuestionario</a>
            <a class="collapse-item" href={{ route('antecedentes_laborales')}}>Datos Laborales</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider" style=" background-color: #FFFFFF;">
      <!-- Sidebar Toggler (Sidebar) -->
      <!-- Heading -->
      <div class="sidebar-heading" style="color: #FFFFFF">
      Utilidades
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
	  
	  
      <li class="nav-item" >
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#tutorias" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fa fa-question-circle" aria-hidden="true"></i><span style="font-size: 0.8em;">&nbsp;Tutorías</span>
        </a>
        <div id="tutorias" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header" style="color: blue">Opciones:</h6>
            <a class="collapse-item" href={{ route('tutorias')}}>Encuesta</a>

          </div>
        </div>
      </li>


      <li class="nav-item">
      <a class="nav-link"  target="_blank"  href="{{asset('MUESTUDIANTE.pdf')}}" aria-expanded="true">
      <i class="fas fa-fw fa-archive"></i>
      <span style="font-size: 0.9em;">Manual de Usuario</span>
    </a>
      </li>     <!-- Sidebar Toggler (Sidebar) -->


      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>

      </div>

    </ul> <!-- End of Sidebar -->
    <!-- Content Wrapper -->

    <div id="content-wrapper" class="d-flex flex-column" style="background-image: url('/image/logos_idiomas/logo_fon.png'); background-position:center; background-repeat: no-repeat; position: relative; background-color: #FFFFFF;">
          <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow " style="opacity: 0.7;filter:alpha(opacity=5); background-color: #819FF7;">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

			<li >
				 <a class="navbar" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <!--<img class="img-responsive center-block" src="logo.ico" width="47" height="47" alt="">-->
           <h1 class="mr-2 d-none d-lg-inline" style="color: #0B173B;font-size: 35px;">&nbsp;Portal de Servicios Educativos "Jat Nijawe"</h1>
			              </a>
            </li>

<div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
      <!--      <li class="nav-item dropdown no-arrow mx-1">
                         <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           <i class="fas fa-bell fa-fw"></i>

                           <span class="badge badge-danger badge-counter"></span>
                         </a>

                         <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                           <h6 class="dropdown-header">
                             Notificaciones
                           </h6>
                           <a class="dropdown-item text-center small text-gray-500" style="background-color: red; color: white;" href="">Ver mis Notificaciones</a>
                       </li>-->
<div class="topbar-divider d-none d-sm-block"></div>
              <li class="nav-item" >

                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php $usuario_actual=Auth::user()->id_user;
               $id=$usuario_actual;
               $users = DB::table('estudiantes')
               ->select('personas.nombre', 'apellido_paterno', 'apellido_materno')
               ->join('personas', 'personas.id_persona', '=', 'estudiantes.id_persona')
               ->where('estudiantes.matricula',$id)
               ->take(1)
               ->first();  echo $users->nombre." ";  //echo $users->apellido_paterno." "; echo $users->apellido_materno;
               ?></span>

               <?php $imagen = DB::table('users')
              ->select('users.imagenurl')
              ->where('users.id_user',$id)
              ->take(1)
              ->first();
              $im=$imagen->imagenurl;
                         ?>
              <?php if($im==""){ $im="foto.png"; }  ?>
              
              <!--<img class="img-profile rounded-circle"  src="{{url('$im')}}">-->
               <img class="img-profile rounded-circle"  src="{{ asset("/storage/$im")}}" >
				
             </a>
                <!-- Dropdown - User Information
                <div class="bg-white py-2 collapse-inner rounded"
                class="collapse" aria-labelledby="headingUtilities">-->

                <div class="dropdown-menu dropdown-menu-right animated--grow-in"  aria-labelledby="userDropdown">
                 <a class="dropdown-item" href={{ route('cuenta')}} >
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-black-400"></i>
                    Configuración de Contraseña  
                  </a>
				  
                  <hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
                  <a class="dropdown-item" href={{ route('foto_perfil')}} >
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-black-400" ></i>
                  Foto de Perfil
                </a>
                <hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">
                <!--  <div class="dropdown-divider"></div>-->
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
      <!-- End of Footer -->

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
  </div>

  <script src="{{asset('requisitos/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('requisitos/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{asset('requisitos/jquery-easing/jquery.easing.min.js')}}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{asset('js/sb-admin-2.min.js')}}"></script>
</body>
</html>
