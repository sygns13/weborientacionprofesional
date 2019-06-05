<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Analisiscampoprof extends Model
{
    protected $fillable = ['area','descripconarea','campoprofesional','orden','analisis','calificaciongral','tipomedida','activProf','perfil_id','activo','borrado'];
    protected $guarded = ['id'];

    public function perfil()
 	{
 		return $this->belongsTo('App\Perfil');
 	}

 	public function calificacion()
 	{
 		return $this->hasMany(Calificacion::class);
 	}
}
