<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Alternativa extends Model
{
    protected $fillable = ['alternativa','descripcion','orden','puntaje','activo','borrado','user_id','detactividadprofesion','pregunta_id','campoprofesional_id'];
    protected $guarded = ['id'];

    public function pregunta()
 	{
 		return $this->belongsTo('App\Pregunta');
 	}

 	public function campoprofesional()
 	{
 		return $this->belongsTo('App\Campoprofesional');
 	}
}
