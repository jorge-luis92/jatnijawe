<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_servicios')
@section('title')
:Egresados
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Inactivos</h1>
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
          <th style="text-align: center;" >ESTATUS</th>
          <th colspan="3" >VER</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($estudiante as $estudiantes)
        <tr>
               <th >{!! $estudiantes->matricula !!}</th>
                <th>{!! $estudiantes->semestre !!}</th>
               <td>{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
                 <th ><?php if(($estudiantes->genero == 'M') or ($estudiantes->genero == 'MASCULINO')){echo "MASCULINO";}else {echo "FEMENINO";}?></th>
               <td style="text-align: center;">EGRESADO</td>
               <td><a  href=""></a></td>
               <td ><a href="generales_egresado_ver/{{ $estudiantes->matricula }}">DATOS GENERALES</a></td>
               <td><a  href="{{ route ('cuestionario_egresado_ver')}}">CUESTIONARIO</a></td>
               <td><a  href="{{ route ('antecedentes_laborales_egresado')}}">DATOS LABORALES</a></td>

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
