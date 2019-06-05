<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        titulo:"IPP-R",
        subtitulo:"Gestión de Campos Profesionales",
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
        divCampoProf:true,

        campoprofesionals: [],

        errors:[],
        fillCamposProfs:{'id':'', 'nombre':'', 'orden':'','activo':'1','metodologiavocacional_id':''},
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
        divNuevoCampoProf:false,
        newNombre:'',
        newOrden:'',
        estadoCampoProf:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        metodologiavocacional_id:'{{$idMetodologia}}',

        thispage:'1',



    },
    created:function () {
        this.getCamposProfs(this.thispage);
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
        getCamposProfs: function (page) {
            var busca=this.buscar;
            var urlCampos ='/../campoProfesional?page='+page+'&busca='+busca+'&metodologiavocacional_id='+this.metodologiavocacional_id;

            axios.get(urlCampos).then(response=>{


                this.campoprofesionals= response.data.campoprofesionals.data;
                this.pagination= response.data.pagination;

                if(this.campoprofesionals.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }

            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getCamposProfs(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getCamposProfs();
            this.thispage='1';
        },
        nuevoCampoProf:function () {
            this.divNuevoCampoProf=true;

            this.$nextTick(function () {
            this.cancelFormCampoProf();
          })
            
        },
        cerrarFormCampoProf: function () {
            this.divNuevoCampoProf=false;
            this.cancelFormCampoProf();
        },
        cancelFormCampoProf: function () {
            $('#txtNombre').focus();
            this.newNombre='';
            this.newOrden='';
            this.estadoCampoProf='1';
        },
        createCampoProf:function () {
            var url='/../campoProfesional';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            axios.post(url,{nombre:this.newNombre, orden:this.newOrden, estado:this.estadoCampoProf,metodologiavocacional_id:this.metodologiavocacional_id }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getCamposProfs(this.thispage);
                    this.errors=[];
                    this.cerrarFormCampoProf();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Campo Seleccionado? -- Nota: Para eliminar esta área, debe primero eliminar todas las carreras profesionales que se encuentran registradas en él y todas las alternativas que se encuentran asociadas a él.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = '/../campoProfesional/'+campo.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCamposProfs(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editCampoProf:function (campo) {

            this.fillCamposProfs.id=campo.id;
            this.fillCamposProfs.nombre=campo.nombre;
            this.fillCamposProfs.orden=campo.orden;
            this.fillCamposProfs.activo=campo.activo;
            this.fillCamposProfs.metodologiavocacional_id=campo.metodologiavocacional_id;

            $("#boxTitulo").text('Campo Profesional: '+campo.nombre);
            $("#modalEditar").modal('show');
        },
        updateCampos:function (id) {
            var url="/../campoProfesional/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillCamposProfs).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getCamposProfs(app.thispage);
                this.fillCamposProfs={'id':'', 'nombre':'', 'orden':'','activo':'1','metodologiavocacional_id':''};
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
        bajaCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el campo Profesional, se mantendrán ocultas todas las carreras profesionales pertenecientes a él y todas las alternativas asociadas a él, hasta que se active el área. ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = '/../campoProfesional/altabaja/'+campo.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCamposProfs(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaCampoProf:function (campo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa el campo Profesional, todas las carreras profesionales pertenecientes al área serán visibles y todas las alternativas asociadas a él.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = '/../campoProfesional/altabaja/'+campo.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCamposProfs(app.thispage);//listamos
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