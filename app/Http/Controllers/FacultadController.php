<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facultad;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class FacultadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        if(accesoUser([1,2])){

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

        $modulo="facultades";

        return view('facultades.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
         $facultades = Facultad::where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('id')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $facultades->total(),
                'current_page'=> $facultades->currentPage(),
                'per_page'=> $facultades->perPage(),
                'last_page'=> $facultades->lastPage(),
                'from'=> $facultades->firstItem(),
                'to'=> $facultades->lastItem(),
            ],
            'facultades'=>$facultades
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
        $facultad=$request->facultad;
        $desc=$request->desc;
        $estado=$request->estado;

        $input1  = array('facultad' => $facultad);
        $reglas1 = array('facultad' => 'required');

        $input2  = array('facultad' => $facultad);
        $reglas2 = array('facultad' => 'unique:facultads,nombre'.',1,borrado');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Facultad.';
            $selector='txtfacultad';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Facultad consignada ya se encuentra registrada';
            $selector='txtfacultad';
        }
        else{
            $newFacultad = new Facultad();
                $newFacultad->nombre=$facultad;
                $newFacultad->descripcion=$desc;
                $newFacultad->activo=$estado;
                $newFacultad->borrado='0';
                $newFacultad->user_id=Auth::user()->id;

            $newFacultad->save();

            $msj='Nueva Facultad de la UNASAM creada con éxito';
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
        $facultad=$request->facultad;
        $descripcion=$request->descripcion;
        $estado=$request->estado;

        $input1  = array('facultad' => $facultad);
        $reglas1 = array('facultad' => 'required');

        $input2  = array('facultad' => $facultad);
        $reglas2 = array('facultad' => 'unique:facultads,nombre,'.$id.',id,borrado,0');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

          if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Facultad.';
            $selector='txtfacultadE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Facultad consignada ya se encuentra registrada';
            $selector='txtfacultadE';
        }
        else{
            $updateFacultad = Facultad::findOrFail($id);
                $updateFacultad->nombre=$facultad;
                $updateFacultad->descripcion=$descripcion;
                $updateFacultad->activo=$estado;
                $updateFacultad->user_id=Auth::user()->id;

            $updateFacultad->save();

            $msj='La Facultad ha sido modificada con éxito';
        }



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateFacultad = Facultad::findOrFail($id);
        $updateFacultad->activo=$estado;
        $updateFacultad->save();

        if(strval($estado)=="0"){
            $msj='La Facultad fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Facultad fue Activada exitosamente';
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

        $consulta=DB::table('facultads')
                    ->join('carrerasunasams', 'carrerasunasams.facultad_id', '=', 'facultads.id')
                    ->where('carrerasunasams.borrado','0')
                    ->where('facultads.id',$id)->count();

        if ($consulta>0) {
            $result='0';
            $msj='La Facultad Seleccionada no puede ser eliminada, debido a que cuenta con registros de carreras universitarias dentro de ella';
        }else{

        $borrarFacultad = Facultad::findOrFail($id);
        //$task->delete();

        $borrarFacultad->borrado='1';

        $borrarFacultad->save();

        $msj='Facultad eliminada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
