<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',
        titulo:"Áreas Académicas",
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
        classTitle:'fa fa-cogs',
        classMenu0:'',
        classMenu1:'active',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divhome:false,
        divarea:true,

        areas: [],
        errors:[],
        fillArea:{'id':'', 'area':'', 'estado':''},
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
        divNuevaArea:false,
        newArea:'',
        estadoArea:'1',

        divloaderNuevo:false,
        divloaderEdit:false,

        thispage:'1',



    },
    created:function () {
        this.getAreas(this.thispage);
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
        getAreas: function (page) {
            var busca=this.buscar;
            var urlAreas = 'areas?page='+page+'&busca='+busca;

            axios.get(urlAreas).then(response=>{
                this.areas= response.data.areas.data;
                this.pagination= response.data.pagination;

                if(this.areas.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getAreas(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getAreas();
            this.thispage='1';
        },
        nuevaArea:function () {
            this.divNuevaArea=true;
            //$("#txtarea").focus();
            //$('#txtarea').focus();
            this.$nextTick(function () {
            this.cancelFormArea();
          })
            
        },
        cerrarFormArea: function () {
            this.divNuevaArea=false;
            this.cancelFormArea();
        },
        cancelFormArea: function () {
            $('#txtarea').focus();
            this.newArea='';
            this.estadoArea='1';
        },
        createArea:function () {
            var url='areas';
            $("#btnGuardar").attr('disabled', true);
            $("#btnCancel").attr('disabled', true);
            $("#btnClose").attr('disabled', true);
            this.divloaderNuevo=true;
            axios.post(url,{area:this.newArea, estado:this.estadoArea }).then(response=>{
                //console.log(response.data);

                $("#btnGuardar").removeAttr("disabled");
                $("#btnCancel").removeAttr("disabled");
                $("#btnClose").removeAttr("disabled");
                this.divloaderNuevo=false;

                if(response.data.result=='1'){
                    this.getAreas(this.thispage);
                    this.errors=[];
                    this.cerrarFormArea();
                    toastr.success(response.data.msj);
                }else{
                    $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },
        borrarArea:function (area) {
              swal({
                  title: '¿Estás seguro?',
                  text: "¿Desea eliminar el área Seleccionado? -- Nota: Para eliminar esta área, debe primero eliminar todas las carreras profesionales que se encuentran registradas en él",
                  type: 'info',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, eliminar'
                }).then(function () {

                            var url = 'areas/'+area.id;
                            axios.delete(url).then(response=>{//eliminamos

                            if(response.data.result=='1'){
                                app.getAreas(app.thispage);//listamos
                                toastr.success(response.data.msj);//mostramos mensaje
                            }else{
                               // $('#'+response.data.selector).focus();
                                toastr.error(response.data.msj);
                            }
                            });
                        
                    }).catch(swal.noop);
        },
        editArea:function (area) {

            this.fillArea.id=area.id;
            this.fillArea.area=area.nombre;
            this.fillArea.estado=area.activo;
            $("#boxTitulo").text('Área: '+area.nombre);
            $("#modalEditar").modal('show');
        },
        updateArea:function (id) {
            var url="areas/"+id;
            $("#btnSaveE").attr('disabled', true);
            $("#btnCancelE").attr('disabled', true);
            this.divloaderEdit=true;

            axios.put(url, this.fillArea).then(response=>{

                $("#btnSaveE").removeAttr("disabled");
                $("#btnCancelE").removeAttr("disabled");
                this.divloaderEdit=false;
                
                if(response.data.result=='1'){   
                this.getAreas(this.thispage);
                this.fillArea={'id':'', 'area':'', 'estado':''};
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
                                app.getAreas(app.thispage);//listamos
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
                                app.getAreas(app.thispage);//listamos
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