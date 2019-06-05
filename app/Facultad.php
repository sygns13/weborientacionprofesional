<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Facultad extends Model
{
    protected $fillable = ['nombre','descripcion','activo','borrado','user_id'];
     protected $guarded = ['id'];

     public function carrerasunasam()
    {
    	return $this->hasMany(Carrerasunasam::class);
    }
}
