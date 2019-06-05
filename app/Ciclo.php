<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model
{
    protected $fillable = ['nombre','fechainicio','fechafin','estado','segundacarrera','activo','borrado','user_id'];
     protected $guarded = ['id'];

     public function alumno()
    {
    	return $this->hasMany(Alumno::class);
    }
}
