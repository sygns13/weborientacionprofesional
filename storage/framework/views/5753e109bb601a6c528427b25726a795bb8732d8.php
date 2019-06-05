<script type="text/javascript">
         let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',
        titulo:"KUDER",
        subtitulo:"Test de Preferencias Vocacionales - Forma C",
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
        divTestKuder:true,
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

        metodologia:'2',
        metodologiaData: [],
        modulos: [],
        reglas: [],
        errors:[],

        preguntasMain:[],
        preguntas: [],
        alternativas: [],
        campoprofesionals: [],
        validezs: [],

        idModulo:'5',
        metodologiavocacional_id:'1',

        checked:[],

        checked1:[],
        checked2:[],
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
            var urlPreguntas = '/preguntakuder?page='+page+'&busca='+busca+'&idModulo='+this.idModulo+'&idMet='+this.idMet;

            axios.get(urlPreguntas).then(response=>{
                this.validezs= response.data.validez,
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
                    $('.wrapper').animate({scrollTop: 0}, 300);
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
                    window.location="testKUDER";
                }
            }).catch(error=>{
                this.errors=error.response.data
            })
        },

        iniciarTest: function () {
            this.divTestKuder=false;
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
                this.divTestKuder=true;
            })
        },
       /* marca:function (pregID,masmin,orden,minmas) {

            idItem='ckeck'+masmin+'-'+pregID;
            idItemNO='ckeck'+minmas+'-'+pregID;

            num=0;

            $('#'+idItemNO).prop('checked', false);


            $(".claschek-"+orden).each(function(){


            if(masmin=="mas"){
                var idel=$(this).attr("id");
                var len=idel.length;
                var fincad=idel.substring(9,len);


                idItem2='ckeck'+masmin+'-'+fincad;

                if(idel!=idItem && idel==idItem2){
                    $('#'+idel).prop('checked', false);
                }
            }
            if(masmin=="menos"){
                var idel=$(this).attr("id");
                var len=idel.length;
                var fincad=idel.substring(11,len);


                idItem2='ckeck'+masmin+'-'+fincad;

                if(idel!=idItem  && idel==idItem2){
                    $('#'+idel).prop('checked', false);
                }
            }




               
           
            });
        },*/

        marca:function(id,inmasmin,orden,outmasmin){

            this.marca2(id,inmasmin,orden,outmasmin);
            this.$nextTick(function () {

            if(inmasmin=="mas"){
                var pos=app.checked2.indexOf(id);
                if (pos > -1) {
                   app.checked2.splice(pos, 1);
                   //app.checked1.push(id);
                   $(".claschek1-"+orden).each(function(){ 
                 
                    idel=$(this).attr("id");
                    //var len=idel.length;
                    //idel=parseInt(idel.substring(9,len));

                    //console.log(idel+' - '+id);

                    if(id!=idel){
                        var pos2=app.checked1.indexOf(parseFloat(idel));
                        //console.log(pos2);
                       // console.log(pos2+ ' - '+idel);  
                        if (pos2 > -1) {
                           app.checked1.splice(pos2, 1);
                           app.checked1.push(id);
                        }
                    }
                    
                });
                }
            }
            if(inmasmin=="menos"){
                var pos=app.checked1.indexOf(id);
                if (pos > -1) {
                   app.checked1.splice(pos, 1);
                   //app.checked2.push(id);
                   if(inmasmin=="menos"){
                $(".claschek2-"+orden).each(function(){ 
                 
                    idel=$(this).attr("id");
                     //var len=idel.length;
                    // idel=parseInt(idel.substring(11,len));

                    //console.log(idel+' - '+id);
                    if(id!=idel){
                        var pos2=app.checked2.indexOf(parseFloat(idel));
                       // console.log(pos2);
                        //console.log(pos2+ ' - '+idel);
                        if (pos2 > -1) {
                           app.checked2.splice(pos2, 1);
                           app.checked2.push(id);
                        }
                    }
                    
                });
            }
                }
            }

            });
        },
        marca2:function(id,inmasmin,orden,outmasmin){
                 if(inmasmin=="mas"){
                $(".claschek1-"+orden).each(function(){ 
                 
                    idel=$(this).attr("id");
                    //var len=idel.length;
                    //idel=parseInt(idel.substring(9,len));

                    //console.log(idel+' - '+id);

                    if(id!=idel){
                        var pos2=app.checked1.indexOf(parseFloat(idel));
                        //console.log(pos2);
                       // console.log(pos2+ ' - '+idel);  
                        if (pos2 > -1) {
                           app.checked1.splice(pos2, 1);
                           app.checked1.push(id);
                        }
                    }
                    
                });
            }
            if(inmasmin=="menos"){
                $(".claschek2-"+orden).each(function(){ 
                 
                    idel=$(this).attr("id");
                     //var len=idel.length;
                    // idel=parseInt(idel.substring(11,len));

                   // console.log(idel+' - '+id);
                    if(id!=idel){
                        var pos2=app.checked2.indexOf(parseFloat(idel));
                      //  console.log(pos2);
                        //console.log(pos2+ ' - '+idel);
                        if (pos2 > -1) {
                           app.checked2.splice(pos2, 1);
                           app.checked2.push(id);
                        }
                    }
                    
                });
            }
        },
        crearTest:function () {
           //console.log(this.pagination.total);

        // console.log(this.validezs[0].minpreguntas);
        var minpregs=this.validezs[0].minpreguntas;
        var totalpregsGustaMas= app.checked1.length;
        var totalpregsGustaMenos= app.checked2.length;

        if(parseFloat(totalpregsGustaMas)>=parseFloat(minpregs)){
           // alert("go a procesar");
           if(parseFloat(totalpregsGustaMenos)>=parseFloat(minpregs)){
           //alert("go a procesar");
           this.createRespuesta();
        }
        else{
             swal({
          title: '',
          text: 'Debe completar la prueba, es decir las: '+minpregs+' respuestas de lo que le Gusta Menos, de lo contrario la prueba no será válida. Hasta ahora ha completado: '+totalpregsGustaMenos+' respuestas de lo que le Gusta Menos',
          type: 'warning',
          confirmButtonText: 'Aceptar'
        });
        }
        }
        else{
             swal({
          title: '',
          text: 'Debe completar la prueba, es decir las: '+minpregs+' respuestas de lo que le Gusta Más, de lo contrario la prueba no será válida. Hasta ahora ha completado: '+totalpregsGustaMas+' respuestas de lo que le Gusta Más',
          type: 'warning',
          confirmButtonText: 'Aceptar'
        });
        }
        },
        

        createRespuesta:function () {
            var url='respuestakuder';
            $("#btnAtrasMove").attr('disabled', true);
            $("#btnCrearTest").attr('disabled', true);

            $("#divPreguntas").hide('slow');

            
            this.divloader6=true;
            $('.wrapper').animate({scrollTop: 0}, 300);


            axios.post(url,{test:this.idTest,respuestasMas:this.checked1,respuestasMenos:this.checked2}).then(response=>{
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

        llenarAuto:function(){

            var url='alternativa2/buscarAuto2';
         
            axios.post(url,{idModulo:this.idModulo}).then(response=>{
                
                 this.checked1=response.data.arrayAlter1;
                 this.checked2=response.data.arrayAlter2;

            }).catch(error=>{
               // $("#divPreguntas").show('slow');
                this.errors=error.response.data
            })
        }


    }
});
</script>