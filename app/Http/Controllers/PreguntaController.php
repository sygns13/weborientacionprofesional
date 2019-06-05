<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Metodologiavocacional;
use App\Modulovocacional;
use App\Validez;
use App\Regla;
use App\Pregunta;
use App\Alternativa;
use App\Campoprofesional;

use Validator;
use Auth;
use DB;
use Storage;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;



class PreguntaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1($idModulo)
    {
        if(accesoUser([1,3])){

        $modulo="gestionPreguntas";


        $moduloVoc=Modulovocacional::findOrFail($idModulo);

        $tituloMod=$moduloVoc->titulo;

        $metodologiaVoc=Metodologiavocacional::findOrFail($moduloVoc->metodologiavocacional_id);

        $nombreMet=$metodologiaVoc->nombre;

        $idMet=$metodologiaVoc->id;

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";
            foreach ($persona as $key => $dato) {
                $imagenPerfil=$dato->imagen;
            }



        return view('preguntas.index',compact('modulo','idModulo','tituloMod','nombreMet','idMet','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index2($idModulo)
    {
        if(accesoUser([1,3])){

        $modulo="gestionPreguntas2";


        $moduloVoc=Modulovocacional::findOrFail($idModulo);

        $tituloMod=$moduloVoc->titulo;

        $metodologiaVoc=Metodologiavocacional::findOrFail($moduloVoc->metodologiavocacional_id);

        $nombreMet=$metodologiaVoc->nombre;

        $idMet=$metodologiaVoc->id;

         $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";
            foreach ($persona as $key => $dato) {
                $imagenPerfil=$dato->imagen;
            }

        return view('preguntaskuder.index',compact('modulo','idModulo','tituloMod','nombreMet','idMet','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }


    public function index(Request $request)
    {   
        $buscar=$request->busca;
        $idModulo=$request->idModulo;
        $idMet=$request->idMet;

         $preguntas = Pregunta::where('descripcion', 'like', '%'.$buscar.'%')->where('modulovocacional_id',$idModulo)->where('borrado','0')->orderBy('orden')->paginate(10);

          $campoprofesionals = Campoprofesional::where('metodologiavocacional_id',$idMet)->where('borrado','0')->orderBy('orden')->get();

         $priOrden="0";
         $secOrden="0";

         foreach ($preguntas as $key => $dato) {
             if($key==0){
                $priOrden=$dato->orden;
             }
              $secOrden=$dato->orden;
         }

          $alternativas=DB::table('alternativas')
          ->join('preguntas', 'alternativas.pregunta_id', '=', 'preguntas.id')
          ->join('modulovocacionals', 'preguntas.modulovocacional_id', '=', 'modulovocacionals.id')
          ->join('campoprofesionals', 'alternativas.campoprofesional_id', '=', 'campoprofesionals.id')
          ->where('modulovocacionals.id',$idModulo)
          ->where('alternativas.borrado','0')
          ->where('preguntas.borrado','0')
          ->where('preguntas.orden','>=',$priOrden)
          ->where('preguntas.orden','<=',$secOrden)
          ->orderBy('alternativas.orden')
          ->orderBy('alternativas.pregunta_id')
          ->select('alternativas.id','alternativas.alternativa','alternativas.descripcion','alternativas.orden','alternativas.puntaje','alternativas.pregunta_id','alternativas.campoprofesional_id','alternativas.detactividadprofesion','campoprofesionals.nombre as campolaboral','preguntas.descripcion as pregunta','preguntas.orden as pregorden')->get();


          $reglas=Regla::where('borrado','0')->where('modulovocacional_id',$idModulo)->get();
          $validez=Validez::where('borrado','0')->where('modulovocacional_id',$idModulo)->get();

        

        return [
            'pagination'=>[
                'total'=> $preguntas->total(),
                'current_page'=> $preguntas->currentPage(),
                'per_page'=> $preguntas->perPage(),
                'last_page'=> $preguntas->lastPage(),
                'from'=> $preguntas->firstItem(),
                'to'=> $preguntas->lastItem(),
            ],
            'preguntas'=>$preguntas,
            'campoprofesionals'=>$campoprofesionals,
            'alternativas'=>$alternativas,
            'reglas'=>$reglas,
            'validez'=>$validez

        ];
    }







    public function getDatos(Request $request)
    {   
        $buscar=$request->busca;
        $idModulo=$request->idModulo;
        $idMet=$request->idMet;

         $preguntas = Pregunta::where('modulovocacional_id',$idModulo)->where('borrado','0')->where('activo','1')->orderBy('orden')->get();

          $campoprofesionals = Campoprofesional::where('metodologiavocacional_id',$idMet)->where('borrado','0')->orderBy('orden')->get();

         $priOrden="0";
         $secOrden="0";

         $aux="0";
         $colspan=1;
         $ultimo=0;

         $array = array();

         foreach ($preguntas as $key => $dato) {
             if($key==0){
                $priOrden=$dato->orden;
             }
              $secOrden=$dato->orden;

              if($aux==$dato->campoprofesional_id){
                $dato->activo="0";
                $colspan++;
              }elseif($aux=="0"){
                $aux=$dato->campoprofesional_id;
                $dato->activo="1";
              }
              else{
                $dato->activo="1";
                $aux=$dato->campoprofesional_id;
                $array[] = $colspan;
                $colspan=1;
              }
              $ultimo=$colspan;
              }

               $array[] = $ultimo;
               
          $alternativas=DB::table('alternativas')
          ->join('preguntas', 'alternativas.pregunta_id', '=', 'preguntas.id')
          ->join('modulovocacionals', 'preguntas.modulovocacional_id', '=', 'modulovocacionals.id')
          ->join('campoprofesionals', 'alternativas.campoprofesional_id', '=', 'campoprofesionals.id')
          ->where('modulovocacionals.id',$idModulo)
          ->where('alternativas.borrado','0')
          ->where('preguntas.borrado','0')
          ->where('preguntas.orden','>=',$priOrden)
          ->where('preguntas.orden','<=',$secOrden)
          ->orderBy('alternativas.orden')
          ->orderBy('alternativas.pregunta_id')
          ->select('alternativas.id','alternativas.alternativa','alternativas.descripcion','alternativas.orden','alternativas.puntaje','alternativas.pregunta_id','alternativas.campoprofesional_id','alternativas.detactividadprofesion','campoprofesionals.nombre as campolaboral','preguntas.descripcion as pregunta','preguntas.orden as pregorden')->get();


          $reglas=Regla::where('borrado','0')->where('modulovocacional_id',$idModulo)->get();

        

        return [
            'preguntas'=>$preguntas,
            'campoprofesionals'=>$campoprofesionals,
            'alternativas'=>$alternativas,
            'reglas'=>$reglas,
            'array'=>$array

        ];
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
        $descripcion=$request->descripcion;
        $orden=$request->orden;
        $obligatorio=$request->obligatorio;
        $activo=$request->activo;

        $modulovocacional_id=$request->modulovocacional_id;

        $campoprofesional_id=$request->campoprofesional_id;

        $detactividadprofesion=$request->detactividadprofesion;

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'unique:preguntas,descripcion'.',1,borrado');

        $preguntas=Pregunta::where('modulovocacional_id',$modulovocacional_id)->where('borrado','0')->where('orden',$orden)->count();

        $input5  = array('campoprofesional_id' => $campoprofesional_id);
        $reglas5 = array('campoprofesional_id' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $validator5 = Validator::make($input5, $reglas5);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una pregunta válida';
            $selector='txtpregunta';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La pregunta consignada ya se encuentra registrada';
            $selector='txtpregunta';
        }elseif ($preguntas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrden';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Campo Laboral Válido';
            $selector='cbuCampoLab';
        }
        else{
            $newPregunta = new Pregunta();
                $newPregunta->descripcion=$descripcion;
                $newPregunta->orden=$orden;
                $newPregunta->obligatorio=$obligatorio;
                $newPregunta->activo=$activo;
                $newPregunta->borrado='0';
                $newPregunta->modulovocacional_id=$modulovocacional_id;
                $newPregunta->user_id=Auth::user()->id;
                $newPregunta->campoprofesional_id=$campoprofesional_id;
                $newPregunta->detactividadprofesion=$detactividadprofesion;

            $newPregunta->save();



            $msj='Nueva Pregunta Creada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
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
        $descripcion=$request->descripcion;
        $orden=$request->orden;
        $obligatorio=$request->obligatorio;
        $activo=$request->activo;

        $modulovocacional_id=$request->modulovocacional_id;

        $campoprofesional_id=$request->campoprofesional_id;

        $detactividadprofesion=$request->detactividadprofesion;

        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'unique:preguntas,descripcion,'.$id.',id,borrado,0');

        $preguntas=Pregunta::where('modulovocacional_id',$modulovocacional_id)->where('id','<>',$id)->where('borrado','0')->where('orden',$orden)->count();

        $input5  = array('campoprofesional_id' => $campoprofesional_id);
        $reglas5 = array('campoprofesional_id' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $validator5 = Validator::make($input5, $reglas5);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una pregunta válida';
            $selector='txtpreguntaE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La pregunta consignada ya se encuentra registrada';
            $selector='txtpreguntaE';
        }elseif ($preguntas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrdenE';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Campo Laboral Válido';
            $selector='cbuCampoLabE';
        }
        else{
            $newPregunta =Pregunta::findOrFail($id);
                $newPregunta->descripcion=$descripcion;
                $newPregunta->orden=$orden;
                $newPregunta->obligatorio=$obligatorio;
                $newPregunta->activo=$activo;
                $newPregunta->user_id=Auth::user()->id;
                $newPregunta->campoprofesional_id=$campoprofesional_id;
                $newPregunta->detactividadprofesion=$detactividadprofesion;

            $newPregunta->save();

            $alternativas=Alternativa::where('pregunta_id',$id)->get();

            foreach ($alternativas as $key => $dato) {
                $editAlternativa = Alternativa::findOrFail($dato->id);
                $editAlternativa->campoprofesional_id=$campoprofesional_id;
                $editAlternativa->detactividadprofesion=$detactividadprofesion;

                $editAlternativa->save();
            }

            $msj='La pregunta ha sido modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updatePregunta = Pregunta::findOrFail($id);
        $updatePregunta->activo=$estado;
        $updatePregunta->save();

        if(strval($estado)=="0"){
            $msj='la Pregunta fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Pregunta fue Activada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarPregunta = Pregunta::findOrFail($id);
        //$task->delete();

        $borrarPregunta->borrado='1';

        $borrarPregunta->save();

        $msj='Pregunta eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function imprimirPlantilla($idMet, $idModulo)
    {

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');

        $modulo="gestionPreguntasImp";

        $moduloVoc=Modulovocacional::findOrFail($idModulo);

        $tituloMod=$moduloVoc->titulo;

        $metodologiaVoc=Metodologiavocacional::findOrFail($moduloVoc->metodologiavocacional_id);

        $nombreMet=$metodologiaVoc->nombre;

        $idMet=$metodologiaVoc->id;

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";
            foreach ($persona as $key => $dato) {
                $imagenPerfil=$dato->imagen;
            }

        return view('preguntas.plantilla',compact('modulo','idModulo','tituloMod','nombreMet','idMet','fecha','hora','tipouser','imagenPerfil'));

    }

    public function imprimirHoja($idMet, $idModulo)
    {

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');

        $modulo="gestionPreguntasImp";

        $moduloVoc=Modulovocacional::findOrFail($idModulo);

        $tituloMod=$moduloVoc->titulo;

        $metodologiaVoc=Metodologiavocacional::findOrFail($moduloVoc->metodologiavocacional_id);

        $nombreMet=$metodologiaVoc->nombre;

        $idMet=$metodologiaVoc->id;

        $iduser=Auth::user()->id;
        $idtipouser=Auth::user()->tipouser_id;
        $tipouser=Tipouser::find($idtipouser);

        $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.borrado','0')
        ->where('users.id',$iduser)
        ->select('personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();

            $imagenPerfil="";
            foreach ($persona as $key => $dato) {
                $imagenPerfil=$dato->imagen;
            }

        return view('preguntas.hoja',compact('modulo','idModulo','tituloMod','nombreMet','idMet','fecha','hora','tipouser','imagenPerfil'));

    }
}
