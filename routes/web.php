<?php
use Illuminate\Support\Facades\Input;
use App\User;
use App\Estudiante;
use App\Persona;
use App\Invoice;
/* Página principal---*/
//Route::get('/', 'Homepag@homepage')->name('welcome');
Route::get('/', 'Homepag@perfil')->name('perfiles');
Route::get('prueba', 'UserSystemController@checando')->name('prueba');
Route::get('denegado', 'Homepag@restringdo')->name('denegado');
/* Rutas de logueo---*/
Route::get('estudiante', 'Auth\LoginController@getLogin')->name('estudiante');
Route::post('login_studiante', ['as' =>'login_studiante', 'uses' => 'Auth\LoginController@postLogin']);
Route::get('tallerista', 'Tallerista_Con\LoginTallerista@getLoginTallerista')->name('tallerista');
Route::post('tallerista', ['as' =>'tallerista', 'uses' => 'Tallerista_Con\LoginTallerista@postLoginTallerista']);
Route::get('administrativo', 'Administrativo_Con\LoginAdministrativo@getLogin')->name('administrativo');
Route::post('logout_system', ['as' => 'logout_system', 'uses' => 'Administrativo_Con\LoginAdministrativo@getLogout']);
Route::post('admin', ['as' =>'admin', 'uses' => 'Administrativo_Con\LoginAdministrativo@postLogin']);

Route::group(['middleware' => 'auth','talleristamiddleware'], function () {
//Route::get('login_personal', 'Administrativo_Con\AdministrativoController@login_admin')->name('login_personal');
Route::get('login_tallerista', 'Tallerista_Con\TalleristaController@logintallerista')->name('login_tallerista');
Route::get('home_tallerista', 'Tallerista_Con\TalleristaController@home_tallerista')->name('home_tallerista');
Route::get('talleres_tallerista', 'Tallerista_Con\TalleristaController@talleres_tallerista')->name('talleres_tallerista');
Route::get('grupo_tallerista', 'Tallerista_Con\TalleristaController@grupo_tallerista')->name('grupo_tallerista');
Route::get('talleres_finalizados', 'Tallerista_Con\TalleristaController@talleres_finalizados')->name('talleres_finalizados');
Route::get('descargar_lista_taller/{id_taller}','GenerarPdf@descargar_lista_tallerista');
Route::get('finalizar_grupo/{id_extracurricular}','Tallerista_Con\TalleristaController@prueba_grupo');
Route::post('finalizar_talleres_tallerista', 'Tallerista_Con\TalleristaController@finalizar_taller_t')->name('finalizar_talleres_tallerista');
Route::get('cuenta_tallerista', 'Tallerista_Con\TalleristaController@cuenta_tallerista')->name('cuenta_tallerista');
  Route::post('changePassword_tallerista','Tallerista_Con\TalleristaController@changePassword')->name('changePassword_tallerista');
   Route::post('changeUser_tallerista','Tallerista_Con\TalleristaController@changeuser')->name('changeUser_tallerista');
   Route::post('changeEmail_tallerista','Tallerista_Con\TalleristaController@changemail')->name('changeEmail_tallerista');
   Route::post('changedatos_tallerista','Tallerista_Con\TalleristaController@datos_personales_tallerista')->name('changedatos_tallerista');
});
/* Rutas de Acdemico---*/
Route::group(['middleware' => 'auth', 'academicomiddleware'], function () {
Route::get('home_academica', 'Administrativo_Con\AdministrativoController@home_auxiliar_adm')->name('home_academica');
Route::get('carga_de_datos', 'Administrativo_Con\AdministrativoController@carga_de_datos')->name('carga_de_datos');
Route::get('registros_estudiantes_dia', 'Administrativo_Con\AdministrativoController@carga_hoy')->name('registros_estudiantes_dia');
Route::get('registro_estudiante_aux', 'Administrativo_Con\AdministrativoController@registro_estudiante_aux')->name('registro_estudiante_aux');
Route::post('registro_estudiante_auxa', 'RegistroEstudiantes@create_estudiante_aux')->name('registro_estudiante_auxa');
Route::get('busqueda_estudiante_aux', 'Administrativo_Con\AdministrativoController@busqueda_estudiante_aux')->name('busqueda_estudiante_aux');
Route::get('estudiante_activo_aux', 'Administrativo_Con\AdministrativoController@estudiante_activo_aux')->name('estudiante_activo_aux');
Route::get('estudiante_inactivo_aux', 'Administrativo_Con\AdministrativoController@estudiante_inactivo_aux')->name('estudiante_inactivo_aux');
Route::get('desactivar_estudiante_auxiliar/{id_user}', 'AdminController@desactivar_estudiante_aux');
Route::get('activar_estudiante_auxiliar/{id_user}', 'AdminController@activar_estudiante_aux');
Route::get('gestion_estudiante', 'Administrativo_Con\AdministrativoController@gestion_estudiante')->name('gestion_estudiante');
Route::get('grupo_auxadm', 'Administrativo_Con\AdministrativoController@grupo_auxadm')->name('grupo_auxadm');
Route::get('datos_estudiantes', 'Administrativo_Con\AdministrativoController@datos_estudiantes')->name('datos_estudiantes');
Route::get('futuros_egresados', 'CoordinadorAcademico@ver_futuros_egresados')->name('futuros_egresados');
Route::get('acreditar_egresado/{matricula}', 'CoordinadorAcademico@cambiar_estudiante');
Route::get('estudiantes_egresados', 'CoordinadorAcademico@egresados_estudiantes')->name('estudiantes_egresados');
Route::any('busqueda_estudiantes_aux', 'AdminController@busqueda_aux')->name('busqueda_estudiantes_aux');
Route::get('cargar_datos_usuario_estudiante', 'UserSystemController@cargar_datos_usuario_estudiante')->name('carga_persona');
Route::post('cargar_datos_usuarios', 'UserSystemController@axcel')->name('cargar_datos_usuarios');
Route::get('editar_estudiante_academico/{matricula}', 'CoordinadorAcademico@editar_estudiante_aca');
Route::post('editar_estudiantes_aux', 'CoordinadorAcademico@editar_estudiante')->name('editar_estudiantes_aux');
Route::get('hoja_de_academica/{matricula}', 'CoordinadorAcademico@generar');
Route::any('busqueda_egresados', 'CoordinadorAcademico@busqueda_egresado')->name('busqueda_egresados');
/*planeacion ACADEMICO esco cu*/
Route::get('info_coord_academica_1E', 'CoordinadorAcademico@info_coord_academica_1E')->name('info_coord_academica_1E');
Route::get('info_coord_academica_2E', 'CoordinadorAcademico@info_coord_academica_2E')->name('info_coord_academica_2E');
Route::get('info_coord_academica_3E', 'CoordinadorAcademico@info_coord_academica_3E')->name('info_coord_academica_3E');
Route::get('reporte9119E', 'CoordinadorAcademico@reporte9119E')->name('reporte9119E');
Route::get('reporte911_9A0E', 'CoordinadorAcademico@reporte911_9A0E')->name('reporte911_9A0E');
Route::get('reporte911_9A1E', 'CoordinadorAcademico@reporte911_9A1E')->name('reporte911_9A1E');
Route::get('reporte911_9A2E', 'CoordinadorAcademico@reporte911_9A2E')->name('reporte911_9A2E');
Route::get('reporte911_9A3E', 'CoordinadorAcademico@reporte911_9A3E')->name('reporte911_9A3E');
/*planeacion ACADEMICO semiesco cu*/
Route::get('info_coord_academica_1S', 'CoordinadorAcademico@info_coord_academica_1S')->name('info_coord_academica_1S');
Route::get('info_coord_academica_2S', 'CoordinadorAcademico@info_coord_academica_2S')->name('info_coord_academica_2S');
Route::get('info_coord_academica_3S', 'CoordinadorAcademico@info_coord_academica_3S')->name('info_coord_academica_3S');
Route::get('reporte9119S', 'CoordinadorAcademico@reporte9119S')->name('reporte9119S');
Route::get('reporte911_9A0S', 'CoordinadorAcademico@reporte911_9A0S')->name('reporte911_9A0S');
Route::get('reporte911_9A1S', 'CoordinadorAcademico@reporte911_9A1S')->name('reporte911_9A1S');
Route::get('reporte911_9A2S', 'CoordinadorAcademico@reporte911_9A2S')->name('reporte911_9A2S');
Route::get('reporte911_9A3S', 'CoordinadorAcademico@reporte911_9A3S')->name('reporte911_9A3S');

Route::get('cuenta_academica', 'CoordinadorAcademico@cuenta_academica')->name('cuenta_academica');
  Route::post('changePassword_academica','CoordinadorAcademico@changePassword')->name('changePassword_academica');
   Route::post('changeUser_academica','CoordinadorAcademico@changeuser')->name('changeUser_academica');
   Route::post('changeEmail_academica','CoordinadorAcademico@changemail')->name('changeEmail_academica');
   Route::post('changedatos_academica','CoordinadorAcademico@datos_personales_academica')->name('changedatos_academica');
    Route::get('/download_carga/{file}', 'CoordinadorAcademico@download');

});

/* Rutas de Estudiante---*/
  Route::group(['middleware' => 'auth','estudiantes'], function () {
  Route::get('home_estudiante', 'Estudiante_Con\EstudianteController@inicio_estudiante')->name('home_estudiante');
  Route::get('mis_actividades', 'Estudiante_Con\EstudianteController@activities')->name('mis_actividades');
  Route::get('perfil_estudiante', 'ConsultasController@datos_nombre')->name('perfil_estudiante');
  Route::get('datos_general', 'ConsultasController@carga_datos_general')->name('datos_general');
  Route::get('datos_generales', 'ConsultasController@carga_datos_general')->name('datos_generales');
  Route::post('datos_general_actualizar', 'RegistroEstudiantes@actualizacion_estudiante')->name('datos_general_actualizar');
  Route::get('otras_actividades', 'ConsultasController@carga_otras_actividades')->name('otras_actividades');
  Route::post('otras_actividades_actualizar', 'ActualizacionesEstudiante@actualizacion_actividades')->name('otras_actividades_actualizar');
  Route::post('act_actividades', 'ActualizacionesEstudiante@act_mis_actividades')->name('act_actividades');
  Route::get('datos_medico', 'ConsultasController@carga_datos_medicos')->name('datos_medico');
  Route::get('datos_personal', 'ConsultasController@carga_datos_personales')->name('datos_personal');
  Route::get('catalogo', 'Actividades\ActvidadesExtra@catalogos')->name('catalogo');
  Route::get('inscripcion_extracurricular/{id_extracurricular}/{creditos}', 'Actividades\ActvidadesExtra@inscripcion_extra');
  Route::post('changePassword','HomeController@changePassword')->name('changePassword');
  Route::get('ma_estudiante', 'Estudiante_Con\EstudianteController@m_estudiantes')->name('ma_estudiante');
  Route::get('mis_actividades', 'Estudiante_Con\EstudianteController@activities')->name('mis_actividades');
  Route::get('avance', 'Estudiante_Con\EstudianteController@avance_horas')->name('avance');
  Route::get('mi_taller', 'Estudiante_Con\EstudianteController@talleres_activos')->name('mi_taller');
  Route::get('pdfs','Estudiante_Con\EstudianteController@generatePDF');
  Route::get('cuenta', 'Estudiante_Con\EstudianteController@cuenta_estudiante')->name('cuenta');
  Route::get('foto_perfil', 'Estudiante_Con\EstudianteController@foto_perfil')->name('foto_perfil');
  Route::post('act_foto','HomeController@act_foto')->name('act_foto');
  Route::get('cuenta_form', 'FormacionIntegralController@cuenta_formaciones')->name('cuenta_form');
  Route::get('cambiar_estatus_beca/{id_beca}', 'ActualizacionesEstudiante@desactivar_lengua');
  Route::get('quitar_act/{id_externos}', 'ActualizacionesEstudiante@desactivar_act');
  Route::post('act_actividades', 'ActualizacionesEstudiante@act_actividades')->name('act_actividades');
  Route::post('act_datos_personales', 'ActualizacionesEstudiante@act_datos_personales')->name('act_datos_personales');
  Route::post('act_datos_medicos', 'ActualizacionesEstudiante@act_datos_medicos')->name('act_datos_medicos');
  Route::get('solicitud_taller', 'Estudiante_Con\EstudianteController@solicitud_taller')->name('solicitud_taller');
  Route::get('pdf_solicitud_taller/{matricula}','GenerarPdf@pdf_solicitud_taller_estudiante');
  Route::post('solicitud_taller_enviar', 'Actividades\ActvidadesExtra@envio_taller')->name('solicitud_taller_enviar');
  Route::get('descargar_solicitud_taller', 'GenerarPdf@descarga_taller');
  Route::get('descargar_solicitud_taller_act/{id_taller}', 'GenerarPdf@descarga_taller_act');
  Route::get('solicitud_practicasP', 'Estudiante_Con\EstudianteController@solicitud_practicasP')->name('solicitud_practicasP');
  Route::get('solicitud_servicioSocial', 'Estudiante_Con\EstudianteController@solicitud_servicioSocial')->name('solicitud_servicioSocial');
  Route::get('tutorias', 'Estudiante_Con\EstudianteController@tutorias')->name('tutorias');
  Route::get('lineamientos', 'Estudiante_Con\EstudianteController@lineamientos')->name('lineamientos');
  Route::get('equipamientosalon', 'Estudiante_Con\EstudianteController@equipamientosalon')->name('equipamientosalon');
  Route::get('generales_egresado', 'SeguimientoEgresadosController@generales_egresado')->name('generales_egresado');
  Route::post('generales_egresado_actu', 'SeguimientoEgresadosController@generales_egresado_actualizar')->name('generales_egresado_actu');
  Route::get('cuestionario_egresado', 'SeguimientoEgresadosController@cuestionario_egresado')->name('cuestionario_egresado');
  Route::post('cuestionario_egresado_actu', 'SeguimientoEgresadosController@cuestionario_egresado_actualizar')->name('cuestionario_egresado_actu');
  Route::get('antecedentes_laborales', 'SeguimientoEgresadosController@antecedentes_laborales')->name('antecedentes_laborales');
  Route::post('antecedentes_laborales_actu', 'SeguimientoEgresadosController@antecedentes_laborales_actualizar')->name('antecedentes_laborales_actu');
  Route::get('antecedentes_laborales', 'SeguimientoEgresadosController@antecedentes_laborales')->name('antecedentes_laborales');
  Route::get('talleres_finalizados_estudiante', 'Actividades\ActvidadesExtra@taller_finalizado_estudiante')->name('talleres_finalizados_estudiante');
  Route::get('descarga_lista_estudiante/{id_taller}','GenerarPdf@descargar_lista_taller');
  Route::post('enviar_solicitud_practicas', 'Estudiante_Con\EstudianteController@enviar_solicitud_practicas')->name('enviar_solicitud_practicas');
  Route::post('enviar_solicitud_servicio', 'Estudiante_Con\EstudianteController@enviar_solicitud_servicio')->name('enviar_solicitud_servicio');
  Route::get('cambiar_estatus_enfermedad/{id_enfermedad}', 'ActualizacionesEstudiante@desactivar_enfermedad');
  Route::get('registro_anterior', 'BusquedaAnteriorController@vista_atras_es')->name('registro_anterior');
  Route::any('registro_anterior_estudiante', 'BusquedaAnteriorController@anteriores_busqueda_es')->name('registro_anterior_estudiante');
  Route::get('avance_estudiante_es/{ID}', 'BusquedaAnteriorController@ver_avance_es');
  Route::get('pdf_solicitud_practicas', 'GenerarPdf@descarga_practicas');
  Route::get('/download/{file}', 'Estudiante_Con\EstudianteController@download');
  Route::post('acepto_lineamientos', 'Estudiante_Con\EstudianteController@aceptacion')->name('acepto_lineamientos');
  Route::get('cambiar_estatus_lengua/{id_lengua}', 'ActualizacionesEstudiante@quitar_lengua');
  Route::get('tutorias', 'Estudiante_Con\EstudianteController@tutorias')->name('tutorias');
  Route::post('tutorias_aceptar', 'Estudiante_Con\EstudianteController@encuesta_tuto')->name('tutorias_aceptar');
});

Route::get('register_tallerista', 'Auth\RegisterController@getRegister');
Route::post('register_tallerista', ['as' => 'register_tallerista', 'uses' => 'Auth\RegisterController@postRegister']);
Route::get('registros_talleristas', 'UserSystemController@index')->name('registros_talleristas');
/*FormacionIntegralController*/
Route::group(['middleware' => 'auth','formacionmiddleware'], function () {
Route::get('inicio_formacion', 'FormacionIntegralController@inicio_formacion')->name('inicio_formacion');
Route::get('register_tallerista', 'FormacionIntegralController@getRegister');
Route::get('form_nuevo_taller', 'FormacionIntegralController@form_nuevo_taller')->name('form_nuevo_taller');
Route::post('agregar_nuevo_taller', 'FormacionIntegralController@agregar_nuevo_taller')->name('agregar_nuevo_taller');
Route::get('busqueda_estudiante_fi', 'FormacionIntegralController@busqueda_estudiante_fi')->name('busqueda_estudiante_fi');
Route::any('busqueda_estudiante_formacion', 'FormacionIntegralController@busqueda_fi')->name('busqueda_estudiante_formacion');
Route::get('registrar_tutor', 'FormacionIntegralController@registrar_tutor')->name('registrar_tutor');
Route::get('registro_actividades', 'FormacionIntegralController@registro_actividad')->name('registro_actividades');
Route::post('registrar_actividad_estudiante', 'FormacionIntegralController@registro_actividad_es')->name('registrar_actividad_estudiante');
Route::post('registrar_tutor_fi', 'FormacionIntegralController@registrar_tutor_fi')->name('registrar_tutor_fi');
Route::get('busqueda_tutor', 'FormacionIntegralController@busqueda_tutor')->name('busqueda_tutor');
Route::get('tutor_activo', 'FormacionIntegralController@tutor_activo')->name('tutor_activo');
Route::get('desactivar_tutor/{id_tutor}', 'FormacionIntegralController@desactivar_tutor');
Route::get('activar_tutor/{id_tutor}', 'FormacionIntegralController@activar_tutor');
Route::get('tutor_inactivo', 'FormacionIntegralController@tutor_inactivo')->name('tutor_inactivo');
Route::get('registro_extracurricular', 'FormacionIntegralController@registro_extracurricular')->name('registro_extracurricular');
Route::get('registro_taller', 'FormacionIntegralController@registro_taller')->name('registro_taller');
Route::post('registrar_taller', 'FormacionIntegralController@registrar_taller')->name('registrar_taller');
Route::get('registro_conferencia', 'FormacionIntegralController@registro_conferencia')->name('registro_conferencia');
Route::post('registrar_conferencia', 'FormacionIntegralController@registrar_conferencia')->name('registrar_conferencia');
Route::get('fechas_actividades', 'FormacionIntegralController@actualizar_fechas_solicitud')->name('fechas_actividades');
Route::get('registro_tallerista', 'FormacionIntegralController@registro_tallerista')->name('registro_tallerista');
Route::post('registrar_talleristas', 'FormacionIntegralController@registrar_talleristas')->name('registrar_talleristas');
Route::get('tallerista_activo', 'FormacionIntegralController@tallerista_activo')->name('tallerista_activo');
Route::get('tallerista_inactivo', 'FormacionIntegralController@tallerista_inactivo')->name('tallerista_inactivo');
Route::get('desactivar_tallerista/{id_user}', 'FormacionIntegralController@desactivar_tallerista');
Route::get('activar_tallerista/{id_user}', 'FormacionIntegralController@activar_tallerista');
Route::get('actividades_registradas', 'FormacionIntegralController@actividades_registradas')->name('actividades_registradas');
Route::get('conferencias_registradas', 'FormacionIntegralController@confe_registradas')->name('conferencias_registradas');
Route::get('actividades_desactivadas_general', 'FormacionIntegralController@actividades_desactivadas')->name('actividades_desactivadas_general');
Route::get('actividades_finalizadas_general', 'FormacionIntegralController@actividades_finalizadas')->name('actividades_finalizadas_general');
Route::get('solicitudes', 'FormacionIntegralController@solicitudes')->name('solicitudes');
Route::get('asignar_taller', 'FormacionIntegralController@asignar_taller')->name('asignar_taller');
Route::get('actividades_asignadas', 'FormacionIntegralController@actividades_asignadas')->name('actividades_asignadas');
Route::get('registro_horas/{matricula}', 'FormacionIntegralController@anteriores');
Route::post('horas_estudiante', 'FormacionIntegralController@registro_hora')->name('horas_estudiante');
Route::get('busqueda_atras', 'BusquedaAnteriorController@vista_atras')->name('busqueda_atras');
Route::any('busqueda_atras_fi', 'BusquedaAnteriorController@anteriores_busqueda')->name('busqueda_atras_fi');
Route::get('avance_estudiante_a/{ID}', 'BusquedaAnteriorController@ver_avance');
Route::get('constancia_parcial_a/{ID}', 'BusquedaAnteriorController@constancia_par');
Route::get('constancia_valida_a/{ID}', 'BusquedaAnteriorController@constancia_val');
Route::get('avance_estudiante/{matricula}', 'FormacionIntegralController@ver_avance');
Route::get('constancia_parcial/{matricula}', 'FormacionIntegralController@constancia_par');
Route::get('constancia_valida/{matricula}', 'FormacionIntegralController@constancia_val');
Route::get('acreditar_estudiantes_formacion/{actividad}/{matricula}', 'FormacionIntegralController@acreditar_estudiantes');
Route::get('solicitud_correcion/{id_matricula}', 'Notificaciones@solicitud_correcion');
Route::post('replantear_solicitud', 'Notificaciones@enviar_correccion')->name('replantear_solicitud');
Route::get('solicitud_rechazo/{id_matricula}', 'Notificaciones@solicitud_rechazo');
Route::post('taller_rechazo', 'Notificaciones@enviar_rechazo')->name('taller_rechazo');
Route::get('solicitud_aprobada/{id_matricula}', 'Notificaciones@solicitud_aceptada');
Route::post('taller_aprobado', 'Notificaciones@enviar_aprobacion')->name('taller_aprobado');
Route::get('talleres_aprobados', 'FormacionIntegralController@taller_aprobado')->name('talleres_aprobados');
Route::get('pdf_taller_aprobado/{matricula}','GenerarPdf@pdf_apro_taller_estudiante');
Route::get('pdf_taller_cancelado/{matricula}','GenerarPdf@pdf_apro_taller_estudiante');
Route::get('pdf_taller_rechazado/{matricula}','GenerarPdf@pdf_apro_taller_estudiante');
Route::get('fecha_solicitud', 'FormacionIntegralController@actualizar_fechas_solicitud')->name('fecha_solicitud');
Route::get('notificaciones_enviadas', 'Notificaciones@enviadas_notifaciones')->name('notificaciones_enviadas');
Route::post('agregar_fecha_taller', 'FormacionIntegralController@fecha_taller')->name('agregar_fecha_taller');
Route::get('talleres_acreditados', 'FormacionIntegralController@taller_acreditado')->name('talleres_acreditados');
Route::post('finalizar_talleres_formacion', 'FormacionIntegralController@finalizar_taller_f')->name('finalizar_talleres_formacion');
Route::get('finalizar/{id_extracurricular}','RegistrosController@prueba');
Route::post('finalizar_taller', 'RegistrosController@finalizar_t')->name('finalizar_taller');
Route::get('desactivar_taller_estudiante/{id_extracurricular}/{matricula}','Notificaciones@cancelacion_aprobado');
Route::post('desactivar_extra', 'Notificaciones@enviar_cancelacion')->name('desactivar_extra');
Route::get('talleres_cancelados_estudiante', 'FormacionIntegralController@taller_can_estudiante')->name('talleres_cancelados_estudiante');
Route::get('acreditar_estudiante/{id_extracurricular}/{matricula}','Notificaciones@acreditacion_aprobado');
Route::post('acreditar_extra', 'Notificaciones@enviar_acreditacion')->name('acreditar_extra');
Route::get('cancelar_actividad/{id_extracurricular}','FormacionIntegralController@taller_desactivado');
Route::post('cancelar_actividad_general','FormacionIntegralController@cancel_actividad')->name('cancelar_actividad_general');
Route::get('actividades_canceladas', 'FormacionIntegralController@actividades_cancel')->name('actividades_canceladas');
Route::get('gestion_taller_estudiante/{id_extracurricular}', 'FormacionIntegralController@gestion_estudiante_taller');
Route::get('talleres_rechazados_estudiante', 'FormacionIntegralController@taller_rec_estudiante')->name('talleres_rechazados_estudiante');
Route::get('lista_inscritos_taller/{taller}/{matricula}','GenerarPdf@lista_estudiante_taller');
Route::get('lista_inscritos_talleres/{taller}/{tutor}','GenerarPdf@lista_talleres_re');
Route::get('lista_inscritos_conferencias/{taller}/{tutor}','GenerarPdf@lista_conferencia_re');
Route::get('editar_taller/{id_extracurricular}','FormacionIntegralController@editar_taller_re');
Route::post('actualizar_taller', 'FormacionIntegralController@actualizar_taller_re')->name('actualizar_taller');
Route::get('editar_conferencia/{id_extracurricular}','FormacionIntegralController@editar_conferencia_re');
Route::post('actualizar_conferencia', 'FormacionIntegralController@actualizar_conferencia_re')->name('actualizar_conferencia');
Route::get('detalles_taller_estudiantes/{id_extracurricular}', 'FormacionIntegralController@detalles_taller_estudiantes')->name('detalles_taller_estudiantes');
Route::get('detalles_taller_talleristas/{id_extracurricular}', 'FormacionIntegralController@detalles_taller_talleristas')->name('detalles_taller_talleristas');
Route::get('detalles_conferencias_registradas/{id_extracurricular}', 'FormacionIntegralController@detalles_taller_conferencias')->name('detalles_conferencias_registradas');
Route::get('inscritos_taller/{id_extracurricular}/{id_tutor}/{matricula}', 'FormacionIntegralController@inscritos_taller')->name('inscritos_taller');
Route::get('desactivar_estudiante_taller/{id_extracurricular}/{matricula}', 'FormacionIntegralController@desactivar_estudiante_taller');
Route::get('acreditar_estudiante_taller/{id_extracurricular}/{matricula}', 'FormacionIntegralController@acreditar_estudiante_taller');
Route::get('desacreditar_estudiante_taller/{id_extracurricular}/{matricula}', 'FormacionIntegralController@desacreditar_estudiante_taller');
Route::get('eliminar_estudiante_taller/{id_extracurricular}/{matricula}', 'FormacionIntegralController@eliminar_estudiante_taller');
Route::get('inscritos_talleres_t/{id_extracurricular}/{id_tutor}', 'FormacionIntegralController@inscritos_taller_t')->name('inscritos_taller');
Route::get('colaborador/{matricula}', 'FormacionIntegralController@registro_colaborador');
Route::post('horas_colaborador', 'FormacionIntegralController@registro_hora_co')->name('horas_colaborador');
Route::get('cuenta_formacion', 'FormacionIntegralController@cuenta_formacion')->name('cuenta_formacion');
Route::post('changePassword_formacion','FormacionIntegralController@changePassword')->name('changePassword_formacion');
Route::post('changeUser_formacion','FormacionIntegralController@changeuser')->name('changeUser_formacion');
Route::post('changeEmail_formacion','FormacionIntegralController@changemail')->name('changeEmail_formacion');
Route::post('changedatos_formacion','FormacionIntegralController@datos_personales_formacion')->name('changedatos_formacion');
Route::get('restablecer_contrasenia_tall/{id_user}', 'FormacionIntegralController@restablecimiento_talle');
Route::get('resultados_encuesta', 'FormacionIntegralController@tutorias_encu')->name('resultados_encuesta');
Route::any('busqueda_encuesta', 'FormacionIntegralController@busqueda_encu')->name('busqueda_encuesta');
Route::get('fecha_encuesta', 'FormacionIntegralController@actualizar_fechas_encuesta')->name('fecha_encuesta');
Route::post('agregar_fecha_encuesta', 'FormacionIntegralController@fecha_encuesta')->name('agregar_fecha_encuesta');
});
/*Rutas ADMIN DEL SISTEMA*/
Route::group(['middleware' => 'auth', 'adminmiddleware' ], function () {
  Route::get('form_nuevo_usuario', 'UserSystemController@form_nuevo_usuario')->name('form_nuevo_usuario');
  Route::post('agregar_nuevo_usuario', 'UserSystemController@agregar_nuevo_usuario')->name('agregar_nuevo_usuario');
  Route::get('busqueda', 'Administrativo_Con\AdministrativoController@formacion_busqueda')->name('busqueda');
  Route::get('home_admin', 'AdminController@home_admin')->name('home_admin');
  Route::get('registro_estudiante', 'AdminController@registro_estudiante')->name('registro_estudiante');
  Route::get('busqueda_estudiante', 'AdminController@busqueda_estudiante')->name('busqueda_estudiante');
  Route::get('estudiante_activo', 'AdminController@estudiante_activo')->name('estudiante_activo');
  Route::get('estudiante_inactivo', 'AdminController@estudiante_inactivo')->name('estudiante_inactivo');
  Route::get('editar_estudiante/{matricula}', 'AdminController@editar_estudiante');
  Route::get('registro_coordinador', 'AdminController@registro_coordinador')->name('registro_coordinador');
  Route::post('registro_estudiantes', 'RegistroEstudiantes@create_estudiante')->name('registro_estudiantes');
  Route::post('editar_estudiantes', 'RegistroEstudiantes@editar_estudiante')->name('editar_estudiantes');
  Route::post('registrar_coordinador', 'AdminController@registrar_coordinador')->name('registrar_coordinador');
  Route::get('busqueda_coordinador', 'AdminController@busqueda_coordinador')->name('busqueda_coordinador');
  Route::any('busqueda_coordinadores', 'AdminController@busqueda_coor')->name('busqueda_coordinadores');
  Route::get('coordinador_activo', 'AdminController@coordinador_activo')->name('coordinador_activo');
  Route::get('coordinador_inactivo', 'AdminController@coordinador_inactivo')->name('coordinador_inactivo');
  Route::any('busqueda_estudiantes', 'AdminController@Busqueda')->name('busqueda_estudiantes');
  Route::get('desactivar_estudiante/{id_user}', 'AdminController@desactivar_estudiante');
  Route::get('activar_estudiante/{id_user}', 'AdminController@activar_estudiante');
  Route::get('activar_coord/{id_user}', 'AdminController@activar_cordinador');
  Route::get('desactivar_coord/{id_user}', 'AdminController@desactivar_cordinador');
  Route::get('nuevo_periodo', 'AdminController@nuevo_periodo')->name('nuevo_periodo');
  Route::post('nuevo_periodo_agregar', 'AdminController@crear_periodo')->name('nuevo_periodo_agregar');
  Route::get('agregar_fecha', 'AdminController@nueva_actualizacion')->name('agregar_fecha');
  Route::post('agregar_fecha_actualizacion', 'AdminController@crear_fecha')->name('agregar_fecha_actualizacion');
  Route::get('restablecer_contrasenia/{matricula}', 'AdminController@restablecimiento');
  Route::get('hoja_de_d/{matricula}', 'AdminController@generar');
Route::get('registros_del_dia', 'Administrativo_Con\AdministrativoController@carga_hoy_admin')->name('registros_del_dia');
 Route::get('cuenta_admin', 'AdminController@cuenta_administrador')->name('cuenta_admin');
  Route::post('changePassword_admin','AdminController@changePassword')->name('changePassword_admin');
   Route::post('changeUser_admin','AdminController@changeuser')->name('changeUser_admin');
   Route::post('changeEmail_admin','AdminController@changemail')->name('changeEmail_admin');
   Route::post('changedatos_admin','AdminController@datos_personales_admin')->name('changedatos_admin');
    Route::get('restablecer_contrasenia_coor/{id_user}', 'AdminController@restablecimiento_coor');
});

Route::get('notes', 'Estudiante_Con\EstudianteController@index');
Route::get('pdf', 'Estudiante_Con\EstudianteController@pdf_g');
Route::get('consultitas', 'ConsultasController@carga_datos_general');

/*SERVICIO SOCIAL Y PRÁCTICAS PROFESIONALES*/
Route::group(['middleware' => 'auth', 'serviciomiddleware' ], function () {
  Route::get('home_servicios', 'ServiciosController@home_servicios')->name('home_servicios');
  Route::get('solicitudes_practicas', 'ServiciosController@solicitudes_practicas')->name('solicitudes_practicas');
  Route::get('estudiantes_activosPP', 'ServiciosController@estudiantes_activosPP')->name('estudiantes_activosPP');
  Route::get('estudiantes_activos_ss', 'ServiciosController@estudiantes_activosSS')->name('estudiantes_activos_ss');
  Route::get('egresado_registrado', 'ServiciosController@egresado_registrado')->name('egresado_registrado');
  Route::get('antecedentes_laborales_egresado', 'ServiciosController@antecedentes_laborales_egresado')->name('antecedentes_laborales_egresado');
  Route::get('cuestionario_egresado_ver', 'ServiciosController@cuestionario_egresado_ver')->name('cuestionario_egresado_ver');
  Route::get('generales_egresado_ver/{matricula}', 'ServiciosController@generales_egresado_ver');
  Route::get('practicas_aprobar/{id_practicas}', 'ServiciosController@aprobar_pr');
  //nuevas Rutas
  Route::get('expedientes_servicio_social', 'ServiciosController@solicitudes_serviciosocial')->name('expedientes_servicio_social');
  Route::get('expedientes_practicas_profesionales', 'ServiciosController@estudiantes_expedientes')->name('expedientes_practicas_profesionales');
  Route::get('pdf_solicitud_practica_estudiantes/{matricula}', 'GenerarPdf@descarga_practicas_es');
  Route::get('carta_noventa_porciento/{matricula}', 'GenerarPdf@carta_noventa');
  Route::get('servicio_aprobar/{id_practicas}', 'ServiciosController@aprobar_se');
  Route::get('practicas_acreditar/{id_practicas}/{matricula}', 'ServiciosController@acreditar_se');
  Route::get('practicas_cancelar/{id_practicas}', 'ServiciosController@cancelar_se');
  Route::get('cancelados_practicas', 'ServiciosController@solicitudes_cancelados')->name('cancelados_practicas');
  Route::get('ingresar_folio/{matricula}/{actividad}', 'ServiciosController@folio')->name('ingresar_folio');
  Route::post('ingreso_folio', 'ServiciosController@crear_folio')->name('ingreso_folio');
  Route::get('ingresar_fechas/{id_practicas}/{matricula}/{periodo}', 'ServiciosController@fecha_p')->name('ingresar_fechas');
  Route::post('ingreso_fechas', 'ServiciosController@crear_fecha_s')->name('ingreso_fechas');
  Route::get('ingresar_fechas_pr/{id_practicas}/{matricula}/{periodo}', 'ServiciosController@fecha_pr')->name('ingresar_fechas_pr');
  Route::post('actualizacion_fechas', 'ServiciosController@crear_fecha_es')->name('actualizacion_fechas');
  Route::get('ingresar_fechas/{id_practicas}/{matricula}/{periodo}', 'ServiciosController@fecha_p')->name('ingresar_fechas');
  Route::get('practicas_liberacion/{id_practicas}/{matricula}', 'ServiciosController@pdf_se');
  Route::any('busqueda_solicitudes_pr', 'ServiciosController@busqueda_solicitudes_pr')->name('busqueda_solicitudes_pr');
  Route::any('busqueda_activos_pr', 'ServiciosController@busqueda_activos_pr')->name('busqueda_activos_pr');
  Route::any('busqueda_expedientes_pr', 'ServiciosController@busqueda_expedientes_pr')->name('busqueda_expedientes_pr');
  Route::any('busqueda_activos_ss', 'ServiciosController@busqueda_activos_ss')->name('busqueda_activos_ss');
  Route::any('busqueda_expedientes_ss', 'ServiciosController@busqueda_expedientes_ss')->name('busqueda_expedientes_ss');
  Route::get('detalles_servicio/{matricula}', 'ServiciosController@detalles_serv');
    Route::get('info_practicas','ServiciosController@info_practicas')->name('info_practicas');

 Route::get('cuenta_ppssocial', 'ServiciosController@cuenta_ppssocial')->name('cuenta_ppssocial');
  Route::post('changePassword_ppssocial','ServiciosController@changePassword')->name('changePassword_ppssocial');
   Route::post('changeUser_ppssocial','ServiciosController@changeuser')->name('changeUser_ppssocial');
   Route::post('changeEmail_ppssocial','ServiciosController@changemail')->name('changeEmail_ppssocial');
   Route::post('changedatos_ppssocial','ServiciosController@datos_personales_ppssocial')->name('changedatos_ppssocial');
   });

Route::group(['middleware' => 'auth', 'planeacionmiddleware' ], function () {
  Route::get('home_planeacion', 'PlaneacionController@home_planeacion')->name('home_planeacion');
  Route::get('info_coord_academica1', 'PlaneacionController@info_coord_academica1')->name('info_coord_academica1');
  Route::get('info_coord_academica2', 'PlaneacionController@info_coord_academica2')->name('info_coord_academica2');
  Route::get('info_coord_academica3', 'PlaneacionController@info_coord_academica3')->name('info_coord_academica3');
  Route::get('info_coord_academica4', 'PlaneacionController@info_coord_academica4')->name('info_coord_academica4');
  Route::get('info_coord_academica5', 'PlaneacionController@info_coord_academica5')->name('info_coord_academica5');
  Route::get('info_formacion_integral1', 'PlaneacionController@info_formacion_integral1')->name('info_formacion_integral1');
  Route::get('gral_escuela', 'PlaneacionController@gral_escuela')->name('gral_escuela');
  Route::post('agregar_escuela', 'PlaneacionController@crear_escuela')->name('agregar_escuela');
  Route::get('gral_carrera', 'PlaneacionController@gral_carrera')->name('gral_carrera');
  Route::post('agregar_carrera', 'PlaneacionController@crear_carrera')->name('agregar_carrera');
  Route::get('carreras_registradas', 'PlaneacionController@info_carreras')->name('carreras_registradas');

  Route::get('reporte_semestral', 'PlaneacionController@reporte_semestral')->name('reporte_semestral');

  Route::get('reporte911_9', 'PlaneacionController@reporte911_9')->name('reporte911_9');

  Route::get('reporte911_9A_0', 'PlaneacionController@reporte911_9A_0')->name('reporte911_9A_0');
  Route::get('reporte911_9A_1', 'PlaneacionController@reporte911_9A_1')->name('reporte911_9A_1');
  Route::get('reporte911_9A_2', 'PlaneacionController@reporte911_9A_2')->name('reporte911_9A_2');
  Route::get('reporte911_9A_3', 'PlaneacionController@reporte911_9A_3')->name('reporte911_9A_3');
  Route::get('reporte911_9A_4', 'PlaneacionController@reporte911_9A_4')->name('reporte911_9A_4');
  Route::get('reporte911_9A_5', 'PlaneacionController@reporte911_9A_5')->name('reporte911_9A_5');
  Route::get('reporte911_9A_6', 'PlaneacionController@reporte911_9A_6')->name('reporte911_9A_6');

  Route::get('info_practicasp', 'PlaneacionController@info_practicasp')->name('info_practicasp');
  Route::get('info_serviciosocial', 'PlaneacionController@info_serviciosocial')->name('info_serviciosocial');

  Route::get('cuenta_planeacion', 'PlaneacionController@cuenta_planeacion')->name('cuenta_planeacion');
  Route::post('changePassword_planeacion','PlaneacionController@changePassword')->name('changePassword_planeacion');
   Route::post('changeUser_planeacion','PlaneacionController@changeuser')->name('changeUser_planeacion');
   Route::post('changeEmail_planeacion','PlaneacionController@changemail')->name('changeEmail_planeacion');
   Route::post('changedatos_planeacion','PlaneacionController@datos_personales_planeacion')->name('changedatos_planeacion');

});
/*INFO FORMACIÓN INTEGRAL*/ /*Seguimiento a Egresados*/
Route::get('home_seguimiento_egresados', 'SeguimientoEgresadosController@home_seguimiento_egresados')->name('home_seguimiento_egresados');
Route::get('registro_externo', 'RegistrosController@ver')->name('registro_externo');
Route::post('registro_externos', 'RegistrosController@create')->name('registro_externos');
Route::get('pdfsol','GenerarPdf@probado');
Route::get('libera','GenerarPdf@liberado');
Route::get('noventa','GenerarPdf@noventa');
Route::get('soli_pr','GenerarPdf@solicitud_de_p');

Auth::routes();
