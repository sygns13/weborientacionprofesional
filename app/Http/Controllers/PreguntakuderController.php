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


class PreguntakuderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar=$request->busca;
        $idModulo=$request->idModulo;
        $idMet=$request->idMet;



         $preguntas = Pregunta::where('descripcion', 'like', '%'.$buscar.'%')->where('modulovocacional_id',$idModulo)->where('borrado','0')->orderBy('orden')->orderBy('id')->paginate(30);

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

         /*$preguntasMain = DB::table('preguntas')
            ->select(DB::raw('preguntas.orden,preguntas.obligatorio,preguntas.activo'))
         ->where('preguntas.modulovocacional_id',$idModulo)
         ->where('preguntas.borrado','0')
         ->where('preguntas.orden','>=',$priOrden)
         ->where('preguntas.orden','<=',$secOrden)
         ->groupBy('preguntas.orden')->get();*/

         $preguntasMain=DB::select("select * FROM preguntas p where p.modulovocacional_id='5' and p.orden>='".$priOrden."' and p.orden<='".$secOrden."' and p.borrado='0' group by p.orden order by p.orden;");

         $validez=Validez::where('borrado','0')->where('modulovocacional_id',$idModulo)->get();
        // $reglas=Regla::where('borrado','0')->where('modulovocacional_id',$idModulo)->get();

        

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
            'preguntasMain'=>$preguntasMain,
            'validez'=>$validez

        ];
    }

    public function getDatos(Request $request)
    {   
         $buscar=$request->busca;
        $idModulo=$request->idModulo;
        $idMet=$request->idMet;

         $preguntas = Pregunta::where('descripcion', 'like', '%'.$buscar.'%')->where('modulovocacional_id',$idModulo)->where('borrado','0')->orderBy('orden')->orderBy('id')->get();
               
        $campoprofesionals = Campoprofesional::where('metodologiavocacional_id',$idMet)->where('borrado','0')->orderBy('orden')->get();

         $priOrden="0";
         $secOrden="0";

         $aux=0;
         $suma=1;
         $ultimo=0;

         $array = array();

         foreach ($preguntas as $key => $dato) {
             if($key==0){
                $priOrden=$dato->orden;
             }
              $secOrden=$dato->orden;


              if($aux==$dato->orden){
                $suma++;
                $dato->activo=$suma;
              }elseif($aux==0){
                $aux=$dato->orden;
                $suma=0;
                $dato->activo=$suma;
              }else{
                $aux=$dato->orden;
                $suma=0;
                $dato->activo=$suma;
              }
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


          $preguntasMain=DB::select("select * FROM preguntas p where p.modulovocacional_id='5' and p.orden>='".$priOrden."' and p.orden<='".$secOrden."' and p.borrado='0' group by p.orden order by p.orden;");

          $cont=0;
          $cont2=0;
          foreach ($preguntasMain as $key => $dato) {

            if($cont==0){
                $array[]=$cont2;
            }

            $cont++;

            if($cont==10){
                $cont=0;
                $cont2++;
            }
         }


        

        return [
            'preguntas'=>$preguntas,
            'campoprofesionals'=>$campoprofesionals,
            'alternativas'=>$alternativas,
            'array'=>$array,
            'preguntasMain'=>$preguntasMain,

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
        $descripcion1=$request->descripcion1;
        $descripcion2=$request->descripcion2;
        $descripcion3=$request->descripcion3;

        $orden=$request->orden;
        $obligatorio=$request->obligatorio;
        $activo=$request->activo;

        $modulovocacional_id=$request->modulovocacional_id;

        $input1  = array('descripcion' => $descripcion1);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion2);
        $reglas2 = array('descripcion' => 'required');

        $input3 = array('descripcion' => $descripcion3);
        $reglas3 = array('descripcion' => 'required');



        $preguntas=Pregunta::where('modulovocacional_id',$modulovocacional_id)->where('borrado','0')->where('orden',$orden)->count();

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una pregunta 01 válida';
            $selector='txtpregunta1';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Consigne una pregunta 02 válida';
            $selector='txtpregunta2';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Consigne una pregunta 03 válida';
            $selector='txtpregunta3';
        }elseif ($preguntas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrden';
        }
        else{
            $newPregunta1 = new Pregunta();
                $newPregunta1->descripcion=$descripcion1;
                $newPregunta1->orden=$orden;
                $newPregunta1->obligatorio=$obligatorio;
                $newPregunta1->activo=$activo;
                $newPregunta1->borrado='0';
                $newPregunta1->modulovocacional_id=$modulovocacional_id;
                $newPregunta1->user_id=Auth::user()->id;

            $newPregunta1->save();

            $newPregunta2 = new Pregunta();
                $newPregunta2->descripcion=$descripcion2;
                $newPregunta2->orden=$orden;
                $newPregunta2->obligatorio=$obligatorio;
                $newPregunta2->activo=$activo;
                $newPregunta2->borrado='0';
                $newPregunta2->modulovocacional_id=$modulovocacional_id;
                $newPregunta2->user_id=Auth::user()->id;

            $newPregunta2->save();

            $newPregunta3 = new Pregunta();
                $newPregunta3->descripcion=$descripcion3;
                $newPregunta3->orden=$orden;
                $newPregunta3->obligatorio=$obligatorio;
                $newPregunta3->activo=$activo;
                $newPregunta3->borrado='0';
                $newPregunta3->modulovocacional_id=$modulovocacional_id;
                $newPregunta3->user_id=Auth::user()->id;

            $newPregunta3->save();

            $msj='Nueva Triada de Preguntas Creadas con éxito';
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
        $pregunta = Pregunta::findOrFail($id);

        $orden=$pregunta->orden;
        $idModulo=$pregunta->modulovocacional_id;

        $id1="";
        $id2="";
        $id3="";

        $pregunta1="";
        $pregunta2="";
        $pregunta3="";


        $preguntas = Pregunta::where('borrado','0')->where('modulovocacional_id',$idModulo)->where('orden',$orden)->orderBy('id')->get();


        foreach ($preguntas as $key => $dato) {
            
            if($key==0){
                $id1=$dato->id;
                $pregunta1=$dato->descripcion;

            }elseif($key==1){
                $id2=$dato->id;
                $pregunta2=$dato->descripcion;
            }elseif($key==2){
                $id3=$dato->id;
                $pregunta3=$dato->descripcion;
            }
        }

        return response()->json(["id1"=>$id1,'pregunta1'=>$pregunta1, "id2"=>$id2,'pregunta2'=>$pregunta2, "id3"=>$id3,'pregunta3'=>$pregunta3]);
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
        $descripcion2=$request->descripcion2;
        $descripcion3=$request->descripcion3;

        $id1=$request->id;
        $id2=$request->id2;
        $id3=$request->id3;

        $orden=$request->orden;
        $obligatorio=$request->obligatorio;
        $activo=$request->activo;

        $modulovocacional_id=$request->modulovocacional_id;


        $pregunta = Pregunta::findOrFail($id);

        $ordenOld=$pregunta->orden;


        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');

        $input2  = array('descripcion' => $descripcion2);
        $reglas2 = array('descripcion' => 'required');

        $input3 = array('descripcion' => $descripcion3);
        $reglas3 = array('descripcion' => 'required');

        $preguntas=Pregunta::where('modulovocacional_id',$modulovocacional_id)->where('orden','<>',$ordenOld)->where('borrado','0')->where('orden',$orden)->count();

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una pregunta 01 válida';
            $selector='txtpregunta1E';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Consigne una pregunta 02 válida';
            $selector='txtpregunta2E';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Consigne una pregunta 03 válida';
            $selector='txtpregunta3E';
        }elseif ($preguntas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrdenE';
        }
        else{
            $newPregunta1 =Pregunta::findOrFail($id1);
                $newPregunta1->descripcion=$descripcion;
                $newPregunta1->orden=$orden;
                $newPregunta1->obligatorio=$obligatorio;
                $newPregunta1->activo=$activo;
                $newPregunta1->user_id=Auth::user()->id;

            $newPregunta1->save();

            $newPregunta2 =Pregunta::findOrFail($id2);
                $newPregunta2->descripcion=$descripcion2;
                $newPregunta2->orden=$orden;
                $newPregunta2->obligatorio=$obligatorio;
                $newPregunta2->activo=$activo;
                $newPregunta2->user_id=Auth::user()->id;

            $newPregunta2->save();

            $newPregunta3 =Pregunta::findOrFail($id3);
                $newPregunta3->descripcion=$descripcion3;
                $newPregunta3->orden=$orden;
                $newPregunta3->obligatorio=$obligatorio;
                $newPregunta3->activo=$activo;
                $newPregunta3->user_id=Auth::user()->id;

            $newPregunta3->save();

            $msj='La triada de preguntas ha sido modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $pregunta = Pregunta::findOrFail($id);

        $orden=$pregunta->orden;
        $idModulo=$pregunta->modulovocacional_id;

        $id="";
        $preguntas = Pregunta::where('borrado','0')->where('modulovocacional_id',$idModulo)->where('orden',$orden)->orderBy('id')->get();

        foreach ($preguntas as $key => $dato) {
            $id=$dato->id;
        $updatePregunta = Pregunta::findOrFail($id);
        $updatePregunta->activo=$estado;
        $updatePregunta->save();

        if(strval($estado)=="0"){
            $msj='la Triada de Preguntas fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Triada de Preguntas fue Activada exitosamente';
        }

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

        $pregunta = Pregunta::findOrFail($id);

        $orden=$pregunta->orden;
        $idModulo=$pregunta->modulovocacional_id;

        $id="";
        $preguntas = Pregunta::where('borrado','0')->where('modulovocacional_id',$idModulo)->where('orden',$orden)->orderBy('id')->get();

        foreach ($preguntas as $key => $dato) {
            $id=$dato->id;

                $borrarPregunta = Pregunta::findOrFail($id);

                $borrarPregunta->borrado='1';

                $borrarPregunta->save();

                $msj='Pregunta eliminada exitosamente';
        }

        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    public function imprimirPlantilla($idMet, $idModulo)
    {

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');

        $modulo="gestionPreguntas2Imp";

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

        return view('preguntaskuder.plantilla',compact('modulo','idModulo','tituloMod','nombreMet','idMet','fecha','hora','tipouser','imagenPerfil'));

    }

    public function imprimirHoja($idMet, $idModulo)
    {

        $fecha = date('d/m/Y');
        $hora = date('H:i:s');

        $modulo="gestionPreguntas2Imp";

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

        return view('preguntaskuder.hoja',compact('modulo','idModulo','tituloMod','nombreMet','idMet','fecha','hora','tipouser','imagenPerfil'));

    }
}
