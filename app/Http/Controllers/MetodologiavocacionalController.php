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

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class MetodologiavocacionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index1()
    {
        if(accesoUser([1,3])){

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

        $modulo="gestionippr";

        return view('ippr.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index2()
    {
        if(accesoUser([1,3])){

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

        $modulo="gestionkuder";

        return view('kuder.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index(Request $request)
    {
        $metodologia=$request->metodologia;
        $ippr = Metodologiavocacional::where('id',$metodologia)->where('borrado','0')->get();
        $modulovocacional=Modulovocacional::where('metodologiavocacional_id',$metodologia)->where('borrado','0')->orderBy('fase')->get();

        $validez=Validez::where('borrado','0')->get();
        $reglas=Regla::where('borrado','0')->get();



       return [
            'ippr'=>$ippr,
            'modulovocacional'=>$modulovocacional,
            'validez'=>$validez,
            'reglas'=>$reglas
        ];

        //return response()->json(['modulovocacional'=>$modulovocacional,"ippr"=>$ippr]);
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
        $nombre=$request->nombre;
        $descripcion=$request->descripcion;
        $descmostrar=$request->descmostrar;

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('descripcion' => $descripcion);
        $reglas2 = array('descripcion' => 'required');

        $input3  = array('descmostrar' => $descmostrar);
        $reglas3 = array('descmostrar' => 'required');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         $result='1';
         $msj='';
         $selector='';

          if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Metodología';
            $selector='txtNombre';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar la Descripción de la Metodología';
            $selector='editorD';

        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar la Descripción de la Metodología para Mostrar al Alumno';
            $selector='editorDM';

        }
        else{
            $updateMetodologia = Metodologiavocacional::findOrFail($id);
                $updateMetodologia->nombre=$nombre;
                $updateMetodologia->descripcion=$descripcion;
                $updateMetodologia->descmostrar=$descmostrar;
                $updateMetodologia->user_id=Auth::user()->id;

            $updateMetodologia->save();

            $msj='La Metodología ha sido modificada con éxito';
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
