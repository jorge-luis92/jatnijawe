<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_coord_academica1') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>Estudiantes Inscritos en el ciclo escolar actual</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Modalidad Escolarizada</h5>
    <tr>
      <td colspan="6"align="center"><strong>CU</strong></td>
    </tr>
    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>
    <tr>
      <td bgcolor="white">{{$totalactualM}}</td>
      <td bgcolor="white">{{$totalactualF}}</td>
      <td bgcolor="white">{{$totalactualT}}</td>
      <td bgcolor="white">{{$discapacidadesTCU}}</td>
      <td bgcolor="white">{{$conteo_lengua}}</td>
    </tr>
    <tr>
      <td colspan="6"align="center"><strong>TEHUANTEPEC</strong></td>
   </tr>
   <tr>
     <th scope="row">Hombres </th>
     <th scope="row">Mujeres</th>
     <th scope="row">Total</th>
     <th scope="row">Con Discapacidad</th>
     <th scope="row">Hablante de Lengua</th>
   </tr>
   <tr>
     <td bgcolor="white">{{$totalactualMT}}</td>
     <td bgcolor="white">{{$totalactualFT}}</td>
     <td bgcolor="white">{{$totalactualTT}}</td>
     <td bgcolor="white">{{$discapacidadesT}}</td>
     <td bgcolor="white">{{$conteo_lenguaT}}</td>
   </tr>
   <tr>
     <td colspan="6"align="center"><strong>PUERTO ESCONDIDO</strong></td>
  </tr>
  <tr>
    <th scope="row">Hombres </th>
    <th scope="row">Mujeres</th>
    <th scope="row">Total</th>
    <th scope="row">Con Discapacidad</th>
    <th scope="row">Hablante de Lengua</th>
  </tr>
  <tr>
    <td bgcolor="white">{{$totalactualMP}}</td>
    <td bgcolor="white">{{$totalactualFP}}</td>
    <td bgcolor="white">{{$totalactualTP}}</td>
    <td bgcolor="white">{{$discapacidadesP}}</td>
    <td bgcolor="white">{{$conteo_lenguaP}}</td>
  </tr>

    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Modalidad Semiescolarizada</h5>
    <tr>
      <td colspan="6"align="center"><strong>CU</strong></td>
    </tr>
    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>

    <tr>
      <td bgcolor="white">{{$totalactualMS}}</td>
      <td bgcolor="white">{{$totalactualFS}}</td>
      <td bgcolor="white">{{$totalactualTS}}</td>
      <td bgcolor="white">{{$discapacidadesTCUS}}</td>
      <td bgcolor="white">{{$conteo_lenguaS}}</td>
    </tr>

    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
    <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Total de Estudiantes del Ciclo escolar actual</h5>
    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>

    <tr>
      <td bgcolor="white">{{$totalactualMG}}</td>
      <td bgcolor="white">{{$totalactualFG}}</td>
      <td bgcolor="white">{{$totalactualTG}}</td>
      <td bgcolor="white">{{$discapacidadesG}}</td>
      <td bgcolor="white">{{$conteo_lenguaG}}</td>
    </tr>
    </table>



  <a> Páginas</a>
  <a class="siguiente" href={{ route('info_coord_academica1')}}><strong>1</strong></a>
  <a class="siguiente" href={{ route('info_coord_academica2')}}>2</a>
  <a class="siguiente" href={{ route('info_coord_academica3')}}>3</a>
  <a class="siguiente" href={{ route('info_coord_academica4')}}>4</a>
  <a class="siguiente" href={{ route('info_coord_academica5')}}>5</a>
    </div>
  </form>
</div>


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
