<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Avance Estudiante
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Historial del Estudiante: {{$estudiante->nombre}} </h1>
 <h2 style="font-size: 1.5em; color: #0A122A;   max-width: 280px;" align="left">&nbsp;Avance de Horas &nbsp;</h2>
 <p style="font-size: 1.0em; color: #0A122A;">&nbsp; Académicas: {{$aca}} &nbsp; Culturales: {{$cul}} &nbsp; Deportivas: {{$dep}}
 &nbsp; Total: {{$suma}} </p>

   <div class="container" id="font7">
       @include('flash-message')
   </br>
   <div class="table-responsive">
     <table class="table table-bordered table-info" style="color: #000000; font-size: 12px;" >
       <thead>
         <tr>
           <th scope="col">NOMBRE</th>
           <th scope="col">CREDITOS</th>
           <th scope="col">AREA</th>
		    <th scope="col">FECHA</th>
           <th scope="col">TUTOR</th>
           <th scope="col">ESTATUS</th>
         </tr>
         <tbody>
       </thead>
         @foreach($dato as $datos)
         <tr style="color: #000000;">

             <td>{{$datos->nombre}}</td>
             <td>{{$datos->creditos}}</td>
             <td>{{$datos->area}}</td>
			 <td>{{$datos->fecha}} </td>
             <td>{{$datos->tutor}} </td>
             <td>ACREDITADO</td>
  </tr>

         @endforeach
        </tbody>
        </table>
        </div>
        @if (count($dato))
        {{ $dato->links() }}
        @endif

     </div>

 @endsection
