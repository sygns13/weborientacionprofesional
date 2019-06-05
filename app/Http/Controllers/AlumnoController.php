<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Alumno;
use App\Ciclo;
use App\Carrerasunasam;
use App\Persona;
use App\User;
use Validator;
use Auth;
use DB;
use Storage;

use App\Tipouser;

class AlumnoController extends Controller
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

        $modulo="alumnos";

        return view('alumnos.index',compact('modulo','tipouser','imagenPerfil'));

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



        $alumnos=DB::table('alumnos')
        ->join('ciclos', 'alumnos.ciclo_id', '=', 'ciclos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('carrerasunasams', 'alumnos.carrerasunasam_id', '=', 'carrerasunasams.id')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->where('alumnos.borrado','0')
        ->where('ciclos.estado','1')
        ->where('users.tipouser_id','4')
        ->where('personas.nombres','like','%'.$buscar.'%')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->orderBy('personas.id')
        ->select('alumnos.id as idalum','alumnos.codigopos','alumnos.estado as estadoAlum','alumnos.carrera_id2','alumnos.activo as activoAlum','alumnos.quinto', 'personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'carrerasunasams.id as idCarre', 'carrerasunasams.nombre as carrera', 'users.id as idUsser', 'users.name as username', 'users.email', 'users.token2','users.activo as activouser')->paginate(10);

        $ciclos=Ciclo::where('estado','1')->get();
        $carreras=Carrerasunasam::where('borrado','0')->where('activo','1')->orderBy('id')->get();


        return [
            'pagination'=>[
                'total'=> $alumnos->total(),
                'current_page'=> $alumnos->currentPage(),
                'per_page'=> $alumnos->perPage(),
                'last_page'=> $alumnos->lastPage(),
                'from'=> $alumnos->firstItem(),
                'to'=> $alumnos->lastItem(),
            ],
            'alumnos'=>$alumnos,
            'carreras'=>$carreras,
            'ciclos'=>$ciclos
        ];
    }


    public function verpersona($dni)
    {
       $persona=Persona::where('dni',$dni)->get();

       $id="0";
       $idUser="0";
       $idAlumno="0";

       foreach ($persona as $key => $dato) {
          $id=$dato->id;
       }

       $user=User::where('persona_id',$id)->where('tipouser_id','4')->where('borrado','0')->get();

       foreach ($user as $key => $dato) {
          $idUser=$dato->id;
       }

       $alumno=Alumno::where('persona_id',$id)->where('borrado','0')->where('borrado','0')->get();

       foreach ($alumno as $key => $dato) {
          $idAlumno=$dato->id;
       }


       return response()->json(["persona"=>$persona, "id"=>$id, "user"=>$user , "idUser"=>$idUser, "alumno"=>$alumno, "idAlumno"=>$idAlumno]);

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
        $result='1';
        $msj='';
        $selector='';

        $idPersona=$request->idPersona;
        $idUser=$request->idUser;

        $newDNI=$request->newDNI;
        $newNombres=$request->newNombres;
        $newApellidos=$request->newApellidos;
        $newGenero=$request->newGenero;
        $newTelefono=$request->newTelefono;
        $newDireccion=$request->newDireccion;
        
        $img=$request->imagen;
        $imagen="";
        $segureImg=0;
        $newTipoDocu=$request->newTipoDocu;

        $newcodigopos=$request->newcodigopos;
        $newEstadoAlumno=$request->newEstadoAlumno;
        $newcarrera_id2=$request->newcarrera_id2;
        $newActivoAlumno=$request->newActivoAlumno;
        $newQuinto=$request->newQuinto;
        $newCarrerasunasam=$request->newCarrerasunasam;
        $newCiclo_id=$request->newCiclo_id;
        $activeOp=$request->activeOp;//Segunda Opción

        $newUsername=$request->newUsername;
        $newEmail=$request->newEmail;
        $newPassword=$request->newPassword;



        $oldImagen=$request->oldImagen;



        if ($request->hasFile('imagen')) { 

            $aux=$newDNI;
            $input  = array('image' => $img) ;
            $reglas = array('image' => 'required|image|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
            $validator = Validator::make($input, $reglas);

            if ($validator->fails())
            {

            $segureImg=1;
            $msj="El archivo ingresado como imagen no es una imagen válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo';
            }

            else
            {

                if(strlen($oldImagen)>0){
                    Storage::disk('perfil')->delete($oldImagen);
                }

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$aux.".".$extension;
            $subir=Storage::disk('perfil')->put($nuevoNombre, \File::get($img));

            if($subir){
                $imagen=$nuevoNombre;

                



            }
            else{
                $msj="Error al subir la imagen, intentelo nuevamente luego";
                $segureImg=1;
                $result='0';
                $selector='archivo';
            }
        }

        }

        if($segureImg==1){ 
            Storage::disk('perfil')->delete($imagen);
        }
        else{

        $input1  = array('titulo' => $newDNI);
        $reglas1 = array('titulo' => 'required');

        $input2  = array('nombres' => $newNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('apellidos' => $newApellidos);
        $reglas3 = array('apellidos' => 'required');

        $input4  = array('codigo' => $newcodigopos);
        $reglas4 = array('codigo' => 'required');

        $input5  = array('codigo' => $newcodigopos);
        $reglas5 = array('codigo' => 'unique:alumnos,codigopos'.',1,borrado');

        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);
         $validator5 = Validator::make($input5, $reglas5);
         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del alumno postulante';
            $selector='txtDNI';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del alumno postulante';
            $selector='txtnombres';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del alumno postulante';
            $selector='txtapellidos';
        }elseif ($validator4->fails()) {
            $result='0';
            $msj='Debe ingresar el código del alumno postulante';
            $selector='txtcodigo';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='El código de postulante ya se encuentra registrado, consigne otro';
            $selector='txtcodigo';
        }elseif (strlen($newCarrerasunasam)==0 || $newCarrerasunasam==null) {
            $result='0';
            $msj='Seleccione una Carrera Profesional válida para el postulante';
            $selector='cbuCarreras';
        }elseif($activeOp=="1" && strlen($newcarrera_id2)==0){
            $result='0';
            $msj='Seleccione una Segunda Opción de Carrera Profesional válida para el postulante';
            $selector='cbuCarrerasOp';
        }
        else{


            if($idUser=="0")
            {
                $input7  = array('username' => $newUsername);
                $reglas7 = array('username' => 'required');

                $input8  = array('username' => $newUsername);
                $reglas8 = array('username' => 'unique:users,name'.',1,borrado');

                $input9  = array('email' => $newEmail);
                $reglas9 = array('email' => 'required');

                $input10  = array('email' => $newEmail);
                $reglas10 = array('email' => 'unique:users,email'.',1,borrado');

                $input11  = array('password' => $newPassword);
                $reglas11 = array('password' => 'required');


                $validator7 = Validator::make($input7, $reglas7);
                $validator8 = Validator::make($input8, $reglas8);
                $validator9 = Validator::make($input9, $reglas9);
                $validator10 = Validator::make($input10, $reglas10);
                $validator11 = Validator::make($input11, $reglas11);


                 if ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar el username del alumno postulante';
                        $selector='txtuser';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtuser';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email del alumno postulante';
                        $selector='txtmail';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtmail';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del alumno postulante';
                        $selector='txtclave';
                    }
                    else
                    {
                        //$idPersona

                        if($idPersona=="0"){

                            $newPersona = new Persona();

                                $newPersona->dni=$newDNI;
                                $newPersona->nombres=$newNombres;
                                $newPersona->apellidos=$newApellidos;
                                $newPersona->genero=$newGenero;
                                $newPersona->telf=$newTelefono;
                                $newPersona->direccion=$newDireccion;
                                $newPersona->imagen=$imagen;
                   
                                $newPersona->activo='1';
                                $newPersona->borrado='0';
                                $newPersona->tipodocu='1';

                            $newPersona->save();

                            $newAlumno = new Alumno();

                                $newAlumno->codigopos=$newcodigopos;
                                $newAlumno->estado=$newEstadoAlumno;
                                $newAlumno->carrera_id2=$newcarrera_id2;
                                $newAlumno->activo=$newActivoAlumno;
                                $newAlumno->borrado='0';
                                $newAlumno->quinto=$newQuinto;
                                $newAlumno->persona_id=$newPersona->id;                   
                                $newAlumno->carrerasunasam_id=$newCarrerasunasam;
                                $newAlumno->ciclo_id=$newCiclo_id;

                            $newAlumno->save();

                            $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->persona_id=$newPersona->id;
                                $newUser->tipouser_id='4';
                                $newUser->activo='1';
                                $newUser->borrado='0';                   
                                $newUser->token2=$newPassword;


                            $newUser->save();


                            $msj='Nuevo Alumno Postulante registrado con éxito';

                        }
                        else{
                            //editar Persona



                            $editPersona = Persona::findOrFail($idPersona);

                            if(strlen($imagen)==0){

                                $editPersona->nombres=$newNombres;
                                $editPersona->apellidos=$newApellidos;
                                $editPersona->genero=$newGenero;
                                $editPersona->telf=$newTelefono;
                                $editPersona->direccion=$newDireccion;

                            $editPersona->save();

                            }
                            else{
                                $editPersona->nombres=$newNombres;
                                $editPersona->apellidos=$newApellidos;
                                $editPersona->genero=$newGenero;
                                $editPersona->telf=$newTelefono;
                                $editPersona->direccion=$newDireccion;
                                $editPersona->imagen=$imagen;

                            $editPersona->save();
                            }


                                

                            $newAlumno = new Alumno();

                                $newAlumno->codigopos=$newcodigopos;
                                $newAlumno->estado=$newEstadoAlumno;
                                $newAlumno->carrera_id2=$newcarrera_id2;
                                $newAlumno->activo=$newActivoAlumno;
                                $newAlumno->borrado='0';
                                $newAlumno->quinto=$newQuinto;
                                $newAlumno->persona_id=$editPersona->id;                   
                                $newAlumno->carrerasunasam_id=$newCarrerasunasam;
                                $newAlumno->ciclo_id=$newCiclo_id;

                            $newAlumno->save();

                            $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->persona_id=$editPersona->id;
                                $newUser->tipouser_id='4';
                                $newUser->activo='1';
                                $newUser->borrado='0';                   
                                $newUser->token2=$newPassword;


                            $newUser->save();


                            $msj='Nuevo Alumno Postulante registrado con éxito';
                        }
                    }



            }
            else{
                //$idUser edit user

                $input7  = array('username' => $newUsername);
                $reglas7 = array('username' => 'required');

                $input8  = array('username' => $newUsername);
                $reglas8 = array('username' => 'unique:users,name,'.$idUser.',id,borrado,0');

                $input9  = array('email' => $newEmail);
                $reglas9 = array('email' => 'required');

                $input10  = array('email' => $newEmail);
                $reglas10 = array('email' => 'unique:users,email,'.$idUser.',id,borrado,0');

                $input11  = array('password' => $newPassword);
                $reglas11 = array('password' => 'required');


                $validator7 = Validator::make($input7, $reglas7);
                $validator8 = Validator::make($input8, $reglas8);
                $validator9 = Validator::make($input9, $reglas9);
                $validator10 = Validator::make($input10, $reglas10);
                $validator11 = Validator::make($input11, $reglas11);


                 if ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar el username del alumno postulante';
                        $selector='txtuser';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtuser';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email del alumno postulante';
                        $selector='txtmail';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtmail';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del alumno postulante';
                        $selector='txtclave';
                    }
                    else
                    {
                        //nuevo

                        if($idPersona=="0"){

                            $newPersona = new Persona();

                                $newPersona->dni=$newDNI;
                                $newPersona->nombres=$newNombres;
                                $newPersona->apellidos=$newApellidos;
                                $newPersona->genero=$newGenero;
                                $newPersona->telf=$newTelefono;
                                $newPersona->direccion=$newDireccion;
                                $newPersona->imagen=$imagen;
                   
                                $newPersona->activo='1';
                                $newPersona->borrado='0';
                                $newPersona->tipodocu='1';

                            $newPersona->save();

                            $newAlumno = new Alumno();

                                $newAlumno->codigopos=$newcodigopos;
                                $newAlumno->estado=$newEstadoAlumno;
                                $newAlumno->carrera_id2=$newcarrera_id2;
                                $newAlumno->activo=$newActivoAlumno;
                                $newAlumno->borrado='0';
                                $newAlumno->quinto=$newQuinto;
                                $newAlumno->persona_id=$newPersona->id;                   
                                $newAlumno->carrerasunasam_id=$newCarrerasunasam;
                                $newAlumno->ciclo_id=$newCiclo_id;

                            $newAlumno->save();

                            $newUser = User::findOrFail($idUser);

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);          
                                $newUser->token2=$newPassword;


                            $newUser->save();


                            $msj='Nuevo Alumno Postulante registrado con éxito';

                        }
                        else{
                            //editar Persona



                            $editPersona = Persona::findOrFail($idPersona);

                            if(strlen($imagen)==0){

                                $editPersona->nombres=$newNombres;
                                $editPersona->apellidos=$newApellidos;
                                $editPersona->genero=$newGenero;
                                $editPersona->telf=$newTelefono;
                                $editPersona->direccion=$newDireccion;

                            $editPersona->save();

                            }
                            else{
                                $editPersona->nombres=$newNombres;
                                $editPersona->apellidos=$newApellidos;
                                $editPersona->genero=$newGenero;
                                $editPersona->telf=$newTelefono;
                                $editPersona->direccion=$newDireccion;
                                $editPersona->imagen=$imagen;

                            $editPersona->save();
                            }


                                

                            $newAlumno = new Alumno();

                                $newAlumno->codigopos=$newcodigopos;
                                $newAlumno->estado=$newEstadoAlumno;
                                $newAlumno->carrera_id2=$newcarrera_id2;
                                $newAlumno->activo=$newActivoAlumno;
                                $newAlumno->borrado='0';
                                $newAlumno->quinto=$newQuinto;
                                $newAlumno->persona_id=$editPersona->id;                   
                                $newAlumno->carrerasunasam_id=$newCarrerasunasam;
                                $newAlumno->ciclo_id=$newCiclo_id;

                            $newAlumno->save();

                            $newUser = User::findOrFail($idUser);

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);          
                                $newUser->token2=$newPassword;


                            $newUser->save();


                            $msj='Nuevo Alumno Postulante registrado con éxito';
                        }
                    }

            }




            }
        }



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
        
        $result='1';
        $msj='';
        $selector='';

        $idPersona=$request->idPersona;
        $idUser=$request->idUser;

        $editDNI=$request->editDNI;
        $editNombres=$request->editNombres;
        $editApellidos=$request->editApellidos;
        $editGenero=$request->editGenero;
        $editTelefono=$request->editTelefono;
        $editDireccion=$request->editDireccion;
        
        $img=$request->imagen;
        $imagen="";
        $segureImg=0;
        $editTipoDocu=$request->editTipoDocu;

        $editcodigopos=$request->editcodigopos;
        $editEstadoAlumno=$request->editEstadoAlumno;
        $editcarrera_id2=$request->editcarrera_id2;
        $editActivoAlumno=$request->editActivoAlumno;
        $editQuinto=$request->editQuinto;
        $editCarrerasunasam=$request->editCarrerasunasam;
        $editCiclo_id=$request->editCiclo_id;
        $activeOp=$request->activeOp;//Segunda Opción

        $editUsername=$request->editUsername;
        $editEmail=$request->editEmail;
        $editPassword=$request->editPassword;



        $oldImagen=$request->oldImagen;

        if ($request->hasFile('imagen')) { 

            $aux=$editDNI;
            $input  = array('image' => $img) ;
            $reglas = array('image' => 'required|image|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
            $validator = Validator::make($input, $reglas);

            if ($validator->fails())
            {

            $segureImg=1;
            $msj="El archivo ingresado como imagen no es una imagen válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo';
            }

            else
            {

                if(strlen($oldImagen)>0){
                    Storage::disk('perfil')->delete($oldImagen);
                }

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$aux.".".$extension;
            $subir=Storage::disk('perfil')->put($nuevoNombre, \File::get($img));

            if($subir){
                $imagen=$nuevoNombre;

                



            }
            else{
                $msj="Error al subir la imagen, intentelo nuevamente luego";
                $segureImg=1;
                $result='0';
                $selector='archivo';
            }
        }

        }

        if($segureImg==1){ 
            Storage::disk('perfil')->delete($imagen);
        }
        else
        {

        $input1  = array('dni' => $editDNI);
        $reglas1 = array('dni' => 'required');

        $input0  = array('dni' => $editDNI);
        $reglas0 = array('dni' => 'unique:personas,dni,'.$id.',id,borrado,0');

        $input2  = array('nombres' => $editNombres);
        $reglas2 = array('nombres' => 'required');

        $input3  = array('apellidos' => $editApellidos);
        $reglas3 = array('apellidos' => 'required');

        $input4  = array('codigo' => $editcodigopos);
        $reglas4 = array('codigo' => 'required');

        $input5  = array('codigo' => $editcodigopos);
        $reglas5 = array('codigo' => 'unique:alumnos,codigopos,'.$id.',id,borrado,0');

        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator0 = Validator::make($input0, $reglas0);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         $validator4 = Validator::make($input4, $reglas4);
         $validator5 = Validator::make($input5, $reglas5);
         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del alumno postulante';
            $selector='txtDNIE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del alumno postulante';
            $selector='txtnombresE';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del alumno postulante';
            $selector='txtapellidosE';
        }elseif ($validator4->fails()) {
            $result='0';
            $msj='Debe ingresar el código del alumno postulante';
            $selector='txtcodigoE';
        }elseif ($validator5->fails()) {
            $result='0';
            $msj='El código de postulante ya se encuentra registrado, consigne otro';
            $selector='txtcodigoE';
        }elseif (strlen($editCarrerasunasam)==0 || $editCarrerasunasam==null) {
            $result='0';
            $msj='Seleccione una Carrera Profesional válida para el postulante';
            $selector='cbuCarrerasE';
        }elseif($activeOp=="1" && strlen($editcarrera_id2)==0){
            $result='0';
            $msj='Seleccione una Segunda Opción de Carrera Profesional válida para el postulante';
            $selector='cbuCarrerasOpE';
        }
        else{

                $input7  = array('username' => $editUsername);
                $reglas7 = array('username' => 'required');

                $input8  = array('username' => $editUsername);
                $reglas8 = array('username' => 'unique:users,name,'.$idUser.',id,borrado,0');

                $input9  = array('email' => $editEmail);
                $reglas9 = array('email' => 'required');

                $input10  = array('email' => $editEmail);
                $reglas10 = array('email' => 'unique:users,email,'.$idUser.',id,borrado,0');

                $input11  = array('password' => $editPassword);
                $reglas11 = array('password' => 'required');


                $validator7 = Validator::make($input7, $reglas7);
                $validator8 = Validator::make($input8, $reglas8);
                $validator9 = Validator::make($input9, $reglas9);
                $validator10 = Validator::make($input10, $reglas10);
                $validator11 = Validator::make($input11, $reglas11);


                 if ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar el username del alumno postulante';
                        $selector='txtuserE';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtuserE';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email del alumno postulante';
                        $selector='txtmailE';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email de postulante ya se encuentra registrado, consigne otro';
                        $selector='txtmailE';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del alumno postulante';
                        $selector='txtclaveE';
                    }
                    else
                    {

                         $editPersona = Persona::findOrFail($idPersona);

                            if(strlen($imagen)==0){

                                $editPersona->nombres=$editNombres;
                                $editPersona->apellidos=$editApellidos;
                                $editPersona->genero=$editGenero;
                                $editPersona->telf=$editTelefono;
                                $editPersona->direccion=$editDireccion;

                            $editPersona->save();

                            }
                            else{
                                $editPersona->nombres=$editNombres;
                                $editPersona->apellidos=$editApellidos;
                                $editPersona->genero=$editGenero;
                                $editPersona->telf=$editTelefono;
                                $editPersona->direccion=$editDireccion;
                                $editPersona->imagen=$imagen;

                            $editPersona->save();
                            }


                                

                            $editAlumno = Alumno::findOrFail($id);

                            if($activeOp=="0"){
                                $editAlumno->codigopos=$editcodigopos;
                                $editAlumno->estado=$editEstadoAlumno;
                                $editAlumno->activo=$editActivoAlumno;
                                $editAlumno->quinto=$editQuinto;                
                                $editAlumno->carrerasunasam_id=$editCarrerasunasam;
                                $editAlumno->ciclo_id=$editCiclo_id;

                            $editAlumno->save();
                            }
                            else{
                                $editAlumno->codigopos=$editcodigopos;
                                $editAlumno->estado=$editEstadoAlumno;
                                $editAlumno->carrera_id2=$editcarrera_id2;
                                $editAlumno->activo=$editActivoAlumno;
                                $editAlumno->quinto=$editQuinto;                
                                $editAlumno->carrerasunasam_id=$editCarrerasunasam;
                                $editAlumno->ciclo_id=$editCiclo_id;

                            $editAlumno->save();
                            }
                                

                            $editUser = User::findOrFail($idUser);

                                $editUser->name=$editUsername;
                                $editUser->email=$editEmail;
                                $editUser->password=bcrypt($editPassword);          
                                $editUser->token2=$editPassword;


                            $editUser->save();


                            $msj='Alumno Postulante modificado con éxito';

                      }

          }

        }

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

        $updateAlumno = User::findOrFail($id);
        $updateAlumno->activo=$estado;
        $updateAlumno->save();

        if(strval($estado)=="0"){
            $msj='El Alumno fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Alumno fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarAlumno = Alumno::findOrFail($id);
        //$task->delete();

        $borrarAlumno->borrado='1';

        $borrarAlumno->save();

        $msj='Alumno seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }


    //Metodos Alumno

    public function alumnoDatos(Request $request)
    {
        $iduser=Auth::user()->id;

        $persona=DB::table('alumnos')
        ->join('ciclos', 'alumnos.ciclo_id', '=', 'ciclos.id')
        ->join('personas', 'alumnos.persona_id', '=', 'personas.id')
        ->join('carrerasunasams', 'alumnos.carrerasunasam_id', '=', 'carrerasunasams.id')
        ->join('areaunasams', 'carrerasunasams.areaunasam_id', '=', 'areaunasams.id')
        ->join('users', 'users.persona_id', '=', 'personas.id')
        ->join('tipousers','tipousers.id','=','users.tipouser_id')
        ->where('alumnos.borrado','0')
        ->where('ciclos.estado','1')
        ->where('users.id',$iduser)
        ->select('alumnos.id as idalum','alumnos.codigopos','alumnos.estado as estadoAlum','alumnos.carrera_id2','alumnos.activo as activoAlum','alumnos.quinto', 'personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu', 'carrerasunasams.id as idCarre', 'carrerasunasams.nombre as carrera', 'users.id as idUsser', 'users.name as username', 'users.email','users.activo as activouser','tipousers.nombre as tipouser','carrerasunasams.nombre as carreraProf','ciclos.nombre as ciclo','areaunasams.nombre as areaU','ciclos.fechainicio','ciclos.fechafin')->get();

        return response()->json(["persona"=>$persona]);
    }
}
