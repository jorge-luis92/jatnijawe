<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_coord_academica_1E') }}">
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
      <td bgcolor="white">{{$totalactualM_E}}</td>
      <td bgcolor="white">{{$totalactualF_E}}</td>
      <td bgcolor="white">{{$totalactualT_E}}</td>
      <td bgcolor="white">{{$discapacidadesTCU_E}}</td>
      <td bgcolor="white">{{$conteo_lengua_E}}</td>
    </tr>
    </table>



  <a> Páginas</a>
  <a class="siguiente" href={{ route('info_coord_academica_1E')}}><strong>1</strong></a>
  <a class="siguiente" href={{ route('info_coord_academica_2E')}}>2</a>
  <a class="siguiente" href={{ route('info_coord_academica_3E')}}>3</a>
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
