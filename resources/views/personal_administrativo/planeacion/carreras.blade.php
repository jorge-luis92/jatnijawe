<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_planeacion')
@section('title')
: Carreras Registradas
@endsection

@section('seccion')
<!--<h1 style="font-size: 3.5em; color: #000000; font-family: Medium;" align="center">"JATWEB"</h1>-->
  <h2 style="font-size: 1.7em; color: #000000;" align="center">Carreras Registradas</h2>
<div class="container" id="font7">
  @include('flash-message')
  </br>
    <div class="table-responsive" style="border:1px solid #819FF7;">
    <table class="table table-bordered table-striped"  style="color: #000000; font-size: 12px;">
    <thead>
      <tr>
        <th scope="col">CLAVE CARRERA</th>
        <th scope="col">CLAVE INSTITUCION</th>
        <th scope="col">FACULTAD</th>
        <th scope="col">CARRERA</th>
        <th scope="col">MODALIDAD</th>
      </tr>
    </thead>
    <tbody>
        @foreach($info_carrera as $datos)
      <tr style="color: #000000;">
          <td>{{$datos->clave_carrera}}</td>
          <td>{{$datos->clave_institucion}}</td>
          <td>{{$datos->facultad}}</td>
          <td>{{$datos->carrera}}</td>
          <td>{{$datos->modalidad}}</td>
          </tr>
       @endforeach
     </tbody>
     </table>
     </div>
     @if (count($info_carrera))
     {{ $info_carrera->links() }}
     @endif
   </br>
</div>

  @endsection
