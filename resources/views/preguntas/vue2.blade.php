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
        subtitulo:"Gestión de Preguntas",
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

        array: [],

        preguntas: [],
        campoprofesionals: [],
        alternativas: [],
        errors:[],
        fillPreguntas:{'id':'', 'descripcion':'', 'orden':'','obligatorio':'1','activo':'1','modulovocacional_id':'','campoprofesional_id':''},
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
        newPregunta:'',
        newOrden:'',
        newoblig:'1',
        estadoPreg:'1',
        newcampoprofesional_id:'',

        divloaderNuevo:false,
        divloaderEdit:false,

        idModulo:'{{$idModulo}}',

         idMet:'{{$idMet}}',

         newAlternativa:'',
         newAlternativaMarca:'A',
         newOrdenAlter:'',
         newPuntaje:'',
         ActivProf:'1',
         newpregunta_id:'',


         divloaderAlter:false,
         divloaderAlterE:false,

         thispage:'1',

         reglas: [],




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
            var urlPreguntas = '/plantilla/datos?page='+page+'&busca='+busca+'&idModulo='+this.idModulo+'&idMet='+this.idMet;

            axios.get(urlPreguntas).then(response=>{

                this.array=response.data.array;

                this.reglas= response.data.reglas;
                this.preguntas='';
                this.alternativas='';
                this.$nextTick(function () {
                this.preguntas= response.data.preguntas;
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

                this.pagination= response.data.pagination;
                this.campoprofesionals= response.data.campoprofesionals;

                
            })
        },
        impPlantilla:function () {
            var url = "/plantilla/imprimir/"+this.idMet+"/"+this.idModulo;
            //window.open(url,'_blank');
            window.location.href = url;
        },
        imprimirPlantilla:function () {
            $("#divImp").printArea();
        }
    }
});
</script>