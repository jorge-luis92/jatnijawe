<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Estudiantes Inscritos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Estudiantes Inscritos Activos</h1>
 <h4 style="color: #000000;" align="center"><strong>{{$detalle->nombre_ec}}</strong></h4>
 <td><a href="/acreditar_estudiante/{{$id_extracurricular}}/{{$matricula}}" >Acreditar Estudiante</a></td>
  </br>
 <div class="container" id="font7">
 </br>
                              <div class="table-responsive" style="border:1px solid #819FF7;">
                     <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                         <thead>
                                   <tr>
                                      <th scope="col">N°</th>
                                     <th scope="col">MATRÍCULA</th>
                                     <th scope="col">NOMBRE</th>
                                     <th scope="col">ESTATUS</th>
                                     <th colspan="4" style="text-align: center;">ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
@foreach($data as $indice => $detalles)
                                 <tr>
                                   <td >{{$indice+1}}</td>
                                   <td >{{$detalles->matricula}}</td>
                                   <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                   <td>{{$detalles->estado}}</td>
                                     <td ><a href="/acreditar_estudiante_taller/{{$detalles->id_extracurricular}}/{{$detalles->matricula}}">ACREDITAR</a></td>
                                   <td ><a href="/desacreditar_estudiante_taller/{{$detalles->id_extracurricular}}/{{$detalles->matricula}}">NO ACREDITAR</a></td>
   <td ><a href="/desactivar_estudiante_taller/{{$detalles->id_extracurricular}}/{{$detalles->matricula}}">DESACTIVAR</a></td>
   <td ><a href="/eliminar_estudiante_taller/{{$detalles->id_extracurricular}}/{{$detalles->matricula}}">ELIMINAR</a></td>
                                                                   </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                             </div>
                            
                             <br />
                         </div>
                         @endsection
