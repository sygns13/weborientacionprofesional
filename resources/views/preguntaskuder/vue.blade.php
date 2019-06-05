<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        titulo:"KUDER FORMA C",
        subtitulo:"Inventario de Intereses Vocacionales",
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
        divPreguntas:true,

        preguntasMain:[],
        preguntas: [],
        campoprofesionals: [],
        alternativas: [],
        errors:[],
        fillPreguntas1:{'id':'', 'id2':'', 'id3':'', 'descripcion':'', 'descripcion2':'', 'descripcion3':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''},
        fillPreguntas2:{'id':'', 'descripcion':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''},
        fillPreguntas3:{'id':'', 'descripcion':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''},
        fillAlternativas:{'id':'','alternativa':'1', 'descripcion':'', 'orden':'','puntaje':'','activo':'1','detactividadprofesion':'1','pregunta_id':'','campoprofesional_id':''},
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
        divNuevaPregunta:false,
        newPregunta1:'',
        newPregunta2:'',
        newPregunta3:'',
        newOrden:'',
        newoblig:'1',
        estadoPreg:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        idModulo:'{{$idModulo}}',

         idMet:'{{$idMet}}',

         newAlternativa:'',
         newAlternativaMarca:'mas',
         newOrdenAlter:'',
         newPuntaje:'',
         ActivProf:'1',
         newpregunta_id:'',
         newcampoprofesional_id:'',

         divloaderAlter:false,
         divloaderAlterE:false,

         thispage:'1',




    },
    created:function () {
        this.getPreguntas(this.thispage);
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
        getPreguntas: function (page) {
            var busca=this.buscar;
            var urlPreguntas = '/preguntakuder?page='+page+'&busca='+busca+'&idModulo='+this.idModulo+'&idMet='+this.idMet;

            axios.get(urlPreguntas).then(response=>{
                this.preguntasMain='';
                this.preguntas='';
                this.alternativas='';

                this.$nextTick(function () {
                this.preguntasMain=response.data.preguntasMain;
                this.preguntas= response.data.preguntas.data;
                this.$nextTick(function () {
                    this.alternativas= response.data.alternativas;
                    if(this.preguntas.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                    }
                  })
                  })

                this.campoprofesionals= response.data.campoprofesionals;
                this.pagination= response.data.pagination;

                
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getPreguntas(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getPreguntas();
            this.thispage='1';
        },
        nuevaPregunta:function () {
            this.divNuevaPregunta=true;
            //$("#txtarea").focus();
            //$('#txtarea').focus();
            this.$nextTick(function () {
            this.cancelFormPreg();
          })
            
        },
        cerrarFormPreg: function () {
            this.divNuevaPregunta=false;
            this.cancelFormPreg();
        },
        cancelFormPreg: function () {
            $('#txtpregunta1').focus();
                this.newPregunta1='';
                this.newPregunta2='';
                this.newPregunta3='';
                this.newOrden='';
                this.newoblig='1';
                this.estadoPreg='1';
        },
        createPregunta:function () {
            var url='/preguntakuder';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            axios.post(url,{descripcion1:this.newPregunta1, descripcion2:this.newPregunta2, descripcion3:this.newPregunta3, orden:this.newOrden, obligatorio:this.newoblig, activo:this.estadoPreg, modulovocacional_id:this.idModulo}).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getPreguntas(this.thispage);
                    this.errors=[];
                    this.cerrarFormPreg();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarPregunta:function (pregunta) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la triada de preguntas Seleccionadas? -- Nota: Este proceso no podrá ser revertido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = '/preguntakuder/'+pregunta.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPreguntas(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editPregunta:function (pregunta) {


            var url = '/preguntakuder/'+pregunta.id+'/edit';
                            axios.get(url).then(response=>{//eliminamos
            
            this.fillPreguntas1.id=response.data.id1;
            this.fillPreguntas1.id2=response.data.id2;
            this.fillPreguntas1.id3=response.data.id3;
            this.fillPreguntas1.descripcion=response.data.pregunta1;
            this.fillPreguntas1.descripcion2=response.data.pregunta2;
            this.fillPreguntas1.descripcion3=response.data.pregunta3;
            this.fillPreguntas1.orden=pregunta.orden;
            this.fillPreguntas1.obligatorio=pregunta.obligatorio;
            this.fillPreguntas1.activo=pregunta.activo;
            this.fillPreguntas1.modulovocacional_id=pregunta.modulovocacional_id;

            this.fillPreguntas2.id=response.data.id2;
            this.fillPreguntas2.descripcion=response.data.pregunta2;
            this.fillPreguntas2.orden=pregunta.orden;
            this.fillPreguntas2.obligatorio=pregunta.obligatorio;
            this.fillPreguntas2.activo=pregunta.activo;
            this.fillPreguntas2.modulovocacional_id=pregunta.modulovocacional_id;

            this.fillPreguntas3.id=response.data.id3;
            this.fillPreguntas3.descripcion=response.data.pregunta3;
            this.fillPreguntas3.orden=pregunta.orden;
            this.fillPreguntas3.obligatorio=pregunta.obligatorio;
            this.fillPreguntas3.activo=pregunta.activo;
            this.fillPreguntas3.modulovocacional_id=pregunta.modulovocacional_id;

            $("#boxTitulo").text('Triada de Preguntas de N° de Orden: '+pregunta.orden);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
            $("#txtpregunta1E").focus();
             })

                            });   
        },
        updatePregunta:function (id) {
            var url="/preguntakuder/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillPreguntas1).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getPreguntas(this.thispage);
                this.fillPreguntas1={'id':'', 'id2':'', 'id3':'', 'descripcion':'', 'descripcion2':'', 'descripcion3':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''};
                this.fillPreguntas2={'id':'', 'descripcion':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''};
                this.fillPreguntas3={'id':'', 'descripcion':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':''};
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
        bajaPregunta:function (pregunta) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva la Pregunta, se mantendrán oculta hasta que se active nuevamente ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = '/preguntakuder/altabaja/'+pregunta.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPreguntas(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaPregunta:function (pregunta) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa la pregunta, se mantendrá visible hasta que sea desactivada nuevamente",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = '/preguntakuder/altabaja/'+pregunta.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPreguntas(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },

        addAlternativa:function (pregunta, numpreg) {

            this.newAlternativa='';
            this.newAlternativaMarca='mas';
            this.newOrdenAlter='';
            this.newPuntaje='';
            this.ActivProf='1';

            this.newpregunta_id=pregunta.id;
            this.newcampoprofesional_id='';

            $('#cbuCampoLab').select2();
            $('#cbuCampoLab').val('').trigger('change');

            $("#boxTituloPreg").text('Pregunta: '+numpreg+': '+pregunta.descripcion);
            $("#modalAddAlternativa").modal('show');

            this.$nextTick(function () {
            $("#txtAlterMarcar").focus();
          })
            
        },
        createAlternativa:function () {
            var url='/alternativakuder';
            $("#btnSaveAlter").attr('disabled', true);
            $("#btnCancelAlter").attr('disabled', true);

            this.newcampoprofesional_id=$('#cbuCampoLab').val();
  
            this.divloaderAlter=true;
            axios.post(url,{alternativa:this.newAlternativaMarca, descripcion:this.newAlternativa, orden:this.newOrdenAlter, puntaje:this.newPuntaje, detactividadprofesion:this.ActivProf, pregunta_id:this.newpregunta_id, campoprofesional_id:this.newcampoprofesional_id}).then(response=>{
                //console.log(response.data);

                $("#btnSaveAlter").removeAttr("disabled");
                $("#btnCancelAlter").removeAttr("disabled");
    
                this.divloaderAlter=false;

                if(response.data.result=='1'){
                    this.getPreguntas(this.thispage);
                    this.errors=[];
                    $("#modalAddAlternativa").modal('hide');
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarAlternativa:function (alternativa) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la puntuación de alternativa Seleccionada? -- Nota: Este proceso no podrá ser revertido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = '/alternativakuder/'+alternativa.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getPreguntas(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        }
        ,
        impPlantilla:function () {
            var url = "/plantillakuder/imprimir/"+this.idMet+"/"+this.idModulo;
            //window.open(url,'_blank');
            window.location.href = url;
        },
        imprimirPlantilla:function () {
            $("#divImp").printArea();
        },
        impHoja:function () {
            var url = "/hojakuder/imprimir/"+this.idMet+"/"+this.idModulo;
            //window.open(url,'_blank');
            window.location.href = url;
        },

        {{--  
        editAlternativa:function (alternativa) {

            this.fillAlternativas.id=alternativa.id;
            this.fillAlternativas.alternativa=alternativa.alternativa;
            this.fillAlternativas.descripcion=alternativa.descripcion;
            this.fillAlternativas.orden=alternativa.orden;
            this.fillAlternativas.puntaje=alternativa.puntaje;
            this.fillAlternativas.activo=alternativa.activo;
            this.fillAlternativas.detactividadprofesion=alternativa.detactividadprofesion;
            this.fillAlternativas.pregunta_id=alternativa.pregunta_id;
            this.fillAlternativas.campoprofesional_id=alternativa.campoprofesional_id;

            this.$nextTick(function () {
    
           $('#cbuCampoLabE').select2();
           this.$nextTick(function () {
           $('#cbuCampoLabE').val(alternativa.campoprofesional_id).trigger('change');
           $('.select2').css("width","100%");
             });
             });

            $("#boxTituloPregE").text('Pregunta: '+alternativa.pregorden+': '+alternativa.pregunta);
            $("#modalAddAlternativaE").modal('show');

            this.$nextTick(function () {
            $("#txtAlternativaE").focus();
          })
            
        },
        updateAlternativa:function (id) {
            var url="/alternativakuder/"+id;
            $("#btnSaveAlterE").attr('disabled', true);
            $("#btnCancelAlterE").attr('disabled', true);
            this.divloaderAlterE=true;

            this.fillAlternativas.campoprofesional_id=$('#cbuCampoLabE').val();

            axios.put(url, this.fillAlternativas).then(response=>{

                $("#btnSaveAlterE").removeAttr("disabled");
                $("#btnCancelAlterE").removeAttr("disabled");
                this.divloaderAlterE=false;
                
                if(response.data.result=='1'){   
                this.getPreguntas(this.thispage);
                this.fillAlternativas={'id':'','alternativa':'1', 'descripcion':'', 'orden':'','puntaje':'','activo':'1','detactividadprofesion':'1','pregunta_id':'','campoprofesional_id':''};
                this.errors=[];
                $("#modalAddAlternativaE").modal('hide');
                toastr.success(response.data.msj);

                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }

            }).catch(error=>{
                this.errors=error.response.data
            })
        }, --}}
    }
});
</script>