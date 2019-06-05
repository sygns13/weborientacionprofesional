<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Areaunasam;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class AreaunasamController extends Controller
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

        $modulo="areasUnasam";
        return view('areas.index',compact('modulo','tipouser','imagenPerfil'));
    }
    else
        {
            return view('adminlte::home');           
        }

   
}
    public function index(Request $request)
    {   
        $buscar=$request->busca;
         $areas = Areaunasam::where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('id')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $areas->total(),
                'current_page'=> $areas->currentPage(),
                'per_page'=> $areas->perPage(),
                'last_page'=> $areas->lastPage(),
                'from'=> $areas->firstItem(),
                'to'=> $areas->lastItem(),
            ],
            'areas'=>$areas
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
        $area=$request->area;
        $estado=$request->estado;

        $input1  = array('area' => $area);
        $reglas1 = array('area' => 'required');

        $input2  = array('area' => $area);
        $reglas2 = array('area' => 'unique:areaunasams,nombre'.',1,borrado');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Casillero Área.';
            $selector='txtarea';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El área consignada ya se encuentra registrada';
            $selector='txtarea';
        }
        else{
            $newArea = new Areaunasam();
                $newArea->nombre=$area;
                $newArea->activo=$estado;
                $newArea->borrado='0';
                $newArea->user_id=Auth::user()->id;

            $newArea->save();

            $msj='Nueva Área Académica UNASAM creada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    /**
     * Display the specified resource.
     *s
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
        $area=$request->area;
        $estado=$request->estado;

        $input1  = array('area' => $area);
        $reglas1 = array('area' => 'required');

        $input2  = array('area' => $area);
        $reglas2 = array('area' => 'unique:areaunasams,nombre,'.$id.',id,borrado,0');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Casillero Área.';
            $selector='txtarea';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El área consignada ya se encuentra registrada para otro registro';
            $selector='txtarea';
        }
        else{
            $updateArea = Areaunasam::findOrFail($id);
                $updateArea->nombre=$area;
                $updateArea->activo=$estado;
                $updateArea->user_id=Auth::user()->id;

            $updateArea->save();

            $msj='El Área Académica de la UNASAM ha sido modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateArea = Areaunasam::findOrFail($id);
        $updateArea->activo=$estado;
        $updateArea->save();

        if(strval($estado)=="0"){
            $msj='El Área fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Área fue Activado exitosamente';
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

        $consulta=DB::table('areaunasams')
                    ->join('carrerasunasams', 'carrerasunasams.areaunasam_id', '=', 'areaunasams.id')
                    ->where('carrerasunasams.borrado','0')
                    ->where('areaunasams.id',$id)->count();

        if ($consulta>0) {
            $result='0';
            $msj='El Área Seleccionado no puede ser eliminado, debido a que cuenta con registros de carreras de la UNASAM';
        }else{

        $borrararea = Areaunasam::findOrFail($id);
        //$task->delete();

        $borrararea->borrado='1';

        $borrararea->save();

        $msj='Área eliminada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
