<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantillasuperadmin')
@section('title')
: Registro Usuarios
@endsection

@section('seccion')
 @include('flash-message')
<h1 style="font-size: 2.0em; color: #000000;" align="center"> Registro de Usuarios</h1>
<div class="container" id="font4">
</br>                    <form method="POST" action="{{ route('registro_externos') }}">
                        @csrf

                         <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="nombre" >{{ __('* Nombre(s)') }}</label>
                                <input id="nombre" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="{{ old('nombre') }}" required autocomplete="nombre">
                                @error('nombre')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                              @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
                                  <input id="apellido_paterno" type="text"  onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno" value="{{ old('apellido_paterno') }}" required autocomplete="apellido_paterno">
                                @error('apellido_paterno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="form-group col-md-4">
                            <label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
                                  <input id="apellido_materno"  onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno" value="{{ old('apellido_materno') }}" autocomplete="apellido_materno">
                                @error('apellido_materno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
</div>


<hr style="height:1px; border:none; color:#000; background-color:#000; width:100%; text-align:left; margin: 0 auto 0 0;">

<div class="form-row">
  <div class="form-group col-md-4">
      <label for="puesto" >{{ __('Puesto') }}</label>
          <input id="puesto" type="text" onKeyUp="this.value = this.value.toUpperCase()"  class="form-control @error('puesto') is-invalid @enderror"  name="puesto"  autocomplete="puesto" autofocus required>
          @error('puesto')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
  </div>

  <div class="form-group col-md-4">
    <label for="grado_estudios">Departamento</label>
      <select name="departamento" id="departamento" required class="form-control">
      <option value="">Seleccione una opción</option>
      @foreach ($de as $des)
      <option value="{!! $des->id_departamento !!}">{!! $des->departamento !!}</option>
      @endforeach
          </select>
        </div>

  <div class="form-group col-md-4">
    <label for="grado_estudios">Grado de Estudios</label>
      <select name="grado_estudios" id="grado_estudios" required class="form-control">
      <option value="">Seleccione una opción</option>
      <option value="licenciatura">LICENCIATURA</option>
      <option value="maestria">MAESTRÍA</option>
      <option value="doctorado">DOCTORADO</option>
      <option value="doctorado">OTRO</option>
          </select>
        </div>
</div>

<div class="form-row">
  <div class="form-group col-md-4">
    <label for="username" >{{ __('Nombre de Usuario') }}</label>
        <input id="username" type="text"  class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group col-md-4">
    <label for="password" >{{ __('Contraseña') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>

<div class="form-group col-md-4">
    <label for="email" >{{ __('Correo Electrónico') }}</label>
        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
</div>
</div>


                        <div class="form-group">
                            <div class="col-xs-offset-2 col-xs-9" align="center">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>
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

<script>
function curpValida(curp) {
    var re = /^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/,
        validado = curp.match(re);

    if (!validado)  //Coincide con el formato general?
    	return false;

    //Validar que coincida el dígito verificador
    function digitoVerificador(curp17) {
        //Fuente https://consultas.curp.gob.mx/CurpSP/
        var diccionario  = "0123456789ABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
            lngSuma      = 0.0,
            lngDigito    = 0.0;
        for(var i=0; i<17; i++)
            lngSuma = lngSuma + diccionario.indexOf(curp17.charAt(i)) * (18 - i);
        lngDigito = 10 - lngSuma % 10;
        if (lngDigito == 10) return 0;
        return lngDigito;
    }

    if (validado[2] != digitoVerificador(validado[1]))
    	return false;

    return true; //Validado
}


//Handler para el evento cuando cambia el input
//Lleva la CURP a mayúsculas para validarlo
function validarInput(input) {
    var curp = input.value.toUpperCase(),
        resultado = document.getElementById("resultado"),
        valido = "No válido";

    if (curpValida(curp)) { // ?? Acá se comprueba
    	valido = "Válido"
        resultado.classList.add("ok");
    } else {
    	resultado.classList.remove("ok");
    }

    resultado.innerText =  "Formato: " + valido;
    var form = document.getElementById('curp').value;
    var  a = form.substring(16,17);
    //var che= form.substring(4,6);
    if(a == 0){
    var anio =  "19"+form.substring(4,6)+"-"+ form.substring(6,8)+ "-"+  form.substring(8,10);

    document.getElementById('fecha_nacimiento').value = anio ;}
    else {
    var anio ="20"+form.substring(4,6)+"-"+ form.substring(6,8)+ "-"+  form.substring(8,10);

    document.getElementById('fecha_nacimiento').value = anio ;
    }


    var  as= form.substring(10,11);
    if( as == 'H'){
    document.getElementById('genero').value = "MASCULINO" ;
    //alert(fe);HEVJ920901HOCRLR08
    }
    if( as == 'M'){
    document.getElementById('genero').value = "FEMEMINO" ;
    }
    var l = document.getElementById('curp').value;
  var  lug = l.substring(11,13);
  if(lug == 'AS'){
    document.getElementById('lugar_nacimiento').value = "AGUASCALIENTES";
  }
  if(lug == 'BC'){
    document.getElementById('lugar_nacimiento').value = "BAJA CALIFORNIA";
  }

  if(lug == 'BS'){
    document.getElementById('lugar_nacimiento').value = "BAJA CALIFORNIA SUR";
  }

  if(lug == 'CC'){
    document.getElementById('lugar_nacimiento').value = "CAMPECHE";
  }

  if(lug == 'CL'){
    document.getElementById('lugar_nacimiento').value = "COAHUILA";
  }

  if(lug == 'CM'){
    document.getElementById('lugar_nacimiento').value = "COLIMA";
  }

  if(lug == 'CS'){
    document.getElementById('lugar_nacimiento').value = "CHIAPAS";
  }

  if(lug == 'CH'){
    document.getElementById('lugar_nacimiento').value = "CHIHUAHUA";
  }

  if(lug == 'DF'){
    document.getElementById('lugar_nacimiento').value = "DISTRITO FEDERAL";
  }

  if(lug == 'DG'){
    document.getElementById('lugar_nacimiento').value = "DURANGO";
  }

  if(lug == 'GT'){
    document.getElementById('lugar_nacimiento').value = "GUANAJUATO";
  }

  if(lug == 'GR'){
    document.getElementById('lugar_nacimiento').value = "GUERRERO";
  }

  if(lug == 'HG'){
    document.getElementById('lugar_nacimiento').value = "HIDALGO";
  }

  if(lug == 'JC'){
    document.getElementById('lugar_nacimiento').value = "JALISCO";
  }

  if(lug == 'MC'){
    document.getElementById('lugar_nacimiento').value = "MÉXICO";
  }

  if(lug == 'MN'){
    document.getElementById('lugar_nacimiento').value = "MICHOACÁN";
  }
  if(lug == 'MS'){
    document.getElementById('lugar_nacimiento').value = "MORELOS";
  }

  if(lug == 'NT'){
    document.getElementById('lugar_nacimiento').value = "NAYARIT";
  }

  if(lug == 'NL'){
    document.getElementById('lugar_nacimiento').value = "NUEVO LEÓN";
  }

  if(lug == 'OC'){
  document.getElementById('lugar_nacimiento').value = "OAXACA";
  }

  if(lug == 'PL'){
    document.getElementById('lugar_nacimiento').value = "PUEBLA";
  }

  if(lug == 'QT'){
    document.getElementById('lugar_nacimiento').value = "QUERÉTARO";
  }

  if(lug == 'QR'){
    document.getElementById('lugar_nacimiento').value = "QUINTANA ROO";
  }

  if(lug == 'SP'){
    document.getElementById('lugar_nacimiento').value = "SANTA LUIS POTOSÍ";
  }

  if(lug == 'SL'){
    document.getElementById('lugar_nacimiento').value = "SINALOA";
  }

  if(lug == 'SR'){
    document.getElementById('lugar_nacimiento').value = "SONORA";
  }

  if(lug == 'TC'){
    document.getElementById('lugar_nacimiento').value = "TABASCO";
  }

  if(lug == 'TS'){
    document.getElementById('lugar_nacimiento').value = "TAMAULIPAS";
  }

  if(lug == 'TL'){
    document.getElementById('lugar_nacimiento').value = "TLAXCALA";
  }

  if(lug == 'VZ'){
    document.getElementById('lugar_nacimiento').value = "VERACRUZ";
  }

  if(lug == 'YN'){
    document.getElementById('lugar_nacimiento').value = "YUCATÁN";
  }

  if(lug == 'ZS'){
    document.getElementById('lugar_nacimiento').value = "ZACATECAS";
  }

  if(lug == 'NE'){
    document.getElementById('lugar_nacimiento').value = "NACIDO EN EL EXTRANJERO";
  }

  if(lug == ''){
    document.getElementById('lugar_nacimiento').value = "";
  }
    var ed = document.getElementById('fecha_nacimiento').value; //fecha de nacimiento en el formulario
    var fechaNacimiento = ed.split("-");
    var ano = fechaNacimiento[0];
    var mes = fechaNacimiento[1];
    var dia = fechaNacimiento[2];
    var fechaHoy = new Date(); // detecto la fecha actual y asigno el dia, mes y anno a variables distintas
    var ahora_ano = fechaHoy.getFullYear();
    var ahora_mes = fechaHoy.getMonth()+1;
    var ahora_dia = fechaHoy.getDate();

    var edad = (ahora_ano + 1900) - ano;
    if(ano < ahora_ano && edad >1899){
    if ( ahora_mes < mes )
    {
        edad--;
    }
    if (mes == ahora_mes && ahora_dia < dia)
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }
    if (edad == 1900)
    {
        edad =0;
    }
    }
    else {
    edad=0;
    }
    var meses=0;
    if(ahora_mes>mes)
        meses=ahora_mes-mes;
    if(ahora_mes<mes)
        meses=12-(mes-ahora_mes);
    document.getElementById('edad').value = edad;
    document.getElementById('mes').value = mes;


}

</script>
