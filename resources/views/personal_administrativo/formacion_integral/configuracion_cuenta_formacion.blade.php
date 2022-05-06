<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Configuración de Contraseña
@endsection
@section('seccion')

@include('flash-message')
<div class="table-responsive" style="border:2px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
  <thead>
    <tr>
      <td scope="col">  <h1 style="color: #0B173B; font-size: 20px;"><strong>Configuración contraseña</strong></h1>
	  
                          <form class="form-horizontal" method="POST" action="{{ route('changePassword_formacion') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							  
                              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                  <label for="current-password" >Contraseña Actual</label>

 <div class="col-md-12">
                                      <input id="current-password" type="password" class="form-control" name="current-password" required>

                                      @if ($errors->has('current-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('current-password') }}</strong>
                                          </span>
                                      @endif
</div>
                              </div>
							  
							  

                              <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                  <label for="new-password" >Nueva Contraseña</label>
 <div class="col-md-12">

                                      <input id="new-password" type="password" class="form-control" name="new-password" required>

                                      @if ($errors->has('new-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('new-password') }}</strong>
                                          </span>
                                      @endif

                              </div>
							  </div>

                              <div class="form-group">
                                  <label for="new-password-confirm" >Confirmar Contraseña</label>
 <div class="col-md-12">

                                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
</div>
                              </div>

                              <div class="form-group" align="left">
                                  <div class="col-md-8 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar Contraseña
                                      </button>
                                  </div>
                              </div>
                          </form>
	    
							  </td>
      <td scope="col">
	                            <form class="form-horizontal" method="POST" action="{{ route('changeUser_formacion') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							 
 <h1 style="color: #0B173B; font-size: 20px;"><strong>Datos de Usuario</strong></h1>
                               <div class="form-group">
                            <label for="username" >{{ __('Nombre de usuario') }}</label>

                            <div class="col-md-12">
                                <input id="username" type="text" value="{{ Auth::user()->username }}"  class="form-control @error('username') is-invalid @enderror" name="username"  required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                                        
                              <div class="form-group" align="left">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar
                                      </button>
                                  </div>
                              </div>
                          </form>
						   <form class="form-horizontal" method="POST" action="{{ route('changeEmail_formacion') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							 
 <h1 style="color: #0B173B; font-size: 20px;"><strong></strong></h1>
                              <div class="form-group">
                            <label for="email"  >{{ __('Correo electrónico') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email"  value="{{ Auth::user()->email }}"  class="form-control @error('email') is-invalid @enderror" name="email" required autocomplete="email" >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                             

                              <div class="form-group" align="left">
                                  <div class="col-md-8 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar
                                      </button>
                                  </div>
                              </div>
                          </form>
	  </td>
	    <td scope="col">
		  <form class="form-horizontal" method="POST" action="{{ route('changedatos_formacion') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}
							 
							 
 <h1 style="color: #0B173B; font-size: 20px;"><strong>Datos personales</strong></h1>
 
  <div class="form-group col-md-12" id="labels">
        <label for="nombre">* Nombre(s)</label>
        <input type="text" class="form-control" name="nombre" value="{{$datos_usuario->nombre}}" id="nombre" autocomplete="nombre" onKeyUp="this.value = this.value.toUpperCase();" required>
      </div>
      <div class="form-group col-md-12" id="labels">
        <label for="apellido_paterno">* Apellido Paterno</label>
		<input type="text" class="form-control" name="apellido_paterno" value="<?php if(empty($datos_usuario->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $datos_usuario->apellido_paterno;} ?>" id="apellido_paterno" autocomplete="apellido_paterno" onKeyUp="this.value = this.value.toUpperCase();" required>
      </div>
      <div class="form-group col-md-12" id="labels">
        <label for="apellido_materno">Apellido Materno</label>
        <input type="text" class="form-control" name="apellido_materno" value="<?php if(empty($datos_usuario->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $datos_usuario->apellido_materno;} ?>" id="apellido_materno" autocomplete="apellido_materno" onKeyUp="this.value = this.value.toUpperCase();" >
     
      </div>
                    <div class="form-group col-md-12">
                          <label for="genero">* Género</label>
                            <select name="genero" id="genero" required class="form-control" autocomplete="genero" >
                          <option value="">Seleccione una opción</option>
                          <option value="F">FEMENINO</option>
                          <option value="M">MASCULINO</option>
                    </select>
                        </div>        
						
						 <div class="form-group col-md-12" id="labels">
        <label for="puesto">Puesto</label>
        <input type="text" class="form-control" name="puesto" value="<?php if(empty($datos_usuario->puesto)){ $vacio=null; echo $vacio;} else{ echo $datos_usuario->puesto;} ?>" id="puesto" autocomplete="puesto" onKeyUp="this.value = this.value.toUpperCase();" >
     
      </div>
						  
						
						
                           
                           
                             <div class="form-group" align="left">
                                  <div class="col-md-8 col-md-offset-6">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar datos
                                      </button>
                                  </div>
                              </div>
                          </form>
		</td>
    </tr>
  </thead>
   <tbody>
    <tr> 
    </tr>
	</tbody>
</table>
</div>
              

  @endsection
