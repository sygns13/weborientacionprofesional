@include('maestrocarreras2.componentes')

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
        classTitle:'fa fa-book',
        classMenu0:'',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'active',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divhome:false,
        divMaestroCarreras:true,

        maestroscarreras: [],

        errors:[],
        fillcarreras:{'id':'', 'nombre':'', 'descripcion':'','activo':'1','campoprofesional_id':''},
        pagination: {
        'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
                },
        offset: 3,
        buscar:'',

        divNuevaCarrera:false,
        newCarrera:'',
        newDescripcion:'',
        estadoCarrera:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        campoprofesional_id:'{{$idCampoProfs}}',

        content: '',
        contentE: '',

        thispage:'1',



    },
    created:function () {
        this.getMaestroCarreras(this.thispage);
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
            if(from<1){
                from=1;
            }

            var to= from + (this.offset*2); 
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
        getMaestroCarreras: function (page) {
            var busca=this.buscar;
            var urlgetcarreras ='/maestrocarrera?page='+page+'&busca='+busca+'&campoprofesional_id='+this.campoprofesional_id;

            axios.get(urlgetcarreras).then(response=>{


                this.maestroscarreras= response.data.maestroscarreras.data;
                this.pagination= response.data.pagination;

                if(this.maestroscarreras.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getMaestroCarreras(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getMaestroCarreras();
            this.thispage='1';
        },
        nuevaCarrera:function () {
            this.divNuevaCarrera=true;

            this.$nextTick(function () {
            this.cancelFormCarreraProf();
          })
            
        },
        cerrarFormCarreraProf: function () {
            this.divNuevaCarrera=false;
            this.cancelFormCarreraProf();
        },
        cancelFormCarreraProf: function () {
            $('#txtcarrera').focus();
            this.newCarrera='';
            this.newDescripcion='';
            this.estadoCarrera='1';
            CKEDITOR.instances['editor'].setData("");
        },
        createCarrera:function () {
            var url='/maestrocarrera';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            this.newDescripcion=CKEDITOR.instances['editor'].getData();

            axios.post(url,{nombre:this.newCarrera, descripcion:this.newDescripcion, estado:this.estadoCarrera,campoprofesional_id:this.campoprofesional_id }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getMaestroCarreras(this.thispage);
                    this.errors=[];
                    this.cerrarFormCarreraProf();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarCarrera:function (carrera) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Carrera Profesional? -- Nota: Una vez Llevado a cabo el proceso, este no podrá ser revertido",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = '/maestrocarrera/'+carrera.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMaestroCarreras(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editCarrera:function (carrera) {

            this.fillcarreras.id=carrera.id;
            this.fillcarreras.nombre=carrera.nombre;
            this.fillcarreras.descripcion=carrera.descripcion;
            this.fillcarreras.activo=carrera.activo;
            this.fillcarreras.campoprofesional_id=carrera.campoprofesional_id;

            if(carrera.descripcion != null){
                CKEDITOR.instances['editorE'].setData(carrera.descripcion);
            }
            else{
                CKEDITOR.instances['editorE'].setData("");
            }

            $("#boxTitulo").text('Carrera Profesional: '+carrera.nombre);
            $("#modalEditar").modal('show');
        },
        updateCarrera:function (id) {
            var url="/maestrocarrera/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

             this.fillcarreras.descripcion=CKEDITOR.instances['editorE'].getData();

            axios.put(url, this.fillcarreras).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getMaestroCarreras(this.thispage);
                this.fillcarreras={'id':'', 'nombre':'', 'descripcion':'','activo':'1','campoprofesional_id':''};
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
        bajaCarrera:function (carrera) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva el carrera Profesional, se mantendrán oculta hasta que vuelva a ser activada.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = '/maestrocarrera/altabaja/'+carrera.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMaestroCarreras(app.thispage);//listamos
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
                  text: "Nota: Si activa el carrera Profesional, la carrera será visible hasta que vuelva a ser desactivada",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = '/maestrocarrera/altabaja/'+carrera.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getMaestroCarreras(app.thispage);//listamos
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