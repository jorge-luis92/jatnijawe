<!doctype html>
<html lang="en">
  <head>
    <meta name="google-site-verification">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 , shrink-to-fit=no" />
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<link  rel="stylesheet" href="{{asset('css/animate.min.css')}}" type="text/css">
<link  rel="stylesheet" href="{{asset('css/estilopage.css')}}" type="text/css">
<link  rel="stylesheet" href="{{asset('css/style.css')}}" type="text/css">
<link  rel="stylesheet" href="{{asset('css/bootstrap-dropdownhover.min.css')}}" type="text/css">
  <script src="{{asset('js/drow.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Home: @yield('title')</title>

  </head>
  <body style="font-family: 'Century Gothic'; background-image: url('./image/logos_idiomas/logo_fon.png'); background-size: 1000px; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF  ;">
   <div class="container">
   <div class="row">
     <div  class="col-5 col-sm-2" align="left">
       <img  src="{{asset('image/idiom.png')}}" width="150" height="150" alt=""/>
     </div>
     <div  class="col-6 col-sm-7">
     </br>
       <h1>Universidad Autónoma Benito Juaréz de Oaxaca</h1>
       <h3>CIENCIA * ARTE * LIBERTAD</h3>
       <h4>Facultad de Idiomas</h4>
     </div>
     <div  class="col-7 col-sm-2" align="right">
         <img src="{{asset('image/logos_idiomas/logo_uabjo.png')}}" width="150" height="150" alt=""/>
     </div>
   </div>

 </div>
    <div class="container" align="center" id="font2">

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
      <a class="navbar-brand" href={{ route('welcome')}}>
        <img src="logo.ico" width="30" height="30" class="d-inline-block align-top" alt="">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
               <li class="dropdown">
                 <a style="color:white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"  data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                   Acerca de
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navbarDropdown" data-hover="dropdown">
                   <a class="dropdown-item" href="#">Misión</a>
                   <a class="dropdown-item" href="#">Visión</a>
                   <a class="dropdown-item" href="#">Redes Sociales</a>
               </li>

               <li class="nav-item dropdown">
                 <a style="color:white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Oferta
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                   <a class="dropdown-item" href="#">Licenciatura</a>
                   <a class="dropdown-item" href="#">Posgrado</a>
                   <a class="dropdown-item" href="#">Doctorado</a>
                   <a class="dropdown-item" href="#">Cursos</a>
               </li>

               <li class="nav-item dropdown">
                 <a style="color:white" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   Normatividad
                 </a>
                 <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                   <a class="dropdown-item" href="https://www.google.com" target="_blank"></a>
                   <a class="dropdown-item" href="#"></a>
              </li>
              </ul>

              <ul class="nav navbar-nav navbar-right ">
                <li>
                  <a href={{ route('perfiles')}}  class="btn btn-outline-primary active" role="button" aria-pressed="true">JATWEB</a>
                </li>

              </ul>

      </div>
         </nav>
  </div>

    @yield('seccion')
  </br>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js"></script>

    <div class="container" align="center" div id="font2">

    <footer class="container-fluid text-center" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
      <p style="color: black">Av. Universidad S/N. Ex-Hacienda 5 Señores, Oaxaca, Méx. C.P. 68120</p>
      <p style="color: black">Copyright &copy; <a href="http://www.idiomas.uabjo.mx" style="color: white" target="_blank">Facultad de Idiomas</a> <?php $anio= date("Y"); echo $anio?>. Todos los derechos reservados.</p>
</footer>
  </div>
  </body>
</html>
