<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ciclo;
use Validator;
use Auth;
use DB;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class CicloController extends Controller
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

        $modulo="ciclos";

        return view('ciclos.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }


    public function index(Request $request)
    {
        $buscar=$request->busca;
         $ciclos = Ciclo::where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('id')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $ciclos->total(),
                'current_page'=> $ciclos->currentPage(),
                'per_page'=> $ciclos->perPage(),
                'last_page'=> $ciclos->lastPage(),
                'from'=> $ciclos->firstItem(),
                'to'=> $ciclos->lastItem(),
            ],
            'ciclos'=>$ciclos
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
        $ciclo=$request->Ciclo;
        $fecIni=$request->fecIni;
        $fecFin=$request->fecFin;
        $estado=$request->estado;
        $secOp=$request->secOp;

        $input1  = array('ciclo' => $ciclo);
        $reglas1 = array('ciclo' => 'required');

        $input2  = array('ciclo' => $ciclo);
        $reglas2 = array('ciclo' => 'unique:ciclos,nombre'.',1,borrado');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Nombre del Ciclo.';
            $selector='txtciclo';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El Ciclo consignado ya se encuentra registrado';
            $selector='txtciclo';
        }elseif(!validaFecha($fecIni)){
            $result='0';
            $msj='La Fecha Inicial ingresada es Incorrecta';
            $selector='txtfecIni';
        }elseif(!validaFecha($fecFin)){
            $result='0';
            $msj='La Fecha Final ingresada es Incorrecta';
            $selector='txtFecFin';
        }
        else{

            if($estado=='1'){
                Ciclo::where('estado','1')->update(['estado' => '0']);
            }

            $newCiclo = new Ciclo();
                $newCiclo->nombre=$ciclo;
                $newCiclo->fechainicio=$fecIni;
                $newCiclo->fechafin=$fecFin;
                $newCiclo->estado=$estado;
                $newCiclo->segundacarrera=$secOp;

                $newCiclo->activo='1';
                $newCiclo->borrado='0';
                $newCiclo->user_id=Auth::user()->id;

            $newCiclo->save();

            $msj='Nuevo Ciclo Académica UNASAM creada con éxito';


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
        $ciclo=$request->ciclo;
        $fecIni=$request->fechainicio;
        $fecFin=$request->fechafin;
        $estado=$request->estado;
        $secOp=$request->segundacarrera;

        $input1  = array('ciclo' => $ciclo);
        $reglas1 = array('ciclo' => 'required');

        $input2  = array('ciclo' => $ciclo);
        $reglas2 = array('ciclo' => 'unique:ciclos,nombre,'.$id.',id,borrado,0');

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe completar el Nombre del Ciclo.';
            $selector='txtcicloE';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El Ciclo consignado ya se encuentra registrado en otro registro';
            $selector='txtcicloE';
        }
        elseif(!validaFecha($fecIni)){
            $result='0';
            $msj='La Fecha Inicial ingresada es Incorrecta';
            $selector='txtfecIniE';
        }elseif(!validaFecha($fecFin)){
            $result='0';
            $msj='La Fecha Final ingresada es Incorrecta';
            $selector='txtFecFinE';
        }
        else{

            if($estado=='1'){
                Ciclo::where('estado','1')->update(['estado' => '0']);
            }

            $updateCiclo = Ciclo::findOrFail($id);
                $updateCiclo->nombre=$ciclo;
                $updateCiclo->fechainicio=$fecIni;
                $updateCiclo->fechafin=$fecFin;
                $updateCiclo->estado=$estado;
                $updateCiclo->segundacarrera=$secOp;
                $updateCiclo->user_id=Auth::user()->id;

            $updateCiclo->save();

            $msj='El Ciclo Académica ha sido modificado con éxito';
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

     public function activar($id,$estado)
    {

        $result='1';
        $msj='';
        $selector='';

        Ciclo::where('estado','1')->update(['estado' => '0']);

        $updateCiclo = Ciclo::findOrFail($id);
        $updateCiclo->estado=$estado;
        $updateCiclo->save();

        if(strval($estado)=="0"){
            $msj='El Ciclo seleccionado fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Ciclo seleccionado fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';

        $consulta=DB::table('ciclos')
                    ->join('alumnos', 'alumnos.ciclo_id', '=', 'ciclos.id')
                    ->where('alumnos.borrado','0')
                    ->where('ciclos.id',$id)->count();

        if ($consulta>0) {
            $result='0';
            $msj='El Ciclo Seleccionado no puede ser eliminado, debido a que cuenta con registros de alumnos matriculados en él';
        }else{

        $borrarCiclo = Ciclo::findOrFail($id);
        //$task->delete();

        $borrarCiclo->borrado='1';

        $borrarCiclo->save();

        $msj='Ciclo eliminado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
