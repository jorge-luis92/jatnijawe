<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Notificaciones Enviadas
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center">Notificaciones enviadas</h1>
 <div class="container" id="font7">
   @include('flash-message')
 </br>
                    <div class="table-responsive" style="border:1px solid #819FF7;">
                     <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px; margin: auto;"  >
                                 <thead>
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                       <th style="width:3px; " >MATRICULA</th>
                                      <th  style="width:auto;;" >NOMBRE DEL ESTUDIANTE</th>
                                       <th scope="col">TALLER</th>
                                     <th style="width:140px;;" >FECHA DE ENVÍO</th>
									 <th scope="col">EMAIL</th>
                                     <th scope="col">ASUNTO</th>
                                     <th scope="col">MENSAJE</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data as $detalles)
                                    <tr style="color: #000000;">
                                        <td >{{$detalles->matricula}}</td>
                                        <td >{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                        <td>{{$detalles->nombre_taller}}</td>
                                        <td>{{date("d-m-y H:i a", strtotime($detalles->created_at))}} </td>
										 <td>{{$detalles->email}}</td>
                                        <td>{{$detalles->asunto}}</td>
                                        <td>{{$detalles->mensaje}}</td>
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
