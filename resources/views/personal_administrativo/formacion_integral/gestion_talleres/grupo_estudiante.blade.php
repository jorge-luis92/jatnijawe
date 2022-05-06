<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Gestión Taller
@endsection

@section('seccion')
<!--<h1 style="font-size: 3.5em; color: #000000; font-family: Medium;" align="center">"JATWEB"</h1>-->
  <h2 style="font-size: 1.7em; color: #000000;" align="center">Actividades Extracurriculares </h2>
<div class="container" id="font2">
    @include('flash-message') </br>
<!--  <h2 style="font-size: 1.0em; color: #0A122A;   max-width: 280px; text-decoration: underline;" align="left">AVANCE DE ACTIVIDADES:&nbsp;</h2>-->
  <div class="table-responsive">
    <table class="table table-bordered table-info" style="color: #000000; font-size: 12px;" >
      <thead>
        <tr>
          <th scope="col">NOMBRE</th>
          <th scope="col">TIPO</th>
          <th scope="col">CREDITOS</th>
          <th scope="col">AREA</th>
          <th scope="col">MODALIDAD</th>
          <th scope="col">TUTOR</th>
          <th scope="col">DURACION</th>
          <th scope="col">HORARIO</th>
          <th scope="col" >ESTATUS</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dato as $datos)
        <tr style="color: #000000;">

            <td>{{$datos->nombre_ec}}</td>
            <td>{{$datos->tipo}} </td>
            <td>{{$datos->creditos}}</td>
            <td>{{$datos->area}}</td>
            <td>{{$datos->modalidad}}</td>
            <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
            <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}
             <?php if(empty($datos->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo date('d-m-Y', strtotime($datos->fecha_inicio));}?></td>
            <td><?php if(empty($datos->dias_sem) && empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{ echo $datos->dias_sem; echo "\n\n"; echo $datos->hora_inicio;echo " a "; echo $datos->hora_fin;} ?>
              </td>
            <td>{{$datos->estado}}</td>
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
