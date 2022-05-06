<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Cordinadores Inactivos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Coordinadores Inactivos</h1>
<div class="container" id="font7">
  <div class="table-responsive" style="border:1px solid #819FF7;">
  <table class="table table-bordered table-striped"  style="color: #000000; font-size: 12px;">
    <thead>
      <tr>
        <th scope="col">NOMBRE</th>
        <th scope="col">PUESTO</th>
        <th colspan="1" >USUARIO</th>
        <th colspan="1" >EMAIL</th>
        <th colspan="1" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($coordi as $coordinadores)
      <tr>
        <th scope="row"> {!! $coordinadores->nombre !!} {!! $coordinadores->apellido_paterno !!} {!! $coordinadores->apellido_materno !!}</th>
        <td>{!! $coordinadores->puesto !!}</td>
        <td>{!! $coordinadores->username !!}</td>
        <td>{!! $coordinadores->email !!}</td>
             <td><a href="activar_coord/{{$coordinadores->id_user}}">ACTIVAR</a></td
           </tr>
        @endforeach
    </tbody>
  </table>
</div>
@if (count($coordi))
  {{ $coordi->links() }}
@endif
</div>
  @endsection
