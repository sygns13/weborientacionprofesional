<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Informacion extends Model
{
    protected $fillable = ['titulo','descripcion','orden','urlimagen','activo','borrado','urldocumento','carrerasunasam_id','user_id','archivonombre'];
    protected $guarded = ['id'];

    public function carrerasunasam()
 	{
 		return $this->belongsTo('App\Carrerasunasam');
 	}
}
