<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A0E') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ESTUDIANTES DE PRIMER INGRESO DEL CICLO ESCOLAR ANTERIOR</strong></h4>

    <h5 style="font-size: 1.0em; color: #000000;" align="center"><i>Número de estudiantes de primer ingreso a la carrera del ciclo escolar anterior por género</i></h5>
  </thead>

  </table>
    <table class="table table-bordered table-info" style="color: #8181F7;" >
  <h6 style="font-size: 1.0em; color: #000000;" align="left"><strong>MODALIDAD ESCOLARIZADA</strong></h6>
    <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>

    <tr>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>

    </tr>
    <tr>
      <td bgcolor="white">{{$total_masculino_primerE}}</td>
      <td bgcolor="white">{{$total_femenino_primerE}}</td>
      <td bgcolor="white">{{$total_primerE}}</td>
      <td bgcolor="white">{{$total_estudiantes_discapacidadESC2}}</td>
      <td bgcolor="white">{{$total_estudiantes_lenguaESC2}}</td>

    </tr>

    </table>


<a> Páginas</a>
<a class="siguiente" href={{ route('reporte911_9A0E')}}><strong>1</strong></a>
<a class="siguiente" href={{ route('reporte911_9A1E')}}>2</a>
<a class="siguiente" href={{ route('reporte911_9A2E')}}>3</a>
<a class="siguiente" href={{ route('reporte911_9A3E')}}>4</a>






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
