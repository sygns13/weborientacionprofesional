<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Metodologiavocacional;
use App\Campoprofesional;
use Validator;
use Auth;
use DB;
use Storage;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class CampoprofesionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index1($idMetodologia)
    {
        if(accesoUser([1,3])){

        $modulo="gestionCampoProfs";

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


        return view('campoprofesional.index',compact('modulo','idMetodologia','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }


    public function index2($idMetodologia)
    {
        if(accesoUser([1,3])){

        $modulo="gestionCampoProfs2";

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

        return view('areaprofesional.index',compact('modulo','idMetodologia','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }


    public function index(Request $request)
    {   
        $buscar=$request->busca;
        $metodologiavocacional_id=$request->metodologiavocacional_id;

         $campoprofesionals = Campoprofesional::where('nombre', 'like', '%'.$buscar.'%')->where('metodologiavocacional_id',$metodologiavocacional_id)->where('borrado','0')->orderBy('orden')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $campoprofesionals->total(),
                'current_page'=> $campoprofesionals->currentPage(),
                'per_page'=> $campoprofesionals->perPage(),
                'last_page'=> $campoprofesionals->lastPage(),
                'from'=> $campoprofesionals->firstItem(),
                'to'=> $campoprofesionals->lastItem(),
            ],
            'campoprofesionals'=>$campoprofesionals
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
        $nombre=$request->nombre;
        $orden=$request->orden;
        $estado=$request->estado;

        $metodologiavocacional_id=$request->metodologiavocacional_id;

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:campoprofesionals,nombre'.',1,borrado');

        $camposProfs=Campoprofesional::where('metodologiavocacional_id',$metodologiavocacional_id)->where('borrado','0')->where('orden',$orden)->count();

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne un nombre válido';
            $selector='txtNombre';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El nombre consignado ya se encuentra registrado';
            $selector='txtNombre';
        }elseif ($camposProfs>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrden';
        }
        else{
            $newCamposProfs = new Campoprofesional();
                $newCamposProfs->nombre=$nombre;
                $newCamposProfs->orden=$orden;
                $newCamposProfs->activo=$estado;
                $newCamposProfs->borrado='0';
                $newCamposProfs->user_id=Auth::user()->id;
                $newCamposProfs->metodologiavocacional_id=$metodologiavocacional_id;

            $newCamposProfs->save();

            $msj='Nuevo Campo Profesional creado con éxito';
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
        $nombre=$request->nombre;
        $orden=$request->orden;
        $activo=$request->activo;

        $metodologiavocacional_id=$request->metodologiavocacional_id;

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        $reglas2 = array('nombre' => 'unique:campoprofesionals,nombre,'.$id.',id,borrado,0');

        $camposProfs=Campoprofesional::where('metodologiavocacional_id',$metodologiavocacional_id)->where('id','<>',$id)->where('borrado','0')->where('orden',$orden)->count();

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne un nombre válido';
            $selector='txtNombre';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El nombre consignado ya se encuentra registrado';
            $selector='txtNombre';
        }elseif ($camposProfs>0) {
            $result='0';
            $msj='El número de orden ingresado ya se encuentra registrado';
            $selector='txtNumOrden';
        }
        else{
            $newCamposProfs = Campoprofesional::findOrFail($id);
                $newCamposProfs->nombre=$nombre;
                $newCamposProfs->orden=$orden;
                $newCamposProfs->activo=$activo;
                $newCamposProfs->user_id=Auth::user()->id;

            $newCamposProfs->save();

            $msj='El campo Profesional ha sido modificado con éxito';
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

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateCampo = Campoprofesional::findOrFail($id);
        $updateCampo->activo=$estado;
        $updateCampo->save();

        if(strval($estado)=="0"){
            $msj='El Campo Profesional fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Campo Profesional fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }
    public function destroy($id)
    {
       $result='1';
        $msj='1';

        $consulta=DB::table('campoprofesionals')
                    ->join('maestrocarreras', 'maestrocarreras.campoprofesional_id', '=', 'campoprofesionals.id')
                    ->where('maestrocarreras.borrado','0')
                    ->where('campoprofesionals.id',$id)->count();

        $consulta2=DB::table('campoprofesionals')
                    ->join('alternativas', 'alternativas.campoprofesional_id', '=', 'campoprofesionals.id')
                    ->where('alternativas.borrado','0')
                    ->where('campoprofesionals.id',$id)->count();

        if ($consulta>0) {
            $result='0';
            $msj='El Campo Profesional Seleccionado cuenta con carreras profesionales registradas en él, por lo que no puede ser eliminado, primero elimine las carreras profesionales registradas dentrp del campo profesional';
        }elseif (($consulta2>0)) {
           $result='0';
            $msj='El Campo Profesional Seleccionado cuenta con alternativas asociadas a él, por lo que no puede ser eliminado, primero elimine las alternativas asociadas al campo profesional';
        }else{

        $borrarCampo = Campoprofesional::findOrFail($id);
        //$task->delete();

        $borrarCampo->borrado='1';

        $borrarCampo->save();

        $msj='Campo Profesional eliminado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
