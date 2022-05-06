<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Búsqueda Tutores
@endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Tutores Registrados</h1>
 <div class="container" id="font7">
 </br>
 <div class="table-responsive" style="border:1px solid #819FF7;">
  <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
      <thead>
                                   <tr style="font-size: 12px;" >
                                     <th scope="col">NOMBRE</th>
                                     <th scope="col">GRADO DE ESTUDIOS</th>
                                      <th scope="col">TELÉFONO CONTACTO</th>
                                       <th scope="col">PROCEDENCIA INTERNA</th>
                                        <th scope="col">PROCEDENCIA EXTERNA</th>
                                     <th colspan="1" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   @foreach($re as $res)
                                   <tr>
                                          <td>{{$res->nombre}} {{$res->apellido_paterno}} {{$res->apellido_materno}}</td>
                                          <td>{{$res->grado_estudios}}</td>
                                          <td>{{$res->numero}}</td>
                                          <td>{{$res->procedencia_interna}}</td>
                                          <td>{{$res->procedencia_externa}}</td>
                                          <td><a href="desactivar_tutor/{{$res->id_tutor}}">DESACTIVAR</a></td>
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

 <script>
 function numeros(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = " 0123456789";
  especiales = [8,37,39,46];

  tecla_especial = false
  for(var i in especiales){
 if(key == especiales[i]){
   tecla_especial = true;
   break;
      }
  }

  if(letras.indexOf(tecla)==-1 && !tecla_especial)
      return false;
 }
 </script>
