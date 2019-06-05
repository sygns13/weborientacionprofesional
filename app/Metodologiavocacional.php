<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Metodologiavocacional extends Model
{
    protected $fillable = ['nombre','descripcion','descmostrar','activo','borrado','user_id'];
    protected $guarded = ['id'];

    public function modulovocacional()
    {
    	return $this->hasMany(Modulovocacional::class);
    }

    public function campoprofesional()
    {
    	return $this->hasMany(Campoprofesional::class);
    }

}
