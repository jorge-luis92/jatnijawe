<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Solicitudes Aprobadas
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Talleres Activos - Estudiantes </h1>
 <div class="container" id="font7">
   @include('flash-message')
 </br>
                    <div class="table-responsive" style="border:1px solid #819FF7;">
                     <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
                                       <th scope="col">N°</th>
                                      <th scope="col">ESTUDIANTE</th>
                                       <th scope="col">TALLER</th>
                                  <!--   <th scope="col">FECHA DE APROBACIÓN</th>
                                    
									 <th scope="col">CUPO</th>
									  <th scope="col">INSCRITOS</th>
									   <th scope="col">LUGARES DISPONIBLES</th>
									    <th scope="col">DURACION</th>
                             <th scope="col">HORARIO</th>
		                    <th scope="col">LUGAR</th>-->
                                     <th colspan="4" style="text-align: center;">ACCIONES</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data as $indice => $detalles)
                                    <tr style="color: #000000;">
                                         <td>{{$indice+1}}</td>
                                        <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                        <td>{{$detalles->nombre_ec}}</td>
                                      <!--  <td>{{ date('d-m-Y', strtotime($detalles->created_at))}}</td>
                                       										
										<td>{{$detalles->cupo}}</td>
										<td><?php $inscritos= ($detalles->cupo)-($detalles->control_cupo); echo $inscritos;?></td>
										<td>{{$detalles->control_cupo}}</td>
										<td>{{ date('d-m-Y', strtotime($detalles->fecha_inicio)) }}
           <?php echo " al "; if(empty($detalles->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo date('d-m-Y', strtotime($detalles->fecha_fin));}?></td>
          <td><?php if(empty($detalles->dias_sem) && empty($detalles->hora_fin)){ echo $detalles->hora_inicio;} else{ echo $detalles->dias_sem; echo "\n\n"; echo date("H:i a", strtotime($detalles->hora_inicio)); echo " a "; echo date("H:i a", strtotime($detalles->hora_fin));} ?>
            </td>
			<td>{{$detalles->lugar}}</td>-->
			
			<td><a href="/detalles_taller_estudiantes/{{$detalles->id_extracurricular}}">Detalles</a></td>
			 <td><a href="editar_taller/{{$detalles->id_extracurricular}}">Editar</a></td>			 
	<td><a href="/inscritos_taller/{{$detalles->id_extracurricular}}/{{$detalles->id_tutor}}/{{$detalles->matricula}}">Gestión Taller</a></td>
			  
			 <td><a href="desactivar_taller_estudiante/{{$detalles->id_extracurricular}}/{{$detalles->matricula}}">Cancelar</a></td>
                            
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             </div>
                             @if (count($data))
                             {{ $data->links() }}
                             @endif
                             <br />
                         </div>
                         @endsection
