<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\User;
use App\Tipouser;
use Validator;
use Auth;
use DB;
use Storage;

class UserController extends Controller
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


        $modulo="usuarios";

        return view('usuarios.index',compact('modulo','tipouser','imagenPerfil'));

        }
    else
        {
            return view('adminlte::home');           
        }
    }



    public function index(Request $request)
    {
        $buscar=$request->busca;

         $usuarios=DB::table('users')
        ->join('tipousers', 'users.tipouser_id', '=', 'tipousers.id')
        ->join('personas', 'users.persona_id', '=', 'personas.id')
        ->where('users.borrado','0')
        ->where('tipousers.id','<','4')
        ->where('tipousers.activo','1')
        ->where('personas.nombres','like','%'.$buscar.'%')
        ->orderBy('personas.apellidos')
        ->orderBy('personas.nombres')
        ->orderBy('personas.id')
        ->select('users.id as iduser','users.name as username','users.email','users.token2','users.activo','tipousers.id as idtipo','tipousers.nombre as tipouser','tipousers.descripcion','personas.id as idper', 'personas.dni', 'personas.nombres as nombresPer', 'personas.apellidos as apePer', 'personas.genero', 'personas.telf', 'personas.direccion', 'personas.imagen', 'personas.tipodocu')->paginate(10);

        $tipousers=Tipouser::where('borrado','0')->where('activo','1')->where('id','<','4')->orderBy('id')->get();

        return [
            'pagination'=>[
                'total'=> $usuarios->total(),
                'current_page'=> $usuarios->currentPage(),
                'per_page'=> $usuarios->perPage(),
                'last_page'=> $usuarios->lastPage(),
                'from'=> $usuarios->firstItem(),
                'to'=> $usuarios->lastItem(),
            ],
            'usuarios'=>$usuarios,
            'tipousers'=>$tipousers
        ];
    }

    public function verpersona($dni)
    {
       $persona=Persona::where('dni',$dni)->get();

       $id="0";
       $idUser="0";

       foreach ($persona as $key => $dato) {
          $id=$dato->id;
       }

       $user=User::where('persona_id',$id)->where('tipouser_id','<','4')->where('borrado','0')->get();

       foreach ($user as $key => $dato) {
          $idUser=$dato->id;
       }


       return response()->json(["persona"=>$persona, "id"=>$id, "user"=>$user , "idUser"=>$idUser]);

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

        $newUsername=$request->newUsername;
        $newEmail=$request->newEmail;
        $newPassword=$request->newPassword;

        $newEstado=$request->newEstado;
        $newTipoUser=$request->newTipoUser;



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



        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);

         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del usuario';
            $selector='txtDNI';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del usuario';
            $selector='txtnombres';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del usuario';
            $selector='txtapellidos';
        }
        else{


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

                    if(strlen($newTipoUser)==0){
                        $result='0';
                        $msj='Debe seleccionar el tipo de usuario';
                        $selector='cbuTipoUser';
                    }
                    elseif ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar un Username válido';
                        $selector='txtuser';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username ya se encuentra registrado, consigne otro';
                        $selector='txtuser';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email usuario';
                        $selector='txtmail';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email del usuario ya se encuentra registrado, consigne otro';
                        $selector='txtmail';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del usuario';
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

                            $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->persona_id=$newPersona->id;
                                $newUser->tipouser_id=$newTipoUser;
                                $newUser->activo=$newEstado;
                                $newUser->borrado='0';                   
                                $newUser->token2=$newPassword;


                            $newUser->save();


                            $msj='Nuevo Usuario del Sistema registrado con éxito';

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



                             $newUser = new User();

                                $newUser->name=$newUsername;
                                $newUser->email=$newEmail;
                                $newUser->password=bcrypt($newPassword);
                                $newUser->persona_id=$idPersona;
                                $newUser->tipouser_id=$newTipoUser;
                                $newUser->activo=$newEstado;
                                $newUser->borrado='0';                   
                                $newUser->token2=$newPassword;


                            $newUser->save();



                            $msj='Nuevo Usuario del Sistema registrado con éxito';
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


        $editUsername=$request->editUsername;
        $editEmail=$request->editEmail;
        $editPassword=$request->editPassword;

        $idtipo=$request->idtipo;
        $activo=$request->activo;



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

        //$input6  = array('carrera' => $newCarrerasunasam);
       // $reglas6 = array('carrera' => 'required');

        // Segunda Carrera OP chekiar $newcarrera_id2

         $validator1 = Validator::make($input1, $reglas1);
         $validator0 = Validator::make($input0, $reglas0);
         $validator2 = Validator::make($input2, $reglas2);
         $validator3 = Validator::make($input3, $reglas3);
         //$validator6 = Validator::make($input6, $reglas6);

         if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el DNI del usuario';
            $selector='txtDNIE';
        }elseif ($validator2->fails()) {
            $result='0';
            $msj='Debe ingresar el nombre del usuario';
            $selector='txtnombresE';
        }elseif ($validator3->fails()) {
            $result='0';
            $msj='Debe ingresar los Apellidos del usuario';
            $selector='txtapellidosE';
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

                 if(strlen($idtipo)==0){
                        $result='0';
                        $msj='Debe seleccionar el tipo de usuario';
                        $selector='cbuTipoUserE';
                    }
                 elseif ($validator7->fails())
                    {
                        $result='0';
                        $msj='Debe ingresar un Username válido';
                        $selector='txtuserE';
                    }elseif ($validator8->fails()) {
                        $result='0';
                        $msj='El username ya se encuentra registrado, consigne otro';
                        $selector='txtuserE';
                    }elseif ($validator9->fails()) {
                        $result='0';
                        $msj='Debe ingresar el email del usuario';
                        $selector='txtmailE';
                    }elseif ($validator10->fails()) {
                        $result='0';
                        $msj='El email del usuario ya se encuentra registrado, consigne otro';
                        $selector='txtmailE';
                    }elseif ($validator11->fails()) {
                        $result='0';
                        $msj='Debe ingresar el password del usuario';
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

                            $editUser = User::findOrFail($idUser);

                                $editUser->name=$editUsername;
                                $editUser->email=$editEmail;
                                $editUser->password=bcrypt($editPassword);          
                                $editUser->token2=$editPassword;

                                $editUser->activo=$activo;
                                $editUser->tipouser_id=$idtipo;


                            $editUser->save();


                            $msj='Usuario modificado con éxito';

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

        $updateUsuario = User::findOrFail($id);
        $updateUsuario->activo=$estado;
        $updateUsuario->save();

        if(strval($estado)=="0"){
            $msj='El Usuario fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Usuario fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }


    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarUsuario = User::findOrFail($id);
        //$task->delete();

        $borrarUsuario->borrado='1';

        $borrarUsuario->save();

        $msj='Usuario seleccionado eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
