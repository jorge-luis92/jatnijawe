@extends('layouts.plantilla_estudiante')
@section('title')
:Tutorías
@endsection
@section('seccion')
<h1 style="font-size: 2.0em; color: #000000;" align="center">Encuesta</h1>
<div class="container" id="font7">
                  <form method="POST" action="{{ route('tutorias_aceptar') }}"  >
                        @csrf
  <p style="color: #000000; font-size: 1,5em; "><strong>Todas las preguntas con un * son Obligatorias</strong> </p>
  <div class="form-row">
  <div class="radio col-md-12" id="labels" align="justify">
  <label><strong> * </strong>1.- Durante el semestre pasado, ¿Tuviste el acompañamiento de un(a) Tutor(a)?</label>
  </br>
  <div align="justify">

   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" id="tutor_si" name="tutor" value="1"  onclick="checar(this.id)" required >
   <label for="tutor_si">Si</label>

   <input type="radio" id="tutor_no" name="tutor" value="0" onclick="nochecar(this.id)" required>
   <label for="tutor_no">No</label>
   </div>
  </div>
  </div>

  <div class="form-row">

  <div class="radio col-md-12" id="labels" align="justify">
  <label>2.- Si tu respuesta anterior fue Si, de acuerdo a la siguiente escala ubica el desempeño del tutor(a), considerando el 5 como el valor máximo:</label>
  </br>
  <div align="justify">

  &nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" id="uno" name="desempenio" value="1"  required disabled>
   <label for="uno">1</label>

   <input type="radio" id="dos" name="desempenio" value="2"  required disabled>
   <label for="dos">2</label>

   <input type="radio" id="tres" name="desempenio" value="3"  required disabled>
   <label for="res">3</label>

   <input type="radio" id="cuatro" name="desempenio" value="4" required disabled>
   <label for="cuatro">4</label>

   <input type="radio" id="cinco" name="desempenio" value="5"  required disabled>
   <label for="cinco">5</label>
   </div>

  </div>
  </div>
  <div class="form-row">

  <div class="radio col-md-12" id="labels" align="justify">
  <label><strong>* </strong> 3.-De las siguientes dimensiones de la Formación Integral, identifica al menos 3 áreas que te gustaría trabajar con tu tutor(a) este semestre:
  </label>
  </br>
  </div>
  </div>
  <div class="radio col-md-12" id="labels" align="justify">
   <label for="area_academico">1.-Académico </label>
 <input type="radio" name="area_academico" value="1" required >
   <label >Si</label>

    <input type="radio"  name="area_academico" value="0" required>
   <label >No</label>
</div>
<div class="radio col-md-12" id="labels" align="justify">
   <label for="area_emocional">2.-Emocional </label>
   <input type="radio" name="area_emocional" value="1" required >
   <label >Si</label>

   <input type="radio"  name="area_emocional" value="0" required>
   <label >No</label>
</div>
<div class="radio col-md-12" id="labels" align="justify">
   <label for="area_salud">3.-Cuidado de la Salud </label>
   <input type="radio" name="area_salud" value="1" required >
   <label >Si</label>

   <input type="radio"  name="area_salud" value="0" required>
   <label >No</label>
</div>
<div class="radio col-md-12" id="labels" align="justify">
   <label for="area_valores">4.-Actitudes y Valores </label>
   <input type="radio" name="area_valores" value="1" required >
   <label >Si</label>

   <input type="radio"  name="area_valores" value="0" required>
   <label >No</label>
</div>
<div class="radio col-md-12" id="labels" align="justify">
   <label for="area_relaciones">5.-Relaciones inter e intra personales</label>
   <input type="radio" name="area_relaciones" value="1" required >
   <label >Si</label>

   <input type="radio"  name="area_relaciones" value="0" required>
   <label >No</label>
   </div>


   <div class="form-group">
 <div class="col-xs-offset-2 col-xs-9" align="center">
   <a  class="btn btn-primary" href="#" data-toggle="modal" data-target="#encuesta_l">Registrar</a>
   <!--  <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>-->
 </div>
</div>

<div class="modal fade" id="encuesta_l" tabindex="-1" role="dialog" aria-labelledby="encuesta_fi" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="encuesta_fi">¿Estás Seguro?</h5>
<button class="close" type="button" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">×</span>
</button>
</div>
<div class="modal-body">¡Solo puedes contestar la encuesta 1 vez por semestre! Al dar clic en aceptar se guardarán tus datos.</div>
<div class="modal-footer">

<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
<button class="btn btn-primary"  type="submit" >Aceptar</button>

</div>
</div>
</div>
</div>
                </form>
                </div>
</br>
@endsection


<script language="JavaScript">
    function checar(id){
      // document.getElementById("nombre_lengua").removeAttr("disabled");
       //$(".inputText").removeAttr("disabled");
       if ( id == "tutor_si" ) {
        document.getElementById("uno").removeAttribute("disabled");
        document.getElementById("dos").removeAttribute("disabled");
        document.getElementById("tres").removeAttribute("disabled");
        document.getElementById("cuatro").removeAttribute("disabled");
        document.getElementById("cinco").removeAttribute("disabled");
      }
    }

    function nochecar(id){
      if ( id == "tutor_no" ) {
       document.getElementById("uno").setAttribute("disabled","disabled");
       document.getElementById('uno').checked = false;
       document.getElementById("dos").setAttribute("disabled","disabled");
       document.getElementById('dos').checked = false;
       document.getElementById("tres").setAttribute("disabled","disabled");
       document.getElementById('tres').checked = false;
       document.getElementById("cuatro").setAttribute("disabled","disabled");
       document.getElementById('cuatro').checked = false;
       document.getElementById("cinco").setAttribute("disabled","disabled");
       document.getElementById('cinco').checked = false;
         }

    }

</script>
