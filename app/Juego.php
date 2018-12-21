<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $primaryKey   =   "id_ju";

    protected $with         =   ['jugadores'];

    protected $casts        =   [
        'estado_ju'=>'bool'
    ];

    public function creador(){
        return $this->hasOne(User::class,'id','id_us');
    }

    public function jugadores(){
        return $this->hasMany(Participante::class,'id_ju','id_ju');
    }
}
