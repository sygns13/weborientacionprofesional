<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Persona extends Model
{
    protected $fillable = ['dni','nombres','apellidos','genero','telf','direccion','imagen','activo','borrado','tipodocu'];
    protected $guarded = ['id'];

    public function alumno()
    {
    	return $this->hasMany(Alumno::class);
    }
    public function user()
    {
    	return $this->hasMany(User::class);
    }
}
