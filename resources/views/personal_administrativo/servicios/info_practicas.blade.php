<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
: Información Estudiantes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Información de Estudiantes</h1>
 <div class="container" id="font4">
 </br>
<form  method="post" action="{{ route('info_practicas') }}">
                         @csrf
<div class="form-row">
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #8181F7;" >
    <h4 style="font-size: 1.0em; color: #000000;" align="center"><strong>ESTUDIANTES ACTIVOS EN PRÁCTICAS </strong></h4>
    <h5 style="font-size: 1.0em; color: #000000;" align="center"><strong> CU </strong></h5>
    <h6 style="font-size: 1.0em; color: #000000;" align="center">MODALIDAD ESCOLARIZADA</h6>



        <tr>
          <td ><strong></strong></td>
          <td align="center"><strong>HOMBRES</strong></td>
          <td align="center"><strong>MUJERES</strong></td>
          <td ><strong>Total</strong></td>

        </tr>



        <tr>
          <td ><strong>Alumnos en Prácticas Profesionales  </strong></td>
          <td bgcolor="white" >{{$tot_P_E_M}}</td>
          <td bgcolor="white" >{{$tot_P_E_F}}</td>
          <td bgcolor="white" >{{$tot_P_E}}</td>
        </tr>

        <tr>
        <td ><strong></strong></td>
          <td align="center"><strong>HOMBRES</strong></td>
          <td align="center"><strong>MUJERES</strong></td>
          <td ><strong>Total</strong></td>

        </tr>



        <tr>
          <td ><strong>Alumnos en Servicio Social </strong></td>
          <td bgcolor="white" >{{$tot_S_E_M}}</td>
          <td bgcolor="white" >{{$tot_S_E_F}}</td>
          <td bgcolor="white" >{{$tot_S_E}}</td>
        </tr>


    </table>

    <table class="table table-bordered table-info" style="color: #8181F7;" >

    <h6 style="font-size: 1.0em; color: #000000;" align="center">MODALIDAD SEMIESCOLARIZADA</h6>



        <tr>
          <td ><strong></strong></td>
          <td align="center"><strong>HOMBRES</strong></td>
          <td align="center"><strong>MUJERES</strong></td>
          <td ><strong>Total</strong></td>

        </tr>



        <tr>
          <td ><strong>Alumnos en Prácticas Profesionales  </strong></td>
          <td bgcolor="white" >{{$tot_P_S_M}}</td>
          <td bgcolor="white" >{{$tot_P_S_F}}</td>
          <td bgcolor="white" >{{$tot_P_S}}</td>
        </tr>

        <tr>
        <td ><strong></strong></td>
          <td align="center"><strong>HOMBRES</strong></td>
          <td align="center"><strong>MUJERES</strong></td>
          <td ><strong>Total</strong></td>

        </tr>



        <tr>
          <td ><strong>Alumnos en Servicio Social </strong></td>
          <td bgcolor="white" >{{$tot_S_S_M}}</td>
          <td bgcolor="white" >{{$tot_S_S_F}}</td>
          <td bgcolor="white" >{{$tot_S_S}}</td>
        </tr>


    </table>
    </div>
  </form>
</div>
</div>

 @endsection
