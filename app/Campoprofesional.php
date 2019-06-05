<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Campoprofesional extends Model
{
    protected $fillable = ['nombre','orden','activo','borrado','user_id','metodologiavocacional_id','descripcion'];
    protected $guarded = ['id'];

    public function metodologiavocacional()
 	{
 		return $this->belongsTo('App\Metodologiavocacional');
 	}

 	public function maestrocarrera()
    {
    	return $this->hasMany(Maestrocarrera::class);
    }

    public function alternativa()
    {
    	return $this->hasMany(Alternativa::class);
    }
}
