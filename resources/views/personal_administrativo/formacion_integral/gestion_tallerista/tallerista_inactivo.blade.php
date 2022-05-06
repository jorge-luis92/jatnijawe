<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Talleristas Inactivos
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Talleristas Inactivos</h1>
 <div class="container" id="font7">
 </br>
                             <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
                                 <thead>
                                   <tr>
                                     <th scope="col">NOMBRE</th>
                                     <th scope="col">USUARIO</th>
                                     <th scope="col">EMAIL</th>
                                     <th scope="col">ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($re as $res)
                                   <tr>
                                     <td>{{$res->nombre}} {{$res->apellido_paterno}} {{$res->apellido_materno}}</td>
                                     <th scope="row">{{$res->username}}</th>
                                     <th scope="row">{{$res->email}}</th>
                                            <td><a href="activar_tallerista/{{ $res->id_user }}">ACTIVAR</a></td>
                                            </tr>

                                              @endforeach
                                 </tbody>
                               </table>
                             </div>
                             @if (count($re))
                               {{ $re->links() }}
                             @endif
                           </div>

            @endsection
