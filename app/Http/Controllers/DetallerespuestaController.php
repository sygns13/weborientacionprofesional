<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Metodologiavocacional;
use App\Modulovocacional;
use App\Validez;
use App\Regla;
use App\Pregunta;
use App\Alternativa;
use App\Tipouser;
use App\Test;
use App\Detallerespuesta;
use App\Perfil;
use App\Campoprofesional;
use App\Analisiscampoprof;
use App\Maestrocarrera;

use Validator;
use Auth;
use DB;
use Storage;


class DetallerespuestaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idTest=$request->idTest;
        $idMeto=$request->idMeto;


     /*  $resultado = DB::table('tests')
                ->join('metodologiavocacionals', 'tests.metodologiavocacional_id', '=', 'metodologiavocacionals.id')
                ->join('perfils', 'perfils.test_id', '=', 'tests.id')
                ->where('tests.estado','>','1')
                ->where('tests.id',$idTest)
                ->orderBy('tests.id')
        ->select('tests.id','tests.fecha','tests.fechafin','tests.horainicio','tests.horafin','tests.estado','tests.alumno_id','tests.metodologiavocacional_id','metodologiavocacionals.nombre as tipo')->first();*/

        $test=Test::find($idTest);

        $perfil=Perfil::where('test_id',$idTest)->first();



    return response()->json(['test'=>$test,'perfil'=>$perfil]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $test=$request->test;
        $respuestas=$request->respuestas;

        $fecha=date("Y-m-d");
        $hora=date("H:i:s");

        $editTest = Test::findOrFail($test);
                $editTest->fechafin=$fecha;
                $editTest->horafin=$hora;
                $editTest->estado='2';
        $editTest->save();

        $puntajeProf=0;
        $puntajeActiv=0;

            $muybajoActi=0;
            $bajoActi=0;
            $medioActi=0;
            $altoActi=0;
            $muyAltoActi=0;

            $muybajoProf=0;
            $bajoProf=0;
            $medioProf=0;
            $altoProf=0;
            $muyAltoProf=0;

            $contcampos=0;

        $result='1';
         $msj='';
         $selector='';

         for ($i=0; $i <count($respuestas) ; $i++) { 
             $idAlter=$respuestas[$i];

             $alternativa=Alternativa::findOrFail($idAlter);
             $pregunta=Pregunta::findOrFail($alternativa->pregunta_id);

             $newRespuesta = new Detallerespuesta();

             $newRespuesta->pregunta_id=$pregunta->id;
             $newRespuesta->test_id=$editTest->id;
             $newRespuesta->alternativa_id=$alternativa->id;
             $newRespuesta->pregunta=$pregunta->descripcion;
             $newRespuesta->alternativa=$alternativa->alternativa;
             $newRespuesta->descripcion=$alternativa->descripcion;

             $newRespuesta->save();
         }

         $msj='Respuestas Guardadas con Éxito';

        // $newPerfil=analizarIPP($editTest);

         /*************************************Analisis de Validez    **************************************************/

          //Validez 02
        $respuestas=Detallerespuesta::where('test_id',$editTest->id)->get();
        $newPerfil="";

        $alterA=0;
        $alterB=0;
        $alterC=0;
        $alterD=0;

        $total=0;

        foreach ($respuestas as $key => $dato) {
            $total++;

            if($dato->alternativa=="A"){
                $alterA++;
            }elseif($dato->alternativa=="B"){
                $alterB++;
            }elseif($dato->alternativa=="C"){
                $alterC++;
            }elseif($dato->alternativa=="D"){
                $alterD++;
            }
        }

        $total90=$total*0.9;
        $b=0;

        if($total90<=$alterA){
            $b=1;
            $editTest->estado='3';
            $editTest->save();

            $newPerfil= new Perfil();

            $newPerfil->titulo="Validez de la Prueba no Superada";
            $newPerfil->descripcion="<p>ENTRE LAS RAZONES QUE PUEDEN PRODUCIR LA FALTA DE RESPUESTAS O
                                        COINCIDENCIAS DE LAS MISMAS, SE ENCUENTRAN:</p>
                                        <p>1. BAJO NIVEL DE INTERESES.</p>
                                        <p>2. POCO DOMINIO DE LA LECTURA O DEL IDIOMA.</p>
                                        <p>3. ERRORES AL ANOTAR LAS RESPUESTAS.</p>
                                        <p>4. CONTESTA SIN LEER LOS ELEMENTOS O ALTERNATIVAS.</p>
                                        <p>5. DEFICIENTE COMPRENSIÓN DE LAS INSTRUCCIONES.</p>
                                        <p>6. COMBINACIÓN DE LAS ANTERIORES.</p>";
            $newPerfil->descripcionalumno="<p>Se ha comprobado que ha marcado más del 90% la Alternativa A, por lo tanto la prueba no ha pasado la Comprobación de Validez de Consistencia.</p>";
            $newPerfil->test_id=$editTest->id;

            $newPerfil->save();


        }elseif($total90<=$alterB){
            $b=2;
            $editTest->estado='3';
            $editTest->save();

            $newPerfil= new Perfil();

            $newPerfil->titulo="Validez de la Prueba no Superada";
            $newPerfil->descripcion="<p>ENTRE LAS RAZONES QUE PUEDEN PRODUCIR LA FALTA DE RESPUESTAS O
                                        COINCIDENCIAS DE LAS MISMAS, SE ENCUENTRAN:</p>
                                        <p>1. BAJO NIVEL DE INTERESES.</p>
                                        <p>2. POCO DOMINIO DE LA LECTURA O DEL IDIOMA.</p>
                                        <p>3. ERRORES AL ANOTAR LAS RESPUESTAS.</p>
                                        <p>4. CONTESTA SIN LEER LOS ELEMENTOS O ALTERNATIVAS.</p>
                                        <p>5. DEFICIENTE COMPRENSIÓN DE LAS INSTRUCCIONES.</p>
                                        <p>6. COMBINACIÓN DE LAS ANTERIORES.</p>";
            $newPerfil->descripcionalumno="<p>Se ha comprobado que ha marcado más del 90% la Alternativa B, por lo tanto la prueba no ha pasado la Comprobación de Validez de Consistencia.</p>";
            $newPerfil->test_id=$editTest->id;

            $newPerfil->save();

        }elseif($total90<=$alterC){
            $b=3;
            $editTest->estado='3';
            $editTest->save();

            $newPerfil= new Perfil();

            $newPerfil->titulo="Validez de la Prueba no Superada";
            $newPerfil->descripcion="<p>ENTRE LAS RAZONES QUE PUEDEN PRODUCIR LA FALTA DE RESPUESTAS O
                                        COINCIDENCIAS DE LAS MISMAS, SE ENCUENTRAN:</p>
                                        <p>1. BAJO NIVEL DE INTERESES.</p>
                                        <p>2. POCO DOMINIO DE LA LECTURA O DEL IDIOMA.</p>
                                        <p>3. ERRORES AL ANOTAR LAS RESPUESTAS.</p>
                                        <p>4. CONTESTA SIN LEER LOS ELEMENTOS O ALTERNATIVAS.</p>
                                        <p>5. DEFICIENTE COMPRENSIÓN DE LAS INSTRUCCIONES.</p>
                                        <p>6. COMBINACIÓN DE LAS ANTERIORES.</p>";
            $newPerfil->descripcionalumno="<p>Se ha comprobado que ha marcado más del 90% la Alternativa C, por lo tanto la prueba no ha pasado la Comprobación de Validez de Consistencia.</p>";
            $newPerfil->test_id=$editTest->id;

            $newPerfil->save();
        }elseif($total90<=$alterD){
            $b=4;
            $editTest->estado='3';
            $editTest->save();

            $newPerfil= new Perfil();

            $newPerfil->titulo="Validez de la Prueba no Superada";
            $newPerfil->descripcion="<p>ENTRE LAS RAZONES QUE PUEDEN PRODUCIR LA FALTA DE RESPUESTAS O
                                        COINCIDENCIAS DE LAS MISMAS, SE ENCUENTRAN:</p>
                                        <p>1. BAJO NIVEL DE INTERESES.</p>
                                        <p>2. POCO DOMINIO DE LA LECTURA O DEL IDIOMA.</p>
                                        <p>3. ERRORES AL ANOTAR LAS RESPUESTAS.</p>
                                        <p>4. CONTESTA SIN LEER LOS ELEMENTOS O ALTERNATIVAS.</p>
                                        <p>5. DEFICIENTE COMPRENSIÓN DE LAS INSTRUCCIONES.</p>
                                        <p>6. COMBINACIÓN DE LAS ANTERIORES.</p>";
            $newPerfil->descripcionalumno="<p>Se ha comprobado que ha marcado más del 90% la Alternativa D, por lo tanto la prueba no ha pasado la Comprobación de Validez de Consistencia.</p>";
            $newPerfil->test_id=$editTest->id;

            $newPerfil->save();
        }


        //Validez Aceptada
        if($b==0){

            $newPerfil= new Perfil();

            $newPerfil->titulo="Resultados Perfil IPP";
            $newPerfil->descripcion="";
            $newPerfil->descripcionalumno="";
            $newPerfil->test_id=$editTest->id;
            $newPerfil->save();

            $campoProfesional=Campoprofesional::where('metodologiavocacional_id',$editTest->metodologiavocacional_id)->where('activo','1')->where('borrado','0')->orderby('orden')->get();


            $muybajoActi=0;
            $bajoActi=0;
            $medioActi=0;
            $altoActi=0;
            $muyAltoActi=0;

            $muybajoProf=0;
            $bajoProf=0;
            $medioProf=0;
            $altoProf=0;
            $muyAltoProf=0;

            $contcampos=0;
        
            $cont2=1;
        foreach ($campoProfesional as $key => $dato) {

            $contcampos++;


            $respuestas=DB::table('detallerespuestas')
            ->join('alternativas','alternativas.id','=','detallerespuestas.alternativa_id')
            ->join('preguntas','preguntas.id','=','alternativas.pregunta_id')

            ->where('detallerespuestas.test_id',$editTest->id)
            ->where('preguntas.campoprofesional_id',$dato->id)
            ->select('detallerespuestas.id as iddetres', 'detallerespuestas.pregunta as pregres', 'detallerespuestas.alternativa as alterres', 'detallerespuestas.descripcion as descalterres','preguntas.id as idpreg', 'preguntas.descripcion as descpreg', 'preguntas.orden as ordenpreg', 'preguntas.obligatorio as oblipreg', 'preguntas.modulovocacional_id as modulopreg', 'preguntas.campoprofesional_id as campoidpreg', 'preguntas.detactividadprofesion as detactivprofpreg', 'alternativas.id as idalter', 'alternativas.alternativa as alter', 'alternativas.descripcion as descalter', 'alternativas.orden as ordenalter', 'alternativas.puntaje as puntaje', 'alternativas.detactividadprofesion as detactivprof', 'alternativas.campoprofesional_id as campoid')->get();

            $puntajeProf=0;
            $puntajeActiv=0;
            $totalPercentil1=0;
            $totalPercentil2=0;
            $cont=0;
            

            foreach ($respuestas as $key1 => $datoRes) {

               // var_dump($datoRes->pregres);
               // var_dump($datoRes->iddetres);

                $cont++;
                if($datoRes->detactivprof=="1"){

                    $puntajeActiv=$puntajeActiv+intval($datoRes->puntaje);
                    $totalPercentil1=$totalPercentil1+2;

                }elseif($datoRes->detactivprof=="2"){

                    $puntajeProf=$puntajeProf+intval($datoRes->puntaje);
                    $totalPercentil2=$totalPercentil2+2;

                }
            }

           /* var_dump($cont2);

            var_dump($cont);
            var_dump($puntajeActiv);
            var_dump($totalPercentil1);

            var_dump($puntajeProf);
            var_dump($totalPercentil2);
*/
             $cont2++;

            $puntajeActiv=(100* $puntajeActiv)/$totalPercentil1;
            $puntajeProf=(100* $puntajeProf)/$totalPercentil2;


            $analisis="";



            if($puntajeActiv<=10){
                $analisis="muy bajo";
                $muybajoActi++;

            }elseif($puntajeActiv<=30){
                $analisis="bajo";
                $bajoActi++;

            }elseif($puntajeActiv<=70){
                $analisis="medio";
                $medioActi++;

            }elseif($puntajeActiv<=90){
                $analisis="alto";
                $altoActi++;

            }elseif($puntajeActiv>90){
                $analisis="muy alto";
                $muyAltoActi++;

            }

            $newAnalisis= new Analisiscampoprof();

            $newAnalisis->area=$dato->nombre;
            $newAnalisis->descripconarea=$dato->nombre;
            $newAnalisis->campoprofesional=$dato->id;
            $newAnalisis->orden=$dato->orden;
            $newAnalisis->analisis=$analisis;
            $newAnalisis->calificaciongral=$puntajeActiv;
            $newAnalisis->tipomedida='ordninal';
            $newAnalisis->activProf='1';
            $newAnalisis->perfil_id=$newPerfil->id;
            $newAnalisis->activo='1';
            $newAnalisis->borrado='0';

            $newAnalisis->save();



            $analisis2="";




            if($puntajeProf<=10){
                $analisis2="muy bajo";
                $muybajoProf++;

            }elseif($puntajeProf<=30){
                $analisis2="bajo";
                $bajoProf++;

            }elseif($puntajeProf<=70){
                $analisis2="medio";
                $medioProf++;

            }elseif($puntajeProf<=90){
                $analisis2="alto";
                $altoProf++;

            }elseif($puntajeProf>90){
                $analisis2="muy alto";
                $muyAltoProf++;
            }

            $newAnalisis2= new Analisiscampoprof();

            $newAnalisis2->area=$dato->nombre;
            $newAnalisis2->descripconarea=$dato->nombre;
            $newAnalisis2->campoprofesional=$dato->id;
            $newAnalisis2->orden=$dato->orden;
            $newAnalisis2->analisis=$analisis2;
            $newAnalisis2->calificaciongral=$puntajeProf;
            $newAnalisis2->tipomedida='ordninal';
            $newAnalisis2->activProf='2';
            $newAnalisis2->perfil_id=$newPerfil->id;
            $newAnalisis2->activo='1';
            $newAnalisis2->borrado='0';

             $newAnalisis2->save();

        }




            /*************Analisis Perfil*********************/

            $perfilFin="Perfil IPP-R Relativamente Normal";
            $descriPerfilFin="Cuenta con un perfil profesional relativamente normal debido a la elección de puntaje para cada pregunta, por lo que se le mostrará los campos profesionales que se adecúan más a su perfil y las carreras profesionales recomendadas.";



            if($muybajoActi==$contcampos){

            

                if($muybajoProf==$contcampos){

                    $perfilFin="Perfil Negativo No Válido";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba o sufre graves problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($bajoProf==$contcampos){

                    $perfilFin="Perfil Negativo Actividades, Bajo Profesiones";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a actividades y puntos bajos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o está sufriendo problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($medioProf==$contcampos){

                    $perfilFin="Perfil Negativo Actividades, Plano Profesiones";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a actividades y puntos medios en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que siente inseguridad al plasmar sus respuestas.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($altoProf==$contcampos){

                    $perfilFin="Perfil Negativo Actividades, Discrepancia en Profesiones";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a actividades y puntos altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($muyAltoProf==$contcampos){

                    $perfilFin="Perfil Negativo Actividades, Discrepancia en Profesiones";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a actividades y puntos muy altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }
                else{
                    $perfilFin="Perfil Negativo Actividades";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a actividades, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba o sufre graves problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();
                }

            }elseif($bajoActi==$contcampos){
            

                if($muybajoProf==$contcampos){

                    $perfilFin="Perfil No Válido";
                    $descriPerfilFin="Se encuentran puntos  bajos en toda la prueba en cuanto a actividades, y muy bajos en cuanto a profesiones  por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba o sufre problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($bajoProf==$contcampos){

                    $perfilFin="Perfil Bajo Actividades, Bajo Profesiones";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a actividades y puntos bajos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o está sufriendo problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($medioProf==$contcampos){

                    $perfilFin="Perfil Bajo Actividades, Plano Profesiones";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a actividades y puntos medios en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que siente inseguridad al plasmar sus respuestas.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($altoProf==$contcampos){

                    $perfilFin="Perfil Bajo Actividades, Discrepancia en Profesiones";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a actividades y puntos altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($muyAltoProf==$contcampos){

                    $perfilFin="Perfil Bajo Actividades, Discrepancia en Profesiones muy Altas";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a actividades y puntos muy altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }

                else{
                    $perfilFin="Perfil Bajo Actividades";
                    $descriPerfilFin="Se encuentran  bajos en toda la prueba en cuanto a actividades, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba o sufre problemas emocionales.";

                    $editTest->estado='4';
                    $editTest->save();
                }

            }elseif($medioActi==$contcampos){

                if($muybajoProf==$contcampos){

                    $perfilFin="Perfil Plano Actividades, muy Bajo Profesiones";
                    $descriPerfilFin="Se encuentran puntos  medios en toda la prueba en cuanto a actividades, y muy bajos en cuanto a profesiones  por lo que el perfil debe ser evaluado con mayor detenimiento, puede evidenciarse inseguridad al momento de registrar sus respuestas, o no realizó la prueba seriamente.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($bajoProf==$contcampos){

                    $perfilFin="Perfil Plano Actividades, Bajo Profesiones";
                    $descriPerfilFin="Se  encuentran puntos medios en toda la prueba en cuanto a actividades y puntos bajos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede evidenciarse inseguridad al momento de registrar sus respuestas, o no realizó la prueba seriamente.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($medioProf==$contcampos){
                    
                     $perfilFin="Perfil plano";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a actividades y profesiones sin puntos altos ni bajos, la persona no tiene preferencias marcadas ni sentimiento de rechazo por ninguna clase de trabajo. Estuvo Indeciso al realizar la prueba, o no la realizó con seriedad";

                    $editTest->estado='4';
                    $editTest->save();


                }elseif($altoProf==$contcampos){

                     $perfilFin="Perfil Plano Actividades, Alto en Profesiones";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a actividades y puntos altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();


                }elseif($muyAltoProf==$contcampos){

                    $perfilFin="Perfil Plano Actividades, muy Alto en Profesiones";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a actividades y puntos muy altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();


                }

                else{
                    $perfilFin="Perfil Plano Actividades";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a actividades, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();
                }

            }elseif($altoActi==$contcampos){

                if($muybajoProf==$contcampos){

                    $perfilFin="Perfil Alto en Actividades, Discrepancia con Profesiones muy Bajas";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a profesiones y puntos altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($bajoProf==$contcampos){

                    $perfilFin="Perfil Alto en Actividades, Discrepancia con Profesiones";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a profesiones y puntos altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($medioProf==$contcampos){

                    $perfilFin="Perfil Alto en Actividades, Plano Profesiones";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a profesiones y puntos altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que siente inseguridad al plasmar sus respuestas.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($altoProf==$contcampos){
                    $perfilFin="Perfil Alto Actividades, Alto en Profesiones";
                    $descriPerfilFin="Se encuentran puntos altos en toda la prueba en cuanto a actividades y puntos altos en cuanto a todas las profesiones, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba, o falta de conocimiento de las profesiones.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($muyAltoProf==$contcampos){

                    $perfilFin="Perfil No Válido";
                    $descriPerfilFin="Se encuentran puntos  altos en toda la prueba en cuanto a actividades, y muy altos en cuanto a profesiones  por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();

                }

                else{
                    $perfilFin="Perfil Alto Actividades";
                    $descriPerfilFin="Se encuentran puntos altos en toda la prueba en cuanto a actividades, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();
                }


            }elseif($muyAltoActi==$contcampos){

                if($muybajoProf==$contcampos){

                    $perfilFin="Perfil Muy Alto en Actividades, Discrepancia con Profesiones muy Bajas";
                    $descriPerfilFin="Se encuentran puntos muy bajos en toda la prueba en cuanto a profesiones y puntos muy altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();
                    

                }elseif($bajoProf==$contcampos){

                   $perfilFin="Perfil Muy Alto en Actividades, Discrepancia con Profesiones bajas";
                    $descriPerfilFin="Se encuentran puntos bajos en toda la prueba en cuanto a profesiones y puntos muy altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que no cuenta con suficiente información sobre lo que implica una profesión, o su elección se debe a la presión familiar, el prestigio, la remuneración, etc.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($medioProf==$contcampos){

                     $perfilFin="Perfil Alto en Actividades, Plano Profesiones";
                    $descriPerfilFin="Se encuentran puntos medios en toda la prueba en cuanto a profesiones y puntos muy altos en cuanto a las actividades, por lo que el perfil debe ser evaluado con mayor detenimiento, puede deberse a desinterés en realizar la prueba o que siente inseguridad al plasmar sus respuestas.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($altoProf==$contcampos){

                    $perfilFin="Perfil No Válido";
                    $descriPerfilFin="Se encuentran puntos  muy altos en toda la prueba en cuanto a actividades, y  altos en cuanto a profesiones  por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();

                }elseif($muyAltoProf==$contcampos){

                    $perfilFin="Perfil No Válido";
                    $descriPerfilFin="Se encuentran puntos muy altos en toda la prueba en cuanto a actividades, y muy altos en cuanto a profesiones  por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();

                }

                else{
                    $perfilFin="Perfil Muy Alto Actividades";
                    $descriPerfilFin="Se encuentran puntos muy altos en toda la prueba en cuanto a actividades, por lo que el perfil es no válido, puede deberse a desinterés en realizar la prueba.";

                    $editTest->estado='4';
                    $editTest->save();
                }

            }
            else{

                $campoProfesional=Campoprofesional::where('metodologiavocacional_id',$editTest->metodologiavocacional_id)->where('activo','1')->where('borrado','0')->orderby('orden')->get();

                $cont=0;

                $bandera=false;

                $descFinal="";
                $descFinalA="";

                $perfilFin="Perfil del Alumno Normal";
            $descriPerfilFin="";



                foreach ($campoProfesional as $key => $dato) {


                    $análisisActiv=Analisiscampoprof::where('perfil_id',$newPerfil->id)->where('campoprofesional',$dato->id)->where('activProf','1')->first();


                    $análisisProf=Analisiscampoprof::where('perfil_id',$newPerfil->id)->where('campoprofesional',$dato->id)->where('activProf','2')->first();

                    if(intval($análisisActiv->calificaciongral)>90){

                        if(intval($análisisProf->calificaciongral)>90){

                            $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias e Intereses Vocacionales muy altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;

                            }elseif(intval($análisisProf->calificaciongral)>70 && intval($análisisProf->calificaciongral)<=90){

                                $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias muy altas e Intereses Vocacionales altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;



                            }elseif(intval($análisisProf->calificaciongral)>70 && intval($análisisProf->calificaciongral)<=30){

                                $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales muy altas e Intereses Vocacionales medios en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;



                            }
                            elseif(intval($análisisProf->calificaciongral)<=30){

                            }


                    }elseif(intval($análisisActiv->calificaciongral)>70 && intval($análisisActiv->calificaciongral)<=90){

                        if(intval($análisisProf->calificaciongral)>90){

                            $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales altas e Intereses Vocacionales muy altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;

                            }elseif(intval($análisisProf->calificaciongral)>70 && intval($análisisProf->calificaciongral)<=90){

                                $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales altas e Intereses Vocacionales altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;



                            }elseif(intval($análisisProf->calificaciongral)>30 && intval($análisisProf->calificaciongral)<=70){

                                $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales  altas e Intereses Vocacionales medios en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;



                            }
                            elseif(intval($análisisProf->calificaciongral)<=30){

                            }



                    }elseif(intval($análisisActiv->calificaciongral)>30 && intval($análisisActiv->calificaciongral)<=70){

                        if(intval($análisisProf->calificaciongral)>90){

                            $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales medias e Intereses Vocacionales muy altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;

                            }elseif(intval($análisisProf->calificaciongral)>70 && intval($análisisProf->calificaciongral)<=90){

                                $descriPerfilFin.="<div class='col-md-12'>";

                            $descriPerfilFin.="<p>Usted tiene Preferencias actitudinales medias e Intereses Vocacionales altas en el Campo: <b>".$dato->nombre.".</b> por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";

                            $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->id)->get();

                            $descriPerfilFin.="<ul>";
                            foreach ($carreras as $carre) {
                                $descriPerfilFin.="<li>".$carre->nombre."</li>";
                            }

                            $descriPerfilFin.="<ul>";


                            $descriPerfilFin.="</div>";

                            $bandera=true;



                            }

                            elseif(intval($análisisProf->calificaciongral)>30 && intval($análisisProf->calificaciongral)<=70){

                            }elseif(intval($análisisProf->calificaciongral)<=30){

                            }

                    }elseif(intval($análisisActiv->calificaciongral)<=30){

                    }
                }

                if($bandera==false){
                    $perfilFin="Perfil de Discrepancia entre puntuaciones en actividades (A) y en profesiones (P): <br> <br>";
                    $descriPerfilFin="No realizó la prueba en forma conciente, o completó las alternativas aleatoriamente, o No tiene información suficiente sobre lo que implica una profesión. su elección puede deberse a la presión familiar, el prestigio, la remuneración, etc. <br>";

                    $editTest->estado='4';
                    $editTest->save();
                }

            }



            $newPerfil->titulo=$perfilFin;
            $newPerfil->descripcion=$descriPerfilFin;
            $newPerfil->descripcionalumno=$descriPerfilFin;
            $newPerfil->test_id=$editTest->id;
            $newPerfil->save();
    }


        $analisisCampo=Analisiscampoprof::where('perfil_id',$newPerfil->id)->get();

        /*


        $muybajoActi=0;
            $bajoActi=0;
            $medioActi=0;
            $altoActi=0;
            $muyAltoActi=0;

            $muybajoProf=0;
            $bajoProf=0;
            $medioProf=0;
            $altoProf=0;
            $muyAltoProf=0;

            $contcampos=0;
            */



 return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'perfil'=>$newPerfil,'test'=>$editTest,'analisisCampo'=>$analisisCampo, 'muybajoActi'=>$muybajoActi, 'bajoActi'=>$bajoActi, 'medioActi'=>$medioActi, 'altoActi'=>$altoActi, 'muyAltoActi'=>$muyAltoActi, 'muybajoProf'=>$muybajoProf, 'bajoProf'=>$bajoProf, 'medioProf'=>$medioProf, 'altoProf'=>$altoProf, 'muyAltoProf'=>$muyAltoProf, 'contcampos'=>$contcampos, 'perfilFin'=>$perfilFin, 'descriPerfilFin'=>$descriPerfilFin]);

    }


    public function respuestakuder(Request $request)
    {
        $test=$request->test;
        $respuestasMas=$request->respuestasMas;
        $respuestasMenos=$request->respuestasMenos;

        $fecha=date("Y-m-d");
        $hora=date("H:i:s");

        $editTest = Test::findOrFail($test);
                $editTest->fechafin=$fecha;
                $editTest->horafin=$hora;
                $editTest->estado='2';
        $editTest->save();

        $result='1';
         $msj='';
         $selector='';

         for ($i=0; $i <count($respuestasMas) ; $i++) { 
             $idPreg=$respuestasMas[$i];

            // $alternativa=Alternativa::findOrFail($idAlter);
             $pregunta=Pregunta::findOrFail($idPreg);

             $newRespuesta = new Detallerespuesta();

             $newRespuesta->pregunta_id=$pregunta->id;
             $newRespuesta->test_id=$editTest->id;
             $newRespuesta->alternativa_id='1';
             $newRespuesta->pregunta=$pregunta->descripcion;
             $newRespuesta->alternativa='mas';
             $newRespuesta->descripcion='Le agrada más';

             $newRespuesta->save();
         }

         for ($i=0; $i <count($respuestasMenos) ; $i++) { 
             $idPreg=$respuestasMenos[$i];

            // $alternativa=Alternativa::findOrFail($idAlter);
             $pregunta=Pregunta::findOrFail($idPreg);

             $newRespuesta = new Detallerespuesta();

             $newRespuesta->pregunta_id=$pregunta->id;
             $newRespuesta->test_id=$editTest->id;
             $newRespuesta->alternativa_id='-1';
             $newRespuesta->pregunta=$pregunta->descripcion;
             $newRespuesta->alternativa='menos';
             $newRespuesta->descripcion='Le gusta menos';

             $newRespuesta->save();
         }

         $msj='Respuestas Guardadas con Éxito';


         // Iniciando el Análisis de Data

           $newPerfil= new Perfil();

            $newPerfil->titulo="Resultados Perfil KUDER - Resultados de Alumno Normal";
            $newPerfil->descripcion="";
            $newPerfil->descripcionalumno="";
            $newPerfil->test_id=$editTest->id;
            $newPerfil->save();

             $perfilFin="Resultados Perfil KUDER - Resultados de Alumno Normal";
             
         $campoprofesionals=Campoprofesional::where('metodologiavocacional_id','2')->where('activo','1')->where('borrado','0')->orderby('orden')->get();

         $respuestas=Detallerespuesta::where('test_id',$editTest->id)->get();

         $bajo=0;
         $medio=0;
         $alto=0;

         foreach ($campoprofesionals as $key => $dato) {

            $alterzero=DB::select("select count(p.orden) as contar, p.orden FROM alternativas a
                inner join preguntas p on p.id=a.pregunta_id
                where a.campoprofesional_id=".$dato->id."
                group by p.orden
                order by p.orden;");

            $restar=0;

            foreach ($alterzero as $key2 => $dato2) {
                if(intval($dato2->contar)>2){
                    $restar=$restar+intval($dato2->contar)-2;
                }
            }
             
             $alternativas=DB::table('alternativas')
             ->join('preguntas','preguntas.id','=','alternativas.pregunta_id')
             ->where('alternativas.campoprofesional_id',$dato->id)
             ->where('alternativas.activo','1')->where('alternativas.borrado',0)
             ->orderby('preguntas.orden')
             ->select('alternativas.id','alternativas.alternativa','alternativas.pregunta_id','preguntas.orden')->get();

             $cont=0;
             $contr=0;


             foreach ($alternativas as $key2 => $dato2) {

                $pregunta=Pregunta::find($dato2->pregunta_id);

                $cont++;

                foreach ($respuestas as $key3 => $dato3) {
                    
                    if($dato2->pregunta_id==$dato3->pregunta_id && $dato2->alternativa==$dato3->alternativa){
                        $contr++;
                    }
                }
             }

             //var_dump($cont);
             //var_dump($contr);

             $cont=$cont-$restar;

              $porcent=(100* $contr)/$cont;

              //var_dump($restar);
              //var_dump($cont);


            $analisis="";



            if($porcent<23){
                $analisis="no es del agrado del examinado";
                $bajo++;

            }elseif($porcent<=76){
                $analisis="agrado del tipo corriente";
                $medio++;

            }elseif($porcent>76){
                $analisis="le gustaría el área";
                $alto++;

            }

            $newAnalisis= new Analisiscampoprof();

            $newAnalisis->area=$dato->nombre;
            $newAnalisis->descripconarea=$dato->descripcion;
            $newAnalisis->campoprofesional=$dato->id;
            $newAnalisis->orden=$dato->orden;
            $newAnalisis->analisis=$analisis;
            $newAnalisis->calificaciongral=$porcent;
            $newAnalisis->tipomedida='ordninal';
            $newAnalisis->activProf='0';
            $newAnalisis->perfil_id=$newPerfil->id;
            $newAnalisis->activo='1';
            $newAnalisis->borrado='0';

            $newAnalisis->save();



         }

         //Análisis del Perfil

      
        $descriPerfilFin="";

         $analisis=Analisiscampoprof::where('perfil_id',$newPerfil->id)->get();

         
         $auxresp=0;

         foreach ($analisis as $key => $dato) {
             

             if(floatval($dato->calificaciongral)>76)
             {
                $auxresp++;

                $descriPerfilFin.="<div class='col-md-12'>";

                if($auxresp==1){
                    $descriPerfilFin.="<p>Usted tiene muy altos Intereses Profesionales en el Área: <b>".$dato->area.".</b></p>

                    <p>".$dato->descripconarea."</p>

                 <p>Por lo que según los resultados del TEST, podría desempeñarse muy bien en las siguientes carreras profesionales:</p>";
                }
                else{
                    $descriPerfilFin.="<p>Usted también tiene muy altos Intereses Profesionales en el Área: <b>".$dato->area.".</b></p>

                    <p>".$dato->descripconarea."</p>

                 <p>Por lo que según los resultados del TEST, podría desempeñarse muy bien en las siguientes carreras profesionales:</p>";
                }
                

                $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->campoprofesional)->get();

                $descriPerfilFin.="<ul>";
                foreach ($carreras as $carre) {
                    $descriPerfilFin.="<li>".$carre->nombre."</li>";
                }

                $descriPerfilFin.="<ul>";


                $descriPerfilFin.="</div>";
             }
         }

         if($auxresp==0){

            $auxresp2=0;

         foreach ($analisis as $key => $dato) {
             

             if(floatval($dato->calificaciongral)>65)
             {
                $auxresp2++;

                $descriPerfilFin.="<div class='col-md-12'>";

                if($auxresp2==1){
                    $descriPerfilFin.="<p>Usted tiene altos Intereses Profesionales en el Área: <b>".$dato->area.".</b></p>

                    <p>".$dato->descripconarea."</p>

                 <p>Por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";
                }
                else{
                    $descriPerfilFin.="<p>Usted también tiene altos Intereses Profesionales en el Área: <b>".$dato->area.".</b></p>

                    <p>".$dato->descripconarea."</p>

                 <p>Por lo que según los resultados del TEST, podría desempeñarse bien y/o regularmente en las siguientes carreras profesionales:</p>";
                }
                

                $carreras=Maestrocarrera::where('activo','1')->where('borrado','0')->where('campoprofesional_id',$dato->campoprofesional)->get();

                $descriPerfilFin.="<ul>";
                foreach ($carreras as $carre) {
                    $descriPerfilFin.="<li>".$carre->nombre."</li>";
                }

                $descriPerfilFin.="<ul>";


                $descriPerfilFin.="</div>";
             }
         }


         if($auxresp2==0){
            $perfilFin="El test completado no muestra intereses por ningún Área Profesional, por lo que la prueba no es válida <br> <br>";
                    $descriPerfilFin="No realizó la prueba en forma conciente, o completó las alternativas aleatoriamente.  <br>
                    Esto puede deberse a que el examinado no entendió bien las instrucciones o ha tenido dificultad para comprender los items, o el examinado contestó de una manera descuidada o insincera. O el examinado aun no tiene sus intereses bien definidos.
                    <br>";

                    $editTest->estado='4';
                    $editTest->save();

         }

                
         }

            $newPerfil->titulo=$perfilFin;
            $newPerfil->descripcion=$descriPerfilFin;
            $newPerfil->descripcionalumno=$descriPerfilFin;
            $newPerfil->test_id=$editTest->id;
            $newPerfil->save();


            $analisisCampo=Analisiscampoprof::where('perfil_id',$newPerfil->id)->get();
         

         //return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

 return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'perfil'=>$newPerfil,'test'=>$editTest,'analisisCampo'=>$analisisCampo, 'perfilFin'=>$perfilFin, 'descriPerfilFin'=>$descriPerfilFin]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
