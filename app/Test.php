<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = ['fecha','fechafin','horainicio','horafin','estado','alumno_id','metodologiavocacional_id'];
    protected $guarded = ['id'];

    public function alumno()
 	{
 		return $this->belongsTo('App\Alumno');
 	}
}
