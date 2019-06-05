<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {   
        $iduser=Auth::user()->id;

        $numuser=User::where('id',$iduser)->where('activo','1')->where('borrado','0')->count();
        if($numuser==1){

            $idtipouser=Auth::user()->tipouser_id;
            $tipouser=Tipouser::find($idtipouser);

            if($idtipouser=="4"){
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

         $numAlumno=DB::table('alumnos')
        ->join('ciclos', 'alumnos.ciclo_id', '=', 'ciclos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('carrerasunasams', 'alumnos.carrerasunasam_id', '=', 'carrerasunasams.id')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->where('alumnos.borrado','0')
        ->where('ciclos.estado','1')
        ->where('users.id',$iduser)
        ->count();

        if($numAlumno==1){

            $imagenPerfil="";
            foreach ($persona as $key => $dato) {
                $imagenPerfil=$dato->imagen;
            }

            $modulo="alumno";

            

            

            return view('adminlte::home',compact('tipouser','imagenPerfil','modulo','iduser'));
        }
        else{
            Auth::logout();

          return redirect()->back()
            ->withErrors([
                'email' => 'alumnoSemestre'
            ]);
        }


            }

            else{

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

                return view('adminlte::home',compact('tipouser','imagenPerfil'));
            }
        

        }
        else{
            Auth::logout();

          return redirect()->back()
            ->withErrors([
                'email' => 'usuarioActiv'
            ]);
        }
    }
}