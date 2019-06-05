<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pregunta extends Model
{
     protected $fillable = ['descripcion','orden','obligatorio','activo','borrado','modulovocacional_id','user_id','campoprofesional_id','detactividadprofesion'];
    protected $guarded = ['id'];

    public function modulovocacional()
 	{
 		return $this->belongsTo('App\Modulovocacional');
 	}

 	public function alternativa()
    {
    	return $this->hasMany(Alternativa::class);
    }

    public function detallerespuesta()
    {
    	return $this->hasMany(Detallerespuesta::class);
    }
}
