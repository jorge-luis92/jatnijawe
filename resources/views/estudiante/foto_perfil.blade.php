<link rel="shortcut icon" href="{{asset('/logo.ico')}}">
@extends('layouts.plantilla_estudiante')
@section('title')
: Foto de Perfil
@endsection

@section('seccion')
@include('flash-message')

<div class="table-responsive" style="border:2px solid #819FF7;">
                                 <table class="table table-bordered table-striped" style="color: #000000; font-size: 13px;"  >
  <thead>
    <tr>
      <td scope="col"> 
     
        
                        <form class="form-horizontal" method="POST" action="{{ route('act_foto') }}" validate  enctype="multipart/form-data" data-toggle="validator">
                            {{ csrf_field() }}                                                                 

                          
                              <span style="color: #000000"> </span>
                              <?php
                              $usuario_actual=auth()->user();
                             $id=$usuario_actual->id_user;
                             $imagen = DB::table('users')
                            ->select('users.imagenurl')
                            ->where('users.id_user',$id)
                            ->take(1)
                            ->first();
                            $im=$usuario_actual->imagenurl;

                   ?>
<?php if($usuario_actual->imagenurl==""){ $im="foto.png"; }  ?>
</br> 

                              <img   src="{{ asset("/storage/$im")}}"  width="200" height="250" >
							  							  </br> 
							
</br>                        <input type="file" name="foto" accept="image/.jpeg, .jpg" required id="foto" > 
                               
                                
                          
                             <br /> <br />
                            <div class="form-group" align="center">
                                <div class="col-md-12 col-md-offset-12">
                                    <button type="submit" class="btn btn-primary">
                                       Actualizar Foto
                                    </button>
                                </div>
								</div>
                            
                        </form>
						 </td>
      <td scope="col" align="center">
	 
	  	  	  <p style="color: #0B173B; font-size: 20px; background: yellow;"><strong>Nota: La foto que subas se reflejará en tu hoja de datos  personales</strong> </p>
			  <h1 style="color: #0B173B; font-size: 19px;"><strong>Instrucciones</strong> </h1>
		 <p  align="left">
<span style="font-size:15px" >
 <strong>1. Antes de subir cualquier imagen, asegurate que sea en formato .jpg o .jpeg </br>
		  </br>2. El tamaño de la imagen no debe exceder 100 KB de tamaño </br>
		   </br>3. Si tu imagen pesa más de lo indicado no te preocupes, accede al siguiente enlace para cambiarle el tamaño: 
		   </br><a target="_blank" href="http://webresizer.com/resizer/"> &nbsp;&nbsp;&nbsp;&nbsp;http://webresizer.com/ </a>	</br>
           </br>4. Una vez hayas cambiado el tamaño y guardado la imagen puedes realizar la actualización </br>
           </br>5. Si no realizas los pasos como se mencionó en los puntos anteriores tendrás problemas al intentar subir la imagen y te saldrá un error en el sistema.		   
</span> 
</p>
 
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
