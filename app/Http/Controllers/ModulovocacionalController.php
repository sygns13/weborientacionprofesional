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



class ModulovocacionalController extends Controller
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
        $titulo=$request->titulo;
        $fase=$request->fase;
        $pregsAlea=$request->pregsAlea;
        $descripcion=$request->descripcion;

        $minpregs=$request->minpregs;
        $maxlater=$request->maxlater;

        $metodologia=$request->metodologia;

        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');

        $modulovocacional=Modulovocacional::where('metodologiavocacional_id',$metodologia)->where('borrado','0')->where('fase',$fase)->count();

        $input2  = array('minpregs' => $minpregs);
        $reglas2 = array('minpregs' => 'required');

        $input3  = array('maxlater' => $maxlater);
        $reglas3 = array('maxlater' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Título del Módulo';
            $selector='txtTituloModNew';

        }elseif ($modulovocacional>0) {
            $result='0';
            $msj='La fase ingresada ya se encuentra configurada en otro módulo, ingrese otra';
            $selector='txtfaseN';

         }elseif ($validator2->fails()) {
            $result='0';
            $msj='Ingrese un mínimo de Preguntas válido';
            $selector='txtMinPregsN';
        }
        elseif ($validator3->fails()) {
            $result='0';
            $msj='Ingrese un máximo de alternativas a marcar válido';
            $selector='txtMaxAlterN';
        }
        else{
            $newModulo = new Modulovocacional();

                $newModulo->fase=$fase;
                $newModulo->titulo=$titulo;
                $newModulo->descripcion=$descripcion;
                $newModulo->pregaleatorias=$pregsAlea;
                $newModulo->activo='1';
                $newModulo->borrado='0';
                $newModulo->metodologiavocacional_id=$metodologia;
                $newModulo->user_id=Auth::user()->id;

            $newModulo->save();

            $newValidez = new Validez();

             $newValidez->minpreguntas=$minpregs;
             $newValidez->maxalternativas=$maxlater;
             $newValidez->activo='1';
             $newValidez->borrado='0';
             $newValidez->modulovocacional_id=$newModulo->id;
             $newValidez->user_id=Auth::user()->id;

             $newValidez->save();


            $msj='Nuevo Módulo de la Metodología Creado Con Éxito';
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
        $fase=$request->fase;
        $titulo=$request->titulo;
        $descripcion=$request->descripcion;
        $pregaleatorias=$request->pregaleatorias;
        $metodologiavocacional_id=$request->metodologiavocacional_id;

        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

        $modulovocacional=Modulovocacional::where('metodologiavocacional_id',$metodologiavocacional_id)->where('id','<>',$id)->where('borrado','0')->where('fase',$fase)->count();

         $result='1';
         $msj='';
         $selector='';

          if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Título del Módulo';
            $selector='txtTituloMod';

        }elseif ($modulovocacional>0) {
            $result='0';
            $msj='La fase ingresada ya se encuentra configurada en otro módulo, ingrese otra';
            $selector='txtfase';

        }
        else{
            $updateModulo = Modulovocacional::findOrFail($id);
                $updateModulo->fase=$fase;
                $updateModulo->titulo=$titulo;
                $updateModulo->descripcion=$descripcion;
                $updateModulo->pregaleatorias=$pregaleatorias;
                $updateModulo->user_id=Auth::user()->id;

            $updateModulo->save();

            $msj='El Módulo ha sido modificada con éxito';
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

       /* $consulta=DB::table('facultads')
                    ->join('carrerasunasams', 'carrerasunasams.facultad_id', '=', 'facultads.id')
                    ->where('carrerasunasams.borrado','0')
                    ->where('facultads.id',$id)->count();*/

        if (1==2) {
            $result='0';
            $msj='El módulo Seleccionada no puede ser eliminado, debido a que cuenta con registros de preguntas  dentro de el';
        }else{

        $borrarModulo = Modulovocacional::findOrFail($id);
        //$task->delete();

        $borrarModulo->borrado='1';

        $borrarModulo->save();

        $msj='el Módulo fue eliminado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }

    
}
