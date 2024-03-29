<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"IPP-R",
        subtitulo:"Inventario de Intereses Profesionales",
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
        classMenu3:'',
        classMenu4:'',
        classMenu5:'active',
        classMenu6:'',
        classMenu7:'',

        divhome:false,
        divTestIPP:true,
        divPreguntas:false,
        divResultado:false,

       
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
        thispage:1,

        metodologia:'1',
        metodologiaData: [],
        modulos: [],
        reglas: [],
        errors:[],

        preguntas: [],
        alternativas: [],
        campoprofesionals: [],
        validezs: [],

        idModulo:'1',
        metodologiavocacional_id:'1',

        checked:[],
        picked:'',
        textoTest:'Iniciar Test',
        idTest:'0',

        divloaderNuevo:false,

        resultados:'',
        descresultados:'',



    },
    created:function () {
        //this.getTest(this.thispage);
        this.getMetodologia(this.thispage)
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
        getTest: function (page) {
            var busca=this.buscar;
            var urlCampos ='campoProfesional?page='+page+'&busca='+busca+'&metodologiavocacional_id='+this.metodologiavocacional_id;

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

        getPreguntas: function (page) {
            var busca=this.buscar;
            var urlPreguntas = 'pregunta?page='+page+'&busca='+busca+'&idModulo='+this.idModulo+'&idMet='+this.idMet;

            axios.get(urlPreguntas).then(response=>{

                this.validezs= response.data.validez,
                this.reglas= response.data.reglas;
                this.preguntas='';
                this.alternativas='';
                this.$nextTick(function () {
                this.preguntas= response.data.preguntas.data;
                this.$nextTick(function () {
                    this.alternativas= response.data.alternativas;
                    if(this.preguntas.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                        }

                        $('.wrapper').animate({scrollTop: 0}, 300);
                  })

                  })

                this.pagination= response.data.pagination;
                this.campoprofesionals= response.data.campoprofesionals;

                
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getPreguntas(page);
            this.thispage=page;
        },

        getMetodologia: function () {
            var aux=this.metodologia;
            var urlIppr = 'metodologia?metodologia='+aux;

            axios.get(urlIppr).then(response=>{
               // console.log(response.data.ippr);
                this.metodologiaData= response.data.ippr,
                this.modulos= response.data.modulovocacional,
                this.reglas= response.data.reglas
            })
        },

        iniciarTest: function () {
            this.divTestIPP=false;
            this.divloader3=true;

            if(this.idTest=="0"){
                this.createTest();
                this.$nextTick(function () {
                this.getPreguntas(this.thispage);
                this.divloader3=false;
                this.divPreguntas=true;
                toastr.success("Test Inicializado Correctamente");
            })
            }
            else{
                this.$nextTick(function () {
                this.getPreguntas(this.thispage);
                this.divloader3=false;
                this.divPreguntas=true;
                toastr.info("Continuando con el Desarrollo del Test");
            })
            }
         

            

        },
        volverTest:function() {
            this.divPreguntas=false;
            this.divloader3=true;

            if(this.checked.length>0){
                this.textoTest="Continuar con el Test";
                toastr.warning("Test No Finalizado, continúe con el Test, si se dirige a otra página desde aquí se perderá el avance del proceso");
            }
            

            this.$nextTick(function () {
            this.getPreguntas(this.thispage);
                this.divloader3=false;
                this.divTestIPP=true;
            })
        },
        marca:function (pregID,alterID) {
            $(".claschek-"+pregID).each(function(){
                var idel=$(this).attr("id");
                var len=idel.length;
                var fincad=idel.substring(6,len);
                //console.log(idel+" --- "+fincad);

                var index = app.checked.indexOf(parseFloat(fincad));

                if(index > -1 ){
                    //console.log(idel+" --- "+fincad+" -- "+alterID);

                    app.checked.splice(index, 1);
                   
                }
                else{

                    if(parseFloat(alterID)==parseFloat(fincad)){
                            app.checked.push(parseFloat(fincad));
                            //console.log(idel+" --- "+fincad+" -- "+alterID);
                    }
                }
           
            });
        },
        crearTest:function () {
           //console.log(this.pagination.total);

        // console.log(this.validezs[0].minpreguntas);
        var minpregs=this.validezs[0].minpreguntas;
        var totalpregs= app.checked.length;

        if(parseFloat(totalpregs)>parseFloat(minpregs)){
           // alert("go a procesar");
           this.createRespuesta();
        }
        else{
             swal({
          title: '',
          text: 'Debe completar por lo menos el 70% de la prueba, es decir: '+minpregs+' preguntas, de lo contrario la prueba no será válida. Hasta ahora ha completado: '+totalpregs+' preguntas.',
          type: 'warning',
          confirmButtonText: 'Aceptar'
        });
        }
        },
        createTest:function () {
            var url='test';
            $("#btnIniciarTest").attr('disabled', true);
            axios.post(url,{metod:this.metodologia}).then(response=>{
                //console.log(response.data);
                $("#btnIniciarTest").removeAttr("disabled");
                if(response.data.result=='1'){
                   // this.getPreguntas(this.thispage);
                    this.errors=[];
                    this.idTest=response.data.testcreated;
                   // this.cerrarFormPreg();
                   // toastr.success(response.data.msj);
                }else{
                    //$('#'+response.data.selector).focus();
                    //toastr.error(response.data.msj);
                    window.location="testIPP";
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },



        createRespuesta:function () {
            var url='respuesta';
            $("#btnAtrasMove").attr('disabled', true);
            $("#btnCrearTest").attr('disabled', true);

            $("#divPreguntas").hide('slow');

            
            this.divloader6=true;
            $('.wrapper').animate({scrollTop: 0}, 300);


            axios.post(url,{test:this.idTest,respuestas:this.checked}).then(response=>{
                //console.log(response.data);

                $("#btnAtrasMove").removeAttr("disabled");
                $("#btnCrearTest").removeAttr("disabled");

                
                 

                if(response.data.result=='1'){
                  /*  this.getPreguntas(this.thispage);
                    this.errors=[];
                    this.cerrarFormPreg();*/
                    toastr.success(response.data.msj);
                 this.divloader6=false;   
                this.divPreguntas=false;
                this.divResultado=true;

                this.resultados=response.data.perfilFin;
                this.descresultados=response.data.descriPerfilFin;

                }else{
                    $("#divPreguntas").show('slow');
                    this.divloader6=false;
                   /* $('#'+response.data.selector).focus();
                    toastr.error(response.data.msj);*/
                }
            }).catch(error=>{
                $("#divPreguntas").show('slow');
                this.errors=error.response.data
            })
        },

        imprimirResults:function (){

            var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page  { size: portrait; } body #btnImpRes{display:none!important;} .perfil{font-weight: bold;text-decoration: underline;s}</style>', strict:false  };


            $("#impResultados").printArea(options);
        },

        chekiarauto:function(){
            this.checked
        },


        llenarAuto:function(){

            var url='alternativa/buscarAuto';
         
            axios.post(url,{idModulo:this.idModulo}).then(response=>{
                
                 this.checked=response.data.arrayAlter;

            }).catch(error=>{
                $("#divPreguntas").show('slow');
                this.errors=error.response.data
            })
        }


    }
});
</script>