<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_coord_academica5') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">

  <table class="table table-bordered table-info" style="color: #8181F7;" >
<thead>
  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>Estudiantes del ciclo escolar actual que realizan otras actividades </strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Modalidad Escolarizada</h5>
  <tr>
    <th scope="row">Actividad</th>
    <th scope="row">Hombres </th>
    <th scope="row">Mujeres</th>
    <th scope="row">Total</th>


  </tr>
  <tr>
    <th scope="col">Escolar</th>
    <td bgcolor="white">{{$tipos_actextM_ESC['Escolar']}}</td>
    <td bgcolor="white">{{$tipos_actextF_ESC['Escolar']}}</td>
    <td bgcolor="white">{{$tipos_actext_ESC['Escolar']}}</td>

  </tr>

  <tr>
    <th scope="col">Laboral</th>
    <td bgcolor="white">{{$tipos_actextM_ESC['Laboral']}}</td>
    <td bgcolor="white">{{$tipos_actextF_ESC['Laboral']}}</td>
    <td bgcolor="white">{{$tipos_actext_ESC['Laboral']}}</td>

  </tr>
  <tr>
    <th scope="col">Total</th>
    <td bgcolor="white">{{$tipos_actextM_ESC['TOTAL']}}</td>
    <td bgcolor="white">{{$tipos_actextF_ESC['TOTAL']}}</td>
    <td bgcolor="white">{{$tipos_actext_ESC['TOTAL']}}</td>

  </tr>
  </table>



  <table class="table table-bordered table-info" style="color: #8181F7;" >
<thead>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Modalidad Semiescolarizada</h5>

  <tr>
    <th scope="row">Actividad</th>
    <th scope="row">Hombres </th>
    <th scope="row">Mujeres</th>
    <th scope="row">Total</th>
  </tr>

  <tr>
    <th scope="col">Escolar</th>
    <td bgcolor="white">{{$tipos_actextM_SEMI['Escolar']}}</td>
    <td bgcolor="white">{{$tipos_actextF_SEMI['Escolar']}}</td>
    <td bgcolor="white">{{$tipos_actext_SEMI['Escolar']}}</td>

  </tr>

  <tr>
    <th scope="col">Laboral</th>
    <td bgcolor="white">{{$tipos_actextM_SEMI['Laboral']}}</td>
    <td bgcolor="white">{{$tipos_actextF_SEMI['Laboral']}}</td>
    <td bgcolor="white">{{$tipos_actext_SEMI['Laboral']}}</td>

  </tr>
  <tr>
    <th scope="col">Total</th>
    <td bgcolor="white">{{$tipos_actextM_SEMI['TOTAL']}}</td>
    <td bgcolor="white">{{$tipos_actextF_SEMI['TOTAL']}}</td>
    <td bgcolor="white">{{$tipos_actext_SEMI['TOTAL']}}</td>

  </tr>
  </table>


<table class="table table-bordered table-info" style="color: #8181F7;" >
<thead>
<h5 style="font-size: 1.0em; color: #000000;" align="rigt">Total de Estudiantes  del ciclo escolar actual que realizan otras actividades</h5>
<tr>
  <th scope="row">Actividad</th>
  <th scope="row">Hombres </th>
  <th scope="row">Mujeres</th>
  <th scope="row">Total</th>


</tr>
<tr>
  <th scope="col">Escolar</th>
  <td bgcolor="white">{{$tipos_actextM['Escolar']}}</td>
  <td bgcolor="white">{{$tipos_actextF['Escolar']}}</td>
  <td bgcolor="white">{{$tipos_actext['Escolar']}}</td>

</tr>

<tr>
  <th scope="col">Laboral</th>
  <td bgcolor="white">{{$tipos_actextM['Laboral']}}</td>
  <td bgcolor="white">{{$tipos_actextF['Laboral']}}</td>
  <td bgcolor="white">{{$tipos_actext['Laboral']}}</td>

</tr>
<tr>
  <th scope="col">Total</th>
  <td bgcolor="white">{{$tipos_actextM['TOTAL']}}</td>
  <td bgcolor="white">{{$tipos_actextF['TOTAL']}}</td>
  <td bgcolor="white">{{$tipos_actext['TOTAL']}}</td>

</tr>
  </table>

    </div>
  </form>
</div>

<a class="siguiente" href={{ route('info_coord_academica1')}}>1</a>
<a class="siguiente" href={{ route('info_coord_academica2')}}>2</a>
<a class="siguiente" href={{ route('info_coord_academica3')}}>3</a>
<a class="siguiente" href={{ route('info_coord_academica4')}}>4</a>
<a class="siguiente" href={{ route('info_coord_academica5')}}><strong>5</strong></a>

</div>

 @endsection

 <script>
 function numeros(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789";
  especiales = [8,37,39,46];

  tecla_especial = false
  for(var i in especiales){
 if(key == especiales[i]){
   tecla_especial = true;
   break;
      }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial)
      return false;
 }
 </script>
