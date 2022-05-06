<!doctype html>
<html lang="en">
  <head>
<meta name="google-site-verification" content="4Vo0EsJoYo7WJURuE4sZZHhJYxXXw91qIiNSfNP3Tb8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 , shrink-to-fit=no" />
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link href="css/animate.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/estiloinicio.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
      <link href="css/nuevo.css" rel="stylesheet">

    <link href="css/bootstrap-dropdownhover.min.css" rel="stylesheet">

    <script src="js/drow.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Usuario @yield('title')</title>

  </head>
  <body style="background-image: url('image/logos_idiomas/logo_fon.png'); background-size: 600px; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF;">
</br>
   <div class="container" align="center">
     <div class="row">
     <div  class="col-6 col-sm-2">
       <img src="image/idiom.png" width="100" height="100" alt=""/>
     </div>
     <div  class="col-6 col-sm-7" class="mr-2 d-none d-lg-inline text-gray-600 small" >
</br>
    <h3 style="font: 'Century Gothic';color: #000000"> Portal de Servicios Educativos </br>"JAT NIJAWE"</h3>

     </div>
     <div  class="col-6 col-sm-2">
       <img src="image/nuevo.png" width="100" height="100" alt=""/>
    </div>
    </div>
</br>

  </div>

  <div class="container" align="center" id="font2">
    <nav class="navbar" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
    <a class="navbar-brand" style="color:black" href={{ route('welcome')}}>
    <img src="logo.ico" width="30" height="30" class="d-inline-block align-top" alt="">&nbsp;Facultad de Idiomas </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav navbar-right "></ul>
    </nav>
  </div>
</br>
</br>
    </br>

  </br>
</div>
</br>
    @yield('seccion')



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validate.js/0.12.0/validate.min.js"></script>
    </br>
    <div class="container" align="center" div id="font2">

    <footer class="container-fluid text-center" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
      <p style="color: black">Av. Universidad S/N. Ex-Hacienda 5 Señores, Oaxaca, Méx. C.P. 68120</p>
      <p style="color: black">Copyright &copy; <a href="http://www.idiomas.uabjo.mx" style="color: white" target="_blank">Facultad de Idiomas</a> <?php $anio= date("Y"); echo $anio?> . Todos los derechos reservados.</p>
</footer>
  </div>
  </body>
</html>
