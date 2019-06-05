@include('ippr.componentesEditorMetodologia')

<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        titulo:"Metodología IPP-R",
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
        classTitle:'fa fa-file-powerpoint-o',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'active',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divhome:false,
        divippr:true,

        metodologiaData: [],
        modulos: [],
        validezs: [],
        reglas: [],
        errors:[],
        fillMetodologia:{'id':'', 'nombre':'', 'descripcion':'','descmostrar':'','activo':'1'},

        fillModulo:{'id':'', 'fase':'', 'titulo':'','descripcion':'','pregaleatorias':'0','activo':'1','metodologiavocacional_id':''},

        fillValidez:{'id':'', 'minpreguntas':'', 'maxalternativas':'','activo':'1','modulovocacional_id':''},

        fillReglas:{'id':'', 'descripcion':'','activo':'1','modulovocacional_id':''},

        metodologia:'1',

        divNuevoModulo:false,
        newFase:'',
        newTitulo:'',
        newDescripcion:'',
        newPregalestoria:'0',
        newActivo:'1',
        newmetodologiavocacional:'1',

        newMinPregs:'',
        newMaxAlter:'',

        divloaderNuevo:false,
        divloaderEdit:false,
        divloaderEditMod:false,

        divloaderEditM:false,
        divloaderEditVal:false,
        divloaderNewMod:false,
        divloaderNewReg:false,
        divloaderEditReg:false,

        contentD:'',
        contentDM:'',
        contentMod:'',
        contentNMod:'',
        contentNReg:'',
        contentEReg:'',

        newDescripcionReg:'',
        newActivoReg:'1',
        newmodulovocacional_id:'',







    },
    created:function () {
        this.getMetodologia();
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
    methods: {
        getMetodologia: function () {
            var aux=this.metodologia;
            var urlIppr = 'metodologia?metodologia='+aux;

            axios.get(urlIppr).then(response=>{
               // console.log(response.data.ippr);
                this.metodologiaData= response.data.ippr,
                this.modulos= response.data.modulovocacional,
                this.validezs= response.data.validez,
                this.reglas= response.data.reglas
            })
        },

        editMetodologia:function (metodologia) {
            this.fillMetodologia.id=metodologia.id;
            this.fillMetodologia.nombre=metodologia.nombre;

            if(metodologia.descripcion != null){
                CKEDITOR.instances['editorD'].setData(metodologia.descripcion);
            }
            else{
                CKEDITOR.instances['editorD'].setData("");
            }

            if(metodologia.descmostrar != null){
                CKEDITOR.instances['editorDM'].setData(metodologia.descmostrar);
            }
            else{
                CKEDITOR.instances['editorDM'].setData("");
            }

            $("#boxTitulo").text('Metodología: '+metodologia.nombre);
            $("#modalEditarM").modal('show');

            this.$nextTick(function () {
           $("#txtNombre").focus();
          })
        },
        updateMetodologia:function (id) {
            var url="metodologia/"+id;
            $("#btnSaveEM").attr('disabled', true);
            $("#btnCancelEM").attr('disabled', true);

            this.fillMetodologia.descripcion=CKEDITOR.instances['editorD'].getData();
            this.fillMetodologia.descmostrar=CKEDITOR.instances['editorDM'].getData();

            this.divloaderEditM=true;

            axios.put(url, this.fillMetodologia).then(response=>{

                $("#btnSaveEM").removeAttr("disabled");
                $("#btnCancelEM").removeAttr("disabled");
                this.divloaderEditM=false;
                
                if(response.data.result=='1'){   
                this.getMetodologia();
                this.fillMetodologia={'id':'', 'nombre':'', 'descripcion':'','descmostrar':'','activo':'1'};
                this.errors=[];
                $("#modalEditarM").modal('hide');
                toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },


        nuevaRegla:function (modulo) {
            this.newDescripcionReg='';
            this.newActivoReg='1';
            this.newmodulovocacional_id=modulo.id;

            CKEDITOR.instances['editorNReg'].setData("");

            $("#modalCrearReg").modal('show');
             this.$nextTick(() => {
            CKEDITOR.instances["editorNReg"].focus();
            })
        },

        createReglas:function () {
            var url='regla';
            $("#btnSaveRegN").attr('disabled', true);
            $("#btnCancelRegN").attr('disabled', true);
            this.divloaderNewReg=true;

            this.newDescripcionReg=CKEDITOR.instances['editorNReg'].getData();

            axios.post(url,{descripcion:this.newDescripcionReg, activo:this.newActivoReg, modulovocacional_id: this.newmodulovocacional_id }).then(response=>{
                //console.log(response.data);

                $("#btnSaveRegN").removeAttr("disabled");
                $("#btnCancelRegN").removeAttr("disabled");
                this.divloaderNewReg=false;

                if(response.data.result=='1'){
                    this.getMetodologia();
                    this.newDescripcionReg='';
                    this.newActivoReg='1';
                    this.newmodulovocacional_id='';

                    $("#modalCrearReg").modal('hide');
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error;
                alert(this.errors)
            })
        },

        editRegla:function(regla){
            this.fillReglas.id=regla.id;
            this.fillReglas.descripcion=regla.descripcion;
            this.fillReglas.modulovocacional_id=regla.modulovocacional_id;


            if(regla.descripcion != null){
                CKEDITOR.instances['editorEReg'].setData(regla.descripcion);
            }
            else
            {
                CKEDITOR.instances['editorEReg'].setData("");
            }

            $("#boxTituloEditReg").text('Regla a Editar:');
            $("#modalEditReg").modal('show');

            this.$nextTick(() => {
            CKEDITOR.instances["editorEReg"].focus();
            })
        },


        updateRegla:function (id) {
            var url="regla/"+id;

            $("#btnSaveRegE").attr('disabled', true);
            $("#btnCancelRegE").attr('disabled', true);

            this.fillReglas.descripcion=CKEDITOR.instances['editorEReg'].getData();

            this.divloaderEditReg=true;

            axios.put(url, this.fillReglas).then(response=>{

                $("#btnSaveRegE").removeAttr("disabled");
                $("#btnCancelRegE").removeAttr("disabled");
                this.divloaderEditReg=false;
                
                if(response.data.result=='1'){   
                this.getMetodologia();
                this.fillReglas={'id':'', 'descripcion':'','activo':'1','modulovocacional_id':''};
                this.errors=[];
                $("#modalEditReg").modal('hide');
                toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        borrarRegla:function (regla) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Regla Seleccionada? -- Nota: Este proceso no podrá ser revertido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'regla/'+regla.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMetodologia();//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },






        nuevoModulo:function () {

            CKEDITOR.instances['editorNMod'].setData("");

            $("#modalCrearMod").modal('show');

            this.$nextTick(function () {
           $("#txtTituloModNew").focus();
          })
        },

        

        createModulo:function () {
            var url='modulo';
            $("#btnSaveModN").attr('disabled', true);
            $("#btnCancelModN").attr('disabled', true);
            this.divloaderNewMod=true;

            this.newDescripcion=CKEDITOR.instances['editorNMod'].getData();

            axios.post(url,{titulo:this.newTitulo, fase:this.newFase, pregsAlea:this.newPregalestoria, descripcion:this.newDescripcion, minpregs:this.newMinPregs, maxlater:this.newMaxAlter, metodologia:this.metodologia }).then(response=>{
                //console.log(response.data);

                $("#btnSaveModN").removeAttr("disabled");
                $("#btnCancelModN").removeAttr("disabled");
                this.divloaderNewMod=false;

                if(response.data.result=='1'){
                    this.getMetodologia();
                    this.errors=[];
                    this.txtTituloModNew='';
                    this.txtfase='';
                    this.newPregalestoria='';
                    this.newDescripcion='';
                    this.newMinPregs='';
                    this.newMaxAlter='';

                    $("#modalCrearMod").modal('hide');
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        editModulo:function(modulo){
            this.fillModulo.id=modulo.id;
            this.fillModulo.titulo=modulo.titulo;
            this.fillModulo.fase=modulo.fase;
            this.fillModulo.descripcion=modulo.descripcion;
            this.fillModulo.pregaleatorias=modulo.pregaleatorias;
            this.fillModulo.metodologiavocacional_id=modulo.metodologiavocacional_id;

            if(modulo.descripcion != null){
                CKEDITOR.instances['editorMod'].setData(modulo.descripcion);
            }
            else
            {
                CKEDITOR.instances['editorMod'].setData("");
            }

            $("#boxTituloMod").text('Módulo: '+modulo.titulo);
            $("#modalEditarMod").modal('show');

            this.$nextTick(function () {
           $("#txtTituloMod").focus();
          })
        },



        updateModulo:function (id) {
            var url="modulo/"+id;
            $("#btnSaveModE").attr('disabled', true);
            $("#btnCancelModE").attr('disabled', true);

            this.fillModulo.descripcion=CKEDITOR.instances['editorMod'].getData();

            this.divloaderEditMod=true;

            axios.put(url, this.fillModulo).then(response=>{

                $("#btnSaveModE").removeAttr("disabled");
                $("#btnCancelModE").removeAttr("disabled");
                this.divloaderEditMod=false;
                
                if(response.data.result=='1'){   
                this.getMetodologia();
                this.fillModulo={'id':'', 'fase':'', 'titulo':'','descripcion':'','pregaleatorias':'0','activo':'1','metodologiavocacional_id':''};
                this.errors=[];
                $("#modalEditarMod").modal('hide');
                toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        borrarModulo:function (modulo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Módulo Seleccionado? -- Nota: Se eliminará toda la información registrada en este módulo, y este proceso no podrá ser revertido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'modulo/'+modulo.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMetodologia();//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },


        editValidez:function (validez) {
            this.fillValidez.id=validez.id;
            this.fillValidez.minpreguntas=validez.minpreguntas;
            this.fillValidez.maxalternativas=validez.maxalternativas;
            this.fillValidez.modulovocacional_id=validez.modulovocacional_id;

            $("#modalEditarVal").modal('show');

            this.$nextTick(function () {
           $("#txtTituloMod").focus();
          })
        },



        updateValidez:function (id) {
            var url="validez/"+id;
            $("#btnSaveValE").attr('disabled', true);
            $("#btnCancelValE").attr('disabled', true);

            this.divloaderEditVal=true;

            axios.put(url, this.fillValidez).then(response=>{

                $("#btnSaveValE").removeAttr("disabled");
                $("#btnCancelValE").removeAttr("disabled");
                this.divloaderEditVal=false;
                
                if(response.data.result=='1'){   
                this.getMetodologia();
                this.fillValidez={'id':'', 'minpreguntas':'', 'maxalternativas':'','activo':'1','modulovocacional_id':''};
                this.errors=[];
                $("#modalEditarVal").modal('hide');
                toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        },

       
        bajaArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el área, se mantendrán ocultas todas las carreras profesionales pertenecientes a él, hasta que se active el área. ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'areas/altabaja/'+area.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAreas();//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el área, todas las carreras profesionales pertenecientes al área serán visibles.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'areas/altabaja/'+area.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAreas();//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
    }
});
</script>