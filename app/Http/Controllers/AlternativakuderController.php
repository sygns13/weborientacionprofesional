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

class AlternativakuderController extends Controller
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

            $descripcion="";
            $orden="0";
            $puntaje="0";
            $detactividadprofesion="0";


        if($alternativa=="mas"){

            $descripcion="Le agrada más";
            $orden="0";
            $puntaje="1";
            $detactividadprofesion="0";

        }elseif($alternativa=="menos"){

            $descripcion="Le gusta menos";
            $orden="0";
            $puntaje="1";
            $detactividadprofesion="0";
        }

        $pregunta_id=$request->pregunta_id;
        $campoprofesional_id=$request->campoprofesional_id;

        

        $input5  = array('campoprofesional_id' => $campoprofesional_id);
        $reglas5 = array('campoprofesional_id' => 'required');

         $validator5 = Validator::make($input5, $reglas5);

         $result='1';
         $msj='';
         $selector='';

        if ($validator5->fails()) {
            $result='0';
            $msj='Seleccione un Área de Interés Válido';
            $selector='cbuCampoLab';

            
        }
        else{

        $alternativas=Alternativa::where('pregunta_id',$pregunta_id)->where('alternativa',$alternativa)->where('borrado','0')->where('campoprofesional_id',$campoprofesional_id)->count();

        if ($alternativas>0) {
            $result='0';
            $msj='La puntuación del Área de Interés ya se encuentra registrada para esta alternativa';
            $selector='txtNumOrden';
        }else{


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

            $msj='Nueva Puntuación de Alternativa Creada con éxito';
        }

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
        $result='1';
         $msj='1';

      

        $borrarRegla = Alternativa::destroy($id);


        $msj='La Puntuación de Alternativa fue eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
