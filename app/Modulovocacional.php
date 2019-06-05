<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Modulovocacional extends Model
{
    protected $fillable = ['fase','titulo','descripcion','pregaleatorias','activo','borrado','metodologiavocacional_id','user_id'];
    protected $guarded = ['id'];

    public function metodologiavocacional()
 	{
 		return $this->belongsTo('App\Metodologiavocacional');
 	}

 	    public function regla()
    {
    	return $this->hasMany(Regla::class);
    }

    public function tipoperfil()
    {
    	return $this->hasMany(Tipoperfil::class);
    }

    public function pregunta()
    {
    	return $this->hasMany(Pregunta::class);
    }

    public function validez()
    {
    	return $this->hasMany(Validez::class);
    }
}
