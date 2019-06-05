<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modulovocacional;
use App\Validez;
use App\Regla;
use Validator;
use Auth;
use DB;
use Storage;

class ReglaController extends Controller
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
        $descripcion=$request->descripcion;
        $activo=$request->activo;
        $modulovocacional_id=$request->modulovocacional_id;


        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');



         $validator1 = Validator::make($input1, $reglas1);


         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción de la Regla';
            $selector='editorNReg';

        }
        else{
            $newRegla = new Regla();

                $newRegla->descripcion=$descripcion;
                $newRegla->activo=$activo;
                $newRegla->borrado='0';
                $newRegla->modulovocacional_id=$modulovocacional_id;
                $newRegla->user_id=Auth::user()->id;

            $newRegla->save();

            $msj='Nueva Regla Registrada con Éxito';
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
        $activo=$request->activo;
        $modulovocacional_id=$request->modulovocacional_id;


        $input1  = array('descripcion' => $descripcion);
        $reglas1 = array('descripcion' => 'required');



         $validator1 = Validator::make($input1, $reglas1);


         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar la Descripción de la Regla';
            $selector='editorNReg';

        }
        else{
            $newRegla = Regla::findOrFail($id);

                $newRegla->descripcion=$descripcion;
                $newRegla->activo=$activo;
                $newRegla->user_id=Auth::user()->id;

            $newRegla->save();

            $msj='La Regla ha sido Modificada con Éxito';
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

      

        $borrarRegla = Regla::destroy($id);


        $msj='La Regla fue eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
