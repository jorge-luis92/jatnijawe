<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: 911.9
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte9119S') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">

  <table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ESTUDIANTES BECADOS</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>Número de Estudiantes Becados del ciclo escolar actual</u></h5>
  <h6 style="font-size: 1.0em; color: #000000;" align="justify"><i><strong>Número de estudiantes becados del ciclo escolar actual,
    según el origen de la beca, por género, discapacidad y hablantes de alguna lengua índigena</i></strong></h6>
<tr>
<td colspan="6"align="center"><strong>Modalidad Semiescolarizada</strong></td>
</tr>
<tr>
<td colspan="6"align="center" bgcolor="white"><strong>CU</strong></td>
</tr>
<tr>
  <td ><strong>Origen de la Beca</strong></td>
  <td bgcolor="white">Hombres</td>
  <td bgcolor="white">Mujeres</td>
    <td ><strong>Total</strong></td>
  <td bgcolor="white">Con discapacidad</td>
  <td bgcolor="white">Hablante de Lengua Índigena</td>
</tr>

<tr>
  <td bgcolor="white" >Propia Institución</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['INSTITUCIONAL']}}</td>
  <td >{{$tipos_becas_ESC_G['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['INSTITUCIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['INSTITUCIONAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Federal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['FEDERAL']}}</td>
  <td >{{$tipos_becas_ESC_G['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['FEDERAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['FEDERAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Estatal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['ESTATAL']}}</td>
  <td >{{$tipos_becas_ESC_G['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['ESTATAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['ESTATAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Municipal</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['MUNICIPAL']}}</td>
  <td >{{$tipos_becas_ESC_G['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['MUNICIPAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['MUNICIPAL']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Particular</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['PARTICULAR']}}</td>
  <td >{{$tipos_becas_ESC_G['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['PARTICULAR']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['PARTICULAR']}}</td>
</tr>
<tr>
  <td bgcolor="white" >Beca Internacional</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['INTERNACIONAL']}}</td>
  <td >{{$tipos_becas_ESC_G['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['INTERNACIONAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['INTERNACIONAL']}}</td>
</tr>
<tr>
  <td ><strong>Total</strong></td>
  <td bgcolor="white" >{{$tipos_becas_ESC_M['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_ESC_F['TOTAL']}}</td>
  <td >{{$tipos_becas_ESC_G['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_D['TOTAL']}}</td>
  <td bgcolor="white" >{{$tipos_becas_esco_L['TOTAL']}}</td>
</tr>

    </table>

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
