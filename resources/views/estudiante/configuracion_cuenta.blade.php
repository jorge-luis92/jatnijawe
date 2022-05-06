<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Configuración de Contraseña
@endsection

@section('seccion')

              <div class="container"  id="font8">
              </br>
          @include('flash-message')
                          <form class="form-horizontal" method="POST" action="{{ route('changePassword') }}" validate enctype="multipart/form-data" data-toggle="validator">
                              {{ csrf_field() }}

                              <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                  <label for="current-password" >Contraseña Actual</label>


                                      <input id="current-password" type="password" class="form-control" name="current-password" required>

                                      @if ($errors->has('current-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('current-password') }}</strong>
                                          </span>
                                      @endif

                              </div>

                              <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                  <label for="new-password" >Nueva Contraseña</label>


                                      <input id="new-password" type="password" class="form-control" name="new-password" required>

                                      @if ($errors->has('new-password'))
                                          <span class="help-block">
                                              <strong>{{ $errors->first('new-password') }}</strong>
                                          </span>
                                      @endif

                              </div>

                              <div class="form-group">
                                  <label for="new-password-confirm" >Confirmar Contraseña</label>


                                      <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>

                              </div>

                              <div class="form-group" align="center">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Actualizar Contraseña
                                      </button>
                                  </div>
                              </div>
                          </form>
                        </div>

</br>
  @endsection
