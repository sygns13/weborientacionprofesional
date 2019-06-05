<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrerasunasam;
use App\Areaunasam;
use App\Facultad;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class CarreraunasamController extends Controller
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

        $modulo="carreraunasam";

        return view('carrerasunasam.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index(Request $request)
    {
        $buscar=$request->busca;
         //$carreras = Carreraunasam::where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('facultad_id')->paginate(10);
        // $carreras = Carreraunasam::showCarreras($buscar);

        $carreras=DB::table('carrerasunasams')
        ->join('facultads', 'carrerasunasams.facultad_id', '=', 'facultads.id')
        ->join('areaunasams', 'carrerasunasams.areaunasam_id', '=', 'areaunasams.id')
        ->where('carrerasunasams.borrado','0')
        ->where('carrerasunasams.nombre','like','%'.$buscar.'%')
        ->orderBy('carrerasunasams.facultad_id')
        ->orderBy('carrerasunasams.areaunasam_id')
        ->orderBy('carrerasunasams.id')
        ->select('facultads.id as idfac','facultads.nombre as facultad','facultads.activo as estadofac','areaunasams.id as idarea','areaunasams.nombre as area','areaunasams.activo as estadoarea','carrerasunasams.id as idcarre','carrerasunasams.nombre as carrera','carrerasunasams.descripcion','carrerasunasams.activo','carrerasunasams.borrado','carrerasunasams.user_id')->paginate(10);

        $areas=Areaunasam::where('borrado','0')->where('activo','1')->orderBy('id')->get();
        $facultades=Facultad::where('borrado','0')->where('activo','1')->orderBy('id')->get();


        return [
            'pagination'=>[
                'total'=> $carreras->total(),
                'current_page'=> $carreras->currentPage(),
                'per_page'=> $carreras->perPage(),
                'last_page'=> $carreras->lastPage(),
                'from'=> $carreras->firstItem(),
                'to'=> $carreras->lastItem(),
            ],
            'carreras'=>$carreras,
            'areas'=>$areas,
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
        $idarea=$request->area;
        $idfac=$request->facul;

        $carrera=$request->carrera;
        $desc=$request->desc;
        $estado=$request->estado;

        $input1  = array('carrera' => $carrera);
        $reglas1 = array('carrera' => 'required');

        $input2  = array('carrera' => $carrera);
        $reglas2 = array('carrera' => 'unique:carrerasunasams,nombre'.',1,borrado');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if(strlen($idarea)==0){
            $result='2';
            $msj='Seleccione un área Profesional';
            $selector='cbuarea';
         }elseif(strlen($idfac)==0){
            $result='2';
            $msj='Seleccione una Facultad';
            $selector='cbuFacultades';
         }

         elseif ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Carrera Profesional';
            $selector='txtcarrera';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Carrera Profesional consignada ya se encuentra registrada';
            $selector='txtcarrera';
        }
        else{
            $newCarrera = new Carrerasunasam();
                $newCarrera->nombre=$carrera;
                $newCarrera->descripcion=$desc;
                $newCarrera->areaunasam_id=$idarea;
   
                $newCarrera->activo=$estado;
                $newCarrera->borrado='0';
                $newCarrera->user_id=Auth::user()->id;
                $newCarrera->facultad_id=$idfac;

            $newCarrera->save();

            $msj='Nueva Carrera Profesional de la UNASAM creada con éxito';
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
        $idarea=$request->areaunasam_id;
        $idfac=$request->facultad_id;

        $carrera=$request->carrera;

        $descripcion=$request->descripcion;
        $estado=$request->estado;

        $input1  = array('carrera' => $carrera);
        $reglas1 = array('carrera' => 'required');

        $input2  = array('carrera' => $carrera);
        $reglas2 = array('carrera' => 'unique:carrerasunasams,nombre,'.$id.',id,borrado,0');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

          if(strlen($idarea)==0){
            $result='2';
            $msj='Seleccione un área Profesional';
            $selector='cbuarea';
         }elseif(strlen($idfac)==0){
            $result='2';
            $msj='Seleccione una Facultad';
            $selector='cbuFacultadesE';
         }

         elseif ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el Nombre de la Carrera Profesional';
            $selector='txtcarreraE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='La Carrera Profesional consignada ya se encuentra registrada';
            $selector='txtcarreraE';
        }
        else{
            $updateCarrera = Carrerasunasam::findOrFail($id);
                $updateCarrera->nombre=$carrera;
                $updateCarrera->descripcion=$descripcion;
                $updateCarrera->areaunasam_id=$idarea;
                $updateCarrera->activo=$estado;
                $updateCarrera->user_id=Auth::user()->id;
                $updateCarrera->facultad_id=$idfac;

            $updateCarrera->save();

            $msj='La Carrera Profesional ha sido modificada con éxito';
        }



        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }

    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateCarrera = Carrerasunasam::findOrFail($id);
        $updateCarrera->activo=$estado;
        $updateCarrera->save();

        if(strval($estado)=="0"){
            $msj='La Carrera Profesional fue Desactivada exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='La Carrera Profesional fue Activada exitosamente';
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

        $consulta=DB::table('carrerasunasams')
                    ->join('alumnos', 'alumnos.carrerasunasam_id', '=', 'carrerasunasams.id')
                    ->join('ciclos', 'ciclos.id', '=', 'alumnos.ciclo_id')
                    ->where('alumnos.borrado','0')
                    ->where('ciclos.estado','1')
                    ->where('carrerasunasams.id',$id)->count();

        if ($consulta>0) {
            $result='0';
            $msj='La Carrera profesional Seleccionada no puede ser eliminada, debido a que cuenta con registros de alumnos en el Ciclo Activo Actual';
        }else{

        $borrarCarrera = Carrerasunasam::findOrFail($id);
        //$task->delete();

        $borrarCarrera->borrado='1';

        $borrarCarrera->save();

        $msj='Carrera Profesional eliminada exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
