<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Talleres
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Actividades Registradas(Talleres)</h1>
 <div class="container" id="font7">
   @include('flash-message')
 </br>
                               <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
								    <th scope="col">N°</th>
                                     <th scope="col">ACTIVIDAD</th>  
                                     <th scope="col">TUTOR</th>
									 <!--<th scope="col">CUPO</th>
									  <th scope="col">INSCRITOS</th>
									   <th scope="col">LUGARES DISPONIBLES</th>
									    <th scope="col">DURACION</th>
                             <th scope="col">HORARIO</th>
		                    <th scope="col">LUGAR</th>-->
                                     <th colspan="4" style="text-align: center;">ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($dato as $indice => $datos)
                                   <tr style="color: #000000;">
								   <td>{{$indice+1}}</td>
                                       <td>{{$datos->nombre_ec}}</td>
                                                                         <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
									<!--    <td>{{$datos->cupo}}</td>
		<td><?php $inscritos= ($datos->cupo)-($datos->control_cupo); echo $inscritos;?></td>		
        <td>{{$datos->control_cupo}}</td>
        <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}
           <?php echo " al "; if(empty($datos->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo date('d-m-Y', strtotime($datos->fecha_fin));}?></td>
          <td><?php if(empty($datos->dias_sem) && empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{ echo $datos->dias_sem; echo "\n\n"; echo date("H:i a", strtotime($datos->hora_inicio)); echo " a "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
            </td>
			<td>{{$datos->lugar}}</td>	
			<td><a href="lista_inscritos_talleres/{{$datos->id_extracurricular}}/{{$datos->id_tutor}}" target="_blank">Lista Inscritos</a></td>-->			
										   			 		   			
										   <td><a href="detalles_taller_talleristas/{{$datos->id_extracurricular}}">Detalles</a></td>										   
                                           <td><a href="editar_taller/{{$datos->id_extracurricular}}">Editar</a></td>
 <td><a href="/inscritos_talleres_t/{{$datos->id_extracurricular}}/{{$datos->id_tutor}}">Gestión Taller</a></td>
			 
               <td><a href="cancelar_actividad/{{$datos->id_extracurricular}}">Cancelar Taller</a></td>
                                        
                                        </tr>
                                   @endforeach
                               </tbody>
                           </table>
                         </div>
                       </br></br>
                           @if (count($dato))
                             {{ $dato->links() }}
                           @endif
                                     </div>

 @endsection
