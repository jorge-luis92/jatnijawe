<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Solicitudes
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Solicitudes de Talleres </h1>
 <div class="container" id="font7">
   @include('flash-message')
 </br>
                    <div class="table-responsive" style="border:1px solid #819FF7;">
                     <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
                                     <!--<th scope="col">SOLICITUD</th>-->
                                      <th scope="col">ESTUDIANTE</th>
                                       <th scope="col">TALLER</th>
                                     <th scope="col">FECHA DE SOLICITUD</th>
                                     <th scope="col">ESTATUS</th>
                                     <th scope="col">DETALLES</th>
                                     <th colspan="3" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data as $detalles)
                                    <tr style="color: #000000;">
                                      <!--  <td>{{$detalles->num_solicitud}}</td>-->
                                        <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                        <td>{{$detalles->nombre_taller}}</td>
                                        <td>{{ date('d-m-Y', strtotime($detalles->fecha_solicitud))}} </td>
                                        <td>{{$detalles->estado}}</td>

                                        <td><a href="pdf_solicitud_taller/{{$detalles->matricula}}" target="_blank">VER SOLICITUD</a></td>
                                        <td>  <a href="solicitud_aprobada/{{$detalles->matricula}}">APROBAR</a></td>
                                        <td>  <a href="solicitud_rechazo/{{$detalles->matricula}}">RECHAZAR</a></td>
                                        <td>  <a href="solicitud_correcion/{{$detalles->matricula}}">RE-PLANTEAR</a></td>
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
