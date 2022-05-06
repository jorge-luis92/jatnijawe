<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Avance de Horas
  @endsection
 @section('seccion')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Búsqueda de Estudiantes</h1>
   <div class="container" id="font7">
       @include('flash-message')
   </br>
   <form action="{{route ('registro_anterior_estudiante')}}" method="POST" role="search">
       {{ csrf_field() }}
        <div class="form-row">

          <div class="input-group col-md-6">
            <!--   <input type="text" ng-model="test" class="search-query form-control" placeholder="Nombre de familia"><p>&nbsp;</p>
   --><input type="text" class="form-control" name="q" placeholder="Introduce tu nombre"><p>&nbsp;</p>
                  <span class="input-group-btn">
                    <button class="btn btn-danger" type="submit"><span>&nbsp;
                  <i class="fa fa-search" ></i></span>
                     </button>
                  </span>
           </div>
   </div>
   </form>

       @if(isset($details))
       <div class="table-responsive" style="border:1px solid #819FF7;">
         <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
             <thead>
               <tr style="color: #000000;">
			       <th>Nombre</th>
                   <th>Avance</th>

               </tr>
           </thead>
           <tbody>
               @foreach($details as $user)
               <tr style="color: #000000;">
                   <td>{{$user->nombre}} </td>
                   <td><a href="avance_estudiante_es/{{ $user->ID }}">Detalles</a></td>
                                     </tr>
               @endforeach
           </tbody>
       </table>
       @if (count($details))
         {{ $details->links() }}
         @endif
         @endif
     </div>
   </div>
   </div>
   </div>
 @endsection
