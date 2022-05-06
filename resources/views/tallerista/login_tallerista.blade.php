@extends('layouts.plantillaperfil')

@section('title')
: Tallerista
@endsection

@section('seccion')
<div class="container">
     @include('flash-message')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="opacity: 0.7;filter:alpha(opacity=5);">
                <div class="card-header" align="center">{{ __('Inicio de Sesión') }}</div>

                <div class="card-body">
                  @if(count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach($errors->all() as $error)
                      <li>{{$error}}</li>
                      @endforeach
                    </ul>
                  </div>
                  @endif
                    <form method="POST" action="{{ route('tallerista')}} ">
                      @csrf

                      <div class="form-group row">
                          <label for="username" class="col-md-4 col-form-label text-md-right" >{{ __('Nombre de Usuario') }}</label>

                          <div class="col-md-6">
                              <input id="username" type="text"  class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                              @error('username')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                          <div class="col-md-6">
                              <input id="password" value="{{ old('password') }}" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                              @error('password')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Ingresar') }}
                                </button>
                                @if (Route::has('password.request'))
                                   <a class="btn btn-link" href="{{ route('password.request') }}">
                                       {{ __('¿Olvidaste tu Contraseña?') }}
                                   </a>
                               @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
