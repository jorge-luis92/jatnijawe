<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: 911.9A
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte911_9A_6') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">

  <table class="table table-bordered table-info" style="color: #8181F7;" >

  <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ALUMNOS INSCRITOS POR TIPO DE INGRESO</strong></h4>
  <h5 style="font-size: 1.0em; color: #000000;" align="rigt">Número de alumnos inscritos de nuevo ingreso y reingreso por edad, género y tipo de ingreso</h5>

  <tr>
    <td colspan="4"align="center"><strong>Primer Ingreso</strong></td>
 </tr>
    <tr>
      <td ><strong>Edad</strong></td>
      <td bgcolor="white">Hombres</td>
      <td bgcolor="white">Mujeres</td>
        <td ><strong>Total</strong></td>
    </tr>

    <tr>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td ></td>
    </tr>

    <tr>
    <td ><strong>Total</strong></td>
      <td bgcolor="white" ></td>
      <td bgcolor="white" ></td>
      <td ></td>
    </tr>
  </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <tr>
      <td colspan="4"align="center"><strong>Reingreso</strong></td>
   </tr>
      <tr>
        <td ><strong>Edad</strong></td>
        <td bgcolor="white">Hombres</td>
        <td bgcolor="white">Mujeres</td>
          <td ><strong>Total</strong></td>
      </tr>

      <tr>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td ></td>
      </tr>

      <tr>
      <td ><strong>Total</strong></td>
        <td bgcolor="white" ></td>
        <td bgcolor="white" ></td>
        <td ></td>
      </tr>

    </table>
<a> Páginas</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_0')}}>1</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_1')}}>2</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_2')}}>3</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_3')}}>4</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_4')}}>5</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_5')}}>6</a>
    <a class="siguiente" align="rigth" href={{ route('reporte911_9A_6')}}><strong>7</strong></a>

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
