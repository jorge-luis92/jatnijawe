<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_coord_academica_2S') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #8181F7;" >

    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ESTUDIANTES BECADOS</strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="center"><u>Número de Estudiantes Becados del ciclo escolar actual</u></h5>
    <h6 style="font-size: 1.0em; color: #000000;" align="justify"><i><strong>Número de estudiantes becados del ciclo escolar actual,
      según el origen de la beca, por género, discapacidad y hablantes de alguna lengua índigena</i></strong></h6>
  <td colspan="6"align="center"><strong>Modalidad Semiescolarizada</strong></td>

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
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['INSTITUCIONAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['INSTITUCIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['INSTITUCIONAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Federal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['FEDERAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['FEDERAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['FEDERAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Estatal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['ESTATAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['ESTATAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['ESTATAL']}}</td>    </tr>
        <tr>
          <td bgcolor="white" >Beca Municipal</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['MUNICIPAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['MUNICIPAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['MUNICIPAL']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Particular</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['PARTICULAR']}}</td>
          <td >{{$tipos_becas_SEMI_G['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['PARTICULAR']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['PARTICULAR']}}</td>
        </tr>
        <tr>
          <td bgcolor="white" >Beca Internacional</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['INTERNACIONAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['INTERNACIONAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['INTERNACIONAL']}}</td>
        </tr>

        <tr>
        <td ><strong>Total</strong></td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_M['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_SEMI_F['TOTAL']}}</td>
          <td >{{$tipos_becas_SEMI_G['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_D['TOTAL']}}</td>
          <td bgcolor="white" >{{$tipos_becas_semi_L['TOTAL']}}</td>
        </tr>
    </table>

    </div>
  </form>
</div>

<a class="siguiente" href={{ route('info_coord_academica_1S')}}>1</a>
<a class="siguiente" href={{ route('info_coord_academica_2S')}}><strong>2</strong></a>
<a class="siguiente" href={{ route('info_coord_academica_3S')}}>3</a>
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
