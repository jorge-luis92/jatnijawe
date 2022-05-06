<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Mis Talleres
@endsection
@section('seccion')
<!--<h1 style="font-size: 3.5em; color: #000000; font-family: Medium;" align="center">"JATWEB"</h1>-->
  <h2 style="font-size: 1.7em; color: #000000;" align="center">TALLERES FINALIZADOS</h2>
<div class="container" id="font7">
    @include('flash-message')
  </br>

  <div class="table-responsive" style="border:1px solid #819FF7;">
  <table class="table table-bordered table-striped"  style="color: #000000; font-size: 12px;">
    <thead>
      <tr>
        <th scope="col">NOMBRE DE TALLER </th>
        <th scope="col">ESTATUS</th>
        <th scope="col">FECHA INICIO DE TALLER</th>
        <th scope="col">FECHA FIN DE TALLER</th>
      </tr>
    </thead>
    <tbody>
  @foreach($dato as $datos)
      <tr>
        <td>{{$datos->nombre_ec}}</td>
        <td>FINALIZADO</td>
        <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}</td>
        <td>{{ date('d-m-Y', strtotime($datos->fecha_fin)) }}</td>
        </tr>
      @endforeach
     </tbody>
     </table>
     </div>
     @if (count($dato))
     {{ $dato->links() }}
     @endif
</div>


  @endsection
