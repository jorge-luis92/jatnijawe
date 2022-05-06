<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A2') }}">
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
      <td bgcolor="white">{{$inscritos_M['1']}}</td>
      <td bgcolor="white">{{$inscritos_F['1']}}</td>
      <td bgcolor="white">{{$inscritos_G['1']}}</td>
      <td bgcolor="white">{{$inscritos_D['1']}}</td>
      <td bgcolor="white">{{$inscritos_L['1']}}</td>
      </tr>
  <tr>
      <td bgcolor="white">Segundo</td>
      <td bgcolor="white">{{$inscritos_M['2']}}</td>
      <td bgcolor="white">{{$inscritos_F['2']}}</td>
      <td bgcolor="white">{{$inscritos_G['2']}}</td>
      <td bgcolor="white">{{$inscritos_D['2']}}</td>
      <td bgcolor="white">{{$inscritos_L['2']}}</td>
    </tr>
  <tr>
      <td bgcolor="white">Tercero</td>
      <td bgcolor="white">{{$inscritos_M['3']}}</td>
      <td bgcolor="white">{{$inscritos_F['3']}}</td>
      <td bgcolor="white">{{$inscritos_G['3']}}</td>
      <td bgcolor="white">{{$inscritos_D['3']}}</td>
      <td bgcolor="white">{{$inscritos_L['3']}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Cuarto</td>
      <td bgcolor="white">{{$inscritos_M['4']}}</td>
      <td bgcolor="white">{{$inscritos_F['4']}}</td>
      <td bgcolor="white">{{$inscritos_G['4']}}</td>
      <td bgcolor="white">{{$inscritos_D['4']}}</td>
      <td bgcolor="white">{{$inscritos_L['4']}}</td>
  <tr>
      <td bgcolor="white">Quinto</td>
      <td bgcolor="white">{{$inscritos_M['5']}}</td>
      <td bgcolor="white">{{$inscritos_F['5']}}</td>
      <td bgcolor="white">{{$inscritos_G['5']}}</td>
      <td bgcolor="white">{{$inscritos_D['5']}}</td>
      <td bgcolor="white">{{$inscritos_L['5']}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Sexto</td>
      <td bgcolor="white">{{$inscritos_M['6']}}</td>
      <td bgcolor="white">{{$inscritos_F['6']}}</td>
      <td bgcolor="white">{{$inscritos_G['6']}}</td>
      <td bgcolor="white">{{$inscritos_D['6']}}</td>
      <td bgcolor="white">{{$inscritos_L['6']}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Séptimo</td>
      <td bgcolor="white">{{$inscritos_M['7']}}</td>
      <td bgcolor="white">{{$inscritos_F['7']}}</td>
      <td bgcolor="white">{{$inscritos_G['7']}}</td>
      <td bgcolor="white">{{$inscritos_D['7']}}</td>
      <td bgcolor="white">{{$inscritos_L['7']}}</td>
  </tr>
  <tr>
      <td bgcolor="white">Octavo</td>
      <td bgcolor="white">{{$inscritos_M['8']}}</td>
      <td bgcolor="white">{{$inscritos_F['8']}}</td>
      <td bgcolor="white">{{$inscritos_G['8']}}</td>
      <td bgcolor="white">{{$inscritos_D['8']}}</td>
      <td bgcolor="white">{{$inscritos_L['8']}}</td>
  </tr>

    <tr>
      <th>Total</th>
      <td bgcolor="white">{{$inscritos_M['TOTAL']}}</td>
      <td bgcolor="white">{{$inscritos_F['TOTAL']}}</td>
      <td>{{$inscritos_G['TOTAL']}}</td>
      <td bgcolor="white">{{$inscritos_D['TOTAL']}}</td>
      <td bgcolor="white">{{$inscritos_L['TOTAL']}}</td>
    </tr>

    </table>


<a> Páginas</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A0')}}>1</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A1')}}>2</a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A2')}}><strong>3</strong></a>
      <a class="siguiente" align="rigth" href={{ route('reporte911_9A3')}}>4</a>
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
