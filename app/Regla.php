<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Regla extends Model
{
    protected $fillable = ['descripcion','activo','borrado','modulovocacional_id','user_id'];
    protected $guarded = ['id'];

    public function modulovocacional()
 	{
 		return $this->belongsTo('App\Modulovocacional');
 	}
}
