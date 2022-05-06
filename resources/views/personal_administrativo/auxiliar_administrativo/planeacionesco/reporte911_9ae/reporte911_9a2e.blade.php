<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A2E') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
<table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>MATRÍCULA TOTAL DE LA CARRERA</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="center">Estudiantes inscritos en el ciclo escolar actual</h5>
    <h6 style="font-size: 1.0em; color: #000000;" align="justify"><i><strong>Total de estudiantes inscritos en la carrera,
      por grado de avance, género, discapacidades y hablantes de alguna lengua indígena</i></strong></h6>
</table>
<table class="table table-bordered table-info" style="color: #8181F7;" >
    <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>MODALIDAD ESCOLARIZADA</u></h5>
  <h6 style="font-size: 1.0em; color: #000000;" align="center"><u>CU</u></h6>
    <tr>
      <th scope="row">Semestre</th>
      <th scope="row">Hombres </th>
      <th scope="row">Mujeres</th>
      <th scope="row">Total</th>
      <th scope="row">Con Discapacidad</th>
      <th scope="row">Hablante de Lengua</th>
    </tr>
    <tr>
      <td bgcolor="white">Primero</td>
      <td bgcolor="white">{{$tot_1_M_CU}}</td>
      <td bgcolor="white">{{$tot_1_F_CU}}</td>
      <td bgcolor="white">{{$tot_1_M_CU + $tot_1_F_CU}}</td>
      <td bgcolor="white">{{$tot_1_D_CU}}</td>
      <td bgcolor="white">{{$tot_1_L_CU}}</td>
      </tr>
  <tr>
      <td bgcolor="white">Segundo</td>
      <td bgcolor="white">{{$tot_2_M_CU}}</td>
      <td bgcolor="white">{{$tot_2_F_CU}}</td>
    <td bgcolor="white">{{$tot_2_M_CU + $tot_2_F_CU}}</td>
      <td bgcolor="white">{{$tot_2_D_CU}}</td>
      <td bgcolor="white">{{$tot_2_L_CU}}</td>
    </tr>
  <tr>
      <td bgcolor="white">Tercero</td>
      <td bgcolor="white">{{$tot_3_M_CU}}</td>
      <td bgcolor="white">{{$tot_3_F_CU}}</td>
      <td bgcolor="white">{{$tot_3_M_CU + $tot_3_F_CU}}</td>
      <td bgcolor="white">{{$tot_3_D_CU}}</td>
      <td bgcolor="white">{{$tot_3_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Cuarto</td>
      <td bgcolor="white">{{$tot_4_M_CU}}</td>
      <td bgcolor="white">{{$tot_4_F_CU}}</td>
      <td bgcolor="white">{{$tot_4_M_CU + $tot_4_F_CU}}</td>
      <td bgcolor="white">{{$tot_4_D_CU}}</td>
      <td bgcolor="white">{{$tot_4_L_CU}}</td>
  <tr>
      <td bgcolor="white">Quinto</td>
      <td bgcolor="white">{{$tot_5_M_CU}}</td>
      <td bgcolor="white">{{$tot_5_F_CU}}</td>
      <td bgcolor="white">{{$tot_5_M_CU + $tot_5_F_CU}}</td>
      <td bgcolor="white">{{$tot_5_D_CU}}</td>
      <td bgcolor="white">{{$tot_5_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Sexto</td>
      <td bgcolor="white">{{$tot_6_M_CU}}</td>
      <td bgcolor="white">{{$tot_6_F_CU}}</td>
      <td bgcolor="white">{{$tot_6_M_CU + $tot_6_F_CU}}</td>
      <td bgcolor="white">{{$tot_6_D_CU}}</td>
      <td bgcolor="white">{{$tot_6_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Séptimo</td>
      <td bgcolor="white">{{$tot_7_M_CU}}</td>
      <td bgcolor="white">{{$tot_7_F_CU}}</td>
      <td bgcolor="white">{{$tot_7_M_CU + $tot_7_F_CU}}</td>
      <td bgcolor="white">{{$tot_7_D_CU}}</td>
      <td bgcolor="white">{{$tot_7_L_CU}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Octavo</td>
      <td bgcolor="white">{{$tot_8_M_CU}}</td>
      <td bgcolor="white">{{$tot_8_F_CU}}</td>
      <td bgcolor="white">{{$tot_8_M_CU + $tot_8_F_CU}}</td>
      <td bgcolor="white">{{$tot_8_D_CU}}</td>
      <td bgcolor="white">{{$tot_8_L_CU}}</td>
  </tr>

    <tr>
      <th>Total</th>
      <td bgcolor="white">{{$tot_M_CU}}</td>
      <td bgcolor="white">{{$tot_F_CU}}</td>
      <td bgcolor="white">{{$tot_M_CU + $tot_F_CU}}</td>
      <td bgcolor="white">{{$tot_T_D_CU}}</td>
      <td bgcolor="white">{{$tot_T_L_CU}}</td>
    </tr>

    </table>


<a> Páginas</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A0E')}}>1</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A1E')}}>2</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A2E')}}><strong>3</strong></a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A3E')}}>4</a>
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
