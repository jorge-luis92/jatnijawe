<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_coord_academica_2') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">


      <table class="table table-bordered table-info" style="color: #8181F7;" >
    <thead>
      <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>Estudiantes Becados del ciclo escolar actual</strong></h4>
      <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Modalidad Escolarizada</h5>
      <tr>
        <td colspan="6"align="center"><strong>CU</strong></td>
      </tr>
      <tr>
        <th scope="row">Origen de la Beca</th>
        <th scope="row">Hombres </th>
        <th scope="row">Mujeres</th>
        <th scope="row">Total</th>
        <th scope="row">Con Discapacidad</th>
        <th scope="row">Hablante de Lengua</th>

      </tr>
      <tr>

        <th scope="col">Propia Institución</th>
        <td bgcolor="white">{{$total_masc_I}}</td>
        <td bgcolor="white">{{$total_fem_I}}</td>
        <td bgcolor="white">{{$total_general_I}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['INSTITUCIONAL'] }}</td>
        <td bgcolor="white">{{$tipos_becas_ESCL['INSTITUCIONAL'] }}</td>

      </tr>
      <tr>
        <th scope="col">Beca Federal</th>
        <td bgcolor="white">{{$total_masc_F}}</td>
        <td bgcolor="white">{{$total_fem_F}}</td>
        <td bgcolor="white">{{$total_general_F}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['FEDERAL'] }} </td>
        <td bgcolor="white">{{$tipos_becas_ESCL['FEDERAL'] }}</td>
      </tr>
      <tr>
        <th scope="col">Beca Estatal </th>
        <td bgcolor="white">{{$total_masc_E}}</td>
        <td bgcolor="white">{{$total_fem_E}}</td>
        <td bgcolor="white">{{$total_general_E}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['ESTATAL'] }} </td>
        <td bgcolor="white">{{$tipos_becas_ESCL['ESTATAL'] }}</td>
      </tr>
      <tr>
        <th scope="col">Beca Municipal</th>
        <td bgcolor="white">{{$total_masc_M}}</td>
        <td bgcolor="white">{{$total_fem_M}}</td>
        <td bgcolor="white">{{$total_general_M}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['MUNICIPAL'] }} </td>
        <td bgcolor="white">{{$tipos_becas_ESCL['MUNICIPAL'] }}</td>
      </tr>
      <tr>
        <th scope="col">Beca Particular</th>
        <td bgcolor="white">{{$total_masc_P}}</td>
        <td bgcolor="white">{{$total_fem_P}}</td>
        <td bgcolor="white">{{$total_general_P}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['PARTICULAR'] }} </td>
        <td bgcolor="white">{{$tipos_becas_ESCL['PARTICULAR'] }}</td>
      </tr>
      <tr>
        <th scope="col">Beca internacional</th>
        <td bgcolor="white">{{$total_masc_IN}}</td>
        <td bgcolor="white">{{$total_fem_IN}}</td>
        <td bgcolor="white">{{$total_general_IN}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['INTERNACIONAL'] }} </td>
        <td bgcolor="white">{{$tipos_becas_ESCL['INTERNACIONAL'] }}</td>
      </tr>
      <tr>
        <th scope="col">Total</th>
        <td bgcolor="white">{{$total_masc}}</td>
        <td bgcolor="white">{{$total_fem}}</td>
        <td bgcolor="white">{{$total_general_I + $total_general_F +
                              $total_general_E + $total_general_M +
                              $total_general_P + $total_general_IN}}</td>
        <td bgcolor="white">{{$tipos_becas_ESC['TOTAL']}}</td>
        <td bgcolor="white">{{$tipos_becas_ESCL['TOTAL'] }}</td>
      </tr>
      <tr>

      </table>

    </div>
  </form>
</div>

<a class="siguiente" href={{ route('info_coord_academica_1')}}>1</a>
<a class="siguiente" href={{ route('info_coord_academica_2')}}><strong>2</strong></a>
<a class="siguiente" href={{ route('info_coord_academica_3')}}>3</a>
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
