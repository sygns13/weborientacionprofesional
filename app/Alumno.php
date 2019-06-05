<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Alumno extends Model
{
    protected $fillable = ['codigopos','estado','carrera_id2','activo','borrado','quinto','persona_id','carrerasunasam_id','ciclo_id'];
    protected $guarded = ['id'];

    public function test()
    {
    	return $this->hasMany(Test::class);
    }
    public function persona()
 	{
 		return $this->belongsTo('App\Persona');
 	}
 	public function ciclo()
 	{
 		return $this->belongsTo('App\Ciclo');
 	}
 	public function carrerasunasam()
 	{
 		return $this->belongsTo('App\Carrerasunasam');
 	}
}
