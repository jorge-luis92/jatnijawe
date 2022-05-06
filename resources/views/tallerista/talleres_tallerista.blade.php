<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_tallerista')
@section('title')
: Mis talleres
@endsection
@section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Mis talleres activos</h1>
 <div class="container" id="font7">
 </br>
          <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
          <thead>
          <tr>
            <th scope="col">NOMBRE DE TALLER</th>
			 <th scope="col">TIPO</th>
                                      <th scope="col">AREA</th>
                                       <th scope="col">MODALIDAD</th>
                                     <th scope="col">CREDITOS</th>
                                     <th scope="col">TUTOR</th>
									 <th scope="col">CUPO</th>
									  <th scope="col">INSCRITOS</th>
									   <th scope="col">LUGARES DISPONIBLES</th>
									    <th scope="col">DURACION</th>
                             <th scope="col">HORARIO</th>						  
		                    <th scope="col">LUGAR</th>                     
            <th colspan="1" align="center" >ACCIONES</th>

          </tr>
          </thead>
          <tbody>
            @foreach($dato as $datos)
                <tr>
                  <td>{{$datos->nombre_ec}}</td>
                  <td>{{$datos->tipo}} </td>
                                       <td>{{$datos->area}}</td>
                                       <td>{{$datos->modalidad}}</td>
                                       <td>{{$datos->creditos}}</td>
                                       <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
									   <td>{{$datos->cupo}}</td>
		<td><?php $inscritos= ($datos->cupo)-($datos->control_cupo); echo $inscritos;?></td>		
        <td>{{$datos->control_cupo}}</td>
        <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}
           <?php echo " al "; if(empty($datos->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo date('d-m-Y', strtotime($datos->fecha_fin));}?></td>
          <td><?php if(empty($datos->dias_sem) && empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{ echo $datos->dias_sem; echo "\n\n"; echo date("H:i a", strtotime($datos->hora_inicio)); echo " a "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
            </td>
			<td>{{$datos->lugar}}</td>	
                  <td><a href="descargar_lista_taller/{{$datos->id_extracurricular}}" target="_blank">Ver Lista Inscritos</a></td>
                 
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
