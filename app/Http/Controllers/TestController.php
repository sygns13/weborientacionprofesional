<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Metodologiavocacional;
use App\Modulovocacional;
use App\Validez;
use App\Regla;
use App\Pregunta;
use App\Alternativa;
use App\Tipouser;
use App\Test;

use Validator;
use Auth;
use DB;
use Storage;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        

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

        $modulo="testIPPR";

        return view('testippr.index',compact('modulo','tipouser','imagenPerfil'));

 
    }


    public function index2()
    {
        

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

        $modulo="testKUDER";

        return view('testkuder.index',compact('modulo','tipouser','imagenPerfil'));

 
    }


    public function index(Request $request)
    {
        $iduser=Auth::user()->id;

        $persona=DB::table('alumnos')
        ->join('ciclos', 'alumnos.ciclo_id', '=', 'ciclos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('carrerasunasams', 'alumnos.carrerasunasam_id', '=', 'carrerasunasams.id')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('alumnos.borrado','0')
        ->where('ciclos.estado','1')
        ->where('users.id',$iduser)
        ->select('alumnos.id as idalum','alumnos.codigopos','alumnos.estado as estadoAlum','alumnos.carrera_id2','alumnos.activo as activoAlum','alumnos.quinto', 'personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'carrerasunasams.id as idCarre', 'carrerasunasams.nombre as carrera', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser')->get();


        $idAlumno="";
        foreach ($persona as $key => $dato) {
            $idAlumno= $dato->idalum;
        }

        $buscar=$request->busca;
         //$test = Test::where('nombre', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('id')->paginate(10);
         $test = DB::table('tests')
                ->join('metodologiavocacionals', 'tests.metodologiavocacional_id', '=', 'metodologiavocacionals.id')
                ->join('perfils', 'perfils.test_id', '=', 'tests.id')
                ->where('tests.estado','>','1')
                ->where('tests.alumno_id',$idAlumno)
                ->orderBy('tests.id')
        ->select('tests.id','tests.fecha','tests.fechafin','tests.horainicio','tests.horafin','tests.estado','tests.alumno_id','tests.metodologiavocacional_id','metodologiavocacionals.nombre as tipo')->paginate(10);



        return [
            'pagination'=>[
                'total'=> $test->total(),
                'current_page'=> $test->currentPage(),
                'per_page'=> $test->perPage(),
                'last_page'=> $test->lastPage(),
                'from'=> $test->firstItem(),
                'to'=> $test->lastItem(),
            ],
            'tests'=>$test
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $metodologiavocacional_id=$request->metod;

        $input1  = array('metodologiavocacional_id' => $metodologiavocacional_id);
        $reglas1 = array('metodologiavocacional_id' => 'required');

        $validator1 = Validator::make($input1, $reglas1);

         $result='1';
         $msj='';
         $selector='';
         $testcreated='';

         if ($validator1->fails() || (strval($metodologiavocacional_id)!="1" && strval($metodologiavocacional_id)!="2"))
        {
            $result='0';

        }
        else{

             $iduser=Auth::user()->id;

             $persona=DB::table('personas')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('alumnos', 'alumnos.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('users.id',$iduser)
        ->select('alumnos.id as idalumno')->get();


        $idAlumno="";
            foreach ($persona as $key => $dato) {
                $idAlumno=$dato->idalumno;
            }

        $fecha=date("Y-m-d");
        $hora=date("H:i:s");

            $newTest = new Test();
                $newTest->fecha=$fecha;
                $newTest->fechafin=$fecha;
                $newTest->horainicio=$hora;
                $newTest->horafin=$hora;
                $newTest->estado='1';
                $newTest->alumno_id=$idAlumno;
                $newTest->metodologiavocacional_id=$metodologiavocacional_id;
            $newTest->save();


            $testcreated=$newTest->id;
            $msj='Nuevo Test Creado con éxito';
        }
        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector,'testcreated'=>$testcreated]);
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
        //
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
