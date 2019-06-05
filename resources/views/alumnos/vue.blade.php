<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',

        noPerfil:'noPerfil.png',
        titulo:"Alumnos",
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
        classTitle:'fa fa-users',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',
        divEditAlumno:false,

        divhome:false,
        divalumno:true,

        alumnos: [],
        ciclos: [],
        carreras: [],
        persona:[],
        user:[],
        alumno:[],
        errors:[],
        fillPersona:{'id':'', 'dni':'', 'nombres':'', 'apellidos':'', 'genero':'', 'telf':'', 'direccion':'', 'imagen':'', 'tipodocu':'1'},

        fillAlumno:{'id':'', 'codigopos':'', 'estado':'1', 'carrera_id2':'', 'activo':'', 'quinto':'', 'persona_id':'', 'carrerasunasam_id':'', 'ciclo_id':''},

        filluser:{'id':'', 'name':'', 'email':'', 'password':'', 'persona_id':'', 'activo':'', 'token2':''},

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
        divNuevoAlumno:false,

        newDNI:'',
        newNombres:'',
        newApellidos:'',
        newGenero:'1',
        newTelefono:'',
        newDireccion:'',

        newTipoDocu:'1',

        newcodigopos:'',
        newEstadoAlumno:'1',
        newcarrera_id2:'',
        newActivoAlumno:'1',
        newQuinto:'0',
        newCarrerasunasam:'',
        newCiclo_id:'',
        oldImagen:'',

        newUsername:'',
        newEmail:'',
        newPassword:'',


        divloaderNuevo:false,

        divloaderEdit:false,

        divloaderEditPersona:false,
        divloaderEditImagen:false,
        divloaderEditAlumno:false,
        divloaderEditUser:false,

        formularioCrear:false,
        mostrarPalenIni:false,

        validated:'0',

        
        imagen : null,

        idPersona:'0',
        idUser:'0',
        idAlumno:'0',
        activeOp:'0',

        nameCiclo:'',

        Pricarrera:'',
        Secarrera:'',

        thispage:'1',



    },
    created:function () {
        this.getAlumnos(this.thispage);
    },
    mounted: function () {
        this.divloader0=false;
        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.noPerfil);
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
        getAlumnos: function (page) {
            var busca=this.buscar;
            var urlAlumnos = 'alumno?page='+page+'&busca='+busca;

            axios.get(urlAlumnos).then(response=>{

                this.alumnos= response.data.alumnos.data;
                this.carreras= response.data.carreras;
                this.ciclos= response.data.ciclos;
                this.pagination= response.data.pagination;
                this.mostrarPalenIni=true;

                $.each(this.ciclos, function( index, dato ) {
                    app.newCiclo_id=dato.id;
                    app.activeOp=dato.segundacarrera;
                    app.nameCiclo=dato.nombre;
                });

                if(this.alumnos.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }


            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getAlumnos(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getAlumnos();
            this.thispage='1';
        },
        nuevoAlumno:function () {
            this.divNuevoAlumno=true;
            this.divloaderEditAlumno=false;

            this.$nextTick(function () {
            this.cancelFormAlumno();
          })
            
        },
        cerrarFormAlumno: function () {
            this.divNuevoAlumno=false;
            this.cancelFormAlumno();
        },
        cancelFormAlumno: function () {
            this.validated='0';
            this.$nextTick(function () {
            $('#txtDNI').focus();
            })
            this.newDNI='';
            this.newNombres='';
            this.newApellidos='';
            this.newGenero='1';
            this.newTelefono='';
            this.newDireccion='';

            this.newTipoDocu='1';
            this.newcodigopos='';
            this.newEstadoAlumno='1';
            this.newcarrera_id2='';
            this.newActivoAlumno='1';
            this.newQuinto='0';
            this.newCarrerasunasam='';
            this.newUsername='';
            this.newEmail='';
            this.newPassword='';
            this.formularioCrear=false;
            this.imagen=null;
            this.idPersona='0';
            this.persona=[];
            this.idUser='0';
            this.user=[];
            this.persona=[];
            this.idAlumno='0';
            this.oldImagen='';


        },
        pressNuevoDNI: function (dni) {

            if(dni.length!=8){
                alertify.error('Complete los 08 dígitos correspondientes del DNI');
            }
            else{



                var url = 'alumno/verpersona/'+dni;
                var auximg="";
                axios.get(url).then(response=>{

                this.idAlumno=response.data.idAlumno;
                
                if(this.idAlumno=="0")
                    {

                this.idPersona=response.data.id;
                this.persona=response.data.persona;

                this.idUser=response.data.idUser;
                this.user=response.data.user;

                if(this.idUser!='0'){
                    $.each(this.user, function( index, dato ) {
                        app.newUsername=dato.name;
                        app.newEmail=dato.email;
                        app.newPassword=dato.token2;
                    });
                }

                if(this.idPersona!='0'){
                    //toastr.success("te encontre");
                    //console.log(this.persona);
                    $.each(this.persona, function( index, dato ) {
                     //console.log(dato.nombres);

                        app.newDNI=dato.dni;
                        app.newNombres=dato.nombres;
                        app.newApellidos=dato.apellidos;
                        app.newGenero=dato.genero;
                        app.newTelefono=dato.telf;
                        app.newDireccion=dato.direccion;

                    console.log(dato.imagen);

                    

    

                        if(dato.imagen!=null && dato.imagen.length>0)
                        {
                            auximg=dato.imagen;
                            app.oldImagen=dato.imagen;
                            
                        }
                        


                    });


                    this.$nextTick(function () {
                        this.formularioCrear=true;
                        this.$nextTick(function () {

                            if(auximg.length>0){
                                $("#ImgPerfilNuevo").attr("src","{{ asset('/img/perfil/')}}"+"/"+auximg);
                            }
        
                             this.validated='1';
                             $('#txtcodigo').focus();
                             $('#cbuCarreras').select2();
                             $('#cbuCarreras').val('').trigger('change');


                        if ( $("#cbuCarrerasOp").length > 0 ) {
                             $('#cbuCarrerasOp').select2();
                             $('#cbuCarrerasOp').val('').trigger('change');
                            }
                        })
                            })

                }else{


                    this.formularioCrear=true;
                this.$nextTick(function () {
                     this.validated='1';
                     $('#txtnombres').focus();
                     $('#cbuCarreras').select2();
                     $('#cbuCarreras').val('').trigger('change');

                if ( $("#cbuCarrerasOp").length > 0 ) {
                     $('#cbuCarrerasOp').select2();
                     $('#cbuCarrerasOp').val('').trigger('change');
                    }
                })
                }


                }
                else{
                     swal({
                      title: 'Alumno Registrado',
                      text: 'Ya se encuentra registrado el alumno con el DNI: '+dni+' En el Ciclo Activado: '+app.nameCiclo,
                      type: 'info',
                      confirmButtonText: 'Aceptar'
                    });

                     this.cancelFormAlumno();
                }

                });

            
                
               
            }
            

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
        createAlumno:function () {
            var url='alumno';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);

            this.divloaderNuevo=true;

            if($("#cbuCarreras").val()!=null){
                this.newCarrerasunasam=$("#cbuCarreras").val();
            }

             if($("#cbuCarrerasOp").val()!=null && this.activeOp=="1"){
                this.newCarrerasunasam=$("#cbuCarrerasOp").val();
            }

            var data = new  FormData();

            data.append('idPersona', this.idPersona);
            data.append('idUser', this.idUser);
            data.append('newDNI', this.newDNI);
            data.append('newNombres', this.newNombres);
            data.append('newApellidos', this.newApellidos);
            data.append('newGenero', this.newGenero);
            data.append('newTelefono', this.newTelefono);
            data.append('newDireccion', this.newDireccion);
            data.append('imagen', this.imagen);
            data.append('newTipoDocu', this.newTipoDocu);

            data.append('newcodigopos', this.newcodigopos);
            data.append('newEstadoAlumno', this.newEstadoAlumno);
            data.append('newcarrera_id2', this.newcarrera_id2);
            data.append('newActivoAlumno', this.newActivoAlumno);
            data.append('newQuinto', this.newQuinto);
            data.append('newCarrerasunasam', this.newCarrerasunasam);
            data.append('newCiclo_id', this.newCiclo_id);
            data.append('activeOp', this.activeOp);

            data.append('newUsername', this.newUsername);
            data.append('newEmail', this.newEmail);
            data.append('newPassword', this.newPassword);
            data.append('oldImagen', this.oldImagen);

            
            const config = { headers: { 'Content-Type': 'multipart/form-data' } };


            axios.post(url,data,config).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getAlumnos(this.thispage);
                    this.errors=[];
                    this.cerrarFormAlumno();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarAlumno:function (alumno) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el alumno seleccionado? -- Nota: Este proceso no se podrá revertir",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'alumno/'+alumno.idalum;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAlumnos(app.thispage);//listamos
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
                  this.imagen=null;
                }
                else{
                this.imagen = event.target.files[0];
                }
            },
        editAlumno:function (alumno) {

            this.fillPersona.id=alumno.idper;
            this.fillPersona.dni=alumno.dni;
            this.fillPersona.nombres=alumno.nombresPer;
            this.fillPersona.apellidos=alumno.apePer;
            this.fillPersona.telf=alumno.telf;
            this.fillPersona.direccion=alumno.direccion;
            this.fillPersona.imagen=alumno.imagen;
            this.fillPersona.tipodocu=alumno.tipodocu;
            this.fillPersona.genero=alumno.genero;

            this.fillAlumno.id=alumno.idalum;
            this.fillAlumno.codigopos=alumno.codigopos;
            this.fillAlumno.estado=alumno.estadoAlum;
            this.fillAlumno.carrera_id2=alumno.carrera_id2;
            this.fillAlumno.activo=alumno.activoAlum;
            this.fillAlumno.quinto=alumno.quinto;
            this.fillAlumno.carrerasunasam_id=alumno.idCarre;


            this.filluser.id=alumno.idUsser;
            this.filluser.name=alumno.username;
            this.filluser.email=alumno.email;
            this.filluser.token2=alumno.token2;

            this.divNuevoAlumno=false;
            this.divloaderEditAlumno=false;
            this.divEditAlumno=true;
            this.$nextTick(function () {
                     this.validated='1';
                     $('#txtnombresE').focus();
                     $('#cbuCarrerasE').select2();
                     $('#cbuCarrerasE').val(alumno.idCarre).trigger('change');

                if ( $("#cbuCarrerasOpE").length > 0 ) {
                     $('#cbuCarrerasOpE').select2();
                     $('#cbuCarrerasOpE').val(alumno.carrera_id2).trigger('change');
                    }

                if(alumno.imagen.length>0){
                    $("#ImgPerfilNuevoE").attr("src","{{ asset('/img/perfil/')}}"+"/"+alumno.imagen);
                }

                })

        },
        cerrarFormAlumnoE: function(){

            this.divEditAlumno=false;

            this.$nextTick(function () {
            this.fillPersona={'id':'', 'dni':'', 'nombres':'', 'apellidos':'', 'genero':'', 'telf':'', 'direccion':'', 'imagen':'', 'tipodocu':'1'};
            this.fillAlumno={'id':'', 'codigopos':'', 'estado':'1', 'carrera_id2':'', 'activo':'', 'quinto':'', 'persona_id':'', 'carrerasunasam_id':'', 'ciclo_id':''};
            this.filluser={'id':'', 'name':'', 'email':'', 'password':'', 'persona_id':'', 'activo':'', 'token2':''};
          })

        },
        updateAlumno:function (idPer,idAlum,idUser) {


            if($("#cbuCarrerasE").val()!=null){
                this.fillAlumno.carrerasunasam_id=$("#cbuCarrerasE").val();
            }

             if($("#cbuCarrerasOpE").val()!=null && this.activeOp=="1"){
                this.fillAlumno.carrera_id2=$("#cbuCarrerasOpE").val();
            }


        var data = new  FormData();

        data.append('idPersona', this.fillPersona.id);
        data.append('idUser', this.filluser.id);

        data.append('editDNI', this.fillPersona.dni);
        data.append('editNombres', this.fillPersona.nombres);
        data.append('editApellidos', this.fillPersona.apellidos);
        data.append('editGenero',  this.fillPersona.genero);
        data.append('editTelefono', this.fillPersona.telf);
        data.append('editDireccion', this.fillPersona.direccion);
        data.append('imagen', this.imagen);
        data.append('editTipoDocu', this.fillPersona.tipodocu);

        data.append('editcodigopos', this.fillAlumno.codigopos);
        data.append('editEstadoAlumno', this.fillAlumno.estado);
        data.append('editcarrera_id2',  this.fillAlumno.carrera_id2);
        data.append('editActivoAlumno', this.fillAlumno.activo);
        data.append('editQuinto', this.fillAlumno.quinto);
        data.append('editCarrerasunasam',  this.fillAlumno.carrerasunasam_id);
        data.append('editCiclo_id', this.newCiclo_id);
        data.append('activeOp', this.activeOp);

        data.append('editUsername', this.filluser.name);
        data.append('editEmail', this.filluser.email);
        data.append('editPassword',  this.filluser.token2);
        data.append('oldImagen', this.fillPersona.imagen);

        data.append('_method', 'PUT');

        const config = { headers: { 'Content-Type': 'multipart/form-data' } };

        this.divloaderEditAlumno=true;

           var url="alumno/"+idAlum;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCloseE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.post(url, data, config).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCloseE").removeAttr("disabled");

                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getAlumnos(this.thispage);
                this.cerrarFormAlumnoE();
                toastr.success(response.data.msj);


                this.divEditAlumno=false;

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        bajaAlumno:function (alumno) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el alumno, No podrá acceder al sistema, hasta que sea activado nuevamente",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'alumno/altabaja/'+alumno.idUsser+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAlumnos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaAlumno:function (alumno) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el alumno, podrá acceder al sistema nuevamente",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'alumno/altabaja/'+alumno.idUsser+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAlumnos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        impFicha:function (alumno) {

            

            this.fillPersona.dni=alumno.dni;
            this.fillPersona.nombres=alumno.nombresPer;
            this.fillPersona.apellidos=alumno.apePer;
            this.fillPersona.telf=alumno.telf;
            this.fillPersona.direccion=alumno.direccion;

            this.fillPersona.tipodocu=alumno.tipodocu;
            this.fillPersona.genero=alumno.genero;

            this.fillAlumno.id=alumno.idalum;
            this.fillAlumno.codigopos=alumno.codigopos;
            this.fillAlumno.estado=alumno.estadoAlum;
            this.fillAlumno.carrera_id2=alumno.carrera_id2;
            this.fillAlumno.activo=alumno.activoAlum;
            this.fillAlumno.quinto=alumno.quinto;
            this.fillAlumno.carrerasunasam_id=alumno.idCarre;


            this.filluser.id=alumno.idUsser;
            this.filluser.name=alumno.username;
            this.filluser.email=alumno.email;
            this.filluser.token2=alumno.token2;

            this.Pricarrera=alumno.carrera;

            this.fillPersona.imagen=alumno.imagen;

            this.$nextTick(function () {

                if(alumno.imagen.length>0){
            $("#divImgFIcha").attr("src","{{ asset('/img/perfil/')}}"+"/"+app.fillPersona.imagen);
            }
            this.$nextTick(function () {

            $('#modalFicha').modal(); 
          })
          })

            
            

              
        },
        Imprimir:function (alumno) {
            $("#FichaAlumno").printArea();
        },
    }
});
</script>