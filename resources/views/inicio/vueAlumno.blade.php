<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'{{ $tipouser->nombre }}',
        userPerfil:'{{ Auth::user()->name }}',
        mailPerfil:'{{ Auth::user()->email }}',
        imgPerfil:'{{ $imagenPerfil }}',
        noPerfil:'noPerfil.png',

        alumno:[],

        titulo:"Menú Principal",
        subtitulo:"Inicio",
        subtitulo:"Bienvenido Alumno",
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
        classTitle:'fa fa-home',
        classMenu0:'active',
        classMenu1:'',
        classMenu2:'',
        classMenu3:'',
        classMenu4:'',
        classMenu5:'',
        classMenu6:'',
        classMenu7:'',

        divhome:true,
        divarea:false,
        divciclo:false,

          thispage:'1',

        tests:[],
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

         metodologiaData: [],

        resultados:'',
        descresultados:'',

        divPrincipal2:false,
        divPrincipal1:true,



        },
        created:function () {
        this.getData(this.adat);
        this.getTests(this.thispage);
            

        },
        mounted: function () {


        this.divloader0=false;

            
        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.noPerfil);
        }
 
    },computed:{
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

    filters: {
  fecha: function (value) {
    if (!value) return ''
    value = value.toString()
    return value.slice(8)+"/"+value.slice(5,7)+"/"+value.slice(0,4)
  }
},

     methods: {
        getData: function (adat) {
            //var busca=this.busca;
            var urlCampos ='alumnoDatos';

            axios.get(urlCampos).then(response=>{
                this.alumno= response.data.persona;
                this.$nextTick(function () {
                if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.imgPerfil);
                }
                else{
                    $(".imgPerfil").attr("src","{{ asset('/img/perfil/')}}"+"/"+this.noPerfil);
                }

            })
            })
        },


         getTests: function (page) {
            var busca=this.buscar;
            var url = 'test?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{
               this.tests= response.data.tests.data;
               this.pagination= response.data.pagination;

               //console.log(response.data);

                if(this.tests.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                }
            })
        },
        changePage:function (page) {
            this.pagination.current_page=page;
            this.getTests(page);
            this.thispage=page;
        },
        buscarBtn: function () {
            this.getTests();
            this.thispage='1';
        },
        pasfechaVista:function(date) 
        {
            date=date.slice(-2)+'/'+date.slice(-5,-3)+'/'+date.slice(0,4);
            return date;
        },

        getMetodologia: function (idMetodologia) {
            var aux=idMetodologia;
            var url = 'metodologia?metodologia='+aux;

            axios.get(url).then(response=>{
               // console.log(response.data.ippr);
                this.metodologiaData= response.data.ippr;
               /* this.modulos= response.data.modulovocacional,
                this.reglas= response.data.reglas*/
            })
        },


        getRespuesta: function (test) {
            var busca=this.buscar;
            var url = 'respuesta?idTest='+test.id+'&idMeto='+test.metodologiavocacional_id;

            this.getMetodologia(test.metodologiavocacional_id);

            axios.get(url).then(response=>{
               
                this.resultados=response.data.perfil.titulo;
                this.descresultados=response.data.perfil.descripcionAlumno;

                this.divPrincipal2=true;
                $("#divTama3").hide('slow');
                $("#divTama9").hide('slow');
            })
        },

        imprimirResults:function (){

            var options = { extraHead : '<style rel="stylesheet" type="text/css" media="print">@page { size: portrait; } body #btnImpRes{display:none!important;} .perfil{font-weight: bold;text-decoration: underline;s}</style>', strict:false  };


            $("#impResultados").printArea(options);
        },

        volverPrincipal:function (){

                $("#divTama3").show('slow');
                $("#divTama9").show('slow');
                this.divPrincipal2=false;
        },
        
        },

});
</script>