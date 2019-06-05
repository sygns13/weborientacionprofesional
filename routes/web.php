<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    //    Route::get('/link1', function ()    {
//        // Uses Auth Middleware
//    });

    //Please do not remove this if you want adminlte:route and adminlte:link commands to works correctly.
    #adminlte_routes
Route::get('areasUNASAM','AreaunasamController@index1');
Route::get('ciclos','CicloController@index1');
Route::get('facultades','FacultadController@index1');
Route::get('carrerasUNASAM','CarreraunasamController@index1');
Route::get('alumnos','AlumnoController@index1');
Route::get('usuarios','UserController@index1');
Route::get('inventarioInteresesProfesionales','MetodologiavocacionalController@index1');
Route::get('kuder','MetodologiavocacionalController@index2');

Route::get('campoprofesionalippr/{idmetodologia}','CampoprofesionalController@index1');
Route::get('maestrocarreras/{idCampoProfs}','MaestrocarreraController@index1');

Route::get('campoprofesionalkuder/{idmetodologia}','CampoprofesionalController@index2');
Route::get('maestrocarreras2/{idCampoProfs}','MaestrocarreraController@index2');

Route::get('preguntasippr/{idModulo}','PreguntaController@index1');
Route::get('preguntaskuder/{idModulo}','PreguntaController@index2');



Route::resource('areas','AreaunasamController');
Route::resource('ciclo','CicloController');
Route::resource('facultad','FacultadController');
Route::resource('carreraunasam','CarreraunasamController');
Route::resource('informacion','InformacionController');
Route::resource('alumno','AlumnoController');
Route::resource('usuario','UserController');
Route::resource('metodologia','MetodologiavocacionalController');
Route::resource('modulo','ModulovocacionalController');
Route::resource('validez','ValidezController');
Route::resource('regla','ReglaController');
Route::resource('campoProfesional','CampoprofesionalController');
Route::resource('maestrocarrera','MaestrocarreraController');
Route::resource('pregunta','PreguntaController');
Route::resource('alternativa','AlternativaController');
Route::resource('preguntakuder','PreguntakuderController');
Route::resource('alternativakuder','AlternativakuderController');


Route::get('areas/altabaja/{id}/{var}','AreaunasamController@altabaja');
Route::get('ciclo/activar/{id}/{var}','CicloController@activar');
Route::get('facultad/altabaja/{id}/{var}','FacultadController@altabaja');
Route::get('carreraunasam/altabaja/{id}/{var}','CarreraunasamController@altabaja');
Route::get('informacion/altabaja/{id}/{var}','InformacionController@altabaja');
Route::get('informacion/deleteImg/{id}/{var}','InformacionController@deleteImg');
Route::get('informacion/deleteFile/{id}/{var}','InformacionController@deleteFile');
Route::get('informacion/cambiarAdj/{id}/{var}','InformacionController@cambiarAdj');
Route::post('informacion/editar','InformacionController@editar');
Route::get('alumno/verpersona/{dni}','AlumnoController@verpersona');
Route::get('alumno/altabaja/{id}/{var}','AlumnoController@altabaja');
Route::get('usuario/verpersona/{dni}','UserController@verpersona');
Route::get('usuario/altabaja/{id}/{var}','UserController@altabaja');
Route::get('campoProfesional/altabaja/{id}/{var}','CampoprofesionalController@altabaja');
Route::get('maestrocarrera/altabaja/{id}/{var}','MaestrocarreraController@altabaja');
Route::get('pregunta/altabaja/{id}/{var}','PreguntaController@altabaja');
Route::get('preguntakuder/altabaja/{id}/{var}','PreguntakuderController@altabaja');

//Impresiones IPP
Route::get('plantilla/imprimir/{id}/{id2}','PreguntaController@imprimirPlantilla');
Route::get('hoja/imprimir/{id}/{id2}','PreguntaController@imprimirHoja');
Route::get('plantilla/datos','PreguntaController@getDatos');


//Impresiones KUDER
Route::get('plantillakuder/imprimir/{id}/{id2}','PreguntakuderController@imprimirPlantilla');
Route::get('hojakuder/imprimir/{id}/{id2}','PreguntakuderController@imprimirHoja');
Route::get('plantillakuder/datos','PreguntakuderController@getDatos');




//Rutas Alumno
Route::get('alumnoDatos','AlumnoController@alumnoDatos');
Route::get('testIPP','TestController@index1');

Route::resource('test','TestController');
Route::resource('respuesta','DetallerespuestaController');

Route::get('testKUDER','TestController@index2');
Route::post('respuestakuder','DetallerespuestaController@respuestakuder');

Route::post('alternativa/buscarAuto','AlternativaController@buscarAuto');
Route::post('alternativa2/buscarAuto2','AlternativaController@buscarAuto2');

//Route::get('tests/buscar','TestController@buscar');

});
