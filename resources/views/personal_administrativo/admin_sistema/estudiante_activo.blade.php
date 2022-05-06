<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Estudiantes Activos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Activos</h1>
 <form action="/search" method="POST" role="search">
   {{ csrf_field() }}
  <div class="form-group col-md-4" align="center">
       <input type="text" class="form-control" name="q"  placeholder="Search users">
       <button type="submit" class="btn btn-default" name="Buscar">
 </button>
   </div>
</form>
<div class="container" id="font7">
  </br>
<div class="table-responsive">
  <table class="table table-bordered table-striped" style="color: #000000;" >
    <thead>
      <tr>
        <th scope="col">MATRICULA</th>
          <th scope="col">SEMESTRE</th>
        <th scope="col">NOMBRE</th>
        <th colspan="2" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($estudiante as $estudiantes)
      <tr>
             <th scope="row">{!! $estudiantes->matricula !!}</th>
              <th scope="row">{!! $estudiantes->semestre !!}</th>
             <td>{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
             <td>  <a data-toggle="modal" href="#">DETALLES</a></td>
              <td>  <a data-toggle="modal" href="#">DESACTIVAR</a></td>
           </tr>
       @endforeach
    </tbody>
  </table>
</div>
@if (count($estudiante))
  {{ $estudiante->links() }}
@endif
</div>

  @endsection
