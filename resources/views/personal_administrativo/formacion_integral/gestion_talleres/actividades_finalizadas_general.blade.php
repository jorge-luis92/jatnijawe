<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
:Talleres
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Actividades Finalizadas</h1>
 <div class="container" id="font7">
   @include('flash-message')
 </br>                    <form method="POST" action="{{ route('actividades_registradas') }}">
                         @csrf
                          <div class="form-row">
                               <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
                                     <th scope="col">NOMBRE DE ACTIVIDAD </th>
                                     <th scope="col">TUTOR</th>
                                     <th scope="col">TIPO</th>
                                     <th scope="col">CREDITOS</th>
                                     <th scope="col">ESTATUS</th>
                                     <th scope="col">FECHA INICIO </th>
                                     <th scope="col">FECHA FIN</th>
                                     <th scope="col">OBSERVACIONES</th>

                                                     </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($dato as $datos)
                                   <tr style="color: #000000;">
                                       <td>{{$datos->nombre_ec}}</td>
                                       <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
                                       <td>{{$datos->tipo}} </td>
                                       <td>{{$datos->creditos}}</td>
                                       <td>FINALIZADO</td>
                                       <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}</td>
                                       <td>{{ date('d-m-Y', strtotime($datos->fecha_fin)) }}</td>
                                       <td>{{$datos->observaciones}}</td>
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
                     </form>
                 </div>

 @endsection
