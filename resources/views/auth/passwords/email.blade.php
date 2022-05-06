@extends('layouts.app')

@section('content')
<div class="container" style="text-align: center;">
  <!--<h1 class="mr-2 d-none d-lg-inline" style="font-family: 'Century Gothic';color: #0B173B;font-size: 35px;">&nbsp;Reestablecimiento de Contraseña</h1>
  -->  <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="font-family: 'Century Gothic';color: #0B173B;">
                <div class="card-header" style="font-family: 'Century Gothic';color: #0B173B;font-size: 25px;">{{ __('Reestablecimiento de Contraseña') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Dirección de correo') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Enviar Petición') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
