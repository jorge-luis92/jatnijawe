<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_tallerista')
@section('title')
: Mis talleres
@endsection
@section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Mis talleres Finalizados</h1>
 <div class="table-responsive" style="border:1px solid #819FF7;">
 <table class="table table-bordered table-striped"  style="color: #000000; font-size: 12px;">
   <thead>
     <tr>
       <th scope="col">NOMBRE DE ACTIVIDAD </th>
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
     <tr>
       <td>{{$datos->nombre_ec}}</td>
       <td>{{$datos->tipo}}</td>
       <td>{{$datos->creditos}}</td>
       <td>FINALIZADO</td>
       <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}</td>
       <td>{{ date('d-m-Y', strtotime($datos->fecha_fin)) }}</td>
       <td>{{$datos->observaciones}}</td>
       </tr>
     @endforeach
    </tbody>
    </table>
    @if (count($dato))
    {{ $dato->links() }}
    @endif
 </div>


 @endsection
