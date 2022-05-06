<link rel="shortcut icon" href="{{asset('logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Datos Médicos
@endsection

@section('seccion')
  <h1 style="font-size: 2.0em; color: #000000;" align="center"> Datos Médicos</h1>
<div class="container" id="font7">
    @include('flash-message')
</br>
<form method="POST" action="{{ route('act_datos_medicos') }}">
    @csrf
  <p style="font-size: 1.0em; color: #000000;"> Los Campos con un * son Obligatorios</p>
     <div class="form-group col-md-4">
                          <label for="tipo_sangre">* Tipo de Sangre</label>
                            <select name="tipo_sangre" id="tipo_sangre" required class="form-control" autocomplete="tipo_sangre" autofocus>
                          <option value="">Seleccione una opción</option>
                          <option value="O RH+">0 +(Positivo) u ORh +(Positivo) </option>
                          <option value="O RH-">0 -(Negativo) u ORh -(Negativo)</option>
                          <option value="A RH+">A +(Positivo) ó ARh +(Positivo)</option>
                          <option value="A RH-">A -(Negativo) ó ARh -(Negativo)</option>
                          <option value="B RH+">B +(Positivo) ó BRh +(Positivo)</option>
                          <option value="B RH-">B -(Negativo) u BRh -(Negativo)</option>
                          <option value="AB RH+">AB +(Positivo) ó ABRh +(Positivo)</option>
                          <option value="AB RH-">AB -(Negativo) ó ABRh -(Negativo)</option>
                    </select>
                        </div>
  <div class="radio col-md-12">
      <label>* ¿Sufres alguna Alergia o Enfermedad?</label>

     <input type="radio" id="si_alergia" name="alergias" value="si_alergia" onclick="checar_alergia(this.id)" required >
     <label for="si_alergia">Si</label>

     <input type="radio" id="no_alergia" name="alergias" value="no_alergia" onclick="nochecar_alergia(this.id)" required>
     <label for="no_alergia">No</label>
     </div>

     <div class="form-row">
          <div class="form-group col-md-3">
         <label for="tipo_enfer">Tipo</label></br>
           <select class="form-control" onclick="checar_seleccion()" name="tipo_enfer" id="tipo_enfer" disabled required >
         <option value="">Seleccione una opción</option>
         <option value="Alergia">Alergia</option>
         <option value="Enfermedad">Enfermedad</option>
   </select>
         </div>
     <div class="form-group col-md-4">
       <label for="nombre_enf_ale">Nombre Alergia</label>
       <select name="nombre_enf_ale" id="alergias_d" required disabled class="form-control">
       <option value="">Seleccione una opción</option>
       <option value="respiratoria">RESPIRATORIA</option>
       <option value="dermica">DÉRMICA</option>
       <option value="alimentos">ALIMENTOS</option>
       <option value="medicamentos">MEDICAMENTOS</option>
       <option value="plantas">PLANTAS E INSECTOS</option>
       <option value="lesiones">LESIONES, HERIDAS, INTOXICACIONES</option>
       <option value="otra">OTRA</option>
           </select>
     </div>

     <div class="form-group col-md-4">
       <label for="nombre_enfermedad">Nombre Enfermedad</label>
       <select name="nombre_enf_ale" id="enfermedad_de" required class="form-control" disabled>
       <option value="">Seleccione una opción</option>
       <option value="infecciosa">INFECCIOSA Y PARASITARIA</option>
       <option value="neoplasma">NEOPLASMAS</option>
       <option value="sangre">SANGRE Y SISTEMA INMUNOLÓGICO</option>
       <option value="endocrina">ENDÓCRINA</option>
       <option value="mental">MENTAL</option>
       <option value="sentidos">SENTIDOS</option>
       <option value="cardiocirculatorio">CARDIOCIRCULATORIO</option>
       <option value="respiratorio">SISTEMA RESPIRATORIO</option>
       <option value="digestivo">SISTEMA DIGESTIVO</option>
       <option value="nervioso">SISTEMA NERVIOSO</option>
       <option value="genitourinario">SISTEMA GENITOURINARIO</option>
       <option value="piel">PIEL</option>
       <option value="locomotor">APARATO LOCOMOTOR</option>
       <option value="embarazo">EMBARAZO, PARTO Y PUERPERIO</option>
       <option value="congenita">CONGÉNITAS</option>
       <option value="lesiones">LESIONES, HERIDAS, INTOXICACIONES</option>

           </select>
     </div>
     <div class="form-group col-md-3">
       <label for="des_enf_ale">Descripción</label>
       <textarea class="form-control" name="des_enf_ale" id="des_enf_ale" placeholder="Descripción" disabled required ></textarea>

             </div>
     <div class="form-group col-md-4">
       <label for="ind_enf_ale">Indicaciones</label>
       <textarea class="form-control" name="ind_enf_ale" id="ind_enf_ale" placeholder="Indicaciones" disabled required></textarea>
     </div>
     <div class="form-group col-md-4">
     </br>
    <a data-toggle="modal" href="#act_externas">Registro de Enfermedades - Alergias</a>
    </div>
 </div>

  <div class="radio col-md-12">
    <label>* ¿Sufres alguna Discapacidad?</label>

   <input type="radio" id="si_discapacidad" name="discapacidad" value="si_discapacidad" onclick="checar_dis(this.id)" required >
   <label for="si_discapacidad">Si</label>

   <input type="radio" id="no_discapacidad" name="discapacidad" value="no_discapacidad" onclick="nochecar_dis(this.id)" required>
   <label for="no_discapacidad">No</label>
   </div>

   <div class="form-row">
   <div class="form-group col-md-4">
     <label for="tipo_discapacidad">Nombre Discapacidad</label>
     <select name="tipo_discapacidad" id="tipo_discapacidad" disabled required class="form-control">
     <option value="">Seleccione una opción</option>
     <option value="fisica">FÍSICA/MOTRIZ</option>
     <option value="intelectual">INTELECTUAL</option>
     <option value="multiple">MULTIPLE</option>
     <option value="hipoacusa">HIPOACUSIA (AUDITIVA)</option>
     <option value="sordera">SORDERA (AUDITIVA)</option>
     <option value="visual1">BAJA VISIÓN (VISUAL)</option>
     <option value="viasual2">CEGUERA (VISUAL)</option>
     <option value="psicosocial">PSICOSOCIAL</option>
     <option value="lesiones">LESIONES, HERIDAS, INTOXICACIONES</option>
         </select>
   </div>

   <div class="form-group col-md-4">
     <label for="registro_dis">Registro Discapacidad</label>
     <input type="text" class="form-control" name="registro_dis" value="<?php if(empty($dis->tipo)){ $vacio=null; echo $vacio;} else{ echo $dis->tipo;} ?>" id="registro_dis" placeholder="Ninguno"  disabled>
   </div>
</div>
</br>
<label for="emergencia">En caso de emergencia llamar a:</label>
<div class="form-row">

<div class="form-group col-md-4">
<label for="nombre" >{{ __('* Nombre(s)') }}</label>
<input id="nombre" type="text" value="<?php if(empty($e->nombre)){ $vacio=null; echo $vacio;} else{ echo $e->nombre;} ?>" onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('nombre') is-invalid @enderror" name="nombre"  required autocomplete="nombre">
   @error('nombre')
<span class="invalid-feedback" role="alert">
<strong>{{ $message }}</strong>
</span>
 @enderror
</div>

<div class="form-group col-md-4">
<label for="apellido_paterno" >{{ __('* Apellido Paterno') }}</label>
     <input id="apellido_paterno" type="text"  value="<?php if(empty($e->apellido_paterno)){ $vacio=null; echo $vacio;} else{ echo $e->apellido_paterno;} ?>"onKeyUp="this.value = this.value.toUpperCase()" class="form-control @error('apellido_paterno') is-invalid @enderror" name="apellido_paterno"  required autocomplete="apellido_paterno">
   @error('apellido_paterno')
       <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
       </span>
   @enderror
</div>

<div class="form-group col-md-4">
<label for="apellido_materno" >{{ __('Apellido Materno') }}</label>
     <input id="apellido_materno"  value="<?php if(empty($e->apellido_materno)){ $vacio=null; echo $vacio;} else{ echo $e->apellido_materno;} ?>" onKeyUp="this.value = this.value.toUpperCase()"  type="text" class="form-control @error('apellido_materno') is-invalid @enderror" name="apellido_materno"  autocomplete="apellido_materno">
   @error('apellido_materno')
       <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
       </span>
   @enderror
</div>
</div>


<div class="form-row">
<div class="form-group col-md-6">
<label for="parentesco">* Parentesco</label>
<input type="text" class="form-control" value="<?php if(empty($p->parentesco)){ $vacio=null; echo $vacio;} else{ echo $p->parentesco;} ?>" name="parentesco" id="parentesco" placeholder="Parentesco"  onKeyUp="this.value = this.value.toUpperCase();" required>
</div>

<div class="form-group col-md-6">
<label for="tel_emergencia">* Teléfono de Emergencia</label>
<input type="tel" name="tel_emergencia" maxlength="10" class="form-control" value="<?php if(empty($ne->numero)){ $vacio=null; echo $vacio;} else{ echo $ne->numero;} ?>" onkeypress="return numeros (event)" required id="tel_emergencia" placeholder="Teléfono de Emergencia a 10 dígitos" pattern="([0-9]{3})([0-9]{7})" >
</div>
</div>

  <div class="form-group">
   <br>
   <div class="col-xs-offset-2 col-xs-9" align="center">
       <input type="submit" class="btn btn-primary" name="agregar" value="Actualizar">
   </div>
</div>
</form>

</div>
</br>

<div class="modal fade" tabindex="-1" role="dialog" id="act_externas" aria-labelledby="act_externa " aria-hidden="true">
  <div class="modal-dialog modal-xl" >
    <div class="modal-content" a>
      <div class="modal-header" >
        <h5 class="modal-title" id="act_externa" style="color: #000000">Registro de Enfermedades Y/O Alergías</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="container" id="font7">
        </br>
      <div class="table-responsive">
        <table class="table table-bordered table-info" style="color: #000000;" >
          <thead>
            <tr>
              <th scope="col">Nombre</th>
              <th scope="col">Tipo</th>
              <th scope="col">Descripción</th>
              <th scope="col">Indicaciones</th>
			  <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ea as $eas)
            <tr>
              <td>{!! $eas->nombre_enfermedadalergia !!}</td>
              <td>{!! $eas->tipo_enfermedadalergia !!}</td>
              <td>{!! $eas->descripcion !!}</td>
              <td>{!! $eas->indicaciones !!}</td>
			      <td><a href="cambiar_estatus_enfermedad/{{ $eas->id_enfermedad }}">Quitar</a></td>
			              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>
  </div>
  @endsection
  <script language="JavaScript">
      function checar_alergia(id){
        // document.getElementById("nombre_lengua").removeAttr("disabled");
         //$(".inputText").removeAttr("disabled");
         if ( id == "si_alergia" ) {
          document.getElementById("tipo_enfer").removeAttribute("disabled");
        //  document.getElementById("descripcion_alergia").removeAttribute("disabled");
          //document.getElementById("indicacion_alergia").removeAttribute("disabled");
        }
      }

      function nochecar_alergia(id){
        if ( id == "no_alergia" ) {
         document.getElementById("tipo_enfer").setAttribute("disabled","disabled");
         document.getElementById("enfermedad_de").setAttribute("disabled","disabled");
         document.getElementById("alergias_d").setAttribute("disabled","disabled");
         document.getElementById("des_enf_ale").setAttribute("disabled","disabled");
         document.getElementById("ind_enf_ale").setAttribute("disabled","disabled");
        document.getElementById('tipo_enfer').value = '';
        document.getElementById('enfermedad_de').value = '';
        document.getElementById('alergias_d').value = '';
        document.getElementById('des_enf_ale').value = '';
          document.getElementById('ind_enf_ale').value = '';

           }

      }
  </script>

  <script language="JavaScript">
      function checar_dis(id){
        // document.getElementById("nombre_lengua").removeAttr("disabled");
         //$(".inputText").removeAttr("disabled");
         if ( id == "si_discapacidad" ) {
          document.getElementById("tipo_discapacidad").removeAttribute("disabled");

        }
      }

      function nochecar_dis(id){
        if ( id == "no_discapacidad" ) {
         document.getElementById("tipo_discapacidad").setAttribute("disabled","disabled");
           document.getElementById('tipo_discapacidad').value = '';

           }

      }
  </script>


  <script>
  function checar_seleccion(){
    var ed = document.getElementById('tipo_enfer').value; //fecha de nacimiento en el formulario

    if(ed == ''){
      document.getElementById("enfermedad_de").setAttribute("disabled","disabled");
      document.getElementById("alergias_d").setAttribute("disabled","disabled");
      document.getElementById("des_enf_ale").setAttribute("disabled","disabled");
      document.getElementById("ind_enf_ale").setAttribute("disabled","disabled");
    }

    if(ed == 'Alergia'){
      document.getElementById("alergias_d").removeAttribute("disabled");
      document.getElementById("des_enf_ale").removeAttribute("disabled");
      document.getElementById("ind_enf_ale").removeAttribute("disabled");
      document.getElementById("enfermedad_de").setAttribute("disabled","disabled");
      document.getElementById('enfermedad_de').value = '';
  //    document.getElementById('des_enf_ale').value = '';
    //    document.getElementById('ind_enf_ale').value = '';
    }

    if(ed == 'Enfermedad'){
      document.getElementById("enfermedad_de").removeAttribute("disabled");
      document.getElementById("des_enf_ale").removeAttribute("disabled");
      document.getElementById("ind_enf_ale").removeAttribute("disabled");
      document.getElementById("alergias_d").setAttribute("disabled","disabled");
      document.getElementById('alergias_d').value = '';
      //document.getElementById('des_enf_ale').value = '';
        //document.getElementById('ind_enf_ale').value = '';
    }

  }
  </script>

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
