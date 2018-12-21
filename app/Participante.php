<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    protected $primaryKey   =   "id_pa";

    public function juego(){
        return $this->hasOne(Juego::class,'id_ju','id_ju');
    }
}
