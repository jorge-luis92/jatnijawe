<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_admin')
@section('title')
: Estudiantes Registrados
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Registros de Estudiantes </h1>
  <div class="container" id="font7">
    </br>
  <div class="table-responsive">
    <table class="table table-bordered table-striped" style="color: #000000;" >
      <thead>
        <tr>
          <th scope="col">MATRICULA</th>
		  <th scope="col">NOMBRE</th>
            <th scope="col">SEMESTRE</th>
            <th scope="col">MODALIDAD</th>
			<th scope="col">GÉNERO</th>
			<th scope="col">FECHA DE REGISTRO</th>
			<th scope="col">SEDE</th>
          
        </tr>
      </thead>
      <tbody>
          @foreach ($estudiante as $estudiantes)
        <tr>
               <th scope="row">{!! $estudiantes->matricula !!}</th>			   
               <td scope="row">{!! $estudiantes->nombre!!} {!! $estudiantes->apellido_paterno!!} {!! $estudiantes->apellido_materno!!}</td>
                <th scope="row">{!! $estudiantes->semestre !!}</th>
                <th scope="row">{!! $estudiantes->modalidad !!}</th>
				<th scope="row">{!! $estudiantes->genero !!}</th>
				<th scope="row">{!! date("d-m-y H:i a", strtotime($estudiantes->created_at))  !!}</th>
				<th scope="row">{!! $estudiantes->sede !!}</th>
				  
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
