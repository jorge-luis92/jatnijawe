<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Conferencias
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Conferencias Registradas</h1>
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
									 
                                     <th colspan="4" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($dato as $indice => $datos)
                                   <tr style="color: #000000;">
								     <td >{{$indice+1}}</td>
                                       <td>{{$datos->nombre_ec}}</td>                                     
                                       <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>								                                                                 
										  <td><a href="detalles_conferencias_registradas/{{$datos->id_extracurricular}}">Detalles</a></td>
										 <td><a href="editar_conferencia/{{$datos->id_extracurricular}}">Editar</a></td>
										 <td><a href="/inscritos_talleres_t/{{$datos->id_extracurricular}}/{{$datos->id_tutor}}">Gestión Taller</a></td>
										 <td><a href="cancelar_actividad/{{$datos->id_extracurricular}}">Cancelar Conferencia</a></td>
                                         

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
