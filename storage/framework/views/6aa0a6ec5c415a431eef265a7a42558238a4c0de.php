<?php echo $__env->make('carrerasunasam.componentes', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<script type="text/javascript">

         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        content: '',
        contentE: '',

        titulo:"Carreras Profesionalres",
        subtitulo:"Gestión",
        subtitle2:false,
        subtitulo2:"",
        divloader0:true,
        divloader1:false,
        divloader2:false,
        divloader3:false,
        divloader4:false,
        divloader5:false,
        divloader6:false,
        divloader7:false,
        divloader8:false,
        divloader9:false,
        divloader10:false,
        divtitulo:true,
        classTitle:'fa fa-book',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divcarrerasu:true,
        divcontentCarrera:false,

        carreras: [],
        errors:[],
        fillCarrera:{'id':'', 'carrera':'', 'descripcion':'', 'estado':'','areaunasam_id':'','facultad_id':''},

        pagination: {
        'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
                },
        offset: 9,
        buscar:'',
        divNuevaCarrera:false,

        carrera_id:'',
        newCarrera:'',
        newDescripcion:'',
        estadoCarrera:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        areas: [],
        facultades: [],

        formuModal:true,




        informacions:[],
        fillinformacion:{'id':'', 'titulo':'', 'descripcion':'', 'orden':'', 'urlimagen':'', 'estado':'', 'urldocumento':'', 'carrerasunasam_id':'','archivonombre':'', 'oldImg':'', 'oldFile':''},
        divNuevaInformacion:false,

        newTitulo:'',
        newOrden:'',
        newDescripcionC:'',
        estadoContenido:'1',
        carreraProf:'',

        imagen : null,
        archivo : null,
        newNombreArchivo : '',
        uploadReady: true,

        imagenE : null,
        archivoE : null,
        uploadReadyE: false,

        oldImg:'',
        oldFile:'',

        file:'',
        image:'',
        nameAdjunto:'',
        urlAdjunto:'',
        iflink:false,
        nameAdjuntoE:'',

        thispage:'1',

        thispage2:'1',


    },
    created:function () {
        this.getCarreras(this.thispage);
    },
    mounted: function () {
        this.divloader0=false;

        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.noPerfil);
        }
    },
    computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if(!this.pagination.to){
                return [];
            }

            var from=this.pagination.current_page - this.offset 
            var from2=this.pagination.current_page - this.offset 
            if(from<1){
                from=1;
            }

            var to= from2 + (this.offset*2); 
            if(to>=this.pagination.last_page){
                to=this.pagination.last_page;
            }

            var pagesArray = [];
            while(from<=to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        }
    },

    methods: {
        getCarreras: function (page) {
            var busca=this.buscar;
            var url = 'carreraunasam?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{
                this.carreras= response.data.carreras.data;
                this.pagination= response.data.pagination;
                this.areas=response.data.areas;
                this.facultades=response.data.facultades;

                if(this.divcarrerasu){
                    if(this.carreras.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);

                    }
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;

            if(this.divcarrerasu){
                this.getCarreras(page);   
                this.thispage=page;             
            }
            else{
                this.getInformacion(page,this.carrera_id);
                this.thispage2=page;
            }
            
        },
        buscarBtn: function () {
            this.getCarreras();
            this.thispage='1';
        },
        nuevaCarrera:function () {
            this.divNuevaCarrera=true;
            this.$nextTick(function () {
            this.cancelFormCarrera();
          })
            
        },
        cerrarFormCarrera: function () {
            this.divNuevaCarrera=false;
            this.cancelFormCarrera();
        },
        cancelFormCarrera: function () {

          $('#txtcarrera').focus();
            this.newCarrera='';
            CKEDITOR.instances['editor'].setData("");
            this.estadoCarrera='1';

           $('#cbuarea').select2();
           $('#cbuFacultades').select2();

           $('#cbuarea').val('').trigger('change');
           $('#cbuFacultades').val('').trigger('change');
 

            


           // $('#cbuarea option:first-child').attr('selected', 'selected');
            //$('#cbuFacultades option:first-child').attr('selected', 'selected');
        },
        createCarrera:function () {
            var url='carreraunasam';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            var idarea=$("#cbuarea").val();
            var idfac=$("#cbuFacultades").val();

            axios.post(url,{area:idarea, facul:idfac, carrera:this.newCarrera, desc:CKEDITOR.instances['editor'].getData(), estado:this.estadoCarrera }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    toastr.success(response.data.msj);
                    this.cerrarFormCarrera();
                    this.getCarreras(this.thispage);

                    

                }else{
                    if(response.data.result=='2'){  

                      $('#'+response.data.selector).select2('open');
                      toastr.error(response.data.msj);
                    }
                      else{
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);
                      }
                    
                }
            }).catch(error=>{
                this.errors=error.data
               // console.log('error: '+this.errors)
            })
        },
        borrarCarrera:function (carrera) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Carrera Seleccionada? -- Nota: Para eliminar esta Carrera, debe primero eliminar todos los alumnos registrados en la carrera profesional en el ciclo académico activo.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'carreraunasam/'+carrera.idcarre;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCarreras(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editCarrera:function (carrera) {

         this.formuModal=false;

          this.$nextTick(function () {
            this.formuModal=true;

            this.$nextTick(function () {
            $('#cbuareaE').select2();
           $('#cbuFacultadesE').select2();
           this.$nextTick(function () {
           $('#cbuareaE').val(carrera.idarea).trigger('change');
           $('#cbuFacultadesE').val(carrera.idfac).trigger('change');
           $('.select2').css("width","100%");
             });
             });
          });


            this.fillCarrera.id=carrera.idcarre;
            this.fillCarrera.carrera=carrera.carrera;
            //CKEDITOR.instances['editorE'].setData("");
            if(carrera.descripcion != null){
                CKEDITOR.instances['editorE'].setData(carrera.descripcion);
            }
            else{
                CKEDITOR.instances['editorE'].setData("");
            }
            
            this.fillCarrera.estado=carrera.activo;

            $("#boxTitulo").text('Carrera Profesional: '+carrera.carrera);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtcarreraE").focus();
          })
        },
        updateCarrera:function (id) {
            var url="carreraunasam/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillCarrera.descripcion=CKEDITOR.instances['editorE'].getData();

            this.fillCarrera.areaunasam_id= $('#cbuareaE').val();
            this.fillCarrera.facultad_id= $('#cbuFacultadesE').val();

            axios.put(url, this.fillCarrera).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getCarreras(this.thispage);
                this.fillCarrera={'id':'', 'carrera':'', 'descripcion':'', 'estado':'','areaunasam_id':'','facultad_id':''};
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditar").modal('hide');
                toastr.success(response.data.msj);

                }else{

                  if(response.data.result=='2'){  

                      $('#'+response.data.selector).select2('open');
                      toastr.error(response.data.msj);
                    }
                    else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                    }
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        bajaCarrera:function (carrera) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva la Carrera, se mantendrá oculta toda la información web correspondiente a la carrera profesional",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'carreraunasam/altabaja/'+carrera.idcarre+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCarreras(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaCarrera:function (carrera) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa la Carrera, toda la información web correspondiente a la carrera profesional será visibles.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'carreraunasam/altabaja/'+carrera.idcarre+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCarreras(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        detalle:function (carrera) {
              this.divloader2=true;
              this.divcarrerasu=false;
              this.subtitle2=true;
              this.subtitulo2="Contenido Informativo Carrera Profesional";
              this.carreraProf=carrera.carrera;
              this.carrera_id=carrera.idcarre;

              this.getInformacion(this.thispage2,carrera.idcarre);
              this.$nextTick(function () {
                this.divloader2=false;
                this.divcontentCarrera=true;
              });
        },
        volverCarreras(){
            this.divloader2=true;
            this.divcontentCarrera=false;
            this.getCarreras(this.thispage);
            this.$nextTick(function () {
              this.divloader2=false;
              this.subtitle2=false;
              this.subtitulo2="";
              this.divcarrerasu=true;
              });
        },
        getInformacion: function (page,idCarrera) {
            var busca=this.buscar;
            var url = 'informacion?page='+page+'&busca='+busca+'&idcarrera='+idCarrera;

            axios.get(url).then(response=>{
                this.informacions= response.data.informacions.data;
                this.pagination= response.data.pagination;

                if(this.divcontentCarrera){
                    if(this.informacions.length==0 && this.thispage2!='1'){
                    var a = parseInt(this.thispage2) ;
                    a--;
                    this.thispage2=a.toString();
                    this.changePage(this.thispage2);
                    }
                }
            })
        },

         nuevaInformacion:function () {
            this.divNuevaInformacion=true;
            this.$nextTick(function () {
            this.cancelFormInformacion();
          })
            
        },
        cerrarFormInformacion: function () {
            
            this.cancelFormInformacion();
            this.$nextTick(() => {
            this.divNuevaInformacion=false;
            })
        },
        cancelFormInformacion: function () {

          $('#txttitulo').focus();
            this.newTitulo='';
            this.newOrden='';
            
            this.estadoContenido='1';

            this.newNombreArchivo='';
        
        /*$("#archivo").fileinput({language: "es",  
        allowedFileExtensions:['jpg', 'gif', 'png', 'jpe', 'jpeg','JPG', 'GIF', 'PNG', 'JPE', 'JPEG'],
        'showUpload':false,  
        'previewFileType':'any', 
        minFileCount: 1,
        maxFileCount: 1});*/

        // $(".fileinput-remove-button").hide();

        this.imagen=null;
        this.archivo=null;
        this.uploadReady = false
        this.$nextTick(() => {
          this.uploadReady = true;
          $('#txttitulo').focus();
          CKEDITOR.instances['editor'].setData("");
        })
       // $(".fileinput-remove-button").click();


        },

        getImage(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.imagen=null;
                }
                else{
                this.imagen = event.target.files[0];
                }
            },

           getArchivo(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivo=null;
                }
                else{
                this.archivo = event.target.files[0];
                }
            },

        createInformacion:function () {
            var url='informacion';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            var data = new  FormData();

            data.append('nombreArchivo', this.newNombreArchivo);
            data.append('titulo', this.newTitulo);
            data.append('desc', CKEDITOR.instances['editor'].getData());
            data.append('orden', this.newOrden);
            data.append('estado', this.estadoContenido);
            data.append('carrera_id', this.carrera_id);
            data.append('imagen', this.imagen);
            data.append('archivo', this.archivo);

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

            /*var formData = new FormData($("#formulario")[0]);
            console.log(formData);*/
    
            axios.post(url,data, config).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    toastr.success(response.data.msj);
                    this.cerrarFormInformacion();
                    this.getInformacion(this.thispage2,this.carrera_id);


                }else{                  
                        $('#'+response.data.selector).focus();
                        toastr.error(response.data.msj);                   
                }
            }).catch(error=>{
                this.errors=error.data
               // console.log('error: '+this.errors)
            })
        },
        borrarInformacion:function (informacion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Contenido Informativo Seleccionado? -- Nota: Si elimina el contenido informativo seleccionado, este dejará de verse en la web",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'informacion/'+informacion.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getInformacion(app.thispage2,app.carrera_id);
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

        getImageE(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.imagenE=null;
                }
                else{
                this.imagenE = event.target.files[0];
                }
            },

           getArchivoE(event){
                //Asignamos la imagen a  nuestra data

                if (!event.target.files.length)
                {
                  this.archivoE=null;
                }
                else{
                this.archivoE = event.target.files[0];
                }
            },

            editInformacion:function (informacion) {

            this.uploadReadyE=false;
          this.$nextTick(() => {
            this.imagenE=null;
            this.archivoE=null;
            this.uploadReadyE=true;
            this.$nextTick(() => {
                
                /*$("#archivoE").fileinput({language: "es",  
        allowedFileExtensions:['jpg', 'gif', 'png', 'jpe', 'jpeg','JPG', 'GIF', 'PNG', 'JPE', 'JPEG'],
        'showUpload':false,  
        'previewFileType':'any', 
        minFileCount: 1,
        maxFileCount: 1});*/

         //$(".fileinput-remove-button").hide();
        // $(".fileinput-remove-button").click();
      
             });
          });
            this.fillinformacion.id=informacion.id;
            this.fillinformacion.titulo=informacion.titulo;
            this.fillinformacion.orden=informacion.orden;

            if(informacion.descripcion != null){
                CKEDITOR.instances['editorE'].setData(informacion.descripcion);
            }
            else{
                CKEDITOR.instances['editorE'].setData("");
            }
            
            this.fillinformacion.estado=informacion.activo;

            this.oldImg=informacion.urlimagen;
            this.oldFile=informacion.urldocumento;


            $("#boxTitulo").text('Contenido Informativo: '+informacion.titulo);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtordenE").focus();
          })
        },
        updateInformacion:function (id) {
            var url="informacion/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillinformacion.descripcion=CKEDITOR.instances['editorE'].getData();
            this.fillinformacion.oldImg= this.oldImg;
            this.fillinformacion.oldFile= this.oldFile;

            var data = new  FormData();

            data.append('id', this.fillinformacion.id);
            data.append('titulo', this.fillinformacion.titulo);
            data.append('desc', this.fillinformacion.descripcion);
            data.append('orden', this.fillinformacion.orden);
            data.append('estado', this.fillinformacion.estado);

            data.append('imagen', this.imagenE);
            data.append('archivo', this.archivoE);
            data.append('nombreArchivo', this.fillinformacion.archivonombre);

            data.append('oldimg', this.fillinformacion.oldImg);
            data.append('oldfile', this.fillinformacion.oldFile);

            data.append('oldfile', this.fillinformacion.oldFile);

              data.append('_method', 'PUT');
         

            const config = { headers: { 'Content-Type': 'multipart/form-data' } };

     
    
            /*
             $.ajax({
            url: url,  
            type: 'POST',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                        
            },
            success: function(data){
                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                app.divloaderEdit=false;

                if(data.result=='1'){   
                app.getInformacion(1,app.carrera_id);
                app.fillinformacion={'id':'', 'titulo':'', 'descripcion':'', 'orden':'', 'urlimagen':'', 'estado':'', 'urldocumento':'', 'carrerasunasam_id':'','archivonombre':'', 'oldImg':'', 'oldFile':''};
                app.errors=[];
                $("#modalEditar").modal('hide');
                toastr.success(data.msj);

                }else{

                    $('#'+data.selector).focus();
                    toastr.error(data.msj);
                 
                }

            },
       
            error: function(data){

            }

            });*/


           

           axios.post(url, data, config).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getInformacion(this.thispage2,this.carrera_id);
                this.fillinformacion={'id':'', 'titulo':'', 'descripcion':'', 'orden':'', 'urlimagen':'', 'estado':'', 'urldocumento':'', 'carrerasunasam_id':'','archivonombre':'', 'oldImg':'', 'oldFile':''};
                //CKEDITOR.instances['editorE'].setData("");
                this.errors=[];
                $("#modalEditar").modal('hide');
                toastr.success(response.data.msj);

                }else{

                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                 
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
            

        },

        bajaInformacion:function (informacion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el Contenido Informativo, se mantendrá oculta de la web este contenido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'informacion/altabaja/'+informacion.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getInformacion(app.thispage2,app.carrera_id);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaInformacion:function (informacion) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el Contenido Informativo, la información de este contenido será visibles.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'informacion/altabaja/'+informacion.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getInformacion(app.thispage2,app.carrera_id);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        verImg:function (informacion) {

            this.image=informacion.urlimagen;
            $("#boxTituloImg").text('Contenido Informativo: '+informacion.titulo);
            $("#modalFoto").modal('show');
            $("#imgInformacion").attr("src","<?php echo e(asset('/img/informacion/images/')); ?>"+"/"+this.image);
            this.fillinformacion.id=informacion.id;
        },
        deleteFoto:function (id) {
            swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Imagen?",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'informacion/deleteImg/'+id+'/'+app.image;
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getInformacion(app.thispage2,app.carrera_id);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                                $("#modalFoto").modal('hide');
                                app.fillinformacion.id="";
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        verArcivo:function (informacion) {

            this.nameAdjunto=informacion.archivonombre;
            this.fillinformacion.id=informacion.id;
            this.urlAdjunto="<?php echo e(asset('/img/informacion/files/')); ?>"+"/"+informacion.urldocumento;
            this.nameAdjuntoE=informacion.archivonombre;
            this.$nextTick(() => {
                this.iflink=true;
                this.file=informacion.urldocumento;
      
             });

            $("#boxTituloFile").text('Archivo Adjunto de: '+informacion.titulo);
            $("#modalArchivo").modal('show');
            
            
        },

        deleteAdjunto:function (id) {
            swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el archivo adjunto?",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'informacion/deleteFile/'+id+'/'+app.file;
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getInformacion(app.thispage2,app.carrera_id);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                                $("#modalArchivo").modal('hide');
                                app.fillinformacion.id="";
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editNombreAdjunto:function (id) {
            swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea cambiar el nombre del archivo adjunto?",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, cambiar'
                }).then(function () {

                            var url = 'informacion/cambiarAdj/'+id+'/'+app.nameAdjuntoE;
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.nameAdjunto=app.nameAdjuntoE;
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        pressBtnEdit:function () {
           // $("#btnEditarNA").trigger('click'); 
          $("#btnEditarNA").focus();
          this.editNombreAdjunto(this.fillinformacion.id);
          this.$nextTick(() => {
            $("#txtnameAdjuntoE").focus();
          });
        },


    }
});


</script>