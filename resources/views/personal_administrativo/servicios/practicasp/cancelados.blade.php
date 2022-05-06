<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
: Cancelados
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Expedientes Prácticas Profesionales </h1>
<div class="container" id="font7">
  </br>
  <div class="table-responsive" style="border:1px solid #819FF7;">
    <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
    <thead>
      <tr>
        <th scope="col">MATRICULA</th>
        <th scope="col">NOMBRE</th>
        <th scope="col">DEPENDENCIA</th>
        <th scope="col">CARGO DE TITULAR</th>
        <th scope="col">ESTATUS</th>
        <th scope="col">PERIODO PRACTICAS</th>

      </tr>
    </thead>
    <tbody>
      @foreach($practicas as $detalles)
      <tr style="color: #000000;">
      <td>{{$detalles->matricula}}</td>
      <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
      <td>{{$detalles->nombre_dependencia}}</td>
      <td>{{$detalles->cargo_titular}}</td>
      <td>{{$detalles->estatus_practica}}</td>
      <td>{{$detalles->periodo_practicas}}</td>
          </tr>
          @endforeach
      </tbody>
  </table>
 </div>
 @if (count($practicas))
 {{ $practicas->links() }}
 @endif
 <br />
 </div>
  @endsection
