<?php
header('Content-Type: text/html; charset=utf-8');
include('../conex/conexion.php');



$modulo=$_POST['modulo'];
//$idUsu=$_SESSION['idusu']; 


switch ($modulo) {

  case 'calendar':
  $accion=$_POST['accion'];
  
    if ($accion=='cargar') {

    $var=$_POST['m']; 
    $diames="";

    $mes=substr($var, 0, -5);
    $year=substr($var, -4);

    switch ($mes){ 
    case 'Enero': $diames="1"; break; 
    case 'Febrero': $diames="2"; break; 
    case 'Marzo': $diames="3"; break; 
    case 'Abril': $diames="4"; break; 
    case 'Mayo': $diames="5"; break; 
    case 'Junio': $diames="6"; break; 
    case 'Julio': $diames="7"; break; 
    case 'Agosto': $diames="8"; break;
    case 'Setiembre': $diames="9"; break;
    case 'Octubre': $diames="10"; break;
    case 'Noviembre': $diames="11"; break;
    case 'Diciembre': $diames="12"; break;
    }


    echo "<h4 style='margin-top: 0px;  margin-bottom: 20px; font-weight:bold;'>".$mes." - ".$year.":</h4>";


    $conec=conectar();
       $res1=$conec->query("select c.idcalendar,c.titulo,c.descripcion,c.rutaimg,c.color, day(c.fechaini),month(c.fechaini),year(c.fechaini),
day(c.fechafin),month(c.fechafin),year(c.fechafin) FROM calendario c where month(c.fechaini)='".$diames."' and year(c.fechaini)='".$year."';");

//echo"select c.idcalendar,c.titulo,c.descripcion,c.rutaimg,c.color, day(c.fechaini),month(c.fechaini),year(c.fechaini),
//day(c.fechafin),month(c.fechafin),year(c.fechafin) FROM calendario c where month(c.fechaini)='".$diames."' and year(c.fechaini)='".$year."';";

$cont=0;
       while($row=mysqli_fetch_row($res1)){
        $cont++;
        //$fecha=substr($row[3],8,2).'/'.substr($row[3], 5,2).'/'.substr($row[3], 0,4);

      echo'<div class="external-event" style="background-color: '.$row[4].'; border-color: '.$row[4].'; color: white;  position: relative;">'.$row[5].' '.$row[1].'</div><p class="texto">'.$row[2].'</p>';
      

    }

    if($cont==0){
      echo'<div class="external-event" style="background-color: black; border-color: black; color: white;  position: relative;">No se cuenta con eventos programados para este mes.</div><p class="texto">'.$row[2].'</p>';
    }




    }


  break;


 
}

?>
