<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
:Reporte Semestral
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Coordinación de Planeación</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('reporte_semestral') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered " style="color: #8181F7; background-color: #F2F2F2;" >
    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>REPORTE SEMESTRAL</strong></h4>


      <tr>
        <td colspan="6"align="center"><strong>LICENCIATURA</strong></td>
     </tr>
        <tr>
          <td ><strong></strong></td>
          <td align="center"><strong>P1</br>Modalidad Escolarizada</strong></td>
          <td align="center"><strong>P2</br>Modalidad Semiescolarizada</strong></td>
          <td ><strong>Total</strong></td>

        </tr>

        <tr>
          <td><strong>Matrícula Atendidida</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
        </tr>

        <tr>
          <td ><strong>Alumnos Reinscritos</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
        </tr>

        <tr>
          <td ><strong>Alumnos en Servicio Social</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
        </tr>

        <tr>
          <td ><strong>Alumnos en Prácticas Profesionales</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
        </tr>

        <tr>
        <td ><strong>Total</strong></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
          <td bgcolor="white" ></td>
        </tr>
    </table>

    </div>
  </form>
</div>
</div>

 @endsection
