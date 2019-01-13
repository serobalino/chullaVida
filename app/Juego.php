<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $primaryKey   =   "id_ju";

    protected $with         =   ['jugadores','titulo'];

    protected $casts        =   [
        'estado_ju'=>'bool'
    ];

    public function creador(){
        return $this->hasOne(User::class,'id','id_us');
    }

    public function titulo(){
        return $this->hasOne(Tipo::class,'id_ti','id_ti');
    }

    public function jugadores(){
        return $this->hasMany(Participante::class,'id_ju','id_ju');
    }
}
