<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_formacion_integral')
@section('title')
: Configuración de Cuenta
@endsection

@section('seccion')

              <div class="container"  id="font6">
              </br>
          @include('flash-message')
                          <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}

                              <div class="form-group col-md-5" style="width: 2rem;" >
                                <span style="color: #000000"> </span>
                                <img class="image" src="image/foto.png" width="100px">
                                   <input type="file" accept="image/png, .jpeg, .jpg">
                              </div>

                              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                  <label for="current-password" class="col-md-4 control-label">Contraseña Actual</label>

                                  <div class="col-md-6">
                                      <input id="current-password" type="password" class="form-control" name="current-password" required>

                                      @if ($errors->has('current-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('current-password') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                  <label for="new-password" class="col-md-4 control-label">Nueva Contraseña</label>

                                  <div class="col-md-6">
                                      <input id="new-password" type="password" class="form-control" name="new-password" required>

                                      @if ($errors->has('new-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('new-password') }}</strong>
                                          </span>
                                      @endif
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="new-password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                                  <div class="col-md-6">
                                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                  </div>
                              </div>

                              <div class="form-group" align="center">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar Datos
                                      </button>
                                  </div>
                              </div>
                          </form>

</br>
  @endsection
