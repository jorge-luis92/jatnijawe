<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_auxadmin')
@section('title')
: Búsqueda Estudiantes
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes a Egresar</h1>
  <div class="container" id="font7">
    </br>
	    <form action="{{route ('busqueda_egresados')}}" method="POST" role="search">
        {{ csrf_field() }}
         <div class="form-row">

           <div class="input-group col-md-6">
             <!--   <input type="text" ng-model="test" class="search-query form-control" placeholder="Nombre de familia"><p>&nbsp;</p>
    --><input type="text" class="form-control" name="q" placeholder="Ingrese Matrícula"><p>&nbsp;</p>
                   <span class="input-group-btn">
                     <button class="btn btn-danger" type="submit"><span>&nbsp;
                   <i class="fa fa-search" ></i></span>
                      </button>
                   </span>
            </div>
    </div>
    </form>
    @if(isset($details))
  <div class="table-responsive">
    <table class="table table-bordered table-striped" style="color: #000000;" >
      <thead>
        <tr>
          <th scope="col">MATRICULA</th>
            <th scope="col">SEMESTRE</th>
          <th scope="col">NOMBRE</th>
          <th scope="col">GENERO</th>
          <th style="text-align: center;" colspan="1" >ACCIONES</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($details as $estudiantes)
        <tr>
               <th scope="row">{!! $estudiantes->matricula !!}</th>
                <th scope="row">{!! $estudiantes->semestre !!}</th>
               <td>{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
                <th >{!! $estudiantes->genero !!}</th>
                <td style="text-align: center;"><a href="acreditar_egresado/{{ $estudiantes->matricula }}">ACTIVAR</a></td>
             </tr>
         @endforeach
      </tbody>
    </table>
  </div>
  @if (count($details))
    {{ $details->links() }}
  @endif
  @endif
  
  <div class="table-responsive">
    <table class="table table-bordered table-striped" style="color: #000000;" >
      <thead>
        <tr>
          <th scope="col">MATRICULA</th>
            <th scope="col">SEMESTRE</th>
          <th scope="col">NOMBRE</th>
          <th scope="col">GENERO</th>
          <th style="text-align: center;" colspan="1" >ACCIONES</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($estudiante as $estudiantes)
        <tr>
               <th scope="row">{!! $estudiantes->matricula !!}</th>
                <th scope="row">{!! $estudiantes->semestre !!}</th>
               <td>{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
                <th >{!! $estudiantes->genero !!}</th>
                <td style="text-align: center;"><a href="acreditar_egresado/{{ $estudiantes->matricula }}">ACTIVAR</a></td>
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
