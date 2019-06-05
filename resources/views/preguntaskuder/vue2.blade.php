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

         array: [],
         array2: {'1':'1','2':'2','3':'3','4':'4','5':'5','6':'6','7':'7','8':'8','9':'9','10':'10'},

         array3:[],





    },
    created:function () {
        this.getPreguntas(this.thispage);
        this.$nextTick(function () {
            this.verAlternativas();
        })
    },
    mounted: function () {
        this.divloader0=false;
        $('#cbuCampoLab').select2();
        this.verAlternativas();

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
            var busca=this.newcampoprofesional_id;
            var urlPreguntas = '/plantillakuder/datos?page='+page+'&busca='+busca+'&idModulo='+this.idModulo+'&idMet='+this.idMet;

            axios.get(urlPreguntas).then(response=>{
                this.preguntasMain='';
                this.preguntas='';
                this.alternativas='';

                this.array=response.data.array;

                this.$nextTick(function () {
                this.preguntasMain=response.data.preguntasMain;
                this.preguntas= response.data.preguntas;
                this.$nextTick(function () {
                    this.alternativas= response.data.alternativas;
                    if(this.preguntas.length==0 && this.thispage!='1'){
                    var a = parseInt(this.thispage) ;
                    a--;
                    this.thispage=a.toString();
                    this.changePage(this.thispage);
                    }
                    this.verAlternativas();
                  })
                  })

                this.campoprofesionals= response.data.campoprofesionals;
                this.pagination= response.data.pagination;


                 $.each(this.campoprofesionals, function( index, dato ) {
                    if(index==0){
                        app.newcampoprofesional_id=dato.id;
                    }
                });

                
            })
        },
        impPlantilla:function () {
            var url = "/plantillakuder/imprimir/"+this.idMet+"/"+this.idModulo;
            //window.open(url,'_blank');
            window.location.href = url;
        },
        imprimirPlantilla:function () {
            $("#divImp").printArea();
        },
        verAlternativas:function () {

            this.array3=[];
            $.each(this.preguntas, function( index, dato ) {
                var cont1=0;
                var cont2=0;
                //console.log(dato.id);
                    $.each(app.alternativas, function( index2, dato2 ) {
                       // console.log(valueOf(dato2.campoprofesional_id)+' --- '+app.newcampoprofesional_id);
                        if(String(dato2.campoprofesional_id)==String(app.newcampoprofesional_id))
                        {
                            if(String(dato.id)==String(dato2.pregunta_id)){
                                if(dato2.alternativa=="mas"){
                                    cont1++;

                                }
                                if(dato2.alternativa=="menos"){
                                    cont2++;

                                }
                            }

                        }
                });
                    if(cont1>0 && cont2>0){
                        app.array3.push(2);
                    }
                    else{
                        if(cont1>0){
                            app.array3.push(1);
                        }
                        if(cont2>0){
                            app.array3.push(-1);
                        }
                    }

                    if(cont1==0 && cont2==0){
                        app.array3.push(0);
                    }
                });
        }

        

  
    }
});

function onChange() {
            app.newcampoprofesional_id=$('#cbuCampoLab').val();
            //console.log(app.newcampoprofesional_id);
            app.verAlternativas();
        }
</script>