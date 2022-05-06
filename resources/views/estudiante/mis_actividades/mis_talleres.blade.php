<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Mis Talleres
@endsection
@section('seccion')
<!--<h1 style="font-size: 3.5em; color: #000000; font-family: Medium;" align="center">"JATWEB"</h1>-->
  <h2 style="font-size: 1.7em; color: #000000;" align="center">TALLERES</h2>
<div class="container" id="font7">
    @include('flash-message')
  </br>

  <div class="table-responsive" style="border:1px solid #819FF7;">
  <table class="table table-bordered table-striped"  style="color: #000000; font-size: 12px;">
    <thead>
      <tr>
        <th scope="col">NOMBRE DE TALLER </th>
        <th scope="col">ESTATUS</th>
		 <th scope="col">CUPO</th>
		  <th scope="col">INSCRITOS</th>
		    <th scope="col">LUGARES DISPONIBLES</th>
			 <th scope="col">DURACION</th>
        <th scope="col">HORARIO</th>
		 <th scope="col">LUGAR</th>
        <th colspan="2" >ACCIONES</th>
      </tr>
    </thead>
    <tbody>
  @foreach($dato as $datos)
      <tr>
        <td>{{$datos->nombre_ec}}</td>
        <td>ACTIVO</td>
		<td>{{$datos->cupo}}</td>
		<td><?php $inscritos= ($datos->cupo)-($datos->control_cupo); echo $inscritos;?></td>		
        <td>{{$datos->control_cupo}}</td>
        <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}
           <?php echo " al "; if(empty($datos->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo date('d-m-Y', strtotime($datos->fecha_fin));}?></td>
          <td><?php if(empty($datos->dias_sem) && empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{ echo $datos->dias_sem; echo "\n\n"; echo date("H:i a", strtotime($datos->hora_inicio)); echo " a "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
            </td>
			<td>{{$datos->lugar}}</td>		
        <td><a href="descargar_solicitud_taller_act/{{$datos->id_extracurricular}}" target="_blank">DETALLES</a></td>
        <td><a href="descarga_lista_estudiante/{{$datos->id_extracurricular}}" target="_blank">DESCARGAR LISTA</a></td>
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
