<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Carrerasunasam extends Model
{
    protected $fillable = ['nombre','descripcion','areaunasam_id','activo','borrado','user_id','facultad_id'];
     protected $guarded = ['id'];

     public function alumno()
    {
    	return $this->hasMany(Alumno::class);
    }
    public function informacion()
    {
    	return $this->hasMany(Informacion::class);
    }

    public function areaunasam()
 	{
 		return $this->belongsTo('App\Areaunasam');
 	}
 	public function facultad()
 	{
 		return $this->belongsTo('App\Facultad');
 	}

    public static function showCarreras($buscar)
    {
        $carreras=DB::select("select f.id as idfac, f.nombre as facultad, f.activo as estadofac, a.id as idarea, a.nombre as area, a.activo as estadoarea,
c.id as idcarre, c.nombre as carrera, c.descripcion as descripcion, c.activo as activo, c.borrado, c.user_id
from carrerasunasams c
inner join facultads f on f.id=c.facultad_id
inner join areaunasams a on a.id=c.areaunasam_id
where c.borrado='0' and c.nombre like '%".$buscar."%'
order by c.facultad_id, c.areaunasam_id, c.id;");
        return $carreras;
    }
}
