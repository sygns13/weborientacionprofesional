<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Validez extends Model
{
    protected $fillable = ['minpreguntas','maxalternativas','activo','borrado','modulovocacional_id','user_id'];
    protected $guarded = ['id'];

    public function modulovocacional()
 	{
 		return $this->belongsTo('App\Modulovocacional');
 	}
}
