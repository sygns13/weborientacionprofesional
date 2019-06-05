<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metodologiavocacional;
use App\Campoprofesional;
use App\Maestrocarrera;
use Validator;
use Auth;
use DB;
use Storage;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class MaestrocarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
        public function index1($idCampoProfs)
    {
        if(accesoUser([1,3])){

            $CampoProf =Campoprofesional::findOrFail($idCampoProfs);

            $idMetodologia=$CampoProf->metodologiavocacional_id;

            $nombreCampo=$CampoProf->nombre;

        $modulo="gestionMaestroCarreras";

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

        return view('maestrocarreras.index',compact('modulo','idCampoProfs','idMetodologia','nombreCampo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index2($idCampoProfs)
    {
        if(accesoUser([1,3])){

            $CampoProf =Campoprofesional::findOrFail($idCampoProfs);

            $idMetodologia=$CampoProf->metodologiavocacional_id;

            $nombreCampo=$CampoProf->nombre;

        $modulo="gestionMaestroCarreras2";

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

        return view('maestrocarreras2.index',compact('modulo','idCampoProfs','idMetodologia','nombreCampo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }

    public function index(Request $request)
    {   
        $buscar=$request->busca;
        $campoprofesional_id=$request->campoprofesional_id;

         $maestroscarreras = Maestrocarrera::where('nombre', 'like', '%'.$buscar.'%')->where('campoprofesional_id',$campoprofesional_id)->where('borrado','0')->orderBy('id')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $maestroscarreras->total(),
                'current_page'=> $maestroscarreras->currentPage(),
                'per_page'=> $maestroscarreras->perPage(),
                'last_page'=> $maestroscarreras->lastPage(),
                'from'=> $maestroscarreras->firstItem(),
                'to'=> $maestroscarreras->lastItem(),
            ],
            'maestroscarreras'=>$maestroscarreras
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
        $descripcion=$request->descripcion;
        $estado=$request->estado;

        $campoprofesional_id=$request->campoprofesional_id;

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
        //$reglas2 = array('nombre' => 'unique:maestrocarreras,nombre'.',1,borrado');
        $reglas2 = array('nombre' => 'unique:maestrocarreras,nombre'.',1,borrado,campoprofesional_id,'.$campoprofesional_id);


         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne un nombre válido';
            $selector='txtcarrera';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El nombre consignado ya se encuentra registrado';
            $selector='txtcarrera';
        }
        else{
            $newMaestroCarrera = new Maestrocarrera();
                $newMaestroCarrera->nombre=$nombre;
                $newMaestroCarrera->descripcion=$descripcion;
                $newMaestroCarrera->activo=$estado;
                $newMaestroCarrera->borrado='0';
                $newMaestroCarrera->campoprofesional_id=$campoprofesional_id;
                $newMaestroCarrera->user_id=Auth::user()->id;


            $newMaestroCarrera->save();

            $msj='Nueva Carrera profesional creada con éxito';
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
        $descripcion=$request->descripcion;
        $activo=$request->activo;

        $campoprofesional_id=$request->campoprofesional_id;

        $input1  = array('nombre' => $nombre);
        $reglas1 = array('nombre' => 'required');

        $input2  = array('nombre' => $nombre);
       // $reglas2 = array('nombre' => 'unique:maestrocarreras,nombre,'.$id.',id,borrado,0');

        $reglas2 = array('nombre' => 'unique:maestrocarreras,nombre,'.$id.',id,borrado,0,campoprofesional_id,'.$campoprofesional_id);


         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);

         $result='1';
         $msj='';
         $selector='';

         if ($validator1->fails())
        {
            $result='0';
            $msj='Consigne un nombre válido';
            $selector='txtcarrera';

        }elseif ($validator2->fails()) {
            $result='0';
            $msj='El nombre consignado ya se encuentra registrado';
            $selector='txtcarrera';
        }
        else{
            $newMaestroCarrera =Maestrocarrera::findOrFail($id);
                $newMaestroCarrera->nombre=$nombre;
                $newMaestroCarrera->descripcion=$descripcion;
                $newMaestroCarrera->activo=$activo;
                $newMaestroCarrera->user_id=Auth::user()->id;


            $newMaestroCarrera->save();

            $msj='la carrera profesional ha sido modificada con éxito';
        }




       //Areaunasam::create($request->all());

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


    public function altabaja($id,$estado)
    {
        $result='1';
        $msj='';
        $selector='';

        $updateCarrera = Maestrocarrera::findOrFail($id);
        $updateCarrera->activo=$estado;
        $updateCarrera->save();

        if(strval($estado)=="0"){
            $msj='La Carrera Profesional fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Carrera Profesional fue Activado exitosamente';
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

      

        $borrarCarrera = Maestrocarrera::destroy($id);


        $msj='La Carrera profesional fue eliminada exitosamente';
        

        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
