<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Home
@endsection

@section('seccion')
 @include('flash-message')
<div class="container" id="font5">
  </br>
<div class="table-responsive">
  <table class="table table-bordered table-info" style="color: #000000;" >
    <thead>
      <tr>
        <th scope="col">RFC</th>
        <th scope="col">USUARIO</th>
        <th scope="col">EMAIL</th>
        <th scope="col">TIPO DE USUARIO</th>
        <th colspan="2" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <th scope="row">{!! $user->id !!}</th>
        <td>{!! $user->name !!}</td>
        <td>{!! $user->email !!}</td>
          <td>{!! $user->tipo_usuario !!}</td>
        <td><a href="#">ACTUALIZAR</a></td>
        <td><a href="#">DESACTIVAR</a></td>
      </tr>
@endforeach
    </tbody>
  </table>
</div>

@if (count($users))
  {{ $users->links() }}
@endif

</div>

  @endsection
