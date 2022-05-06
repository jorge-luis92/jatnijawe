<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Mis Actividades
@endsection

@section('seccion')
<!--<h1 style="font-size: 3.5em; color: #000000; font-family: Medium;" align="center">"JATWEB"</h1>-->
  <h2 style="font-size: 1.7em; color: #000000;" align="center">Actividades Extracurriculares(Cursando)</h2>

    @include('flash-message') </br>
<!--  <h2 style="font-size: 1.0em; color: #0A122A;   max-width: 280px; text-decoration: underline;" align="left">AVANCE DE ACTIVIDADES:&nbsp;</h2>-->
 <div class="table-responsive" style="border:1px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="margin:auto; color: #000000; font-size: 13px;"  >
                                    <thead>
        <tr>
          <th scope="col">NOMBRE</th>
          <th scope="col">TUTOR</th>
          <th scope="col">TIPO</th>
          <th scope="col">CREDITOS</th>
          <th scope="col">AREA</th>
          <th scope="col">MODALIDAD</th>
          <th scope="col">DURACION</th>
          <th scope="col">HORARIO</th>
<th scope="col">LUGAR</th>
          <th scope="col" >ESTATUS</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dato as $datos)
        <tr style="color: #000000;">

            <td>{{$datos->nombre_ec}}</td>

            <td>{{$datos->nombre}} {{$datos->apellido_paterno}} {{$datos->apellido_materno}}</td>
            <td>{{$datos->tipo}} </td>
            <td>{{$datos->creditos}}</td>
            <td>{{$datos->area}}</td>
            <td>{{$datos->modalidad}}</td>
            <td>{{ date('d-m-Y', strtotime($datos->fecha_inicio)) }}
             <?php if(empty($datos->fecha_fin)){ $vacio=null; echo $vacio;} else{ echo " <br />"; echo  date('d-m-Y', strtotime($datos->fecha_inicio));}?></td>
            <td><?php if(empty($datos->dias_sem) && empty($datos->hora_fin)){ echo $datos->hora_inicio;} else{ echo $datos->dias_sem; echo "<br />de: "; echo date("H:i a", strtotime($datos->hora_inicio)); echo "<br />a: "; echo date("H:i a", strtotime($datos->hora_fin));} ?>
              </td>
<td>{{$datos->lugar}}</td>
            <td>{{$datos->estado}}</td>
           </tr>

        @endforeach
       </tbody>
       </table>
       </div>
       @if (count($dato))
       {{ $dato->links() }}
       @endif



  @endsection
