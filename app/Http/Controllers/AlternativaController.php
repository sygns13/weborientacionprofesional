<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Pregunta;
use App\Alternativa;
use App\Campoprofesional;

use Validator;
use Auth;
use DB;
use Storage;

class AlternativaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $alternativa=$request->alternativa;
        $descripcion=$request->descripcion;
        $orden=$request->orden;
        $puntaje=$request->puntaje;
        $detactividadprofesion=$request->detactividadprofesion;

        $pregunta_id=$request->pregunta_id;
        $campoprofesional_id=$request->campoprofesional_id;

        $input1  = array('alternativa' => $alternativa);
        $reglas1 = array('alternativa' => 'required');

        $input2  = array('alternativa' => $alternativa);
        $reglas2 = array('alternativa' => 'unique:alternativas,alternativa'.',1,borrado,pregunta_id,'.$pregunta_id);

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'required');

        $input4  = array('descripcion' => $descripcion);
        $reglas4 = array('descripcion' => 'unique:alternativas,descripcion'.',1,borrado,pregunta_id,'.$pregunta_id);


        $alternativas=Alternativa::where('pregunta_id',$pregunta_id)->where('borrado','0')->where('orden',$orden)->count();

        $input5  = array('campoprofesional_id' => $campoprofesional_id);
        $reglas5 = array('campoprofesional_id' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);

         $validator5 = Validator::make($input5, $reglas5);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una alternativa válida';
            $selector='txtAlterMarcar';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La alternativa consignada ya se encuentra registrada';
            $selector='txtAlterMarcar';

        }elseif ($validator3->fails())
        {
            $result='0';
            $msj='Consigne una descripcion de alternativa válida';
            $selector='txtAlternativa';

        }elseif ($validator4->fails()) {
            $result='0';
            $msj='La descripcion de alternativa consignada ya se encuentra registrada';
            $selector='txtAlternativa';
        }elseif ($alternativas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrden';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Campo Laboral Válido';
            $selector='cbuCampoLab';
        }
        else{
            $newAlternativa = new Alternativa();
                $newAlternativa->alternativa=$alternativa;
                $newAlternativa->descripcion=$descripcion;
                $newAlternativa->orden=$orden;
                $newAlternativa->puntaje=$puntaje;
                $newAlternativa->activo='1';
                $newAlternativa->borrado='0';
                $newAlternativa->user_id=Auth::user()->id;
                $newAlternativa->detactividadprofesion=$detactividadprofesion;
                $newAlternativa->pregunta_id=$pregunta_id;
                $newAlternativa->campoprofesional_id=$campoprofesional_id;

            $newAlternativa->save();

            $msj='Nueva Alternativa Creada con éxito';
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

    public function buscarAuto(Request $request)
    {
        $idModulo=$request->idModulo;
        $preguntas = Pregunta::where('modulovocacional_id',$idModulo)->where('borrado','0')->orderBy('orden')->get();

        $alternativas=DB::table('alternativas')
          ->join('preguntas', 'alternativas.pregunta_id', '=', 'preguntas.id')
          ->join('modulovocacionals', 'preguntas.modulovocacional_id', '=', 'modulovocacionals.id')
          ->join('campoprofesionals', 'alternativas.campoprofesional_id', '=', 'campoprofesionals.id')
          ->where('modulovocacionals.id',$idModulo)
          ->where('alternativas.borrado','0')
          ->where('preguntas.borrado','0')
          ->orderBy('alternativas.orden')
          ->orderBy('alternativas.pregunta_id')
          ->select('alternativas.id','alternativas.alternativa','alternativas.descripcion','alternativas.orden','alternativas.puntaje','alternativas.pregunta_id','alternativas.campoprofesional_id','alternativas.detactividadprofesion','campoprofesionals.nombre as campolaboral','preguntas.descripcion as pregunta','preguntas.orden as pregorden' , 'preguntas.id as idPregunta')->get();

          $arrayAlter = array();

          foreach ($preguntas as $key => $dato) {

            $a=0;
            $b=0;
            $c=0;
            $d=0;

              foreach ($alternativas as $key2 => $dato2) {
                  
                  if($dato->id==$dato2->idPregunta){

                        switch ($dato2->alternativa) {
                            case 'A':
                                $a=$dato2->id;
                                break;
                            case 'B':
                                $b=$dato2->id;
                                break;
                            case 'C':
                                $c=$dato2->id;
                                break;
                            case 'D':
                                $d=$dato2->id;
                                break;
                            
                            default:
                                # code...
                                break;
                        }
                  }

              }

              $aux=rand(1, 4);

              switch ($aux) {
                  case 1:
                      $arrayAlter[] = $a;
                      break;
                  case 2:
                      $arrayAlter[] = $b;
                      break;
                  case 3:
                      $arrayAlter[] = $c;
                      break;
                  case 4:
                      $arrayAlter[] = $d;
                      break;
                  
                  default:
                      # code...
                      break;
              }
          }

          return [

            'preguntas'=>$preguntas,
            'alternativas'=>$alternativas,
            'arrayAlter'=>$arrayAlter

        ];


    }


    public function buscarAuto2(Request $request)
    {
        $idModulo=$request->idModulo;

        $arrayAlter1 = array();
        $arrayAlter2 = array();

        $preguntas = Pregunta::where('modulovocacional_id',$idModulo)->where('borrado','0')->groupBy('orden')->orderBy('orden')->get();

        $alternativas = Pregunta::where('modulovocacional_id',$idModulo)->where('borrado','0')->orderBy('orden')->get();

          foreach ($preguntas as $key => $dato) {

            $alter1=0;
            $alter2=0;

            $id1=0;
            $id2=0;
            $id3=0;

            $cont=0;
            foreach ($alternativas as $key2 => $dato2) {



                if($dato->orden==$dato2->orden){

                    if($cont==0){
                        $id1=$dato2->id;
                    }elseif($cont==1){
                        $id2=$dato2->id;
                    }elseif($cont==2){
                        $id3=$dato2->id;
                    }
                    
                    $cont++;
                }

            }

            do{

                        $alter1=rand(1, 3);
                        $alter2=rand(1, 3);

                    }
                        while($alter1==$alter2);

            if($alter1==1){
                $arrayAlter1[] = intval($id1);
            }elseif($alter1==2){
                $arrayAlter1[] = intval($id2);
            }elseif($alter1==3){
                $arrayAlter1[] = intval($id3);
            }

            if($alter2==1){
                $arrayAlter2[] = intval($id1);
            }elseif($alter2==2){
                $arrayAlter2[] = intval($id2);
            }elseif($alter2==3){
                $arrayAlter2[] = intval($id3);
            }

            
       
          }

          return [

            'preguntas'=>$preguntas,
            'arrayAlter1'=>$arrayAlter1,
            'arrayAlter2'=>$arrayAlter2


        ];


    }


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
        $alternativa=$request->alternativa;
        $descripcion=$request->descripcion;
        $orden=$request->orden;
        $puntaje=$request->puntaje;
        $detactividadprofesion=$request->detactividadprofesion;

        $pregunta_id=$request->pregunta_id;
        $campoprofesional_id=$request->campoprofesional_id;

        $input1  = array('alternativa' => $alternativa);
        $reglas1 = array('alternativa' => 'required');

        $input2  = array('alternativa' => $alternativa);
        //$reglas2 = array('alternativa' => 'unique:alternativas,alternativa'.',1,borrado,pregunta_id,'.$pregunta_id);
        $reglas2 = array('alternativa' => 'unique:alternativas,alternativa,'.$id.',id,borrado,0,pregunta_id,'.$pregunta_id);

        $input3  = array('descripcion' => $descripcion);
        $reglas3 = array('descripcion' => 'required');

        $input4  = array('descripcion' => $descripcion);
       // $reglas4 = array('descripcion' => 'unique:alternativas,descripcion'.',1,borrado,pregunta_id,'.$pregunta_id);
        $reglas4 = array('descripcion' => 'unique:alternativas,descripcion,'.$id.',id,borrado,0,pregunta_id,'.$pregunta_id);


        $alternativas=Alternativa::where('pregunta_id',$pregunta_id)->where('id','<>',$id)->where('borrado','0')->where('orden',$orden)->count();

        $input5  = array('campoprofesional_id' => $campoprofesional_id);
        $reglas5 = array('campoprofesional_id' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);

         $validator5 = Validator::make($input5, $reglas5);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne una alternativa válida';
            $selector='txtAlterMarcarE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La alternativa consignada ya se encuentra registrada';
            $selector='txtAlterMarcarE';

        }elseif ($validator3->fails())
        {
            $result='0';
            $msj='Consigne una descripcion de alternativa válida';
            $selector='txtAlternativaE';

        }elseif ($validator4->fails()) {
            $result='0';
            $msj='La descripcion de alternativa consignada ya se encuentra registrada';
            $selector='txtAlternativaE';
        }elseif ($alternativas>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrdenE';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Campo Laboral Válido';
            $selector='cbuCampoLabE';
        }
        else{
            $newAlternativa = Alternativa::findOrFail($id);
                $newAlternativa->alternativa=$alternativa;
                $newAlternativa->descripcion=$descripcion;
                $newAlternativa->orden=$orden;
                $newAlternativa->puntaje=$puntaje;
                $newAlternativa->user_id=Auth::user()->id;
                $newAlternativa->detactividadprofesion=$detactividadprofesion;
                $newAlternativa->campoprofesional_id=$campoprofesional_id;

            $newAlternativa->save();

            

            $msj='Alternativa Modificada con éxito';
        }




       //Areaunasam::create($request->all());

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

      

        $borrarRegla = Alternativa::destroy($id);


        $msj='La Alternativa fue eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
