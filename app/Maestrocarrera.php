<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Maestrocarrera extends Model
{
    protected $fillable = ['nombre','descripcion','activo','borrado','campoprofesional_id','user_id'];
    protected $guarded = ['id'];

    public function campoprofesional()
 	{
 		return $this->belongsTo('App\Campoprofesional');
 	}
}
