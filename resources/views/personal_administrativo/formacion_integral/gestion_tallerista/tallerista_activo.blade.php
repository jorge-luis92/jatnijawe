<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Talleristas Activos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Talleristas Activos</h1>
 </br>
                             <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
                                     <th scope="col">NOMBRE</th>
                                     <th scope="col">USUARIO</th>
                                     <th scope="col">EMAIL</th>
									  <th scope="col">FECHA DE REGISTRO</th>
                                     <th colspan="2" >ACCIONES</th>

                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($re as $res)
                                 <tr>
                                   <td>{{$res->nombre}} {{$res->apellido_paterno}} {{$res->apellido_materno}}</td>
                                   <th >{{$res->username}}</th>
                                   <th >{{$res->email}}</th>
								   <td>{{date("d-m-Y H:i a", strtotime($res->created_at))}} </td>
                                   <td><a href="desactivar_tallerista/{{ $res->id_user }}">DESACTIVAR</a></td>
								   <td><a href="restablecer_contrasenia_tall/{{$res->id_user}}" >RESTABLECER CONTRASEÑA</a></td>
                                    </tr>

                                              @endforeach
                                 </tbody>
                               </table>
                             
                             @if (count($re))
                               {{ $re->links() }}
                             @endif
                           </div>

            @endsection
