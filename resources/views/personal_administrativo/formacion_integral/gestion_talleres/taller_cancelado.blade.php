<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Talleres Cancelados
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Talleres Cancelados </h1>
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
                                     <th scope="col">FECHA DE APROBACIÓN</th>
                                     <th scope="col">ESTATUS</th>
                                     <th scope="col">OBSERVACIONES</th>
									 <th scope="col">DETALLES DE TALLER</th>
                                                           </tr>
                                 </thead>
                                 <tbody>
                                    @foreach($data as $detalles)
                                    <tr style="color: #000000;">
                                        <td>{{$detalles->nombre}} {{$detalles->apellido_paterno}} {{$detalles->apellido_materno}}</td>
                                        <td>{{$detalles->nombre_ec}}</td>
                                        <td>{{ date('d-m-Y', strtotime($detalles->created_at))}}</td>
                                        <td>CANCELADO</td>
                                        <td>{{$detalles->observaciones}}</td>
										  <td><a href="pdf_taller_cancelado/{{$detalles->matricula}}" target="_blank">Detalles</a></td>
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
