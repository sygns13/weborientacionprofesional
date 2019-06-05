<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Metodologiavocacional;
use App\Modulovocacional;
use App\Validez;
use App\Regla;
use Validator;
use Auth;
use DB;
use Storage;

class ValidezController extends Controller
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
        //
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
        $minpreguntas=$request->minpreguntas;
        $maxalternativas=$request->maxalternativas;
        $modulovocacional_id=$request->modulovocacional_id;

        $input1  = array('minpreguntas' => $minpreguntas);
        $reglas1 = array('minpreguntas' => 'required');

        $input2  = array('maxalternativas' => $maxalternativas);
        $reglas2 = array('maxalternativas' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $validator2 = Validator::make($input2, $reglas2);


         $result='1';
         $msj='';
         $selector='';

          if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Mínumo de Preguntas Resueltas por el Alumno';
            $selector='txtMinPregs';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el máximo de Alternativas que el Alumno puede marcar';
            $selector='txtMaxAlter';

        }
        else{
            $updateValidez = Validez::findOrFail($id);

                $updateValidez->minpreguntas=$minpreguntas;
                $updateValidez->maxalternativas=$maxalternativas;
                $updateValidez->user_id=Auth::user()->id;

            $updateValidez->save();

            $msj='Las Reglas de Validez han sido modificada con éxito';
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
        //
    }
}
