@include('facultades.componentes')

<script type="text/javascript">

         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        content: '',
        contentE: '',

        titulo:"Facultades",
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
        classTitle:'fa fa-bank',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divfacultad:true,

        facultades: [],
        errors:[],
        fillFacultad:{'id':'', 'facultad':'', 'descripcion':'', 'estado':''},
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
        divNuevaFacultad:false,

        newFacultad:'',
        newDescripcion:'',
        estadoFacultad:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        thispage:'1',



    },
    created:function () {
        this.getFacultades(this.thispage);
    },
    mounted: function () {
        this.divloader0=false;

        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.noPerfil);
        }
        
       // CKEDITOR.replace( 'txtdescripcionE' );
 
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
        getFacultades: function (page) {
            var busca=this.buscar;
            var urlFacultads = 'facultad?page='+page+'&busca='+busca;

            axios.get(urlFacultads).then(response=>{
                this.facultades= response.data.facultades.data;
                this.pagination= response.data.pagination;

                if(this.facultades.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getFacultades(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getFacultades();
            this.thispage='1';
        },
        nuevaFacultad:function () {
            this.divNuevaFacultad=true;
            this.$nextTick(function () {
            this.cancelFormFacultad();
          })
            
        },
        cerrarFormFacultad: function () {
            this.divNuevaFacultad=false;
            this.cancelFormFacultad();
        },
        cancelFormFacultad: function () {
            $('#txtfacultad').focus();
            this.newFacultad='';
            CKEDITOR.instances['editor'].setData("");
            this.estadoFacultad='1';
        },
        createFacultad:function () {
            var url='facultad';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;

            axios.post(url,{facultad:this.newFacultad, desc:CKEDITOR.instances['editor'].getData(), estado:this.estadoFacultad }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getFacultades(this.thispage);
                    this.errors=[];
                    this.cerrarFormFacultad();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarFacultad:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar la Facultad Seleccionada? -- Nota: Para eliminar esta Facultad, debe primero eliminar todas las carreras profesionales que se encuentran registradas en la facultad.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'facultad/'+area.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFacultades(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editFacultad:function (facultad) {

            this.fillFacultad.id=facultad.id;
            this.fillFacultad.facultad=facultad.nombre;
            //CKEDITOR.instances['editorE'].setData("");
            if(facultad.descripcion != null){
                CKEDITOR.instances['editorE'].setData(facultad.descripcion);
            }
            else{
                CKEDITOR.instances['editorE'].setData("");
            }
            
            this.fillFacultad.estado=facultad.activo;
            $("#boxTitulo").text('Facultad: '+facultad.nombre);
            $("#modalEditar").modal('show');

            this.$nextTick(function () {
           $("#txtfacultadE").focus();
          })
        },
        updateFacultad:function (id) {
            var url="facultad/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            this.fillFacultad.descripcion=CKEDITOR.instances['editorE'].getData();

            axios.put(url, this.fillFacultad).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getFacultades(this.thispage);
                this.fillFacultad={'id':'', 'facultad':'', 'descripcion':'', 'estado':''};
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
        bajaFacultad:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si se desactiva la Facultads, se mantendrán ocultas todas las carreras profesionales pertenecientes a ella, hasta que se active la facultad. ",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, desactivar'
                }).then(function () {

                            var url = 'facultad/altabaja/'+area.id+'/0';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFacultades(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        altaFacultad:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "Nota: Si activa la Facultads, todas las carreras profesionales pertenecientes a la facultad serán visibles.",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, Activar'
                }).then(function () {

                            var url = 'facultad/altabaja/'+area.id+'/1';
                            axios.get(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getFacultades(app.thispage);//listamos
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