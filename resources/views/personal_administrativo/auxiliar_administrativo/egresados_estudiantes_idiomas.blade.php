<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Búsqueda Estudiantes
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Egresados</h1>
  <div class="container" id="font7">
    </br>
  <div class="table-responsive">
    <table class="table table-bordered table-striped" style="color: #000000;" >
      <thead>
        <tr>
          <th scope="col">MATRICULA</th>
            <th scope="col">SEMESTRE</th>
          <th scope="col">NOMBRE</th>
          <th scope="col">GENERO</th>
          <th style="text-align: center;" colspan="1" >ESTATUS</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($estudiante as $estudiantes)
        <tr>
               <th scope="row">{!! $estudiantes->matricula !!}</th>
                <th scope="row">{!! $estudiantes->semestre !!}</th>
               <td>{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
               <th >{!! $estudiantes->genero !!}</th>
               <td style="text-align: center;">EGRESADO</td>

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
