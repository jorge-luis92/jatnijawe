<!doctype html>
<html lang="en">
  <head>
    <meta name="google-site-verification" content="4Vo0EsJoYo7WJURuE4sZZHhJYxXXw91qIiNSfNP3Tb8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8 , shrink-to-fit=no" />
    <link rel="shortcut icon" href="{{ asset('logo.ico') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
          <link  rel="stylesheet" href="{{asset('css/animate.min.css')}}" type="text/css">
          <link  rel="stylesheet" href="{{asset('css/estilopage.css')}}" type="text/css">
            <link  rel="stylesheet" href="{{asset('css/estiloinicio.css')}}" type="text/css">
          <link  rel="stylesheet" href="{{asset('css/sb-admin-2.min.css')}}" type="text/css">
          <link  rel="stylesheet" href="{{asset('css/bootstrap-dropdownhover.min.css')}}" type="text/css">

  <link  rel="stylesheet" href="{{asset('requisitos/fontawesome-free/css/all.min.css')}}" type="text/css">

  <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">


<script src="{{asset('js/drow.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <title>Usuarios @yield('title')</title>

  </head>
  <body style="background-image: url('./image/logos_idiomas/logo_fon.png'); background-size: 600px; background-position:center; background-repeat: no-repeat; background-color: #FFFFFF; font-family: 'Century Gothic';">

    </br>
   <div class="container" align="center">

   <div class="row">
     <div  class="col-6 col-sm-2">
       <img  src="{{asset('image/idiom.png')}}" width="150" height="150" alt=""/>
     </div>
     <div  class="col-6 col-sm-7" class="mr-2 d-none d-lg-inline text-gray-600 small" >

       <h2  style="color: #000000; font-family: 'Century Gothic';">Facultad de Idiomas</h2>
      <h3 style="color: #000000; font-family: 'Century Gothic';"> Portal de Servicios Educativos </br>"JAT NIJAWE"</h3>
     </div>
     <div  class="col-6 col-sm-2">
         <img src="{{asset('image/nuevo.png')}}" width="150" height="150" alt=""/>
     </div>
   </div>

 </div>
    <div class="container" align="center" id="font2">
    <nav class="navbar" style="background-color: #58ACFA; border-radius: 14px 14px 14px 14px;-moz-border-radius: 14px 14px 14px 14px;-webkit-border-radius: 14px 14px 14px 14px;border: 0px solid #000000;" >
      <a class="navbar-brand" style="color:black" href={{ route('perfiles')}}>
        <img src="logo.ico" width="30" height="30" class="d-inline-block align-top" alt="">&nbsp;Facultad de Idiomas </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
         </button>
         <ul class="nav navbar-nav navbar-right ">
           <li>
             <a href={{ route('perfiles')}}  class="btn btn-outline-primary active" role="button" aria-pressed="true">JATWEB</a>
           </li>
</ul>
         </nav>

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
