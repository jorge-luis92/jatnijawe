<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Tutor Activo
@endsection

@section('seccion')
 @include('flash-message')
 <h1 style="font-size: 2.0em; color: #000000;" align="center"> Tutores Activos</h1>
 <div class="container" id="font4">
 </br>                    <form method="POST" action="{{ route('tutor_activo') }}">
                         @csrf

                          <div class="form-row">
                         <div class="form-group col-md-4">
                             <label for="nombre" >{{ __('') }}</label>
                                 <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre">
                                 @error('nombre')
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                     </span>
                               @enderror
                         </div>


                             <div class="col-xs-offset-2 col-xs-9" align="center">
                                 <button type="submit" class="btn btn-primary">
                                     {{ __('Buscar') }}
                                 </button>
                             </div>

                             <div class="table-responsive">
                               <table class="table table-bordered table-info" style="color: #000000;" >
                                 <thead>
                                   <tr>
                                     <th scope="col">RFC</th>
                                     <th scope="col">NOMBRE</th>
                                     <th colspan="2" >ACCIONES</th>
                                   </tr>
                                 </thead>
                                 <tbody>
                                   <tr>
                                          <th scope="row">QWER123456HO1</th>
                                          <td>JORGE LUIS</td>
                                          <td>  <a data-toggle="modal" href="#">DETALLES</a></td>
                                          <td>  <a data-toggle="modal" href="#">DESACTIVAR</a></td>
                                        </tr>

                                 </tbody>
                               </table>
                             </div>

                         </div>
                     </form>
                 </div>


  @endsection
