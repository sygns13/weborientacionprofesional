<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carrerasunasam;
use App\Informacion;
use Validator;
use Auth;
use DB;
use Storage;

use App\Persona;
use App\Alumno;
use App\Tipouser;
use App\User;

class InformacionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buscar=$request->busca;
        $idcarrera=$request->idcarrera;

        $informacions=Informacion::where('carrerasunasam_id',$idcarrera)->where('titulo', 'like', '%'.$buscar.'%')->where('borrado','0')->orderBy('orden')->paginate(10);

        return [
            'pagination'=>[
                'total'=> $informacions->total(),
                'current_page'=> $informacions->currentPage(),
                'per_page'=> $informacions->perPage(),
                'last_page'=> $informacions->lastPage(),
                'from'=> $informacions->firstItem(),
                'to'=> $informacions->lastItem(),
            ],
            'informacions'=>$informacions
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
         ini_set('memory_limit','256M');
     
        $titulo=$request->titulo;
        $desc=$request->desc;
        $orden=$request->orden;
        $estado=$request->estado;
        $idcarrera=$request->carrera_id;

        $imagen="";
        $img = $request->imagen;
        $segureImg=0;

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo="";


         $result='1';
         $msj='';
         $selector='';

        if ($request->hasFile('imagen')) { 

            $aux=date('d-m-Y').'-'.date('H-i-s');
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

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$aux.".".$extension;
            $subir=Storage::disk('infoImg')->put($nuevoNombre, \File::get($img));

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

        if($request->hasFile('archivo')){



            $nombreArchivo=$request->nombreArchivo;

            $aux2=date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,20480');
            $validatorF = Validator::make($input2, $reglas2);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjunto';
            }
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

                if($extension2=="pdf" || $extension2=="doc" || $extension2=="docx" || $extension2=="xls" || $extension2=="xlsx" || $extension2=="ppt" || $extension2=="pptx" || $extension2=="PDF" || $extension2=="DOC" || $extension2=="DOCX" || $extension2=="XLS" || $extension2=="XLSX" || $extension2=="PPT" || $extension2=="PTTX")
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivo';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo2';
                }
            }

        }

        if($segureImg==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);

        }elseif($segureFile==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);
        }
        else
        {

        
        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');


         $validator1 = Validator::make($input1, $reglas1);


        

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el título del Contenido Informativo';
            $selector='txttitulo';

        }
        else{
                $newinformacion = new Informacion();
                $newinformacion->titulo=$titulo;
                $newinformacion->descripcion=$desc;
                $newinformacion->orden=$orden;
                $newinformacion->urlimagen=$imagen;
                
   
                $newinformacion->activo=$estado;
                $newinformacion->borrado='0';

                $newinformacion->urldocumento=$archivo;
                $newinformacion->carrerasunasam_id=$idcarrera;

                $newinformacion->user_id=Auth::user()->id;
                $newinformacion->archivonombre=$nombreArchivo;


            $newinformacion->save();

            $msj='Nuevo Contenido Informativo Registrado con Éxito';
        }

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
        $titulo=$request->titulo;
        $desc=$request->desc;
        $orden=$request->orden;
        $estado=$request->estado;
   

        $imagen="";
        $img = $request->imagen;
        $segureImg=0;

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo="";


         $result='1';
         $msj='';
         $selector='';

         $oldImg=$request->oldimg;
         $oldFile=$request->oldfile;


if ($request->hasFile('imagen')) { 

            $aux=date('d-m-Y').'-'.date('H-i-s');
            $input  = array('image' => $img) ;
            $reglas = array('image' => 'required|image|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE');
            $validator = Validator::make($input, $reglas);

            if ($validator->fails())
            {

            $segureImg=1;
            $msj="El archivo ingresado como imagen no es una imagen válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivoE';
            }

            else
            {

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$aux.".".$extension;
            $subir=Storage::disk('infoImg')->put($nuevoNombre, \File::get($img));

            if($subir){
                $imagen=$nuevoNombre;



            }
            else{
                $msj="Error al subir la imagen, intentelo nuevamente luego";
                $segureImg=1;
                $result='0';
                $selector='archivoE';
            }
        }

        }


if($request->hasFile('archivo')){



            $nombreArchivo=$request->nombreArchivo;

            $aux2=date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,20480');
            $validatorF = Validator::make($input2, $reglas2);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjuntoE';
            }
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

                if($extension2=="pdf" || $extension2=="doc" || $extension2=="docx" || $extension2=="xls" || $extension2=="xlsx" || $extension2=="ppt" || $extension2=="pptx" || $extension2=="PDF" || $extension2=="DOC" || $extension2=="DOCX" || $extension2=="XLS" || $extension2=="XLSX" || $extension2=="PPT" || $extension2=="PTTX")
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivoE';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo2E';
                }
            }

        }

        if($segureImg==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);

        }elseif($segureFile==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);
        }
        else
        {


        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');


         $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el título del Contenido Informativo '.$request->oldImg;
            $selector='txttituloE';

        }

        else{

            Storage::disk('infoImg')->delete($oldImg);
            Storage::disk('infoFile')->delete($oldFile);

            if(strlen($imagen)>0 && strlen($archivo)>0)
            {
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                $updateInformacion->urlimagen=$imagen;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->urldocumento=$archivo;

                $updateInformacion->user_id=Auth::user()->id;
                $updateInformacion->archivonombre=$nombreArchivo;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)==0 && strlen($archivo)>0){

            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->urldocumento=$archivo;

                $updateInformacion->user_id=Auth::user()->id;
                $updateInformacion->archivonombre=$nombreArchivo;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)>0 && strlen($archivo)==0){
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                $updateInformacion->urlimagen=$imagen;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->user_id=Auth::user()->id;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)==0 && strlen($archivo)==0){
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                  
                $updateInformacion->activo=$estado;

                $updateInformacion->user_id=Auth::user()->id;

            $updateInformacion->save();
            }



            $msj='La Carrera Profesional ha sido modificada con éxito';
        }

        }




        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);
    }


     public function editar(Request $request)
    {

        ini_set('memory_limit','256M');

        $id=$request->id;
        $titulo=$request->titulo;
        $desc=$request->desc;
        $orden=$request->orden;
        $estado=$request->estado;
   

        $imagen="";
        $img = $request->imagen;
        $segureImg=0;

        $archivo="";
        $file = $request->archivo;
        $segureFile=0;

        $nombreArchivo="";


         $result='1';
         $msj='';
         $selector='';

         $oldImg=$request->oldimg;
         $oldFile=$request->oldfile;


if ($request->hasFile('imagen')) { 

            $aux=date('d-m-Y').'-'.date('H-i-s');
            $input  = array('image' => $img) ;
            $reglas = array('image' => 'required|image|mimes:png,jpg,jpeg,gif,jpe,PNG,JPG,JPEG,GIF,JPE|size:20480');
            $validator = Validator::make($input, $reglas);

            if ($validator->fails())
            {

            $segureImg=1;
            $msj="El archivo ingresado como imagen no es una imagen válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivoE';
            }

            else
            {

            $nombre=$img->getClientOriginalName();
            $extension=$img->getClientOriginalExtension();
            $nuevoNombre=$aux.".".$extension;
            $subir=Storage::disk('infoImg')->put($nuevoNombre, \File::get($img));

            if($subir){
                $imagen=$nuevoNombre;



            }
            else{
                $msj="Error al subir la imagen, intentelo nuevamente luego";
                $segureImg=1;
                $result='0';
                $selector='archivoE';
            }
        }

        }


if($request->hasFile('archivo')){



            $nombreArchivo=$request->nombreArchivo;

            $aux2=date('d-m-Y').'-'.date('H-i-s');
            $input2  = array('archivo' => $file) ;
            $reglas2 = array('archivo' => 'required|file:1,20480');
            $validatorF = Validator::make($input2, $reglas2);

            $inputNA  = array('archivonombre' => $nombreArchivo);
            $reglasNA = array('archivonombre' => 'required');
            $validatorNA = Validator::make($inputNA, $reglasNA);

          

            if ($validatorF->fails())
            {

            $segureFile=1;
            $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
            $result='0';
            $selector='archivo2';
            }
            elseif($validatorNA->fails()){
                $segureFile=1;
                $msj="Si va a registrar un archivo adjunto, debe de ingresar un nombre válido con el que se verá en el sistema";
                $result='0';
                $selector='txtArchivoAdjuntoE';
            }
            else
            {
                $nombre2=$file->getClientOriginalName();
                $extension2=$file->getClientOriginalExtension();
                $nuevoNombre2=$aux2.".".$extension2;
                $subir2=Storage::disk('infoFile')->put($nuevoNombre2, \File::get($file));

                if($extension2=="pdf" || $extension2=="doc" || $extension2=="docx" || $extension2=="xls" || $extension2=="xlsx" || $extension2=="ppt" || $extension2=="pptx" || $extension2=="PDF" || $extension2=="DOC" || $extension2=="DOCX" || $extension2=="XLS" || $extension2=="XLSX" || $extension2=="PPT" || $extension2=="PTTX")
                {

                if($subir2){
                    $archivo=$nuevoNombre2;
                }
                else{
                    $msj="Error al subir el archivo adjunto, intentelo nuevamente luego";
                    $segureFile=1;
                    $result='0';
                    $selector='archivoE';
                }
                }
                else {
                    $segureFile=1;
                    $msj="El archivo adjunto ingresado tiene una extensión no válida, ingrese otro archivo o limpie el formulario";
                    $result='0';
                    $selector='archivo2E';
                }
            }

        }

        if($segureImg==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);

        }elseif($segureFile==1){
            Storage::disk('infoImg')->delete($imagen);
            Storage::disk('infoFile')->delete($archivo);
        }
        else
        {


        $input1  = array('titulo' => $titulo);
        $reglas1 = array('titulo' => 'required');


         $validator1 = Validator::make($input1, $reglas1);

        if ($validator1->fails())
        {
            $result='0';
            $msj='Debe ingresar el título del Contenido Informativo '.$request->oldImg;
            $selector='txttituloE';

        }

        else{

            Storage::disk('infoImg')->delete($oldImg);
            Storage::disk('infoFile')->delete($oldFile);

            if(strlen($imagen)>0 && strlen($archivo)>0)
            {
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                $updateInformacion->urlimagen=$imagen;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->urldocumento=$archivo;

                $updateInformacion->user_id=Auth::user()->id;
                $updateInformacion->archivonombre=$nombreArchivo;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)==0 && strlen($archivo)>0){

            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->urldocumento=$archivo;

                $updateInformacion->user_id=Auth::user()->id;
                $updateInformacion->archivonombre=$nombreArchivo;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)>0 && strlen($archivo)==0){
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                $updateInformacion->urlimagen=$imagen;
                   
                $updateInformacion->activo=$estado;

                $updateInformacion->user_id=Auth::user()->id;

            $updateInformacion->save();
            }
            elseif(strlen($imagen)==0 && strlen($archivo)==0){
            $updateInformacion = Informacion::findOrFail($id);
                $updateInformacion->titulo=$titulo;
                $updateInformacion->descripcion=$desc;
                $updateInformacion->orden=$orden;
                  
                $updateInformacion->activo=$estado;

                $updateInformacion->user_id=Auth::user()->id;

            $updateInformacion->save();
            }



            $msj='La Carrera Profesional ha sido modificada con éxito';
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

        $updateInformacion = Informacion::findOrFail($id);
        $updateInformacion->activo=$estado;
        $updateInformacion->save();

        if(strval($estado)=="0"){
            $msj='El Contenido Informativo fue Desactivado exitosamente';
        }elseif(strval($estado)=="1"){
            $msj='El Contenido Informativo fue Activado exitosamente';
        }

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    public function deleteImg($id,$image)
    {
        $result='1';
        $msj='';
        $selector='';

        Storage::disk('infoImg')->delete($image);

        $updateInformacion = Informacion::findOrFail($id);
        $updateInformacion->urlimagen='';
        $updateInformacion->save();

        $msj='Se eliminó la imagen exitosamente';

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

     public function deleteFile($id,$file)
    {
        $result='1';
        $msj='';
        $selector='';

        Storage::disk('infoFile')->delete($file);

        $updateInformacion = Informacion::findOrFail($id);
        $updateInformacion->urldocumento='';
        $updateInformacion->archivonombre='';
        $updateInformacion->save();

        $msj='Se eliminó el archivo adjunto exitosamente';

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }

    public function cambiarAdj($id,$nombre)
    {
        $result='1';
        $msj='';
        $selector='';



        $updateInformacion = Informacion::findOrFail($id);
        $updateInformacion->archivonombre=$nombre;
        $updateInformacion->save();

        $msj='Se modificó el nombre del Archivo Adjunto Correctamente';

        return response()->json(["result"=>$result,'msj'=>$msj,'selector'=>$selector]);

    }




    public function destroy($id)
    {
        $result='1';
        $msj='1';



        $borrarInformacion = Informacion::findOrFail($id);
        //$task->delete();

        $borrarInformacion->borrado='1';

        $borrarInformacion->save();

        $msj='Contenido Informativo eliminado exitosamente';


        return response()->json(["result"=>$result,'msj'=>$msj]);
    }
}
