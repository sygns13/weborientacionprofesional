<script type="text/javascript">
 let app = new Vue({
    el: '#app',
    data:{
        tipouserPerfil:'<?php echo e($tipouser->nombre); ?>',
        userPerfil:'<?php echo e(Auth::user()->name); ?>',
        mailPerfil:'<?php echo e(Auth::user()->email); ?>',
        imgPerfil:'<?php echo e($imagenPerfil); ?>',
        noPerfil:'noPerfil.png',

        titulo:"Menú Principal",
        subtitulo:"Inicio",
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


        

        },
        created:function () {
            <?php if(intval($tipouser->id)==4): ?>
                this.getTests(this.thispage);
            <?php endif; ?>
        },
        mounted: function () {
        this.divloader0=false;

            
        if(this.imgPerfil.length>0){
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.imgPerfil);
        }
        else{
            $(".imgPerfil").attr("src","<?php echo e(asset('/img/perfil/')); ?>"+"/"+this.noPerfil);
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
    methods: { 

        <?php if(intval($tipouser->id)==4): ?>

        getTests: function (page) {
            var busca=this.buscar;
            var url = 'test?page='+page+'&busca='+busca;

            axios.get(url).then(response=>{
                this.tests= response.data.tests.data;
                this.pagination= response.data.pagination;

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
        
        <?php endif; ?>

    },

});
</script>