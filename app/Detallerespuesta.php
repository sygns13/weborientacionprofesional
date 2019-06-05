<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detallerespuesta extends Model
{
    protected $fillable = ['pregunta_id','test_id','alternativa_id','pregunta','alternativa','descripcion'];
    protected $guarded = ['id'];

    public function test()
 	{
 		return $this->belongsTo('App\Test');
 	}

 	public function pregunta()
 	{
 		return $this->belongsTo('App\Pregunta');
 	}
}
