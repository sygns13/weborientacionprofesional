<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        titulo:"Ciclos Académicos",
        subtitulo:"Gestión",
        subtitulo:"Gestión",
        subtitle2:false,
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
        classTitle:'fa fa-calendar',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divciclo:true,

        ciclos: [],
        errors:[],
        fillCiclo:{'id':'', 'ciclo':'', 'fechainicio':'','fechafin':'','estado':'','segundacarrera':''},
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
        divNuevoCiclo:false,

        newCiclo:'',
        estadoCiclo:'1',
        newFecIni:'',
        newFecFin:'',
        newOpcion:'0',

        divloaderNuevo:false,
        divloaderEdit:false,

        thispage:'1',





    },
    created:function () {
        this.getCiclos(this.thispage);
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
        getCiclos: function (page) {
            var busca=this.buscar;
            var urlCiclo = 'ciclo?page='+page+'&busca='+busca;

            axios.get(urlCiclo).then(response=>{
                this.ciclos= response.data.ciclos.data;
                this.pagination= response.data.pagination;

                if(this.ciclos.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getCiclos(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getCiclos();
            this.thispage='1';
        },
        nuevoCiclo:function () {
            this.divNuevoCiclo=true;
            //$("#txtciclo").focus();
            //$('#txtciclo').focus();
            this.$nextTick(function () {
            this.cancelFormCiclo();
          })
            
        },
        cerrarFormCiclo: function () {
            this.divNuevoCiclo=false;
            this.cancelFormCiclo();
        },
        cancelFormCiclo: function () {
            $('#txtciclo').focus();
            this.newCiclo='';
            this.newFecIni='';
            this.newFecFin='';
            this.estadoCiclo='1';
            this.newOpcion='0';

        },
        createCiclo:function () {
            var url='ciclo';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            axios.post(url,{Ciclo:this.newCiclo, fecIni:this.newFecIni, fecFin:this.newFecFin, estado:this.estadoCiclo, secOp:this.newOpcion }).then(response=>{

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;


                //console.log(response.data);
                if(response.data.result=='1'){
                    this.getCiclos(this.thispage);
                    this.errors=[];
                    this.cerrarFormCiclo();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarciclo:function (Ciclo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el Ciclo Seleccionado? -- Nota: Para eliminar este ciclo, debe primero eliminar todos los alumnos que se encuentran inscritos en él",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'ciclo/'+Ciclo.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCiclos(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editciclo:function (Ciclo) {

            this.fillCiclo.id=Ciclo.id;
            this.fillCiclo.ciclo=Ciclo.nombre;
            this.fillCiclo.fechainicio=Ciclo.fechainicio;
            this.fillCiclo.fechafin=Ciclo.fechafin;
            this.fillCiclo.estado=Ciclo.estado;
            this.fillCiclo.segundacarrera=Ciclo.segundacarrera;

            $("#boxTitulo").text('Ciclo: '+Ciclo.nombre);

            $("#modalEditar").modal('show');
        },
        updateCiclo:function (id) {
            var url="ciclo/"+id;

            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillCiclo).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                

                if(response.data.result=='1'){   
                this.getCiclos(this.thispage);
                this.fillCiclo={'id':'', 'ciclo':'', 'fechainicio':'','fechafin':'','estado':'','segundacarrera':''},
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
       
        activar:function (Ciclo) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa este ciclo, se desabilitará otro ciclo activado.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'ciclo/activar/'+Ciclo.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getCiclos(app.thispage);//listamos
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