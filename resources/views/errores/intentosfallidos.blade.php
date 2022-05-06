@extends('layouts.redireccionar')

@section('seccion')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" align="center">{{ __('ACCESO DENEGADO') }}</div>
    </br>
                        <div class="form-group row mb-0" >
                            <div class="col-md-8 offset-md-4" >
                                <a align="center" role="button" class="btn btn-dark"  href={{ route('perfiles')}}>
                                    {{ __('Página de Inicio') }}

                                </a>
                            </div>


                </div>
              </br>
            </div>
        </div>
    </div>
</div>
@endsection
