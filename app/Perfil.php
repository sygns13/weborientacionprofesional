<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $fillable = ['titulo','descripcion','descripcionalumno','test_id'];
    protected $guarded = ['id'];

    public function test()
 	{
 		return $this->belongsTo('App\Test');
 	}

 	public function analisiscampoprof()
 	{
 		return $this->hasMany(Analisiscampoprof::class);
 	}
}
